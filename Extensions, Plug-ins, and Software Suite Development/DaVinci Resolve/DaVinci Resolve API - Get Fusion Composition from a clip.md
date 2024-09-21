Here's how to capture a fusion comp in a variable like `fusion_comp`:
	- You get the timeline that's opened when you drop/paste the code into the DaVinci console: `timeline = project.GetCurrentTimeline()`
	- You get the Timeline Items at a track with `track = timeline.GetItemsInTrack('video', 1)`
	- You for each or get particular about the Timeline item which is actually a clip. Remember DaVinci has been 1-based index, so here's the first clip:
	  `track[1]`
	- And you get a fusion composition from the clip. The clip actually merges all available fusion compositions and the active fusion composition that you see is usually the most recent top stacked one. Keeping that in mind,:
  ```
        # A clip could have multiple fusion clips
        fusion_comp_name_list = clip.GetFusionCompNameList()

        fusion_comp = None
        if len(fusion_comp_name_list) == 0:
            clip.AddFusionComp()  
            fusion_comp_name_list = clip.GetFusionCompNameList()
        
        # Retrieve the Fusion composition from the clip (it's the top recent fusion clip that's active)
        fusion_comp = clip.GetFusionCompByName(fusion_comp_name_list[-1]) # Get most top of the stack fusion
	```
