import pikepdf
import sys

def lock_pdf(input_pdf, output_pdf, password):
    try:
        # Open the PDF without password
        with pikepdf.open(input_pdf) as pdf:
            # Encrypt and save the PDF with the specified password
            pdf.save(output_pdf, encryption=pikepdf.Encryption(user=password, owner=password))
            print("PDF locked successfully.")
    except Exception as e:
        print(f"Failed to lock PDF: {e}")

if __name__ == "__main__":
    input_pdf = sys.argv[1]
    output_pdf = sys.argv[2]
    password = sys.argv[3]
    lock_pdf(input_pdf, output_pdf, password)
