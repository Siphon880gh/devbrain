Required knowledge: 
- Familiar with video editing in DaVinci Resolve
- Fusion scripting is not any language you may know.

What language is DaVinci Fusion scripting based on? 
- DaVinci Fusion scripting is really a markup language that lets you describe the nodes for the Fusion screen. 
- It's very Pythonic and JSON like.

Caveat about DaVinci:
This is for DaVinci is at **version 19.0.1 build 6 - 2024**, aka Fusion Script 19. Note that like the API, DaVinci likes to change the syntax from version to version and it's poorly documented. The documentation out there is outdated and does not contain all syntax and language features. Community support is limited (some just give up). You may want to keep a copy of that working installation version because of frequent language changes between languages.

How to execute:
There are fusion scripting that you can copy and paste into Fusion screen or drag and drop into Fusion screen (.setting file extension). Or using the API to programmatically loading the fusion script (.comp extension although file contents the same) 

Note if you're using the DaVinci Resolve API to load the .comp fusion script into a clip's fusion composition, that method `clip.ImportFusionComp(fusion_path)` is not supported in .py files in free verison. You have to manually type that into the DaVinci console (Workspace -> Console). You could have multiple lines of python code there (make sure to select Python 3 instead of having it on the language LUA) even though it appears the input is single line. That has been an inconsistency since 2022 and still a problem as of this writing 2024 Sept per [https://www.steakunderwater.com/wesuckless/viewtopic.php?t=4317&start=15](https://www.steakunderwater.com/wesuckless/viewtopic.php?t=4317&start=15).

Selecting one or multiple nodes in Fusion then Copying to clipboard will let you paste into text file allowing you to see it’s code

Optional - VS Code setup: Get this extension (BMD stands for BlackMagic Design, company behind DaVinci Resolve)
[https://github.com/EmberLightVFX/BMD-Fusion-extension-for-VSCode](https://github.com/EmberLightVFX/BMD-Fusion-extension-for-VSCode)
![](https://i.imgur.com/dhcWYxe.png)


---

Fusion Scripting API
[https://documents.blackmagicdesign.com/UserManuals/FusionManual.pdf](https://documents.blackmagicdesign.com/UserManuals/FusionManual.pdf)  
[https://emberlightvfx.github.io/Fusion-Script-Docs/#/?id=blackmagic-design-fusion-script-docs](https://emberlightvfx.github.io/Fusion-Script-Docs/#/?id=blackmagic-design-fusion-script-docs)

---

Learn by experimentation

You can start messing around with code by copying to clipboard one or more nodes from the Fusion screen. When you paste to a text file, you'll see the code. Then you can change the code and paste back into Fusion screen!

You can also copy or code groups like the groups you have in Fusion screen

---

Example snippets

**Zoom from blown out 120% to fit all 100%**
...Over 5 seconds at 24 fps (which is `120` for last frame)
```
{
	Tools = ordered() {
		zoom120to100 = GroupOperator {
			CtrlWZoom = false,
			NameSet = true,
			Inputs = ordered() {
				Comments = Input { Value = "After pasting into Fusion screen, connect MediaIn to INPUT_MED_IN and connect OUTPUT_MED_OUT to MediaOut.", },
				Input1 = InstanceInput {
					SourceOp = "INPUT_MED_IN",
					Source = "Background",
				}
			},
			Outputs = {
				Output1 = InstanceOutput {
					SourceOp = "OUTPUT_MED_OUT",
					Source = "Output",
				}
			},
			ViewInfo = GroupInfo {
				Pos = { 440, -16.5 },
				Flags = {
					Expanded = true,
					AllowPan = false,
					GridSnap = true,
					AutoSnap = true,
					RemoveRouters = true
				},
				Size = { 621, 198.364, 310.5, 24.2424 },
				Direction = "Horizontal",
				PipeStyle = "Direct",
				Scale = 1,
				Offset = { -302.5, -106.864 }
			},
			Tools = ordered() {
				OUTPUT_MED_OUT = Merge {
					CtrlWShown = false,
					NameSet = true,
					Inputs = {
						Background = Input {
							SourceOp = "Merge1",
							Source = "Output",
						},
						PerformDepthMerge = Input { Value = 0, }
					},
					ViewInfo = OperatorInfo { Pos = { 550, 181.5 } },
				},
				Merge1 = Merge {
					CtrlWShown = false,
					Inputs = {
						Background = Input {
							SourceOp = "GaussianBlur1",
							Source = "Output",
						},
						Foreground = Input {
							SourceOp = "TransformZoomIn",
							Source = "Output",
						},
						PerformDepthMerge = Input { Value = 0, }
					},
					ViewInfo = OperatorInfo { Pos = { 385, 247.5 } },
				},
				GaussianBlur1 = ofx.com.blackmagicdesign.resolvefx.GaussianBlur {
					CtrlWShown = false,
					Inputs = {
						Source = Input {
							SourceOp = "INPUT_MED_IN",
							Source = "Output",
						},
						HStrength = Input { Value = 1, },
						VStrength = Input { Value = 0.400000005960464, },
						Gang = Input { Value = 1, },
						advancedControlsGroup = Input { Value = 1, },
						BorderType = Input { Value = FuID { "BORDER_TYPE_REPLICATE" }, },
						isBlurAlpha = Input { Value = 1, },
						BlendAmount = Input { Value = 0, },
						blendGroup = Input { Value = 0, },
						blendIn = Input { Value = 1, },
						blend = Input { Value = 0, },
						ignoreContentShape = Input { Value = 0, },
						legacyIsProcessRGBOnly = Input { Value = 0, },
						IsNoTemporalFramesReqd = Input { Value = 0, },
						refreshTrigger = Input { Value = 1, },
						srcProcessingAlphaMode = Input { Value = 1, },
						dstProcessingAlphaMode = Input { Value = 1, },
						resolvefxVersion = Input { Value = "3.0", }
					},
					ViewInfo = OperatorInfo { Pos = { 220, 247.5 } },
				},
				TransformZoomIn = ofx.com.blackmagicdesign.resolvefx.Transform {
					NameSet = true,
					Inputs = {
						Source = Input {
							SourceOp = "INPUT_MED_IN",
							Source = "Output",
						},
						controlMode = Input { Value = FuID { "TransformControlsSliders" }, },
						controlReset = Input { Value = 0, },
						controlGroup = Input { Value = 1, },
						controlVisibility = Input { Value = FuID { "Show" }, },
						posX = Input {
							SourceOp = "TransformZoomInPositionX",
							Source = "Value",
						},
						posY = Input {
							SourceOp = "TransformZoomInPositionY",
							Source = "Value",
						},
						zoom = Input {
							SourceOp = "TransformZoomInZoom",
							Source = "Value",
						},
						rotate = Input { Value = 0, },
						scaleX = Input { Value = 1, },
						scaleY = Input { Value = 1, },
						pitch = Input { Value = 0, },
						yaw = Input { Value = 0, },
						flipH = Input { Value = 0, },
						flipV = Input { Value = 0, },
						adjustGroup = Input { Value = 0, },
						isCrop = Input { Value = 0, },
						cropL = Input { Value = 0, },
						cropR = Input { Value = 0, },
						cropT = Input { Value = 0, },
						cropB = Input { Value = 0, },
						edgeSoftness = Input { Value = 0, },
						edgeRounding = Input { Value = 0, },
						animationGroup = Input { Value = 0, },
						serializedWarpable = Input {
							Value = Text {
							},
						},
						serializedPinnable = Input {
							Value = Text {
							},
						},
						motionBlur = Input { Value = 0, },
						advancedGroup = Input { Value = 0, },
						edgeBehaviour = Input { Value = FuID { "Constant" }, },
						CompositeType = Input { Value = FuID { "COMPOSITE_NORMAL" }, },
						olayAntiAlias = Input { Value = 1, },
						previewAlpha = Input { Value = 0, },
						isLegacyCrop = Input { Value = 0, },
						isLegacyAlphaHandling = Input { Value = 0, },
						isEnforceBlanking = Input { Value = 0, },
						blendGroup = Input { Value = 0, },
						blendIn = Input { Value = 1, },
						blend = Input { Value = 0, },
						ignoreContentShape = Input { Value = 0, },
						legacyIsProcessRGBOnly = Input { Value = 0, },
						IsNoTemporalFramesReqd = Input { Value = 0, },
						refreshTrigger = Input { Value = 1, },
						srcProcessingAlphaMode = Input { Value = -1, },
						dstProcessingAlphaMode = Input { Value = -1, },
						resolvefxVersion = Input { Value = "1.4", }
					},
					ViewInfo = OperatorInfo { Pos = { 385, 181.5 } },
				},
				INPUT_MED_IN = Merge {
					CtrlWShown = false,
					NameSet = true,
					Inputs = {
						PerformDepthMerge = Input { Value = 0, }
					},
					ViewInfo = OperatorInfo { Pos = { 55, 181.5 } },
				}
			},
		},
		TransformZoomInPositionX = BezierSpline {
			SplineColor = { Red = 237, Green = 132, Blue = 222 },
			KeyFrames = {
				[120] = { 0 }
			}
		},
		TransformZoomInPositionY = BezierSpline {
			SplineColor = { Red = 237, Green = 132, Blue = 54 },
			KeyFrames = {
				[120] = { 0 }
			}
		},
		TransformZoomInZoom = BezierSpline {
			SplineColor = { Red = 254, Green = 144, Blue = 123 },
			CtrlWZoom = false,
			KeyFrames = {
				[0] = { 1.2, RH = { 50, 1.14822133333333 }, Flags = { Linear = true } },
				[120] = { 1, LH = { 100, 1.08525466666667 }, Flags = { Linear = true } }
			}
		}
	},
	ActiveTool = "zoom120to100"
}
```



**Zoom and pan to the top right corner** 
...Over 5 seconds at 24 fps (which is `120` for last frame)
```
{
	Tools = ordered() {
		zoompan_right = GroupOperator {
			CtrlWZoom = false,
			Inputs = ordered() {
				Comments = Input { Value = "After pasting into Fusion screen, connect MediaIn to INPUT_MED_IN and connect OUTPUT_MED_OUT to MediaOut.", },
				Input1 = InstanceInput {
					SourceOp = "INPUT_MED_IN",
					Source = "Background",
				}
			},
			Outputs = {
				Output1 = InstanceOutput {
					SourceOp = "OUTPUT_MED_OUT",
					Source = "Output",
				}
			},
			ViewInfo = GroupInfo {
				Pos = { 385, 115.5 },
				Flags = {
					Expanded = true,
					AllowPan = false,
					GridSnap = true,
					AutoSnap = true,
					RemoveRouters = true
				},
				Size = { 621, 198.364, 310.5, 24.2424 },
				Direction = "Horizontal",
				PipeStyle = "Direct",
				Scale = 1,
				Offset = { -302.5, -106.864 }
			},
			Tools = ordered() {
				OUTPUT_MED_OUT = Merge {
					CtrlWShown = false,
					NameSet = true,
					Inputs = {
						Background = Input {
							SourceOp = "Merge1",
							Source = "Output",
						},
						PerformDepthMerge = Input { Value = 0, }
					},
					ViewInfo = OperatorInfo { Pos = { 550, 181.5 } },
				},
				Merge1 = Merge {
					CtrlWShown = false,
					Inputs = {
						Background = Input {
							SourceOp = "GaussianBlur1",
							Source = "Output",
						},
						Foreground = Input {
							SourceOp = "TransformZoomIn",
							Source = "Output",
						},
						PerformDepthMerge = Input { Value = 0, }
					},
					ViewInfo = OperatorInfo { Pos = { 385, 247.5 } },
				},
				GaussianBlur1 = ofx.com.blackmagicdesign.resolvefx.GaussianBlur {
					CtrlWShown = false,
					Inputs = {
						Source = Input {
							SourceOp = "INPUT_MED_IN",
							Source = "Output",
						},
						HStrength = Input { Value = 1, },
						VStrength = Input { Value = 0.400000005960464, },
						Gang = Input { Value = 1, },
						advancedControlsGroup = Input { Value = 1, },
						BorderType = Input { Value = FuID { "BORDER_TYPE_REPLICATE" }, },
						isBlurAlpha = Input { Value = 1, },
						BlendAmount = Input { Value = 0, },
						blendGroup = Input { Value = 0, },
						blendIn = Input { Value = 1, },
						blend = Input { Value = 0, },
						ignoreContentShape = Input { Value = 0, },
						legacyIsProcessRGBOnly = Input { Value = 0, },
						IsNoTemporalFramesReqd = Input { Value = 0, },
						refreshTrigger = Input { Value = 1, },
						srcProcessingAlphaMode = Input { Value = 1, },
						dstProcessingAlphaMode = Input { Value = 1, },
						resolvefxVersion = Input { Value = "3.0", }
					},
					ViewInfo = OperatorInfo { Pos = { 220, 247.5 } },
				},
				TransformZoomIn = ofx.com.blackmagicdesign.resolvefx.Transform {
					NameSet = true,
					Inputs = {
						Source = Input {
							SourceOp = "INPUT_MED_IN",
							Source = "Output",
						},
						controlMode = Input { Value = FuID { "TransformControlsSliders" }, },
						controlReset = Input { Value = 0, },
						controlGroup = Input { Value = 1, },
						controlVisibility = Input { Value = FuID { "Show" }, },
						posX = Input {
							SourceOp = "TransformZoomInPositionX",
							Source = "Value",
						},
						posY = Input {
							SourceOp = "TransformZoomInPositionY",
							Source = "Value",
						},
						zoom = Input {
							SourceOp = "TransformZoomInZoom",
							Source = "Value",
						},
						rotate = Input { Value = 0, },
						scaleX = Input { Value = 1, },
						scaleY = Input { Value = 1, },
						pitch = Input { Value = 0, },
						yaw = Input { Value = 0, },
						flipH = Input { Value = 0, },
						flipV = Input { Value = 0, },
						adjustGroup = Input { Value = 0, },
						isCrop = Input { Value = 0, },
						cropL = Input { Value = 0, },
						cropR = Input { Value = 0, },
						cropT = Input { Value = 0, },
						cropB = Input { Value = 0, },
						edgeSoftness = Input { Value = 0, },
						edgeRounding = Input { Value = 0, },
						animationGroup = Input { Value = 0, },
						serializedWarpable = Input {
							Value = Text {
							},
						},
						serializedPinnable = Input {
							Value = Text {
							},
						},
						motionBlur = Input { Value = 0, },
						advancedGroup = Input { Value = 0, },
						edgeBehaviour = Input { Value = FuID { "Constant" }, },
						CompositeType = Input { Value = FuID { "COMPOSITE_NORMAL" }, },
						olayAntiAlias = Input { Value = 1, },
						previewAlpha = Input { Value = 0, },
						isLegacyCrop = Input { Value = 0, },
						isLegacyAlphaHandling = Input { Value = 0, },
						isEnforceBlanking = Input { Value = 0, },
						blendGroup = Input { Value = 0, },
						blendIn = Input { Value = 1, },
						blend = Input { Value = 0, },
						ignoreContentShape = Input { Value = 0, },
						legacyIsProcessRGBOnly = Input { Value = 0, },
						IsNoTemporalFramesReqd = Input { Value = 0, },
						refreshTrigger = Input { Value = 1, },
						srcProcessingAlphaMode = Input { Value = -1, },
						dstProcessingAlphaMode = Input { Value = -1, },
						resolvefxVersion = Input { Value = "1.4", }
					},
					ViewInfo = OperatorInfo { Pos = { 385, 181.5 } },
				},
				INPUT_MED_IN = Merge {
					NameSet = true,
					Inputs = {
						PerformDepthMerge = Input { Value = 0, }
					},
					ViewInfo = OperatorInfo { Pos = { 55, 181.5 } },
				}
			},
		},
		TransformZoomInPositionX = BezierSpline {
			SplineColor = { Red = 237, Green = 132, Blue = 222 },
			KeyFrames = {
				[0] = { 0, RH = { 38.3333333333333, -0.0703666666666667 }, Flags = { Linear = true } },
				[120] = { -0.2, LH = { 76.6666666666667, -0.140733333333333 }, Flags = { Linear = true } }
			}
		},
		TransformZoomInPositionY = BezierSpline {
			SplineColor = { Red = 237, Green = 132, Blue = 54 },
			KeyFrames = {
				[0] = { 0, RH = { 38.3333333333333, -0.0740666666666667 }, Flags = { Linear = true } },
				[120] = { 0, LH = { 76.6666666666667, -0.148133333333333 }, Flags = { Linear = true } }
			}
		},
		TransformZoomInZoom = BezierSpline {
			SplineColor = { Red = 254, Green = 144, Blue = 123 },
			CtrlWZoom = false,
			KeyFrames = {
				[0] = { 1, RH = { 38.3333333333333, 1.14443333333333 }, Flags = { Linear = true } },
				[120] = { 1.4, LH = { 76.6666666666667, 1.28886666666667 }, Flags = { Linear = true } }
			}
		}
	},
	ActiveTool = "zoompan_right"
}
```

---

Caveats of MediaIn and MediaOut

Note the above snippets do not include the MediaIn and MediaOut nodes. This is because of their hard association with the clip file paths. If you're creating automation for loading in motion effects, you have a few options:
- User drags and drops .setting file into Fusion screen, or copies and pastes your code into Fusion Screen, then connect the MediaIn and MediaOut appropriately.
- You use DaVinci API to load the Fusion script as a .comp file (although file contents the same as .setting or copy paste counterparts). And this import function `clip.ImportFusionComp(fusion_path)` can only be done in DaVinci console and NOT in a .py file you and drop into the DaVinci console

---

Continue learning by following my other guides on DaVinci Python API.