import sys
from PIL import Image
import os
import cairosvg
import subprocess

# Read command line arguments
input_file = sys.argv[1]  # Input image file path
output_file = sys.argv[2]  # Output image file path
output_format = sys.argv[3].upper()  # Desired format (e.g., 'PNG', 'JPEG', etc.)

try:
    # Check if the input file is SVG
    if input_file.lower().endswith('.svg'):
        # Convert SVG to PNG or another format using CairoSVG
        if output_format in ['PNG', 'JPEG', 'BMP', 'WEBP']:
            png_data = cairosvg.svg2png(url=input_file)
            with open(output_file, 'wb') as f:
                f.write(png_data)
            print(f"SVG successfully converted to {output_format}")
        else:
            print(f"Conversion to {output_format} is not supported for SVG files.")
    elif output_format == "SVG":
        # For converting raster images to SVG, we use potrace or autotrace
        if input_file.lower().endswith(('.png', '.jpg', '.jpeg', '.bmp')):
            # First, we convert the image to a bitmap format (PBM/PGM)
            with Image.open(input_file) as img:
                img = img.convert('L')  # Convert image to grayscale
                temp_pgm = f'{os.path.splitext(input_file)[0]}.pgm'
                img.save(temp_pgm, 'PPM')

            # Run potrace to convert the bitmap (pgm) to SVG
            command = f'potrace {temp_pgm} -s -o {output_file}'
            subprocess.run(command, shell=True)

            # Remove the temporary file
            os.remove(temp_pgm)
            print(f"Raster image successfully converted to SVG")
        else:
            print(f"Conversion to SVG is not supported for this file type")
    else:
        # Open the input image file
        with Image.open(input_file) as img:
            # Convert to RGB if necessary (JPEG doesn't support transparency)
            if output_format in ['JPEG', 'BMP'] and img.mode in ['RGBA', 'LA']:
                img = img.convert('RGB')

            # Save the image in the new format
            img.save(output_file, output_format)
            print(f"Image successfully converted to {output_format}")

except Exception as e:
    print(f"Failed to convert image: {e}")
