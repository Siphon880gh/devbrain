
There are API that are undocumented. Someone discovered these methods using a hex viewer. Unfortunately, BMD blocked the hex viewer on Resolve 17 Windows onwards. Some undocumented methods may still work:

---

**Add track**

```
resolve = app.GetResolve()  
projectManager = resolve.GetProjectManager()  
  
# Get the active project  
project = projectManager.GetCurrentProject()  
  
# Get the current timeline  
timeline = project.GetCurrentTimeline()  
timeline.AddTrack("video")
```

In Resolve 18 I've found that you can no longer use "adaptive" for _audioChannelSubType_ when adding an audio track.  
```
bool **AddTrack**(string trackType, _string audioChannelSubType_)  
```
  
You have to specify "adaptive1" up to "adaptive24" (or "mono", "stereo", "5.1film", "7.1film" like before).

Above discussed here: [https://forum.blackmagicdesign.com/viewtopic.php?f=21&t=94911](https://forum.blackmagicdesign.com/viewtopic.php?f=21&t=94911)

---

**More Undocumented APIs**

[https://forum.blackmagicdesign.com/viewtopic.php?f=21&t=113040](https://forum.blackmagicdesign.com/viewtopic.php?f=21&t=113040)