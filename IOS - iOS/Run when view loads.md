
Run code when the view loads including when user navigated back/forward (by tapping modal background). 
```
    override func viewWillAppear(_ animated: Bool) {
        //..
    }
```

Otherwise if it's loaded by clicking a button or programmatically like usual, use viewDidLoad