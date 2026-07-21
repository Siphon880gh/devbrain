## Proper Setup

In Tailwind CSS v4, the "jit" (just-in-time) mode no longer requires a dedicated tailwind.config.js (since config files are entirely removed in v4) file to configure the paths to monitor files for class names; instead, it's configured through a CSS file, offering a CSS-first approach with significant performance improvements. 

The proper setup is a watcher cli compiling the css file that you will deploy.

Install with:
```
npm install -D tailwindcss@4.1.3 @tailwindcss/cli@4.1.3
```

If by the time you're reading this guide, v4 is obsoleted, you may install an above v4 version that will have breaking changes without clear errors (TailwindCSS has been like that with version changes). In that case, stick to v4 by first installing witih:
```
npm install -D tailwindcss@4.1.3 @tailwindcss/cli@4.1.3
```


Adjust your source css file, eg. `tw.css`:
- One single import line is all you need for tailwind to work.
- You can configure the source (relative to the css file) where the html and js files are monitored for picking up classes and writing to the final css file:
```
@import "tailwindcss";
@source "../";
```

The command to leverage html and js files monitoring is:
```
npx @tailwindcss/cli -i ./tw.css -o ./compiled-tw.css --watch
```

Alternately, this command works too:
```
npx tailwindcss -i ./tw.css -o ./compiled-tw.css --watch
```

---

## Proper Setup - Walkthrough


Empty folder.

npm init --y

touch index.html

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


npm install -D tailwindcss@4.1.3 @tailwindcss/cli@4.1.3

touch tw.css

tw.css:
```
@import "tailwindcss";
@source "../";
```


Start watcher - the command to leverage html and js files monitoring is:
```
npx @tailwindcss/cli -i ./tw.css -o ./compiled-tw.css --watch
```

Alternately, this command works too:
```
npx tailwindcss -i ./tw.css -o ./compiled-tw.css --watch
```

Open index.html through a server on web browser (eg. http://localhost:8888/tw/custom/ or whatever is appropriate)


Change index.html to:
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


Refresh page. If everything is wired correctly
- if all the paths are correct in your tailwindcss watcher command
- If in your tailwind.config.js, and you're referencing the correct tailwind compield css file
.. Then it should work.

At the minimum, opening compiled-tw.css should show additional css from having tailwind classes in index.html


Troubleshooting? Turn on verbose
```
npx tailwindcss -i ./tw.css -o ./compiled-tw.css --watch --verbose
```


---


## Quicker Setup (For Development)

For quicker idea to development, and for static custom HTML webpages, you can have this in the HTML:
```
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
```

Browser console will warn this is not for production. When ready for production, you can perform proper setup.