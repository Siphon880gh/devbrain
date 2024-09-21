
Free version limitations:
- A lot of API features are not working on free version but works in paid version. DaVinci seems to have nerfed the API so that it becomes impossible to automate creating a video on the free version without some manual mouse work inbetween running multiple scripts
- Free version does not allow you to run .py files directly from your computer or server. You have to either:
	- Drag and drop the .py into the DaVinci Console
	- Or copy and paste the code into the DaVinci Console (it looks like a single line input but it can handle multiple lines)
- Some API features only work inputted or pasted into the DaVinci console, especially Fusion manipulation code.
- For a more extensive list on the limitations, refer to the rest of this document

---

Example of that doesn't work with .py files that get dropped into the Davinci console, but the code works if you input it directly into Davinci console or paste into the Davinci console

This snippet importing a Fusion composition file's nodes into a current clip:
```
resolve = app.GetResolve()  
project = resolve.GetProjectManager().GetCurrentProject()  
timeline = project.GetCurrentTimeline()  
clip = timeline.GetItemsInTrack('video', 1)[1]  
clip.ImportFusionComp("/Users/wengffung/dev/web/temp-vid/fusion_compiled/exported.comp")
```

Only works when ran / pasted inside the Davinci Console
