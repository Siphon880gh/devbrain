Fetch with cache off:
```
fetch(__README_FILEPATH, {
        cache: "no-cache"
    }, err => {
        if (err) throw "Err fetch README.md";
    })
    .then(r => {
        r.text().then(renderMarkDown)
    });
```