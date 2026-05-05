Requirements: You already have a Vite app created. You want to add tailwind.

Follow official guide:
https://v3.tailwindcss.com/docs/guides/create-react-app

The following is a retelling of their official guide. If the instructions deviate, then that means our tutorial is outdated. In addition, we add clarifications and tips along the way, and gotchas (sometimes official guides miss things).

---

Install `tailwindcss` via npm, and then run the init command to generate your `tailwind.config.js` file:
```
npm install -D tailwindcss@3
npx tailwindcss init
```

Configure your template paths by adding the paths to all of your template files in your `tailwind.config.js` file (added `content`):
```
/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./src/**/*.{js,jsx,ts,tsx}",
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
```

Add the Tailwind directives to your CSS by adding the @tailwind directives for each of Tailwind’s layers to your ./src/index.css file:
```
@tailwind base;
@tailwind components;
@tailwind utilities;
```

Start adding tailwind classes in your React components then run the dev server and test it out on your web browser.
Eg. `text-3xl font-bold underline`