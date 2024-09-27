
Note: This is NOT Fusion scripting because you are programmatically connecting fusion nodes that have not been connected. Fusion scripting is the markup of what nodes and their settings there are.

Requirement of a `fusion_comp`:
- You had to capture a fusion comp in a variable like `fusion_comp`:
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

Here's the code to connect MediaIn1 to a `into_comp` which is a node I custom named, and it connects `exit_comp` to MediaOut1:

```

        # Find the MediaIn1 and MediaOut1 nodes
        media_in_node = fusion_comp.FindTool("MediaIn1")
        media_out_node = fusion_comp.FindTool("MediaOut1")

        print(media_in_node)
        print(media_out_node)

        # Assuming no user manipulation on MediaIn1 and MediaOut1
        if media_in_node and media_out_node: #
            # Skip because inconsistently crash: Disconnect MediaIn1 from MediaOut1
            # print("Disconnected MediaIn1 from MediaOut1")
            # media_out_node.Inputs["Input"].Disconnect() # No need
            print("MediaIn1 and MediaOut1 nodes found.")
        else:
            # Add MediaIn1 if it's missing
            if not media_in_node:
                print("Added MediaIn1 node")
                media_in_node = fusion_comp.AddTool("MediaIn", -32768, 0)  # Adds MediaIn1 node

        # Add MediaOut1 if it's missing
            if not media_out_node:
                print("Added MediaOut1 node")
                media_out_node = fusion_comp.AddTool("MediaOut", 32768, 0)  # Adds MediaOut1 node

        # These nodes are named from Weng's Motion Effects Library
        into_comp = fusion_comp.FindTool("INPUT_MED_IN")
        exit_comp = fusion_comp.FindTool("OUTPUT_MED_OUT")

        # Assuming into_comp and exit_comp are valid nodes in the Fusion composition
        if into_comp:
            print(f"into_comp Inputs: {into_comp.Inputs}")
            print(f"into_comp Outputs: {into_comp.Outputs}")
        else:
            print("into_comp is None")

        if exit_comp:
            print(f"exit_comp Inputs: {exit_comp.Inputs}")
            print(f"exit_comp Outputs: {exit_comp.Outputs}")
        else:
            print("exit_comp is None")

        # Assuming into_comp and exit_comp are valid nodes in the Fusion composition
        # Connect MediaIn1's Output to into_comp's Input
        if media_in_node and into_comp:
            into_comp.ConnectInput("Background", media_in_node, "Output")
            print("Connected MediaIn1 to into_comp")

        # Connect exit_comp's Output to MediaOut1's Input
        if exit_comp and media_out_node:
            media_out_node.ConnectInput("Input", exit_comp, "Output")
            print("Connected exit_comp to MediaOut1")
```