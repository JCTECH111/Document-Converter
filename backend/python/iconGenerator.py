from PIL import Image, ImageDraw, ImageFont, ImageFilter
import os

# Define image formats and their corresponding gradient colors (start and end colors)
formats = {
    'JPEG': [(255, 153, 51), (255, 94, 0)],    # Orange gradient for JPEG
    'PNG': [(102, 178, 255), (0, 102, 204)],   # Blue gradient for PNG
    'GIF': [(153, 204, 0), (102, 153, 0)],     # Green gradient for GIF
    'BMP': [(255, 102, 102), (204, 0, 0)],     # Red gradient for BMP
    'TIFF': [(255, 255, 102), (255, 204, 0)],  # Yellow gradient for TIFF
    'WEBP': [(153, 51, 255), (102, 0, 204)],    # Purple gradient for WEBP
    'SVG': [(0, 255, 0), (0, 128, 0)]    # Purple gradient for WEBP
}

# Font settings (you might need to download a TTF font and specify the path)
font_path = "arial.ttf"  # Specify the path to your font file
font_size = 40

# Define the relative path to the assets folder (two levels up from the current script folder)
assets_folder = os.path.join(os.path.dirname(__file__), '../../assets/')

# Create the assets folder if it doesn't exist
if not os.path.exists(assets_folder):
    os.makedirs(assets_folder)

# Function to create a gradient background
def create_gradient(size, color1, color2):
    base = Image.new('RGB', size, color1)
    top = Image.new('RGB', size, color2)
    mask = Image.linear_gradient("L")
    mask = mask.resize(size)
    return Image.composite(base, top, mask)

# Create rounded rectangle mask for rounded corners
def create_rounded_mask(size, radius):
    mask = Image.new('L', size, 0)
    draw = ImageDraw.Draw(mask)
    draw.rounded_rectangle([0, 0, size[0], size[1]], radius, fill=255)
    return mask

# Create icons
for fmt, (start_color, end_color) in formats.items():
    # Create gradient background image
    img = create_gradient((200, 200), start_color, end_color)
    
    # Create a rounded corner mask and apply it to the image
    rounded_mask = create_rounded_mask((200, 200), 40)
    img.putalpha(rounded_mask)

    # Draw the format name text on the image
    draw = ImageDraw.Draw(img)
    try:
        font = ImageFont.truetype(font_path, font_size)
    except IOError:
        font = ImageFont.load_default()

    # Get text size and position it at the center using textbbox()
    text = fmt
    bbox = draw.textbbox((0, 0), text, font=font)
    text_width = bbox[2] - bbox[0]
    text_height = bbox[3] - bbox[1]
    text_x = (img.width - text_width) // 2
    text_y = (img.height - text_height) // 2

    # Draw shadow text slightly offset for a shadow effect
    shadow_offset = 2
    draw.text((text_x + shadow_offset, text_y + shadow_offset), text, fill=(0, 0, 0), font=font)

    # Draw the main text (on top of the shadow)
    draw.text((text_x, text_y), text, fill=(255, 255, 255), font=font)

    # Save the image to the assets folder with the format name as the filename (convert to PNG if needed)
    img.save(os.path.join(assets_folder, f'{fmt.lower()}_icon.png'))

print(f"Stylish icons created successfully in {assets_folder}!")
