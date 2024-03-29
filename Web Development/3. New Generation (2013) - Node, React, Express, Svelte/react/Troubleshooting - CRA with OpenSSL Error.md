On windows you should change the CRA starting script to
```
"start": "set NODE_OPTIONS=--openssl-legacy-provider && react-scripts start",
```

On linux or mac the following
```
"start": "NODE_OPTIONS=--openssl-legacy-provider react-scripts start",

```