See: [https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css](https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css)  

```
.bg-black {  
  background-color: rgb(0 0 0 / var(--tw-bg-opacity, 1)) !important;  
}
```

  
If bg opacity not defined, it automatically sets to 1 opacity

That's how it respects the rules when you have:
```
<div class="bg-black bg-opacity-75"></div>
```

  
Because `bg-opacity-75` is:
```
.bg-opacity-75 {  
    --tw-bg-opacity: 0.75;  
}
```