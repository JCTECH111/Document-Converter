import sys
import os
from pdf2image import convert_from_path

# Get the PDF file and output folder from the command-line arguments
pdf_file = sys.argv[1]
output_folder = sys.argv[2]
image_format = sys.argv[3].lower()  # The format, e.g., 'jpg' or 'png'

# Ensure the output directory exists
os.makedirs(output_folder, exist_ok=True)

# Set path for poppler binaries (Windows only)
os.environ['PATH'] += r';C:\poppler-24.07.0\Library\bin'  # Adjust this to your poppler path

try:
    # Convert the PDF to images
    images = convert_from_path(pdf_file)

    # Map image formats for Pillow compatibility
    if image_format == 'jpg':
        image_format = 'JPEG'
    elif image_format == 'png':
        image_format = 'PNG'

    # Save each page as an image file
    for i, image in enumerate(images):
        image_file = os.path.join(output_folder, f"page_{i + 1}.{image_format.lower()}")
        image.save(image_file, image_format)
        print(f"Saved image: {image_file}")
    
    # print("success")
except Exception as e:
    print(f"error: {str(e)}")
