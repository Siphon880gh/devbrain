Add these lines before routes for the common middleware parsers:
```
app.use(express.urlencoded({ extended: true }));
app.use(express.json());
```