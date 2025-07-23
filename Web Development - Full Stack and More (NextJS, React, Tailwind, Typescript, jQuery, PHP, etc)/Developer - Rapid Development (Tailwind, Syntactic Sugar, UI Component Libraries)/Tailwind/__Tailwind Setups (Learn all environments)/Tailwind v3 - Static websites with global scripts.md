Include the script:
```
<script src="https://cdn.tailwindcss.com/3.4.16"></script>
```

Then you can configure. Here for example, we don't want css reset:
```
<script>  
  tailwind.config = {  
    corePlugins: {  
      preflight: false, // disables Tailwind's base styles (Preflight)  
    }  
  }  
</script>
```