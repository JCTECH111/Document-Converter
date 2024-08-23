import sys
import os
from pdf2docx import Converter
from PyPDF2 import PdfReader

# Update environment path for poppler if needed
os.environ['PATH'] += r';C:\poppler-24.07.0\Library\bin'

# Retrieve arguments
pdf_file = sys.argv[1]
format = sys.argv[2].lower()  # Ensuring format is in lowercase for consistency
output_folder = sys.argv[3]
output_file = os.path.join(output_folder, f"output.{format}")

# Ensure the output directory exists
os.makedirs(output_folder, exist_ok=True)

try:
    # Count the number of pages in the PDF
    reader = PdfReader(pdf_file)
    num_pages = len(reader.pages)

    # Check if the PDF has more than 20 pages
    if num_pages > 20:
        print(f"too_big: file inputted {num_pages} pages")
        sys.exit(0)

    if format == 'docx':
        # Convert PDF to DOCX
        cv = Converter(pdf_file)
        cv.convert(output_file)
        cv.close()

        # Return success message along with the page count
        print(f"success,{num_pages}")
    else:
        print(f"Unsupported format: {format}")
except Exception as e:
    print(f"Error: {str(e)}")

