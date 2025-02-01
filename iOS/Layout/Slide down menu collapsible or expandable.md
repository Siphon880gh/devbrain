
You have to hide the menu and set the height constraint to 0 or some value (to collapse or to expand). Autolayout will take care of the other UI's placement. You can have a stackview with buttons and for divider - you can use a very small height view with darkgray background.  Select the height constraint from the Interface builder and take an outlet of it. So, when you want to change the height of the view you can use the below code

￼![](9O9GJhp.png)


```
yourHeightConstraintOutlet.constant = someValue
yourView.layoutIfNeeded()
```

It is helpful when you are setting the constraints programmatically. It updates constraints for the view. For more detail click here.

From: https://stackoverflow.com/questions/42669554/how-to-update-the-constant-height-constraint-of-a-uiview-programmatically
