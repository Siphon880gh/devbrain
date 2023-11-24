File upload validation on file type and max file size

```
      document.querySelector("#files").addEventListener("change", (e) => {  
        if (window.File && window.FileReader && window.FileList && window.Blob) {  
          const files = e.target.files;  
          const MAX_SIZE = 1;  
            
          const output = document.querySelector("#result");  
          for (let i = 0; i < files.length; i++) {  
            if (!files[i].type.match("image")) {  
              alert(`The ${file}'s file type is not supported.`);  
              continue;  
            }  
  
            if(files[i].size> MAX_SIZE) {  
              alert(`The ${file}'s file size is too large.`);  
              continue;  
            }  
        // ....
```