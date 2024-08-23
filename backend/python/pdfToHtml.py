import fitz  # PyMuPDF
import os

def pdf_to_html(pdf_path, output_folder):
    # Ensure output folder exists
    os.makedirs(output_folder, exist_ok=True)

    # Open the PDF file
    pdf_document = fitz.open(pdf_path)
    html_content = '<html><head><style>body { font-family: Arial, sans-serif;} .page { margin: 20px auto;position: relative; .text} {position: absolute; overflow: hidden; }.image { max-width: 100%; height: auto;position: absolute; } </style></head><body>'

    for page_number in range(len(pdf_document)):
        page = pdf_document.load_page(page_number)
        
        # Extract text with formatting
        text = page.get_text("html")
        html_content += f'<div class="page" id="page_{page_number + 1}" style="page-break-before: always;">{text}</div>'

        # Extract images
        image_list = page.get_images(full=True)
        for img_index, image in enumerate(image_list):
            xref = image[0]
            base_image = pdf_document.extract_image(xref)
            image_bytes = base_image["image"]
            image_filename = os.path.join(output_folder, f"page_{page_number + 1}_img_{img_index + 1}.png")

            with open(image_filename, "wb") as img_file:
                img_file.write(image_bytes)
            
            html_content += f'<img src="{image_filename}" alt="Page {page_number + 1} Image {img_index + 1}" style="max-width: 100%; height: auto;">'

    html_content += '</body></html>'
    
    # Save HTML file
    html_file_path = os.path.join(output_folder, 'output.html')
    with open(html_file_path, "w", encoding="utf-8") as html_file:
        html_file.write(html_content)

    return html_file_path

if __name__ == "__main__":
    import sys
    pdf_path = sys.argv[1]
    output_folder = sys.argv[2]
    html_file = pdf_to_html(pdf_path, output_folder)
    print(f"HTML file saved at: {html_file}")
