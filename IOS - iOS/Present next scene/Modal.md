Rendering next scene as a modal (with previous screen dimmed in background behind the modal) 

```
        let profileScene1NVC = mainSB.instantiateViewController(withIdentifier: "ProfileScene1NVC") as! ProfileScene1NVC
        self.present(profileScene1NVC, animated:true, completion:nil)
```


^Keep in mind the previous screen is still in memory! It could lead to memory leak and crashes on low spec phones if you chain a bunch of screens this way

---

# Modal Popup

There are a few ways to do this. An easy way is to create a new storyboard. Then a new scene board in it.

Go to the properties of the actual scene board (not a view controller), and select Presentation -> "Over Full Screen" (default was Automatic). 
^A good "Transition Style" for modal popup is "Cross Dissolve"
^In addition, there's a tickbox you need to tick: Is Initial View Controller

Now when designing the scene board, create another view inside the main view. And this inner view should be the smaller view that is constrained by centering horizontally and centering vertically, and constrained with fixed height and fixed width.

In addition, at the outer view, you should go to its properties and select a gray background color. Then customize that gray background color and by clicking Custom, now you can select opacity down to 20%.

Set the outer view at the Size Inspector -> Layout -> Autresizing mask. Then at the inner view, set the Size Inspector -> Layout -> Inferred (Constraints), and also at the inner view you want to adjust the X/Y/width/height to make a small modal over a gray background effect (Recommend offsetting Y, but keep in mind all constraints to the bottom of the margin will need to be offset by negative values to push them back into view)

You can have a button dismiss that "modal"
```
    @IBAction func returner(_ sender: Any) {
        dismiss(animated: true);
    }
```
