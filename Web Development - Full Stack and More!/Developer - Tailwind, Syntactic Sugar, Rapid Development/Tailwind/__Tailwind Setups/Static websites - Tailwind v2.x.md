
Using tailwind 2.x. That way you can just use link tag to a cdn source. No need for running commands. However there are many tailwind classes and the custom arbitrary values (classes with [] values like `<div class="w-[250px] h-[75vh] bg-[#ff5733]"></div>`), that are missing in v2

```
<link href="//cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
```