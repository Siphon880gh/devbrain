Place this after all routes but before listening:

```
app.use((req, res, next) => {
    res.status("404").send("We hit a 404 wall").end();
});
```

Ordering matters! Other routes below these lines will not be reached so those routes will also result in a 404.