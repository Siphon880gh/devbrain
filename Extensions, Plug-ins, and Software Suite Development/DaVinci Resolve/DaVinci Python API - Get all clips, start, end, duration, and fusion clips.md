
This demonstrates how to get all clips, start, end, duration, and fusion clips

Note the timeline gets whatever timeline is opened when you run this code from the DaVinci console (either pasting/typing in it, or dropping .py file into it)

```
resolve = app.GetResolve()
project = resolve.GetProjectManager().GetCurrentProject()
timeline = project.GetCurrentTimeline()
track = timeline.GetItemsInTrack('video', 1) # At Video Track 1

print("TEST: Expect see clip and a fusion composition (eg. Composition 1) at every index")

# Loop through each clip in the video track and create a new Fusion clip
for clip_index, clip in track.items():
    print("")
    # clip.SetStart(0)
    print(f"See Clip {clip_index} that starts and ends {clip.GetStart()}, {clip.GetEnd()}, {clip.GetDuration()}: ", clip)  
    clip.AddFusionComp()
    print("Fusion Clips list: ", clip.GetFusionCompNameList())
```

You may find this snippet helpful because you can refactor it for your purpose.

Warning: Free version does not support setting start, end and duration, though you can continue to get their values.