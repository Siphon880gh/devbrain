Use this boilerplate to start coding with DaVinci Resolve! Remember that the DaVinci Resolve free version makes it convenient to script. You have to drag and drop your py file into the DaVinci console, and some API features can only work if you've pasted directly into the DaVinci console.

Here's the code:
```
# Init Resolve
# ------------------------------------------------
import importlib.util
resolve = None

if importlib.util.find_spec("DaVinciResolveScript") is not None:
    import DaVinciResolveScript as dvr_script
    resolve = dvr_script.scriptapp("Resolve")
else:
    resolve = app.GetResolve() # app is available during runtime with DaVinci Resolve's console

# Common Objects
# ------------------------------------------------
project_manager = resolve.GetProjectManager()
project = project_manager.GetCurrentProject()
timeline = project.GetCurrentTimeline()
track = timeline.GetItemsInTrack('video', 1)

# Script
# ------------------------------------------------
```