import json
from lxml import etree, html
import sys
import os

# Load JSON file
with open('../Data/html-fxml.json', 'r') as file:
    data = json.load(file)

# Extract HTML and FXML examples from the JSON file
html_examples = data['dataset']['.html']
fxml_examples = data['dataset']['.fxml']

# Predefined hardcoded mapping for common elements
html_to_fxml_mapping = {
    'div': 'AnchorPane',
    'p': 'Label',
    'span': 'Text',
    'button': 'Button',
    'input': 'TextField',
    'select': 'ComboBox',
    'textarea': 'TextArea',
    'img': 'ImageView',
    'a': 'Hyperlink',
    'ul': 'ListView',
    'ol': 'ListView',
    'li': 'Label',
    'h1': 'Text',
    'h2': 'Text',
    'h3': 'Text',
    'h4': 'Text',
    'table': 'TableView',
    'thead': 'TableView',
    'tbody': 'TableView',
    'tr': 'TableRow',
    'th': 'TableColumn',
    'td': 'TableCell',
    'tfoot': 'TableView',
    'video': 'MediaView',
    'audio': 'MediaView',
    'canvas': 'Canvas',
    'nav': 'HBox',
    'footer': 'VBox',
}

# Function to map HTML tags to FXML based on both the hardcoded mapping and the JSON file
def map_html_to_fxml(tag):
    # First check in the predefined hardcoded mapping
    if tag in html_to_fxml_mapping:
        return html_to_fxml_mapping[tag]

    # If not found in the hardcoded mapping, search in the JSON file
    for example_name, example in html_examples.items():
        if tag in example['code']:
            return fxml_examples[example_name]['code'].split(' ')[0].strip('<>')
    
    # Default FXML tag if no mapping found
    return 'Label'

# Function to convert HTML inline CSS to FXML compatible style
def convert_css_to_fxml(css):
    css_map = {
    'background': '-fx-background-color',
    'background-color': '-fx-background-color',
    'background-image': '-fx-background-image',
    'background-repeat': '-fx-background-repeat',
    'background-size': '-fx-background-size',
    'background-position': '-fx-background-position',
    'border': '-fx-border-width',  # Combines width, color, and style
    'border-width': '-fx-border-width',
    'border-color': '-fx-border-color',
    'border-style': '-fx-border-style',
    'border-radius': '-fx-background-radius',
    'color': '-fx-text-fill',
    'font-size': '-fx-font-size',
    'font-family': '-fx-font-family',
    'font-weight': '-fx-font-weight',
    'font-style': '-fx-font-style',
    'text-align': '-fx-text-alignment',
    'text-decoration': '-fx-strikethrough',  # Includes underline
    'line-height': '-fx-line-spacing',
    'letter-spacing': '-fx-letter-spacing',
    'word-spacing': '-fx-word-spacing',
    'text-transform': '-fx-text-transform',
    'text-shadow': '-fx-effect',  # Requires effect property for shadows
    'width': '-fx-pref-width',
    'height': '-fx-pref-height',
    'padding': '-fx-padding',
    'margin': '-fx-margin',
    'display': '-fx-visibility',  # For visibility
    'overflow': '-fx-clip',  # For clipping
    'opacity': '-fx-opacity',
    'z-index': '-fx-z-index',
    'box-shadow': '-fx-effect',  # Requires effect property for shadows
    'transform': '-fx-transform',  # For transformations
    'transition': '-fx-transition',  # For animations
    'animation': '-fx-animation',  # For animations
    'cursor': '-fx-cursor',
    'position': '-fx-layout-x',  # For positioning
    'top': '-fx-layout-margin-top',
    'right': '-fx-layout-margin-right',
    'bottom': '-fx-layout-margin-bottom',
    'left': '-fx-layout-margin-left',
    'clip': '-fx-clip',  # For clipping
    'align-items': '-fx-alignment',
    'align-content': '-fx-alignment',
    'align-self': '-fx-alignment',
    'flex': '-fx-flex',
    'flex-direction': '-fx-flex-direction',
    'flex-wrap': '-fx-flex-wrap',
    'justify-content': '-fx-justify-content',
    'align-items': '-fx-align-items',
    'align-content': '-fx-align-content',
    'align-self': '-fx-align-self',
    'grid-template-columns': '-fx-grid-columns',
    'grid-template-rows': '-fx-grid-rows',
    'grid-column': '-fx-grid-column',
    'grid-row': '-fx-grid-row',
    'grid-area': '-fx-grid-area',
    'grid-column-start': '-fx-grid-column-start',
    'grid-column-end': '-fx-grid-column-end',
    'grid-row-start': '-fx-grid-row-start',
    'grid-row-end': '-fx-grid-row-end',
    'gap': '-fx-gap',
    'column-gap': '-fx-column-gap',
    'row-gap': '-fx-row-gap',
    'list-style': '-fx-list-style',
    'list-style-type': '-fx-list-style-type',
    'list-style-position': '-fx-list-style-position',
    'list-style-image': '-fx-list-style-image',
    'border-collapse': '-fx-border-collapse',
    'border-spacing': '-fx-border-spacing',
    'caption-side': '-fx-caption-side',
    'empty-cells': '-fx-empty-cells',
    'visibility': '-fx-visibility',
    'pointer-events': '-fx-pointer-events',
    'resize': '-fx-resize',
    'outline': '-fx-outline',
    'outline-width': '-fx-outline-width',
    'outline-style': '-fx-outline-style',
    'outline-color': '-fx-outline-color',
    'object-fit': '-fx-object-fit',
    'object-position': '-fx-object-position',
    'quotes': '-fx-quotes',
    'page-break-before': '-fx-page-break-before',
    'page-break-after': '-fx-page-break-after',
    'page-break-inside': '-fx-page-break-inside',
    'text-indent': '-fx-text-indent',
    'text-overflow': '-fx-text-overflow',
    'word-break': '-fx-word-break',
    'word-wrap': '-fx-word-wrap',
    'hyphens': '-fx-hyphens',
    'white-space': '-fx-white-space',
    'direction': '-fx-direction',
    'text-align-last': '-fx-text-align-last',
    'text-justify': '-fx-text-justify',
    'text-kashida': '-fx-text-kashida',
    'text-kashida-space': '-fx-text-kashida-space',
    'text-indent': '-fx-text-indent',
    'text-overflow': '-fx-text-overflow',
    'text-transform': '-fx-text-transform',
    'text-shadow': '-fx-effect',  # Requires effect property for shadows
    'letter-spacing': '-fx-letter-spacing',
    'word-spacing': '-fx-word-spacing',
    'white-space': '-fx-white-space',
    'overflow-wrap': '-fx-overflow-wrap',
    'line-clamp': '-fx-line-clamp',
    'resize': '-fx-resize',
    'overflow': '-fx-clip',
    'scroll-behavior': '-fx-scroll-behavior',
    'scrollbar-color': '-fx-scrollbar-color',
    'scrollbar-width': '-fx-scrollbar-width',
    'scrollbar-track-color': '-fx-scrollbar-track-color',
    'scrollbar-thumb-color': '-fx-scrollbar-thumb-color',
    'scrollbar-width': '-fx-scrollbar-width',
    'scrollbar': '-fx-scrollbar',
    'overflow-x': '-fx-overflow-x',
    'overflow-y': '-fx-overflow-y',
    'animation-name': '-fx-animation-name',
    'animation-duration': '-fx-animation-duration',
    'animation-timing-function': '-fx-animation-timing-function',
    'animation-delay': '-fx-animation-delay',
    'animation-iteration-count': '-fx-animation-iteration-count',
    'animation-direction': '-fx-animation-direction',
    'animation-fill-mode': '-fx-animation-fill-mode',
    'animation-play-state': '-fx-animation-play-state',
    'transition-property': '-fx-transition-property',
    'transition-duration': '-fx-transition-duration',
    'transition-timing-function': '-fx-transition-timing-function',
    'transition-delay': '-fx-transition-delay',
    'clip-path': '-fx-clip-path',
    'filter': '-fx-effect',
    'backface-visibility': '-fx-backface-visibility',
    'transform-style': '-fx-transform-style',
    'perspective': '-fx-perspective',
    'perspective-origin': '-fx-perspective-origin',
    'transform-origin': '-fx-transform-origin',
    'transform': '-fx-transform',
    'transform-box': '-fx-transform-box',
    'transform-function': '-fx-transform-function',
    'transform-style': '-fx-transform-style',
}

    
    fxml_style = []
    for style in css.split(';'):
        if ':' in style:
            key, value = style.split(':')
            key = key.strip()
            value = value.strip()
            if key in css_map:
                fxml_style.append(f"{css_map[key]}: {value};")
    
    return ''.join(fxml_style)
def handle_embedded_elements(element):
    if element.text and element.text.strip():
        return element.text.strip()
    
    inner_text = []
    for child in element:
        if child.text:
            inner_text.append(child.text.strip())
        inner_text.append(handle_embedded_elements(child))
    return ' '.join(inner_text)

# Function to convert HTML to FXML
def html_to_fxml(html_code):
    tree = html.fromstring(html_code)

    # Define namespaces for FXML
    nsmap = {'fx': 'http://javafx.com/fxml/1'}
    
    def convert_element(element):
        # Only process valid element nodes
        if not isinstance(element.tag, str):
            return None

        tag = element.tag.lower()
        fxml_tag = map_html_to_fxml(tag)

        if tag == 'link':
            href = element.get('href')
            if href:
                return etree.Comment('Stylesheets are added in the application code, not directly in FXML')
        if tag == 'script':
             return etree.Comment('Script Tag not Allowed in fxml')
        if tag == 'style':
             return etree.Comment('Internal Css aren\'t allowed only inline css')
        # Handle TableView separately to structure correctly
        if fxml_tag == 'TableView':
            new_element = etree.Element(fxml_tag, nsmap=nsmap)
            columns = etree.SubElement(new_element, 'columns')
            items = etree.SubElement(new_element, 'items')
            for child in element:
                if child.tag.lower() == 'thead':
                    # Convert thead into columns
                    for header in child.findall('.//tr'):
                        for th in header:
                            column = etree.SubElement(columns, 'TableColumn', text=th.text or '')
                elif child.tag.lower() == 'tbody':
                    # Convert tbody into rows
                    fxcollections = etree.SubElement(items, 'FXCollections', fx_factory='observableArrayList')
                    for row in child.findall('.//tr'):
                        table_row = etree.SubElement(fxcollections, 'TableRow')
                        for td in row:
                            table_cell = etree.SubElement(table_row, 'TableCell')
                            table_cell.text = td.text or ''
            return new_element
        # Create the FXML element with the 'fx' namespace
        new_element = etree.Element(fxml_tag, nsmap=nsmap)

        # Handle attributes such as 'id', 'class', and 'style'
        for attr, value in element.attrib.items():
            if attr == 'style':
                # Convert CSS to FXML style
                new_element.set('style', convert_css_to_fxml(value))
            elif attr == 'id':
                # Use the 'fx' namespace for 'id'
                new_element.set('{http://javafx.com/fxml/1}id', value)
            elif attr == 'class':
                new_element.set('styleClass', value)
        
        # Recursively convert child elements
        for child in element:
            new_child = convert_element(child)
            if new_child is not None:
                new_element.append(new_child)
        # Handle text content for Label and Text elements
        if fxml_tag in ['Label', 'Text']:
            new_element.set('text', handle_embedded_elements(element))

        # # Set text content if present
        # if element.text and element.text.strip():
        #     new_element.text = element.text.strip()

        return new_element

    # Convert the root HTML element
    fxml_root = convert_element(tree)
    return etree.tostring(fxml_root, pretty_print=True).decode('utf-8')

def convert_html_file_to_fxml(html_file_path):
    if os.path.exists(html_file_path):
        with open(html_file_path, 'r') as file:
            html_code = file.read()

        fxml_code = html_to_fxml(html_code)
        
        # Print the FXML code
        print(fxml_code)
    else:
        print(f"File not found: {html_file_path}")

if __name__ == "__main__":
    if len(sys.argv) > 1:
        # Get the HTML file path from command-line arguments
        html_file_path = sys.argv[1]
        
        # Check if the file exists and convert
        convert_html_file_to_fxml(html_file_path)
    else:
        print("Usage: python convert_html_to_fxml.py <path_to_html_file>")
