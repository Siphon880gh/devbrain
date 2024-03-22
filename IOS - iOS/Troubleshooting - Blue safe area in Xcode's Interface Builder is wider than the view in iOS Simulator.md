The blue safe area in Xcode's Interface Builder is wider than the actual view in the iOS Simulator. This discrepancy can cause your views not to appear as expected on your device or simulator, potentially hiding your UI views even if they are properly constrained for centering or relative distance to margins.

If the safe area appears glitched or is not behaving as expected, reverting to constraints relative to the superview can be a workaround

**TLDR:**
Inspector -> First Tab -> Uncheck "Use Safe Area Layout Guides"
You are reverting to constraints relative to Superview: In the Size Inspector, you'll see a list of constraints applied to the selected view. Look for constraints that are relative to the safe area and modify them to be relative to the superview instead. You can do this by clicking on each constraint and changing the "Second Item" from "Safe Area" to "Superview" in the dropdown menu.


**Detailed:**
1. **Open Your View in Interface Builder**: In Xcode, navigate to the storyboard or XIB file where you're facing the issue.
    
2. **Select the View**: Click on the view whose constraints you want to modify.
    
3. **Open the Size Inspector**: With the view selected, open the Size Inspector by clicking on the ruler icon in the upper-right corner of the interface or by pressing `Option + Command + 5`.
    
4. **Modify Constraints**: In the Size Inspector, you'll see a list of constraints applied to the selected view. Look for constraints that are relative to the safe area and modify them to be relative to the superview instead. You can do this by clicking on each constraint and changing the "Second Item" from "Safe Area" to "Superview" in the dropdown menu.
    
5. **Uncheck 'Use Safe Area Layout Guides' (Optional)**: If you want to disable the use of safe area layout guides for the entire view or view controller, go to the File Inspector (the first tab in the right sidebar or `Command + Option + 1`) and uncheck the "Use Safe Area Layout Guides" checkbox.
    
6. **Adjust Your Layout**: After changing your constraints, you may need to adjust your layout to ensure that everything appears as expected. Remember, when you're not using safe area guides, you need to be mindful of elements like the status bar, notch, and home indicator.
    
7. **Test on Various Devices**: Always test your layout on different device sizes and orientations to ensure that your UI looks good across all supported devices.
    

By reverting to constraints relative to the superview, you can have more control over the layout and avoid issues caused by the mismatched safe area in Interface Builder. However, be mindful of device-specific features that could interfere with your UI when not using the safe area guides.