The developer experience is horrible

- Paid version allows you to run scripts externally from your own terminal instead of having to drag and drop into DaVinci’s Console
- Free version makes you drag and drop .py python script files into the DaVinci console and some API are only supported inputted directly into the DaVinci console
-  **_DaVinci likes to keep changing their API syntax from version to version._**
	- Solutions found online and chatgpt may be very outdated
	- There were useful APIs that DaVinci removed.

- API Maturity: The API is still developing and is not a huge priority to BlackMagic Design. Many API features you expect from a full product are missing.
- API Stability: BMD likes to change the syntax version to version. You may want to keep a working copy of your installation.
- Lack of VS Code Aid: 
	- There is hardly any autocompletion on VS Code
	- Free version requires you to initiate with `resolve = app.GetResolve()` but app is by all logic undefined and gets complained about on VS Code. The python file is drag and dropped into Davinci console to run, so that's when app gets defined.

---

Because of version syntax changes, ChatGPT is rendered useless in many cases

ChatGPT o1 model is gonna give you code that doesnt work on free version even if you inform them it’s free. It even in one chat says no scripting is allowed in free DaVinci when it's not true

When asked how to initialize free DaVinci API, it gave _`resolve = GetResolve()` , but the correct code requires “app” like in: `resolve = app.GetResolve()` . Discussed at [https://forum.blackmagicdesign.com/viewtopic.php?f=21&t=88681](https://forum.blackmagicdesign.com/viewtopic.php?f=21&t=88681)_**

ChatGPT could give outdated syntax:
- **_Chat: `imported_clips = media_storage.AddItemListToMediaPool(image_files)`_** 
- **_Correct: `imported_clips = media_pool.ImportMedia(image_files)`_**

Recommendation: Try asking latest ChatGPT o1 fast reasoning and say "that doesnt work either. Im afraid your code for ___ is outdated?"

---


Free API version is missing a lot of useful features
- SetCurrentTimecode not available on free API
- SetSetting, SetProperty, and similar are not available
- SetStart, SetEnd, SetDuration disabled so you can’t programmatically adjust clip durations
- ImportFusionComp fails to work as a drop into the DaVinci console script, but you can input directly into the DaVinci console and it works
- ImportFusionComp and AddFusionComp sometimes fails if you’re not on the Fusion screen. Last two limitations are discussed https://www.steakunderwater.com/wesuckless/viewtopic.php?t=4317&start=15

---

Even those available in Free API version have inconsistencies

Here is code that doesn't work with .py files that get dropped into the Davinci console, but the code works if you input it directly into Davinci console or paste into the Davinci console

This snippet importing a Fusion composition file's nodes into a current clip:
```
resolve = app.GetResolve()  
project = resolve.GetProjectManager().GetCurrentProject()  
timeline = project.GetCurrentTimeline()  
clip = timeline.GetItemsInTrack('video', 1)[1]  
clip.ImportFusionComp("/Users/wengffung/dev/web/temp-vid/fusion_compiled/exported.comp")
```

Only works when ran / pasted inside the Davinci Console

---

API is not their priority
- The console vs dropped in python file inconsistency has been going on since 2020 and hasn't been fixed as of this writing on Sept 2024  [https://www.steakunderwater.com/wesuckless/viewtopic.php?t=4317&start=15](https://www.steakunderwater.com/wesuckless/viewtopic.php?t=4317&start=15).
- There's a bug where Fusion composition at your clips have the frames shifted to huge numbers, making your fusion effects not appear in the Edit timeline. This has been going on since 2021 and not fixed as of this writing on Sept 2024 https://www.reddit.com/r/davinciresolve/comments/qiqsvw/make_an_adjustment_clip_start_at_0_in_fusion/