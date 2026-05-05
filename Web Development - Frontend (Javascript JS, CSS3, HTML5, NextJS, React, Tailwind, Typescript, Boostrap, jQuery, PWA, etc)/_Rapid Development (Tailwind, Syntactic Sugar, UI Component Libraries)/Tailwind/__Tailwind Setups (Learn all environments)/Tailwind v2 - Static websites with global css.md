Using tailwind 2.x. That way you can just use link tag to a cdn source. No need for running commands. However there are many tailwind classes and the custom arbitrary values (classes with [] values like `<div class="w-[250px] h-[75vh] bg-[#ff5733]"></div>`), that are missing in v2

This is not GIT. You get the entire css file of tailwind classes:

```
<link href="//cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
```

For custom html pages, put them in the html files.

For React pages, put in the entry point html file.