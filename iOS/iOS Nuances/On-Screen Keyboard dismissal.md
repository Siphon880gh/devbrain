iOS doesnt automatically dismiss keyboard when the "Done" at bottom right of keyboard is pressed

You have to delegate the textfield to its own methods then override its event handler:
```
    override func viewDidLoad() {
        super.viewDidLoad()
//...
        self.txtPassword.delegate = self
	}


    func textFieldShouldReturn(_ textField: UITextField) -> Bool {
        self.view.endEditing(true)
        return false
    }
```

The endEditing makes the keyboard go away        