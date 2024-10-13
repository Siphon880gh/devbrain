```
if(typeof window.time === "undefined") {  
    window.time = 0;  
}  
  
  
setInterval(()=>{  
    window.time+=0.1;  
    document.body.innerHTML = `<h1>${window.time}</h1>`;  
}, 100)
```