Use this boilerplate to start coding with DaVinci Resolve! Remember that the DaVinci Resolve free version makes it inconvenient to script. You have to drag and drop your py file into the DaVinci console, and some API features can only work if you've pasted directly into the DaVinci console.

Here's the code for the free DaVinici Resolve:
```
# Init Resolve
# ------------------------------------------------
import importlib.util
resolve = None

import sys
sys.path.append(r'/Library/Application Support/Blackmagic Design/DaVinci Resolve/Developer/Scripting/Modules')
sys.path.append(r'/Library/Application Support/Blackmagic Design/DaVinci Resolve/Developer/Scripting/Examples')

if resolve == None:
    resolve = None
    if importlib.util.find_spec("DaVinciResolveScript") is not None:
        import DaVinciResolveScript as dvr_script
        test_init = dvr_script.scriptapp("Resolve")
        if(test_init is not None):
            resolve = test_init
        else:
            if app is not None:
                resolve = app.GetResolve()
    else:
        # app is available during runtime with DaVinci Resolve's console
        if app is not None:
            resolve = app.GetResolve()
    globals()['resolve'] = resolve


if resolve is None:
	print("Failed to connect to DaVinci Resolve.")
	exit()
else:
    print("Connected to DaVinci Resolve API...")

# _OTHER IMPORTS
# ------------------------------------------------

# Common Objects
# ------------------------------------------------
project_manager = resolve.GetProjectManager()
project = project_manager.GetCurrentProject()
media_pool = project.GetMediaPool()

# Remove timeline block if not applicable
try: 
    timeline = project.GetCurrentTimeline()
except Exception as e: # Comment/Uncomment as needed
    # print("ERROR - No timeline is currently open.")
    # print(e)
    # exit()
    media_pool.CreateEmptyTimeline("Timeline 1")
    timeline = project.GetCurrentTimeline()
    pass

# Remove this video track 1 block if not applicable
try: 
    track = timeline.GetItemsInTrack('video', 1)
except Exception as e:
    print("ERROR - No video track is available in opened timeline. Does your script work with an existing track? If not, you don't need this object - go ahead and remove this block.")
    print(e)
    exit()

# _SCRIPT:
# ------------------------------------------------

```


Add other imports at "OTHER IMPORTS". Continue the rest of the code under the Script section.