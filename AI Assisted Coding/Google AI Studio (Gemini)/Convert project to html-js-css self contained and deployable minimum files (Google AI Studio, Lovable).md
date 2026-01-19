Google AI Studio and Lovable as of Jan 2026 preferably generates Typescript-React-with- Tailwindcss, using the build tool Vite. 

If your hosting server does not support this, you can ask Google AI cursor to create another version of the website that is more compatible with most hosting servers: html-js-css

Prompt with this:
```
> Add **one new file** named **`index-standalone.html`** that contains a **self-contained, deployable** version of the website.  
>  
> **Requirements (preferred):**  
>  
> * Create **only** `index-standalone.html`.  
> * The file must run **by itself** when opened in a browser (no build step).  
> * Inline all required CSS and JavaScript (use `<style>` and `<script>`) so it's easier to deploy.  
> * If Tailwind is needed, use **Tailwind CDN Play** (the official Play CDN script) instead of a build step.  
> * Please retain any existing hover effects, on-load animations, and on-scroll animations (eg. parallax, on scroll animate in, etc).  
>  
> **Fallback rule (only if truly necessary):**  
>  
> * If the site cannot function without **relative assets** (images, fonts, JSON, etc.), you may still create `index-standalone.html`, but you must also create **one additional file** named **`index-standalone.md`** that lists every required asset path and where it’s referenced, so the user knows exactly what to copy/upload.  
> * In `index-standalone.md`, include: asset path, type (image/font/data), referenced from (line/section), and deployment note (must be copied alongside HTML or into `/assets/...`).  
>  
> **Hard constraints:**  
>  
> * **Do not edit, move, or delete** any existing files.  
> * Do not refactor existing code—only add the new file(s) described above.  
>  
> **Output:**  
>  
> * Return the complete contents of `index-standalone.html`.  
> * If you used any relative assets, also return `index-standalone.md`.
```

Look for `index-standalone.html` and `index-standalone.md` (The md file might or might not exist). 

If `index-standalone.md` exists, then you might need to download more than just `index-standalone` files. That file is created if there is any asset (images, css, js, etc) that must come along with your `index-standalone.html`. The md file will guide you on what files to download and in what relative paths they should be at when downloaded to your computer. Once the proper files are in place on the computer, let's test them at localhots.

Test the index-standalone.html file at localhost. If does not load properly, open DevTools console to see any errors. If the webpage does not load properly and/or there are console errors, go inside Cursor IDE at your local machine, and prompt with:
```
Please fix this html file. It's not loading correctly.

{Any console error messages}
```


