import sys
import os
import tabula
import pandas as pd

# Get the PDF file and output folder from the arguments
pdf_file = sys.argv[1]
output_folder = sys.argv[2]

# Set the output file path
output_file = os.path.join(output_folder, "output.xlsx")

# Ensure the output directory exists
os.makedirs(output_folder, exist_ok=True)

try:
    # Read tables from the PDF
    tables = tabula.read_pdf(pdf_file, pages='all', multiple_tables=True)

    # Convert the tables to a single DataFrame
    df = pd.concat(tables)

    # Save the DataFrame to an Excel file
    df.to_excel(output_file, index=False)

    print("success")
except Exception as e:
    print(f"error: {str(e)}")
