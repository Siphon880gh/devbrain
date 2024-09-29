Get a clip and its fusion comps into memory so you can start manipulating with code. Here's the code for you to start playing around to figure out how to obtain and manipulate a clip and its fusion comps:

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