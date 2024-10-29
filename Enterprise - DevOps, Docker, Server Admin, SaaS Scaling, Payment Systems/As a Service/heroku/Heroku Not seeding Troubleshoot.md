
Well, then just override their normal building chain:
```
"scripts": {
  "heroku-postbuild": "npm run install && npm run build && npm run seed" 
}
```

The name sounds like "postbuild" but it's actually overriding the entire build chain