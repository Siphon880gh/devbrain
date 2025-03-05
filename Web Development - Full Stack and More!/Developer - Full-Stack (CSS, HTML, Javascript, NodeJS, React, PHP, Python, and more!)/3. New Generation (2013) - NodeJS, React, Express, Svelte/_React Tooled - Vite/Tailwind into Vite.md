Requirements: You already have a Vite app created. You want to add tailwind.

Follow official guide:
https://tailwindcss.com/docs/installation/using-vite

The following is a retelling of their official guide. If the instructions deviate, then that means our tutorial is outdated. In addition, we add clarifications and tips along the way, and gotchas (sometimes official guides miss things).

---

1. Install Tailwind CSS
```
npm install tailwindcss @tailwindcss/vite
```

2. Configure the Vite plugin
At `vite.config.ts`, add importing of tailwindcss plugin:
```
import tailwindcss from '@tailwindcss/vite'
```

Then add plugin `tailwindcss()`

vite.config.js may look like:
```
import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'
import tailwindcss from '@tailwindcss/vite'

// https://vite.dev/config/
export default defineConfig({
  plugins: [
    react(),
    tailwindcss(),
  ],
})
```

^ Clarification: Official docs was erroneously missing react(). This is the correct version.

3. Import Tailwind CSS
Add an `@import "tailwindcss";` to your CSS file that imports Tailwind CSS.

Likely you'll be adding it to `src/index.css`

^ Added clarification because official guide was not clear which css file.

4. Start your build process
Run your build process with npm run dev


5. Start using Tailwind in your HTML
Go into App.jsx or App.tsx (depending on your app).

Modify:
```
<h1 className="4xl text-red-400">Vite + React</h1>
```

^ Provided this better instruction because official docs suggested adding index.html in a code snippet that doesn't match what Vite generated for the index.html boilerplate.