Here is one way to improve the text:

Nodemon provides configurable options to control how it monitors and restarts your app. By default, it won't restart when CSS files change, but you can specify additional file extensions to monitor. You can also configure whether it runs the start script or build command on changes. 

For file watching, you can specify which folders to watch and which to ignore in a `nodemon.json` config file. Simply run nodemon without any arguments and it will look for this file. 

```
nodemon
```

If you need multiple presets or want to use a config file with a different name, you can specify it directly like:

```
nodemon --config myconfig.json
```

This runs nodemon with the settings from myconfig.json instead of the default nodemon.json file.

---

You can pass the settings directly in the command instead of having a .json config file.

With nodemon.json:
```
{
    "watch": ["src"], 
    "ext": "js,jsx,css,scss",
    "exec": "npm run build",
    "ignore": ["dist"]
}
```

The command equivalent is:
```
nodemon --watch src --ext js,jsx,css,scss --exec "npm run build" --ignore dist
```