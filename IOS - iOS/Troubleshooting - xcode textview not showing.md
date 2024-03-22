
Untick "Scrolling Enabled"

It was scrolled to an empty part of the textview, even if you limit the width and height.

-=

It sounds like you're encountering an issue where the `UITextView` in your Xcode project isn't displaying its content as expected. This can happen if the "Scrolling Enabled" property is ticked and the content is scrolled to a position where it's not visible, despite setting specific width and height constraints.

To resolve this, you can untick the "Scrolling Enabled" option for your `UITextView` in the Interface Builder or disable scrolling programmatically. Here's how you can do it:

1. **Interface Builder:** 
   - Open your storyboard or XIB file.
   - Select the `UITextView`.
   - In the Attributes Inspector, find the "Scrolling Enabled" option and uncheck it.

2. **Programmatically:**
   - If you prefer to disable scrolling in your code, you can set the `isScrollEnabled` property of the `UITextView` to `false`. 
   - Here's a quick line of code to do that:
     ```swift
     textView.isScrollEnabled = false
     ```

By disabling scrolling, the text view will not scroll off to an empty part, and all content should be visible within the bounds you've set, as long as the content fits within those bounds. If the content is larger than the visible area, it will get clipped, so make sure your text view is sized appropriately to show the content you expect it to.

