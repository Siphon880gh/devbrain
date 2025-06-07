You may find the popup not a proper size:

![[Pasted image 20250320161021.png]]

You can define an explicit width if your popup.html sources a popup.css in your chrome extension files:
- popup.css:
```
body {
    min-width:300px;
}
```

Update the Chrome Extension and see how it looks. Looks better:
![[Pasted image 20250320160934.png]]
