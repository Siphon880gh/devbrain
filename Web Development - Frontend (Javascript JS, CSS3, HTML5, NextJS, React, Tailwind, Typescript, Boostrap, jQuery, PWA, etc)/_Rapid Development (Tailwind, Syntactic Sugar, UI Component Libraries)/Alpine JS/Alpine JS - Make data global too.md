

To make `activePanel` a global variable that can be accessed anywhere in your JavaScript code, you can attach it to the `window` object in Alpine.js. For the final `activePanel`, we can set it to a value that doesn't match any existing panels to stop the pattern from looping.

Here's how you can modify the Alpine.js code and add Tailwind CSS classes for styling:

```html
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Panel Toggle Example</title>
<script src="//unpkg.com/alpinejs" defer></script>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>

<div x-data="{ activePanel: 1 }" x-init="window.activePanel = activePanel" x-effect="window.activePanel = activePanel">
<!-- Panel 1 -->
<div x-show="activePanel === 1" class="p-4 border rounded-lg shadow-lg">
Panel 1 content
<button @click="activePanel = 2" class="mt-2 bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700 transition duration-150">Show Panel 2</button>
</div>

<!-- Panel 2 -->
<div x-show="activePanel === 2" class="p-4 border rounded-lg shadow-lg" style="display: none;">
Panel 2 content
<button @click="activePanel = 3" class="mt-2 bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700 transition duration-150">Show Panel 3</button>
</div>

<!-- Panel 3 -->
<div x-show="activePanel === 3" class="p-4 border rounded-lg shadow-lg" style="display: none;">
Panel 3 content
<button @click="activePanel = 'none'" class="mt-2 bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700 transition duration-150">Finish</button>
</div>
</div>

</body>
</html>
```

Changes and explanations:

- I've added `x-init` and `x-effect` directives to the root `div` element, which makes `activePanel` a property on the global `window` object. This allows you to access `activePanel` from anywhere in your JavaScript code using `window.activePanel`.
- The button in the last panel (`Panel 3`) sets `activePanel` to `'none'` when clicked, which will hide all panels and stop the toggling pattern.
- I've included the Tailwind CSS v2.2.19 CDN for styling and added classes for padding (`p-4`), border (`border`), rounded corners (`rounded-lg`), shadow (`shadow-lg`), background color (`bg-blue-500`), text color (`text-white`), padding on `y` and `x` (`py-2`, `px-4`), rounded button (`rounded`), hover background color (`hover:bg-blue-700`), and transition duration (`transition duration-150`).

Remember to include the Tailwind CSS and Alpine.js CDN links in the `head` of your HTML document to use this code as provided. The classes used are from Tailwind CSS v2, which should make the panels look more aesthetic and usable.