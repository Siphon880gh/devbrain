When you serve html files using sendFile, you can add a favicon to that file with:
```
const favicon = require("serve-favicon");
app.use(favicon(path.join(__dirname, 'public', 'assets', 'ico', 'favicon.ico')));

<link rel="icon" href="/assets/ico/favicon.ico">
```

Make sure to install the module serve-favicon to production.