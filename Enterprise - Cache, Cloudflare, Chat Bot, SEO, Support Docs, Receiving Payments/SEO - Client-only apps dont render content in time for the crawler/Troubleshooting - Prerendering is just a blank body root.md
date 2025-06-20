
**Problem:**  
Prerendering any `/exercise/...` page still leaves you with just

```html
<div id="root"></div>
```

— the content never appears.

**Root causes:**

1. **Bad script path**
    
    - Your built HTML points at `./src/index.jsx` (dev path), but in `dist/` there is no `src/` folder.
        
2. **Client-side routing only**
    
    - Your React app only opens the exercise modal when it notices a URL change **after** the app has loaded.
        

---

**Three ways to fix it:**

1. **Static HTML injection**
    
    - Prerender `/` as you already do.
        
    - In post-processing:
        
        1. Add the exercise’s `<meta>` tags.
            
        2. Insert the modal’s HTML directly into the prerendered page.
            
2. **Simulated navigation**
    
    - Prerender `/`.
        
    - In post-processing, inject a small script like:
        
        ```js
        window.history.replaceState(null, '', '/exercise/benchpress');
        ```
        
    - That URL change triggers your React `useEffect` and renders the modal exactly as at runtime.
        
3. **Direct-load modal rendering**
    
    - Update your React routing so that on **initial load**, if `window.location.pathname` starts with `/exercise/…`, you immediately set `selectedExercise` and render the modal—no extra script needed.
        
    - Now visiting `/exercise/benchpress` directly shows the modal on first render.
        

---

Choose the option that best fits your setup—Option 3 keeps everything in React, Option 2 reuses existing code unchanged, and Option 1 gives you full control over the HTML.