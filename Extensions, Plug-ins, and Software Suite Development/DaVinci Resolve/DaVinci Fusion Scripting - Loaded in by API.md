If you’re using DaVinci API Python, you can load the file script like (simplified, missing some variables):

That fusion_path is the filepath and the file extension is ".comp" although the file contents is the same as the ".setting" or copy and paste from Fusion screen counterparts

```
resolve = app.GetResolve()  
project = resolve.GetProjectManager().GetCurrentProject()  
timeline = project.GetCurrentTimeline()  
track = timeline.GetItemsInTrack('video', 1)  
  
clip = track[index]  
clip.ImportFusionComp(fusion_path)
```

Warning: This ImportFusionComp is not supported in .py files you drag and drop into console on free Davinci Resolve. Run these lines of codes (paste them) directly into DaVinci Resolve console (Workspace -> Console)