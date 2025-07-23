
## Approach A

Place this after `var md = window.markdownit();` but before `var result = md.render(source); document.querySelector(".container").innerHTML = result;`

```
const defaultRender = md.renderer.rules.link_open || function(tokens, idx, options, env, self) {
    return self.renderToken(tokens, idx, options);
};

md.renderer.rules.link_open = function (tokens, idx, options, env, self) {
    // Add a "target" attribute

    tokens[idx].attrPush(['target', '_blank']);

    // Add a "rel" attribute to prevent potential security issues with `target="_blank"`

    tokens[idx].attrPush(['rel', 'noopener noreferrer']);

    // pass token to default renderer.

    return defaultRender(tokens, idx, options, env, self);
};
```

---

## Approach B - Another Way
If you are working in an environment where you are including scripts directly in your HTML and not using a module bundler like Webpack or Rollup, you can include `markdown-it` and `markdown-it-link-attributes` using a CDN like jsDelivr.

Here’s how you can do it:

### 1. Include the Scripts in your HTML:

```html
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Markdown-it Linkify</title>
</head>
<body>
<div id="container"></div>

<!-- Include markdown-it from CDN -->
<script src="https://cdn.jsdelivr.net/npm/markdown-it@12/dist/markdown-it.min.js"></script>

<!-- Include markdown-it-link-attributes from CDN -->
<script src="https://cdn.jsdelivr.net/npm/markdown-it-link-attributes@3/dist/index.umd.js"></script>

<script>
// You can place the JavaScript code here
</script>
</body>
</html>
```

### 2. Initialize `markdown-it` and `markdown-it-link-attributes` in your Script Tag:

```html
<script>
// Initialize markdown-it with linkify option enabled
const md = window.markdownit({
  linkify: true
});

// Use the markdown-it-link-attributes plugin with target='_blank' and rel='noopener noreferrer'
md.use(window.markdownitLinkAttributes, {
  attrs: {
    target: '_blank',
    rel: 'noopener noreferrer'
  }
});

// Example markdown string containing a plain URL
const markdownString = 'This is a link: https://www.example.com';

// Convert markdown string to HTML with clickable links that open in a new tab
const htmlString = md.render(markdownString);

// Select an element where you want to render the HTML
const container = document.getElementById('container');

// Set the innerHTML of the container to the resulting HTML string
container.innerHTML = htmlString;
</script>
```

Now, you have `markdown-it` and `markdown-it-link-attributes` included directly in your HTML file, and all links will open in a new tab.