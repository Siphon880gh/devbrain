```
from moviepy.editor import VideoFileClip, TextClip, CompositeVideoClip, ColorClip  
from sys import exit  
  
# Load the video file you created with OpenCV  
video = VideoFileClip('composed.mp4')  
  
# Define your subtitles with their respective start and end times  
SUBTITLES = [  
{"start_time":0, "end_time":10, "text":"Abel: [Gently setting down her tea] Barbara, you've been quiet."},  
{"start_time":11, "end_time":20, "text":"Barbara: [Meeting Abel's gaze, acknowledges her attention but hesitates] Em, what do you mean?"},  
{"start_time":21, "end_time":30, "text":"Ceci: [Noticing the charged silence, leans in with a knowing glance toward Barbara.]"},  
{"start_time":31, "end_time":43, "text":"Darcy: [Mirrors their inquisitive looks and pretends she's aware what's going on] Yes, it's high time we brought that up."}  
]  
  
# Create TextClip objects for each subtitle and set their timings  
text_clips = []  
for subtitle in SUBTITLES:  
# Create and render the TextClip to calculate its size  
txt_clip = TextClip(subtitle["text"], fontsize=24, color='white', bg_color='black', font='Arial')  
# You need to set duration and start to render and therefore calculate size  
txt_clip = txt_clip.set_duration(subtitle["end_time"] - subtitle["start_time"]).set_start(subtitle["start_time"])  
txt_clip = txt_clip.set_position(('center', 'bottom')) # Temporarily set to bottom to enable size calculation  
# Now that the TextClip has been rendered, we can calculate its size and adjust the position  
txt_position = ('center', video.size[1] - txt_clip.size[1] - 20) # 20 pixels above the bottom edge  
# Set the final position now that we have the size  
txt_clip = txt_clip.set_position(txt_position)  
text_clips.append(txt_clip)  
  
composite = CompositeVideoClip([video] + text_clips)  
composite.write_videofile('subbed.mp4', codec='libx264', audio_codec='aac')
```