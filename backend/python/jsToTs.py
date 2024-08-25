import re
import sys
import os

# Function to transform JavaScript code to TypeScript code
def js_to_ts(js_code):
    # Convert single-line comments to TypeScript documentation comments (///)
    ts_code = re.sub(r'//(.*)', r'///\1', js_code)

    # Convert multi-line comments to TypeScript format (no change needed)
    ts_code = re.sub(r'/\*([\s\S]*?)\*/', r'/*\1*/', ts_code, flags=re.DOTALL)
    
    # Convert variable declarations and infer types based on initialization
    # For number
    ts_code = re.sub(r'\b(let|const|var)\s+(\w+)\s*=\s*(-?\d+\.?\d*);', r'\1 \2: number = \3;', ts_code)
    # For string
    ts_code = re.sub(r'\b(let|const|var)\s+(\w+)\s*=\s*"([^"]+)";', r'\1 \2: string = "\3";', ts_code)
    # For boolean
    ts_code = re.sub(r'\b(let|const|var)\s+(\w+)\s*=\s*(true|false);', r'\1 \2: boolean = \3;', ts_code)
    # For arrays of numbers
    ts_code = re.sub(r'\b(let|const|var)\s+(\w+)\s*=\s*\[(\s*-?\d+(\.\d+)?\s*(,\s*-?\d+(\.\d+)?\s*)*)\];',
                     r'\1 \2: number[] = [\3];', ts_code)
    # For arrays of strings
    ts_code = re.sub(r'\b(let|const|var)\s+(\w+)\s*=\s*\["([^"]+)"(,\s*"[^"]+")*\];',
                     r'\1 \2: string[] = [\3];', ts_code)
    # For arrays of booleans
    ts_code = re.sub(r'\b(let|const|var)\s+(\w+)\s*=\s*\[(true|false)(,\s*(true|false))*\];',
                     r'\1 \2: boolean[] = [\3];', ts_code)

    # Convert object literals
    ts_code = re.sub(r'\b(let|const|var)\s+(\w+)\s*=\s*{([^}]+)};',
                     r'\1 \2: { [key: string]: any } = { \3 };', ts_code)

    # Convert function declarations and add 'any' type for parameters
    ts_code = re.sub(r'function\s+(\w+)\((.*?)\)\s*{', 
                     lambda m: f'function {m.group(1)}({add_param_types(m.group(2))}): void {{', ts_code)

    # Convert Math functions (assuming numeric return)
    ts_code = re.sub(r'Math\.(\w+)\((.*?)\)', r'Math.\1(\2): number', ts_code)

    # Convert DOM element selection to TypeScript type assertions
    ts_code = re.sub(r'\b(let|const|var)\s+(\w+)\s*=\s*document\.getElementById\(\s*"([^"]+)"\s*\);',
                     r'\1 \2 = document.getElementById("\3") as HTMLElement | null;', ts_code)

    ts_code = re.sub(r'\b(let|const|var)\s+(\w+)\s*=\s*document\.querySelector\(\s*"([^"]+)"\s*\);',
                     r'\1 \2 = document.querySelector("\3") as HTMLElement | null;', ts_code)

    # Handle addEventListener with typed parameters
    ts_code = re.sub(r'(\w+)\.addEventListener\("([^"]+)",\s*async function\s*\((.*?)\)\s*{',
                     lambda m: f'{m.group(1)}.addEventListener("{m.group(2)}", async function({add_param_types(m.group(3))}): void {{', ts_code)

    return ts_code

# Helper function to add parameter types to function signatures
def add_param_types(params):
    if not params.strip():
        return params
    param_list = [p.strip() for p in params.split(',') if p.strip()]
    typed_params = []
    for param in param_list:
        if param in ['e', 'event']:  # If the parameter is commonly used in event handling
            typed_params.append(f'{param}: Event')
        else:
            typed_params.append(f'{param}: any')
    return ', '.join(typed_params)

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
