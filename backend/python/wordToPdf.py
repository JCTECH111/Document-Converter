from docx2pdf import convert

def convert_docx_to_pdf(input_docx, output_pdf):
    # Convert the Word document to PDF
    convert(input_docx, output_pdf)
    print(f"Converted {input_docx} to {output_pdf}")

if __name__ == "__main__":
    import sys
    input_docx = sys.argv[1]
    output_pdf = sys.argv[2]
    
    convert_docx_to_pdf(input_docx, output_pdf)
