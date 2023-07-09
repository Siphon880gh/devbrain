Dev iOS Chevron icon

This is very time consuming because the chevron icon has to be added for each screen. There are three phases:

Setup Project for Font Awesome
Font awesome right chevon on UI Builder
Font awesome right chevon in Swift code

# To setup project for Font Awesome, it involves cocoa pod. Refer to: Dev iOS Fonts incl Font Awesome

# In the UI Builder / Storyboard / Scene
Let's type the chevron icon into the scene. 

1. Create Text view flushed to the right of primary button
At its settings panel, adjust the following:
- Font -> Custom -> FontAwesome 6
- Text: Copy and paste this symbol (might be question mark or glitched box in this text): 
## Right chevron:


## Left chevron:

## Other icons
Other Awesome 6 icons are here (Make sure same version of font awesome as is in XCode): https://fontawesome.com/icons/chevron-right?s=solid
Click "Copy Glyph" icon (">" at top right of the icon content)

2. Add constraints to the textview. 

3. So you can visibility see it later and won't mistake it as not working:
	a. Set the chevron to Strong, font size 27.
	b. Make sure the icon is BELOW the button in the scene controls navigator. 
		Explanation: Everything going down on the scene controls navigator will be on top on the phone (because Top Layout Guide and Bottom Layout Guide are the two top items that you can place other controls on top of visually).
	c. If the icon is on a dark button, set a transparent background color (aka Default) and a white foreground color to the text view, so you user can see it.


# In the swift code

1. Make sure there is an IB outlet (aka variable) to the icon already.  2. Import the Font Awesome Swift
```
import FontAwesome_swift
```
 3. Load the icon character and settings programmatically. This will have it view in the app too, on top of the UI Builder. XCode is buggy so this step is required.

At viewDidLoad:
```
chevron.font = UIFont.fontAwesome(ofSize: 20, style: .solid)
chevron.text = String.fontAwesomeIcon(name: FontAwesome.chevronRight)
```

UI Builder might not render the chevron icon preview but eventually will or may require a restart (XCode is buggy)


