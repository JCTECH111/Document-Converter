import pandas as pd
from matplotlib.backends.backend_pdf import PdfPages
import matplotlib.pyplot as plt

def excel_to_pdf(input_excel_path, output_pdf_path):
    # Load the Excel file
    df = pd.read_excel(input_excel_path)
    
    # Create a PDF file
    with PdfPages(output_pdf_path) as pdf:
        # Plot each sheet to the PDF
        fig, ax = plt.subplots(figsize=(8, 6))
        ax.axis('tight')
        ax.axis('off')
        table_data = df.values.tolist()
        table = ax.table(cellText=table_data, colLabels=df.columns, loc='center', cellLoc='center')
        pdf.savefig(fig)

if __name__ == "__main__":
    import sys
    input_xlsx = sys.argv[1]
    output_pdf = sys.argv[2]
    excel_to_pdf( input_xlsx, output_pdf)
