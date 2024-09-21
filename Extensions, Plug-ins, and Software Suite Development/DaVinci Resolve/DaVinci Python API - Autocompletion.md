
You can have a little bit more autocompletions by following these instructions. Note there isn't much autocompletion support even then

1. In VS Code open your settings:
   `CMD+SHIFT+P → Settings json`
   Choose workspace or user settings (workspace is only for your project, so probably user for more global)

  

2. We add some redundancies
```
"python.envFile": "/Users/wengffung/VSCode/.env",

"python.autoComplete.extraPaths": [

"/Library/Application Support/Blackmagic Design/DaVinci Resolve/Developer/Scripting",

"/Library/Application Support/Blackmagic Design/DaVinci Resolve/Developer/Modules"

]
```



Then at "/Users/{USER}/VSCode/.env" or whichever .env filepath:
```
PYTHONPATH="/Library/Application Support/Blackmagic Design/DaVinci Resolve/Developer/Scripting":"/Library/Application Support/Blackmagic Design/DaVinci Resolve/Developer/Modules":$PYTHONPATH
```


---

Test there's some autocompletion

Typing project_man... will show you project_manager as an autocompletion option. But typing `project_manager.`  will not give you methods

You may want to disable Copilot to really test this: CMD+SHIFT+P -> ">Github Copilot: Enable/Disable Copilot Completions"