Rendering next scene as a modal (with previous screen dimmed in background behind the modal) 

```
        let profileScene1NVC = mainSB.instantiateViewController(withIdentifier: "ProfileScene1NVC") as! ProfileScene1NVC
        self.present(profileScene1NVC, animated:true, completion:nil)
```


^Keep in mind the previous screen is still in memory! It could lead to memory leak and crashes on low spec phones if you chain a bunch of screens this way