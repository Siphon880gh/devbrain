
Titled: Apply LUT programmatically to a timeline clip

You can apply the LUT programmatically

The main call is:
```
lut_applied = timeline_items[1].SetLUT(1, '/Users/admin/Movies/lut.3dl')
```

Make sure to have clips in your timeline at Video track 1

If you need the init, run this first:
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
timeline_items = track
```

If you don’t actually have a custom LUT file (you also may have to register the LUT with DaVinci) or want to try the LUTs that come with DaVinci:  
  
   - On **macOS**: `/Library/Application Support/Blackmagic Design/DaVinci Resolve/LUT`
   - On **Windows**: `C:\ProgramData\Blackmagic Design\DaVinci Resolve\Support\LUT`
   - On **Linux**: `/opt/resolve/LUT`

Get the filepath to a LUT file and adjust the script that applies the LUT to the first timeline clip in video track 1

Eg. `/Library/Application Support/Blackmagic Design/DaVinci Resolve/LUT/Astrodesign/ALog to ARRI Log C.cube` 

And at such, eg.
```
lut_applied = timeline_items[1].SetLUT(1, '/Library/Application Support/Blackmagic Design/DaVinci Resolve/LUT/RED/RWG_Log3G10_to_REC709_BT1886_with_LOW_CONTRAST_and_R_3_Soft_size_33.cube')
```
^We use that LUT because it’s one of the noticeable ones

Note: LUT files end with various possible file extensions, including .cube.

QUIRK: If your preview monitor is already on the clip before you apply the LUT programmatically, you might not see the new LUT applied in the preview monitor. Just drag the playhead in any direction which will refresh the preview monitor