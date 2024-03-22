Links that open in phone's web browser
``` 
@IBAction func joinLinkTapped(_ sender: Any) {
        guard let url = URL(string: "https://mixo.vip/mentorship") else { return }
        UIApplication.shared.openURL(url)
    } 
```
