
When working with .ts and webpages, you must add DOM to the library list of your typescript configuration

---

Let's say you haven't

Your .ts files refer to the DOM (will directly refer to them when compiled into .js files)
```
document.getElementById('linkedListsContainer').innerHTML += listContent  

```
 
But it'd error: Cannot find name ‘document’. Do you need to change your target library? Try changing the “lib” compiler option to include “dom”

---

**CORRECT PRACTICE**

Just make sure your tsconfig.json includes “DOM”:

```
"lib": ["DOM"], 
```

It may take a while before it realizes tsconfig.json changed. Try recompiling with `npx tsc`