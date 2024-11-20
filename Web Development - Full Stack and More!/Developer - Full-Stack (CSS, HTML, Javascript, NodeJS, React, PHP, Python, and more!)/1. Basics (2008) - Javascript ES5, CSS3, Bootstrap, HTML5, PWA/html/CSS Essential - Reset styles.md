Add this css to reset styles across all devices before applying further css:
```
    /* Reset CSS */
    :root {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
```

Browser default "content-box" is more work by excluding padding and border when rendering explicitly-declared width/height. 