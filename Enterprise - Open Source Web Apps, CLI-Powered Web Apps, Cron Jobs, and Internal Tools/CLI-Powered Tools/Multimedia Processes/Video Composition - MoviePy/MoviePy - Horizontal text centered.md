![](Jxcojmv.png)


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
text = "Horizontal Title"  
  
# Create a drawing context  
draw = ImageDraw.Draw(image)  
  
# Get the text size  
text_width, text_height = draw.textsize(text, font=font)  
  
# Find the center point  
center_x = (image.width - text_width) // 2  
center_y = (image.height - text_height) // 2  
  
# Draw the text  
draw.text((center_x, center_y), text, font=font, fill=(255, 255, 255))  
  
# Save or display the image  
image_with_horizontal_title = 'image_with_horizontal_title.jpg'  
image.save(image_with_horizontal_title)  
# image.show() # opens final image from your computer
```