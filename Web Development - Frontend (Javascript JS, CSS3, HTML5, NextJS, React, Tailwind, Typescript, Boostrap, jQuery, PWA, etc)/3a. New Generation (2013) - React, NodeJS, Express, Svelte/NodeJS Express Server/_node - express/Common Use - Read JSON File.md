In common uses, a client may be requesting JSON resource that a JSON file on the server houses.

Read JSON File:
```
app.get("/api/notes", (req, res) => {
    let jsonText = fs.readFileSync(JSON_FILEPATH, "utf8", (err, data) => {
        if (err) throw err;
    });
    let object = JSON.parse(jsonText);
    res.json(object)
})
```