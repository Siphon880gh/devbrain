
List available fonts: You can list the fonts available to MoviePy with TextClip.list('font') to see if 'Arial' is listed there. If it's not, you may either need to install it or use a different font that is available.

from moviepy.editor import VideoFileClip, TextClip, CompositeVideoClip, ColorClip

print(TextClip.list('font'))


