At the official docs, many versions are skipped. For version 3, the main version for docs is v3.4.17:

[https://v3.tailwindcss.com/docs/installation](https://v3.tailwindcss.com/docs/installation)
![[Pasted image 20250723024758.png]]
->
![[Pasted image 20250723024558.png]]

---

That would mislead you to thinking that version is readily available as a global script. It is NOT!


Proof:
- Visiting https://cdn.tailwindcss.com/3.4.17 will error:
  ![[Pasted image 20250723024903.png]]
- However, a slightly older version is available: https://cdn.tailwindcss.com/3.4.16

Then you would load Tailwind like this:
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
  