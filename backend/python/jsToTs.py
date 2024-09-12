import re
import sys
import os

def add_param_types(params):
    if not params.strip():
        return ""
    param_list = params.split(',')
    typed_params = []
    for param in param_list:
        param = param.strip()
        if param in ['e', 'event']:
            typed_params.append(f'{param}: Event')
        else:
            typed_params.append(f'{param}: any')
    return ', '.join(typed_params)

def infer_type(array_contents):
    # Infer the type of array elements based on content
    trimmed_contents = array_contents.strip()

    if re.match(r"^['\"]", trimmed_contents):
        return 'string'
    elif re.match(r"^\d", trimmed_contents):
        return 'number'
    else:
        return 'any'
    
# Main conversion function
def convert_to_typescript_array(js_code):
    # Regex to match JavaScript array declarations
    pattern = r'\b(let|const|var)\s+(\w+)\s*=\s*\[([^\]]*)\]\s*;?'

    # Function to replace JavaScript array with TypeScript array
    def replacer(match):
        declaration_type = match.group(1)
        var_name = match.group(2)
        array_contents = match.group(3)

        # Infer the type of the array elements
        array_type = infer_type(array_contents)

        # Return the transformed TypeScript array declaration
        return f"{declaration_type} {var_name}: {array_type}[] = [{array_contents}];"

    # Perform the substitution
    ts_code = re.sub(pattern, replacer, js_code)
    
    return ts_code

def js_to_ts(js_code):
    ts_code = convert_to_typescript_array(js_code)
    # Convert single-line comments to TypeScript documentation comments
    ts_code = re.sub(r'//(.*)', r'///\1', js_code)

    # Convert multi-line comments to TypeScript format
    ts_code = re.sub(r'/\*([\s\S]*?)\*/', r'/*\1*/', ts_code, flags=re.DOTALL)
    
    # Convert variable declarations and infer types based on initialization
    ts_code = re.sub(r'\b(let|const|var)\s+(\w+)\s*=\s*(-?\d+\.?\d*)\s*;?', r'\1 \2: number = \3;', ts_code)
    ts_code = re.sub(r'\b(let|const|var)\s+(\w+)\s*=\s*"([^"]+)"\s*;?', r'\1 \2: string = "\3";', ts_code)
    ts_code = re.sub(r'\b(let|const|var)\s+(\w+)\s*=\s*(true|false)\s*;?', r'\1 \2: boolean = \3;', ts_code)
    ts_code = re.sub(r'\b(let|const|var)\s+(\w+)\s*=\s*\[(\s*-?\d+(\.\d+)?\s*(,\s*-?\d+(\.\d+)?\s*)*)\]\s*;?',
                     r'\1 \2: number[] = [\3];', ts_code)
    ts_code = re.sub(r'\b(let|const|var)\s+(\w+)\s*=\s*\["([^"]+)"(,\s*"[^"]+")*\]\s*;?',
                     r'\1 \2: string[] = [\3];', ts_code)
    ts_code = re.sub(r'\b(let|const|var)\s+(\w+)\s*=\s*\[(true|false)(,\s*(true|false))*\]\s*;?',
                     r'\1 \2: boolean[] = [\3];', ts_code)
    ts_code = re.sub(r'\b(let|const|var)\s+(\w+)\s*=\s*{([^}]+)}\s*;?',
                     r'\1 \2: { [key: string]: any } = { \3 };', ts_code)

    # Convert function declarations and add 'any' type for parameters and void return type
    ts_code = re.sub(r'function\s+(\w+)\((.*?)\)\s*{', 
                     lambda m: f'function {m.group(1)}({add_param_types(m.group(2))}): void {{', ts_code)
    
    # Convert async functions with Promise<any> return type
    ts_code = re.sub(r'async\s+function\s+(\w+)\((.*?)\)\s*{', 
                     lambda m: f'async function {m.group(1)}({add_param_types(m.group(2))}): Promise<any> {{', ts_code)

    # Convert arrow functions
    ts_code = re.sub(r'(\w+)\s*=\s*\((.*?)\)\s*=>\s*{', 
                     lambda m: f'{m.group(1)} = ({add_param_types(m.group(2))}): void => {{', ts_code)
    
    # Handle async arrow functions with Promise return type
    ts_code = re.sub(r'(\w+)\s*=\s*async\s*\((.*?)\)\s*=>\s*{', 
                     lambda m: f'{m.group(1)} = async ({add_param_types(m.group(2))}): Promise<any> => {{', ts_code)

    # Convert Date objects to TypeScript with type annotations
    ts_code = re.sub(r'\b(let|const|var)\s+(\w+)\s*=\s*new\s+Date\((.*?)\)\s*;?', r'let \1: Date = new Date(\2);', ts_code)

    # Convert getElementById to TypeScript with type assertion
    ts_code = re.sub(
        r'\b(let|const|var)\s+(\w+)\s*=\s*(\w+)\.getElementById\(\s*["\']([^"\']+)["\']\s*\)\s*;?', 
        r'\1 \2: HTMLElement | null = \3.getElementById("\4");', 
        ts_code
    )
    
    # Convert querySelector to TypeScript with type assertion
    ts_code = re.sub(
        r'\b(let|const|var)\s+(\w+)\s*=\s*(\w+)\.querySelector\(\s*["\']([^"\']+)["\']\s*\)\s*;?', 
        r'\1 \2: HTMLElement | null = \3.querySelector("\4");', 
        ts_code
    )

    # Handle addEventListener with typed parameters
    ts_code = re.sub(r'(\w+)\.addEventListener\("([^"]+)",\s*async function\s*\((.*?)\)\s*{',
                     lambda m: f'{m.group(1)}.addEventListener("{m.group(2)}", async function({add_param_types(m.group(3))}): void {{', ts_code)
    
    # Convert class declarations and add types for properties and methods
    ts_code = re.sub(r'class\s+(\w+)\s*{', r'class \1 {', ts_code)
    
    # Convert constructor parameters to have any type
    ts_code = re.sub(r'constructor\s*\((.*?)\)\s*{', 
                     lambda m: f'constructor({add_param_types(m.group(1))}) {{', ts_code)

    # Add types to methods within classes
    ts_code = re.sub(r'(\w+)\s*\((.*?)\)\s*{', 
                     lambda m: f'{m.group(1)}({add_param_types(m.group(2))}): void {{', ts_code)

    # Handle arrow functions with typed parameters
    ts_code = re.sub(r'(\w+)\s*=\s*\((.*?)\)\s*=>\s*{', 
                     lambda m: f'{m.group(1)} = ({add_param_types(m.group(2))}): void => {{', ts_code)
    
    # Handle fetch requests and type the Promise and response objects
    ts_code = re.sub(
        r'\bfetch\(\s*"([^"]+)"\s*\)',
        r'fetch("\1") as Promise<Response>',
        ts_code
    )

    ts_code = re.sub(
        r'\b(response)\s*=>\s*response\.json\(\)\s*;?',
        r'\1: Response => \1.json() as Promise<any>',
        ts_code
    )

    ts_code = re.sub(
        r'\b(data)\s*=>\s*console\.log\(\s*\1\s*\)\s*;?',
        r'\1: any => console.log(\1)',
        ts_code
    )

    # Handle localStorage setItem/getItem with proper type assertions
    ts_code = re.sub(
        r'localStorage\.setItem\(\s*"([^"]+)"\s*,\s*"([^"]+)"\s*\)\s*;?',
        r'localStorage.setItem("\1", "\2");',
        ts_code
    )

    # Handle localStorage.getItem and wrap it with a type assertion
    ts_code = re.sub(
        r'localStorage\.getItem\(\s*"([^"]+)"\s*\)\s*;?',
        r'(localStorage.getItem("\1") as string | null);',
        ts_code
    )
    
    # Add explicit typing for lodash camelCase (or other functions)
    ts_code = re.sub(
        r'console\.log\(\s*(_\.camelCase\([^\)]+\))\s*\)\s*;?',
        r'const result: string = \1;\nconsole.log(result);',
        ts_code
    )

    # Handle generic type parameters (e.g., Array<T>)
    ts_code = re.sub(
        r'Array<(\w+)>',
        r'Array<\1>',
        ts_code
    )
    
    # Convert function return types to Promise if they are async
    ts_code = re.sub(
        r'(\w+)\s*=\s*async\s*\((.*?)\)\s*=>\s*',
        lambda m: f'{m.group(1)} = async ({add_param_types(m.group(2))}): Promise<any> => ',
        ts_code
    )

    # Ensure no dangling curly braces or misplaced code blocks
    ts_code = re.sub(r'\}\s*;', r'}', ts_code)
    
    
    return ts_code
# Example of using the script
if __name__ == "__main__":
    js_file_path = sys.argv[1]
    
    if os.path.exists(js_file_path):
        with open(js_file_path, 'r') as file:
            js_code = file.read()
        
        ts_code = js_to_ts(js_code)
        
        # Output the transformed TypeScript code
        print(ts_code)
    else:
        print(f"File not found: {js_file_path}")
