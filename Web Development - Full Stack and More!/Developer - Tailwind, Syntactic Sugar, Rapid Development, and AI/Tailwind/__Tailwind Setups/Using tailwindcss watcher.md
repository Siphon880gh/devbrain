Let's say you have a blank folder

Then you ran `npm install -y`.

And you created bare minimum:
```
.
├── package.json
└── public
    ├── index.css
    ├── index.html
```

This tutorial is a more detailed form of the official guide on using postcss:
https://tailwindcss.com/docs/installation/using-postcss

The official guide is missing many steps which could be a gotcha situation that stops you from setting up tailwind with postcss correctly. So just follow my guide.

---

1. Install Tailwind CSS
Install tailwindcss, @tailwindcss/postcss, and postcss via npm:
```
npm install tailwindcss @tailwindcss/postcss postcss
```

2. Add file types to scan for new tailwind classes at tailwind.config.js:
```
/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./public/**/*.{html,js}"],
  theme: {
    extend: {},
  },
  plugins: [],
} 
```

3. Import Tailwind CSS
Import into the top of your index.css file:
```
- @tailwind base;
- @tailwind components;
- @tailwind utilities;
```

This method enables Tailwind's base styles, component classes, and utility classes in your project. Here's what each directive does:

- @tailwind base; → Imports Tailwind’s preflight styles (a minimal CSS reset).
- @tailwind components; → Imports any custom component classes defined in @layer components.
- @tailwind utilities; → Imports all utility classes (e.g., flex, text-center, mt-4).

4. Setup command to build and monitor process
At package.json scripts:
```
  "scripts": {
	  "build": "npx tailwindcss -i ./public/index.css -o ./public/styles.css --watch",
    "test": "echo \"Error: no test specified\" && exit 1"
  },
```

^ Tailwindcss cli will continuously watch, and it knows how to expand the @tailwind directives inside index.css into css rules (and particularly with the tailwind utilities directive, will cherrypick which classes are actually expanded based on which tailwind classes are used in the html files - and knows to scan the files patterned in tailwind.config.js). 

The css is expanded into styles.css. Therefore, index.html needs to reference destination target style.css (NOT index.css)
```
<link href="styles.css" rel="stylesheet"/>
```

Run command to build and monitor index.css -> style.css:
```
npm run build
```


6. Start using Tailwind in your HTML
You can insert this at the `<body>`:
```
<h1 class="text-4xl text-orange-400">Title</h1>
```

7. You can right click in VS Code -> Open Live Server:
![[Pasted image 20250305062859.png]]

You will see hot reload changes as you're changing tailwind classes:
![[Pasted image 20250305063326.png]]
