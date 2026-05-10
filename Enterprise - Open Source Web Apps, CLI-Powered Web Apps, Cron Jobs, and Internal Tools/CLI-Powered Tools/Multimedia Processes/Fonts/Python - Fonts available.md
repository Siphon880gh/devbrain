
Fonts available, why? Gs. Could be combined with Pillow for manipulating images in python (CV2 also manipulates images but you’re stuck with their own and only font)  


```
# txt_clip = TextClip(subtitle["text"], fontsize=50, color='white', font='Arial')
# For macOS and Linux, the list can also be found in directories such as /usr/share/fonts/, /Library/Fonts/, and ~/.fonts/.
# Get fonts on your server/computer with:

# ==> Deprecated as of Mathplotlib 3.2 (circa early 2020)
# from matplotlib import font_manager

# font_paths = font_manager.findSystemFonts()
# fonts = font_manager.createFontList(font_paths)

# for font in fonts:
# print(font.name)

  
# ==> Draw with font family from system
from matplotlib import font_manager

# Instantiate a font manager object, which will load all the system fonts
font_list = font_manager.FontManager()


# Iterate through the ttf (TrueType Font) list attribute of the FontManager object

for font in font_list.ttflist:
 print(font.name)
```