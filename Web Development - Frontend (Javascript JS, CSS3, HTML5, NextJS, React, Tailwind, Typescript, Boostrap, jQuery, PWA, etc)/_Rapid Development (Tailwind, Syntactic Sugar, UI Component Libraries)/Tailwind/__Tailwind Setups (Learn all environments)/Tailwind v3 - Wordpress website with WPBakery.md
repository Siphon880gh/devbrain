
For ease of setup, you want this plugin "Header and Footer Scripts":
![[Pasted image 20250718010230.png]]

Then when you edit a page, below the WPBakery Site Builder will be:
![[Pasted image 20250718010253.png]]

Pro Tip: Move that `Insert Script to <head>` block to above the WPBakery Site Builder

^ Btw: Great for extra schemas, google tag, scripts, loading in tailwind, etc

---

Using the script block ui, add this snippet:
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
          important: true,  
          theme: {  
            extend: {  
              colors: {  
                customBlue: '#1fb6ff'  
              }  
            }  
          }  
        }  
      };  
    </script>
```

Adjust as needed. Here we've disabled css reset, tell Tailwind NOT to ignore important, and added a new color `customBlue` we can use bg and number series with