
```
let myScene1VC = mainSB.instantiateViewController(withIdentifier: "MyScene1VC") as! MyScene1VC

self.present(myScene1VC, animated:true, completion:nil)
```

But also make sure ViewController.vc has the Main storyboard pointed to (look into the File Navigator, eg. Main.storyboard) 

```
let mainSB : UIStoryboard = UIStoryboard(name: "Main", bundle:.main)
```
