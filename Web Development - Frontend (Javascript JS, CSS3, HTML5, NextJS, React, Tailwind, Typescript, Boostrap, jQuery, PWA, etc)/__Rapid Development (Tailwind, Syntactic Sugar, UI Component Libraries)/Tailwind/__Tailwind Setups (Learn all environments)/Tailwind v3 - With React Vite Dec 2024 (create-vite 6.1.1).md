Requirements: You already have a Vite app created. You want to add tailwind.

Follow official guide:
[https://v3.tailwindcss.com/docs/guides/vite#vue](https://v3.tailwindcss.com/docs/guides/vite#vue)

The following is a retelling of their official guide. If the instructions deviate, then that means our tutorial is outdated. In addition, we add clarifications and tips along the way, and gotchas (sometimes official guides miss things).

---

```
npx create-vite@6.1.1 app 
```

Select React as framework

Cd into newly created folder

npm install -D tailwindcss@3 postcss@8.5.3 autoprefixer@10.4.21  

npx tailwindcss init -p  


Make sure tailwind.config.js:
```
/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
```
  

Add to top of src/index.css:
```
@tailwind base;  
@tailwind components;  
@tailwind utilities;  
```

  
npm run dev

Go into App.jsx or App.tsx (depending on your app).

Modify:
```
<h1 className="4xl text-red-400">Vite + React</h1>
```

^ Provided this better instruction because official docs suggested adding index.html in a code snippet that doesn't match what Vite generated for the index.html boilerplate.

![[Pasted image 20250305053713.png]]