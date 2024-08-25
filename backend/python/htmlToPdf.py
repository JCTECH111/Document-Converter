import pdfkit

def convert_html_to_pdf(url, output_pdf):
    try:
        # Convert the URL to a PDF file
        pdfkit.from_url(url, output_pdf)
        print(f"Converted {url} to {output_pdf}")
    except Exception as e:
        print(f"An error occurred: {str(e)}")

if __name__ == "__main__":
    import sys
    url = sys.argv[1]
    output_pdf = sys.argv[2]

    convert_html_to_pdf(url, output_pdf)
