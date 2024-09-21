Required knowledge: 
- Familiar with video editing in DaVinci Resolve
- Python 3


There is scripting in Lua or Python 2 or Python 3 to perform video editor features. I am focused on Python 3

Caveat about DaVinci:
This is for DaVinci is at version 19.0.1 build 6 - 2024. Note that DaVinci likes to change the syntax from version to version and it's poorly documented. The documentation out there is outdated and does not contain all syntax and language features. Community support is limited (some just give up). You may want to keep a copy of that working installation version because of frequent language changes between languages.

Caveat about DaVinci API:
The developer experience is rough. Read more about it at [[DaVinci Python API - Developer Experience]]

Free version limitations:
- A lot of API features are not working on free version but works in paid version. DaVinci seems to have nerfed the API so that it becomes impossible to automate creating a video on the free version without some manual mouse work inbetween running multiple scripts
- Free version does not allow you to run .py files directly from your computer or server. You have to either:
	- Drag and drop the .py into the DaVinci Console
	- Or copy and paste the code into the DaVinci Console (it looks like a single line input but it can handle multiple lines)
- Some API features only work inputted or pasted into the DaVinci console, especially Fusion manipulation code.
- For a more extensive list on the limitations, refer to [[DaVinci Python API - PRIMER]]

---

  

**API REFERENCE:**
[https://resolvedevdoc.readthedocs.io/en/latest/](https://resolvedevdoc.readthedocs.io/en/latest/)  
[https://deric.github.io/DaVinciResolve-API-Docs/](https://deric.github.io/DaVinciResolve-API-Docs/)  
[https://diop.github.io/davinci-resolve-api/#/?id=timeline](https://diop.github.io/davinci-resolve-api/#/?id=timeline)


API REFERENCE - OFFICIAL
The official Davinci API documentation as of Sep 2024 is a Readme file (If Windows, look for equivalent):
```
/Library/Application Support/Blackmagic Design/DaVinci Resolve/Developer/README.txt
```

**_Community Help_**

**_Discord invite: [https://discord.gg/blackmagic-design-co ... 4528647188](https://discord.gg/blackmagic-design-community-479297254528647188)  
Eg. Message link: [https://discord.com/channels/4792972545 ... 4694353008](https://discord.com/channels/479297254528647188/479297254528647190/1242514114694353008)_**
**We Suck Less**: https://www.steakunderwater.com/wesuckless/viewforum.php?f=3**5**
**BlackMagic Design Forums**: https://forum.blackmagicdesign.com/

Snippets
There are example scripts. Look into a Windows equivalent if you're on Window:
```
/Library/Application Support/Blackmagic Design/DaVinci Resolve/Developer/Scripting  
```

---

How most lines start

Python file is run by drag and dropping into DaVinci console on free version (paid version allows you to run externally and integrate with other apps) - $300

The file starts like this:
```
import sys
sys.path.append(r'/Library/Application Support/Blackmagic Design/DaVinci Resolve/Developer/Scripting/Modules')
sys.path.append(r'/Library/Application Support/Blackmagic Design/DaVinci Resolve/Developer/Scripting/Examples')

from python_get_resolve import GetResolve
resolve = app.GetResolve()
```

Note the “app” highlight: Your VS Code will complain app is undefined. However it wont be the case when you drag and drop it into DaVinci

We are importing in the Scripting snippets which have two crucial files needed to make DaVinci API work, at both the Modules folder and Examples folder. You could setup your PYTHONPATH persistently if you do not wish to have to append the path

There may be online snippets that initialize the DaVinci API differently - that’s for the paid $300 studio version.


---

How to test it works:
1. In DaVinci, open any tab besides Edit  
2. Test drag and drop of python file into DaVinci console if it works (free version limits you to drag and drop to execute python script):
```
import sys  
sys.path.append(r'/Library/Application Support/Blackmagic Design/DaVinci Resolve/Developer/Scripting/Modules')  
sys.path.append(r'/Library/Application Support/Blackmagic Design/DaVinci Resolve/Developer/Scripting/Examples')  
  
  
from python_get_resolve import GetResolve  
resolve = app.GetResolve()  
resolve.OpenPage("Edit")
```

3. And see if it successfully go to Edit screen because of the line `resolve.OpenPage("Edit")`
4. In addition, you can see resolve is initiated by running: `print(resolve)`

---

Note on DaVinci Console direct inputting or pasting

You can copy and paste multiple lines of code into the DaVInci console though it will only show one line of input. You can press up and down on your keyboard but you can't see more than one line of input.

---

Most commonly needed variables

You likely will need resolve initiated, the project reference, a timeline reference, and/or a track reference. From there you can do a lot. Here's the boilerplate:

```
resolve = app.GetResolve()
project = resolve.GetProjectManager().GetCurrentProject()
timeline = project.GetCurrentTimeline()
track = timeline.GetItemsInTrack('video', 1) # Video track 1
```


---

How to debug

You can use your usual print, eg.
```
import sys  
print(sys.path)
```

In DaVinci console you can test functions work with:

`Py3> print(into_comp.Output)`

```
Output (0x0x3887b4400) [App: 'Resolve' on 127.0.0.1, UUID: 37fa538c-e532-42d1-bc22-4cf12b210506]
```

`Py3> print(into_comp.ConnectInput)`

```
Remote Function 000000014ec6bf28
```