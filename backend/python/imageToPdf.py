from PIL import Image
import sys

def image_to_pdf(image_path, output_pdf_path):
    # Open the image
    image = Image.open(image_path)

    # Convert the image to RGB mode if it's not already in that mode
    if image.mode in ("RGBA", "P"):
        image = image.convert("RGB")

    # Save the image as a PDF
    image.save(output_pdf_path, "PDF")
    print(f"Converted {image_path} to {output_pdf_path}")

if __name__ == "__main__":
    # Pass image path and output PDF path as command-line arguments
    image_path = sys.argv[1]
    output_pdf_path = sys.argv[2]
    
    image_to_pdf(image_path, output_pdf_path)
