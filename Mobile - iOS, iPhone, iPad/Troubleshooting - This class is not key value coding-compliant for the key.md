Common error:
this class is not key value coding-compliant for the key

- Make sure UI View's name in storyboard mode matches the outlet variable name. If you renamed any UI View, it may not have recognized you renamed it (so recreate the UIView with your desired name)
https://becodable.com/this-class-is-not-key-value-coding-compliant-for-the-key/

- Check the Outlets Inspector on the right side (two icon tabs to the right of the Attributes Inspector tab and looks like an opened circle with a dot inside) and some will have exclamation marks. Fix the outlets with exclamation marks. But be careful it can't detect all problems and put an exclamation mark. Some may be old outlet variable names in code or old ui names in the ui navigator - those might not have exclamation marks - but you have to ex out / remove them.
    - You want to check the Outlets Inspector for the View that contains all the views, but also you might need to check the individual views (UIButton, UIImageView, etc)

￼![](l86mFZP.png)

---

The error message "this class is not key value coding-compliant for the key" often occurs in iOS development when there's a mismatch between the UI elements defined in a storyboard or XIB file and the corresponding IBOutlet or IBAction connections in the view controller's code. It can be frustrating, but it's usually straightforward to fix. Here are detailed steps to troubleshoot and resolve this issue:

1. **Matching UIView Name in Storyboard and Code**: Ensure that the name of the UIView in the storyboard matches its IBOutlet variable name in the code. If you've renamed a UIView, it's possible that the storyboard hasn't recognized the change. If renaming doesn't seem to take effect, you might need to delete the problematic UIView and recreate it with the desired name.

2. **Checking Outlets Inspector**: The Outlets Inspector is crucial for diagnosing these issues. To access it, select the view controller in the storyboard and click on the right-side panel until you find an icon that looks like an open circle with a dot inside. This is the Outlets Inspector. If there are any issues, you might see exclamation marks next to some of the connections. These need to be fixed.

    - When you see an exclamation mark, it indicates a broken or outdated connection. You can remove these by clicking the 'x' next to the connection.
    - Not all problems will have an exclamation mark. Some might be outdated references that you'll need to find and remove manually.

3. **Checking Individual Views**: In addition to checking the main view, inspect the individual components such as UIButtons, UIImageViews, etc. Each component can have its own set of outlets and actions, and any mismatches here can cause the error.

4. **Removing Unused Outlets**: If there are outlets in your code that no longer correspond to any element in the storyboard, you should remove them. These can be leftovers from previous versions of your interface and can cause the error you're seeing.

5. **Consistency Check**: Make sure that all the changes you make in the storyboard are reflected in your code and vice versa. It's a good practice to clean and rebuild your project after making these changes to ensure everything is up to date.

By following these steps, you should be able to resolve the "this class is not key value coding-compliant for the key" error. It's all about ensuring consistency between your storyboard/UI and the code. If the issue persists, it may be helpful to revisit the logic and structure of your code and storyboard to ensure that they are properly aligned.

---

# "this class is not key value coding-compliant for the key X" error?"
Right click every button/control that applies at a storyboard to look for a orange triangle/ exclamation
￼
![](FbnvZIK.png)


And also right click for the whole story board: 
￼
![](wkJDS0g.png)


From: https://stackoverflow.com/questions/3088059/xcode-how-to-fix-nsunknownkeyexception-reason-this-class-is-not-key-valu