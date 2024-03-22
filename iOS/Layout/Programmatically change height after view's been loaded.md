

Changing height after it's been loaded. You need to turn off autosizing mask (so the phone doesn't take over the laying out) AND then add a height anchor.
Also: Changing constraints after it's been loaded. Useful if detecting device and readjusting the layout dynamically

Near end of ViewDidLoad:
```
        profilePicView.translatesAutoresizingMaskIntoConstraints = false;
        profilePicView.heightAnchor.constraint(equalToConstant: 100).isActive = true;
    	redView.leftAnchor.constraint(equalTo: view.leftAnchor, constant: 20).isActive = true
        labelY.centerYAnchor.constraint(equalTo: userMixoView.centerYAnchor, constant: 200).isActive = true
        userMixoView.topAnchor.constraint(equalTo: profilePicView.bottomAnchor, constant: 100).isActive = true;
```


And you determine screen width with:
```
         let screenRect = UIScreen.main.bounds
         let screenWidth = screenRect.size.width
         let screenHeight = screenRect.size.height
```