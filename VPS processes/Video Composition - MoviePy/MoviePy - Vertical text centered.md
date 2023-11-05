![](https://i.imgur.com/Q4Euioz.png)


```
from PIL import Image, ImageDraw, ImageFont  
  
# Load your image  
image_path = 'testTitle.jpg'  
image = Image.open(image_path)  
  
# Choose a font  
font_path = "./DejaVuSans-Bold.ttf"  # Or another path to a font file  
font_size = 30  
font = ImageFont.truetype(font_path, font_size)  
  
# The text to add  
text = "Vertical Title"  
  
# Create a drawing context  
draw = ImageDraw.Draw(image)  
  
# Get the total text height when drawn vertically  
text_height_total = font_size * len(text)  
  
# Find the center point (horizontal and vertical)  
center_x = (image.width) // 2  
center_y = (image.height) // 2  
  
# Calculate where to start the text to center it (initial X stays the same for vertical text)  
initial_x = center_x - (font_size // 2)  
initial_y = center_y - (text_height_total // 2)  
  
# Draw each character vertically  
for index, char in enumerate(text):  
    current_x = initial_x  
    current_y = initial_y + (index * font_size)  
    draw.text((current_x, current_y), char, font=font, fill=(255, 255, 255))  
  
# Save or display the image  
image_with_vertical_title = 'image_with_vertical_title.jpg'  
image.save(image_with_vertical_title)  
# image.show() # opens final image from your computer
```