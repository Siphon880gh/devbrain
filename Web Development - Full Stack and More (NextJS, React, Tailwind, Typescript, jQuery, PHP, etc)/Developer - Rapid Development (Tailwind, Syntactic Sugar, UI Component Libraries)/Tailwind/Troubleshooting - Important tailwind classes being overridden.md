
Titled: Important tailwind classes being overridden

Tailwind classes being overwritten. I dont want to have to edit the other css to fix this. What can do?
  
This example for global script. Adapt to your tech slack if needed:
```
    <!-- Load Tailwind v3 from CDN -->  
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>  
  
    <!-- Must be declared AFTER loading Tailwind -->  
    <script>  
      window.tailwind = {  
        config: {  
          corePlugins: {  
            preflight: false  
          },  
          important: true  
        }  
      };  
    </script>
```


^ Notice that option `important: true`

Then your class attribute can be:
```
!bg-black !bg-opacity-50
```