To choose whether to use postcss or tailwindcss, refer to [[Concept - Choosing watchers - postcss vs tailwindcss]]

---

Let's say you have a blank folder

Then you ran `npm init --y`.

And you created bare minimum:
```
.
├── package.json
└── public
    ├── index.css
    ├── index.html
```

^ You can quickly create the public/* files with these commands:
```
mkdir public; touch public/index.css; touch public/index.html;
```

This tutorial is a more detailed form of the official guide on using tailwind css cli:
https://tailwindcss.com/docs/installation/tailwind-cli


If tailwind is way ahead, then the URL might have migrated to (use this instead):
https://v4.tailwindcss.com/docs/installation


The official guide is missing many steps which could be a gotcha situation that stops you from setting up tailwind correctly. So just follow my guide.

---

Continuing...

1. Install Tailwind CSS
Install tailwindcss engine and tailwind cli tool (v4 splitted tailwindcss and cli into two packages):
```
npm install tailwindcss@4.1.3 @tailwindcss/cli@4.1.3
```

2. See where the source of your html files will be relative to your index.css file. In our case, it'll be "./". We will configure where to monitor for html and js changes for compiling new tailwind classes into the final css file. There is no tailwind.config.js in tailwind v4, and we can configure it as a directive at a css file! Go to next step.
   
3. Import Tailwind CSS
Import into the top of your index.css file (Tailwind v4 just uses one directive unlike v3 which used three directives):
```
@import "tailwindcss";
@source "./";
```

This method enables Tailwind's base styles, component classes, and utility classes in your project.

4. Setup command to build and monitor process
At package.json scripts:
```
  "scripts": {
	  "build": "npx @tailwindcss/cli@4.1.3 -i ./public/index.css -o ./public/styles.css --watch",
    "test": "echo \"Error: no test specified\" && exit 1"
  },
```

^ Tailwindcss cli will continuously watch, and it knows how to expand the @tailwind directives inside index.css into css rules (and particularly with the tailwind utilities directive, will cherrypick which classes are actually expanded based on which tailwind classes are used in the html files - and knows to scan the files patterned in tailwind.config.js). 

The css is compiled into styles.css. Therefore, index.html needs to reference destination target styles.css (NOT index.css)
```
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="styles.css" rel="stylesheet"/>
</head>
<body>
    <h1>Title</h1>
</body>
</html>
```

Run command to build and monitor index.css -> styles.css:
```
npm run build
```


6. You can right click in VS Code -> Open Live Server (Also notice a `styles.css` got generated by the npm script's command):
   ![[Pasted image 20250408001331.png]]

7. Start using Tailwind in your HTML
You modify the h1 to have a tailwind class:
```
<h1 class="text-4xl text-orange-400">Title</h1>
```


8. You will see instant changes on the web browser page, as you're changing tailwind classes in your HTML code because you've started a Live Server that performs hot reload:
![[Pasted image 20250305063326.png]]
