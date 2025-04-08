This tutorial is a more detailed form of the official guide on using postcss:
https://tailwindcss.com/docs/installation/tailwind-cli

Can work with:
- Custom HTML webpage: [[Concept, Categories - Custom HTML Webpage]]
- React static app (at least the static file's tailwind classes)

v3.4.11 is the latest v3.x.x

---

## Walkthrough

Empty folder.

touch index.html

npm init --y

index.html:
```
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="compiled-tw.css">
</head>
<body>
    <h1>Hello World</h1>
</body>
</html>
```


```
npm install -D tailwindcss@3.4.13
```

touch tailwind.config.js

Create config file with `npx tailwindcss init` or `touch tailwind.config.js`, but make sure contents are:
```
/** @type {import('tailwindcss').Config} */
module.exports = {  
  content: [  
    "./*.html",
    "./**/*.html",  
    "./**/*.js",  
  ],  
  theme: {  
    extend: {},  
  },  
  plugins: [],  
};
```

touch compiled-tw.css (and leave empty)

touch tw.css

tw.css:
```
@tailwind base;
@tailwind components;
@tailwind utilities;
```


start watcher:
```
npx tailwindcss -i ./tw.css -o ./compiled-tw.css --watch
```

If problematic, you can specify the tailwind config file with:
`npx tailwindcss -i ./tw.css -o ./compiled-tw.css --config tailwind.config.js --watch`

Open index.html through a server on web browser (eg. http://localhost:8888/app) or whatever is appropriate)

Change index.html to:
- We're adding a tailwind class
```
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/compiled-tw.css">
</head>
<body>
    <h1 class="text-red-400">Hello World</h1>
</body>
</html>
```


Refresh page. 


If everything is wired correctly, and:
- if all the paths are correct in your tailwindcss watcher command
- If in your tailwind.config.js, and you're referencing the correct tailwind compield css file
.. Then it should work immediately. Refreshing the page on your web browser should see the new tailwind class styling apply immediately. The compiled-tw.css should show additional css from having tailwind classes in index.html. Not all the tailwind classes are loaded in, thereby minimizing file size.

Troubleshooting? Turn on config file pointing AND verbose mode:
```
npx tailwindcss -i ./tw.css -o ./compiled-tw.css --config tailwind.config.js --watch --verbose
```



---

## Bonus Challenge - Try a public folder

See if you can adjust the paths correctly to make tailwind work

You can right click in VS Code -> Open Live Server:
![[Pasted image 20250305195300.png]]

And have hot module reload so as you're changing tailwind classes in your HTML code, the page updates instantly without having to refresh manually:

---

## **Streamline Suggestions**

You can save that as a npm script “build” and the build runs continuously as you’re developing/changing code. Refer to [[Tailwind v4 - npm tailwindcss watcher]]

**Even more streamlined:**
You can use postcss command in npm script “build” instead. Then postcss command allows you to chain tailwindcss AND autoprefixer so it can handle backward compatibility by adding moz- and other related vendor prefixes. Postcss allows tailwindcss and autoprefixer to run CSS transformations into a target css file. Refer to [[Tailwind v4 - npm postcss watcher]]