
## Be familiar with the issue of automatic assembling based on filename pattern

If you imported images like this:

```
image_files = [
    "/Users/wengffung/Downloads/DaVinci Assets 2/clip01.jpg",
    "/Users/wengffung/Downloads/DaVinci Assets 2/clip02.jpg",
    "/Users/wengffung/Downloads/DaVinci Assets 2/clip03.jpg",
    "/Users/wengffung/Downloads/DaVinci Assets 2/clip04.jpg",
    "/Users/wengffung/Downloads/DaVinci Assets 2/clip05.jpg",
    "/Users/wengffung/Downloads/DaVinci Assets 2/clip06.jpg",
    "/Users/wengffung/Downloads/DaVinci Assets 2/clip07.jpg"

```

Or you drag and drop thoes files into the Media Pool Panel 

What actually gets imported into the Media Pool will be:
```
clip[01-02]
clip[04-05]
clip07
```

This is because DaVinci is assuming you want to automatically assemble such named assets into clips based on the filenaming with suffixed numerical sequence. 

Reworded: The inconsistency you're experiencing is due to DaVinci Resolve automatically detecting and grouping sequentially numbered images as image sequences. When images like `clip01.jpg`, `clip02.jpg`, etc., are imported, Resolve assumes they are frames of a video sequence and groups them into a single clip in the Media Pool. This is why you see entries like `clip[01-02].jpg` or `clip[04-05].jpg`.

For your use case, this is either a needed feature or a nuance. The problem or feature extends into the coding that loads assets into media pool, not just a problem when manually importing the files through the DaVinci UI.

Thus here are different scenarios  with snippets of importing into the Media Pool and whether or not you want this feature

---

## NO Image Sequence auto assembling - Load from FILE PATHS


Snippet:
```
import sys  
sys.path.append(r'/Library/Application Support/Blackmagic Design/DaVinci Resolve/Developer/Scripting/Modules')  
sys.path.append(r'/Library/Application Support/Blackmagic Design/DaVinci Resolve/Developer/Scripting/Examples')  
  
from python_get_resolve import GetResolve  
resolve = app.GetResolve()  
  
if resolve is None:  
    print("Failed to connect to DaVinci Resolve.")  
    exit()  
  
project_manager = resolve.GetProjectManager()  
project = project_manager.GetCurrentProject()  
  
if project is None:  
    print("No project is currently open.")  
    exit()  
  
media_pool = project.GetMediaPool()  
  
# Open the Edit Page  
resolve.OpenPage("Edit")  
  
# Set timeline to current one or create a new one if needed  
timeline = project.GetCurrentTimeline()  
if timeline is None:  
    timeline = media_pool.CreateEmptyTimeline("Image Sequence Timeline")  
    project.SetCurrentTimeline(timeline)  
  
# Image files (adjust paths if needed)  
image_files = [  
    "/Users/wengffung/Downloads/DaVinci Assets 2/clip01.jpg",  
    "/Users/wengffung/Downloads/DaVinci Assets 2/clip02.jpg",  
    "/Users/wengffung/Downloads/DaVinci Assets 2/clip03.jpg",  
    "/Users/wengffung/Downloads/DaVinci Assets 2/clip04.jpg",  
    "/Users/wengffung/Downloads/DaVinci Assets 2/clip05.jpg",  
    "/Users/wengffung/Downloads/DaVinci Assets 2/clip06.jpg",  
    "/Users/wengffung/Downloads/DaVinci Assets 2/clip07.jpg"  
]  
  
# Import the images to the media pool  
media_storage = resolve.GetMediaStorage()  
  
  
imported_clips = []  
  
# Import each image individually  
for image_file in image_files:  
    clip = media_pool.ImportMedia([image_file])  
    if clip:  
        imported_clips.extend(clip)  
        print(f"Imported {clip[0].GetName()}")  
    else:  
        print(f"Failed to import {image_file}")  
  
  
if not imported_clips:  
    print("Failed to import images. Check the file paths.")  
    exit()  
  
  
# Add each clip to the timeline  
for clip in imported_clips:  
    media_pool.AppendToTimeline([clip])
```

---

## Image Sequence auto assembled based on filename sequence - Load from FOLDER PATH

Snippet:
```
import sys  
sys.path.append(r'/Library/Application Support/Blackmagic Design/DaVinci Resolve/Developer/Scripting/Modules')  
sys.path.append(r'/Library/Application Support/Blackmagic Design/DaVinci Resolve/Developer/Scripting/Examples')  
  
from python_get_resolve import GetResolve  
resolve = app.GetResolve()  
  
if resolve is None:  
    print("Failed to connect to DaVinci Resolve.")  
    exit()  
  
project_manager = resolve.GetProjectManager()  
project = project_manager.GetCurrentProject()  
  
if project is None:  
    print("No project is currently open.")  
    exit()  
  
media_pool = project.GetMediaPool()  
  
# Open the Edit Page  
resolve.OpenPage("Edit")  
  
# Set timeline to current one or create a new one if needed  
timeline = project.GetCurrentTimeline()  
if timeline is None:  
    timeline = media_pool.CreateEmptyTimeline("Image Sequence Timeline")  
    project.SetCurrentTimeline(timeline)  
  
media_storage = resolve.GetMediaStorage()  
  
import_options = {'ImportAsFolder': True}  
  
imported_clips = media_pool.ImportMedia(["/Users/wengffung/Downloads/DaVinci Assets 2/"], import_options)  
  
# imported_clips = media_storage.AddItemListToMediaPool(image_files)  
  
if not imported_clips:  
    print("Failed to import images. Check the file paths.")  
    exit()  
  
# Add the imported clips to the current timeline  
media_pool.AppendToTimeline(imported_clips)
```

---

## Image Sequence auto assembled based on filename sequence - Load from FILE PATHS

Snippet:
```
import sys
sys.path.append(r'/Library/Application Support/Blackmagic Design/DaVinci Resolve/Developer/Scripting/Modules')
sys.path.append(r'/Library/Application Support/Blackmagic Design/DaVinci Resolve/Developer/Scripting/Examples')

from python_get_resolve import GetResolve
resolve = app.GetResolve()

if resolve is None:
    print("Failed to connect to DaVinci Resolve.")
    exit()

project_manager = resolve.GetProjectManager()
project = project_manager.GetCurrentProject()

if project is None:
    print("No project is currently open.")
    exit()

media_pool = project.GetMediaPool()

# Open the Edit Page
resolve.OpenPage("Edit")

# Set timeline to current one or create a new one if needed
timeline = project.GetCurrentTimeline()
if timeline is None:
    timeline = media_pool.CreateEmptyTimeline("Image Sequence Timeline")
    project.SetCurrentTimeline(timeline)

# Image files (adjust paths if needed)
image_files = [
    "/Users/wengffung/Downloads/DaVinci Assets 2/clip01.jpg",
    "/Users/wengffung/Downloads/DaVinci Assets 2/clip02.jpg",
    "/Users/wengffung/Downloads/DaVinci Assets 2/clip03.jpg",
    "/Users/wengffung/Downloads/DaVinci Assets 2/clip04.jpg",
    "/Users/wengffung/Downloads/DaVinci Assets 2/clip05.jpg",
    "/Users/wengffung/Downloads/DaVinci Assets 2/clip06.jpg",
    "/Users/wengffung/Downloads/DaVinci Assets 2/clip07.jpg"
]

# Import the images to the media pool
media_storage = resolve.GetMediaStorage()


# Import the image files
imported_clips = media_pool.ImportMedia(image_files)


if not imported_clips:
    print("Failed to import images. Check the file paths.")
    exit()


# Add the imported clips to the current timeline
media_pool.AppendToTimeline(imported_clips)
```