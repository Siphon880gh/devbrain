
Follow this guide, making sure tailwind is around v4.1:
https://tailwindcss.com/docs/installation/using-vite#vue


If tailwind is way ahead, then the URL might have migrated to (use this instead):
https://v4.tailwindcss.com/docs/guides/vite#vue

---

Walkthrough

Add vite app with `npx create-vite@6.2.0 APPNAME`

Select React as Framework

Cd into newly created folder

```
npm install tailwindcss@4.1.3 @tailwindcss/vite@4.1.3
```


if vite.config.ts, make sure it loads tailwindcss (note if there's no vite.config.ts, you started the app wrong and must start over):
- Add `import tailwindcss from '@tailwindcss/vite'`
- Add `tailwindcss()` into plugins
- Final result may look like:
```
import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'
import tailwindcss from '@tailwindcss/vite'
// https://vite.dev/config/
export default defineConfig({
  plugins: [react(), tailwindcss()],
})
```

Add to top of src/index.css (With Tailwind v4, it's only one directive instead of Tailwind v3's three directives):
```
@import "tailwindcss";
```


npm run dev

Go into App.jsx or App.tsx (depending on your app).

Modify:
```
<h1 className="4xl text-red-400">Vite + React</h1>
```

^ Provided this better instruction because official docs suggested adding index.html in a code snippet that doesn't match what Vite generated for the index.html boilerplate.

![[Pasted image 20250305053713.png]]
