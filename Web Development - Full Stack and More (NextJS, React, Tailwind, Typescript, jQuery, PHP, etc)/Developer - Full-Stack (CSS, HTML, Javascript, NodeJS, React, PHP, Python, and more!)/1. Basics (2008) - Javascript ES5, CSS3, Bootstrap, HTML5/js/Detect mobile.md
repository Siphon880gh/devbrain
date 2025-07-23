mobile-detect:
[https://github.com/hgoebl/mobile-detect.js/?utm_source=chatgpt.com](https://github.com/hgoebl/mobile-detect.js/?utm_source=chatgpt.com)

Script src:
```
<script src="https://cdnjs.cloudflare.com/ajax/libs/mobile-detect/1.4.5/mobile-detect.min.js"></script> <script src="../../assets/week.js"></script>
```

Example use:
```
document.addEventListener("DOMContentLoaded", ()=>{  
    var mdt = new MobileDetect(window.navigator.userAgent);  
    var isMobile = mdt.phone() || mdt.tablet();  
    if(!isMobile) {  
        alert("Detected you are not using a phone or tablet. This running app feature is on the go. It will guide you through walks/jogs/run on your phone.")  
    }  
})
```