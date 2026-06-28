<<
How to make the centered text shifted up slightly so that the eyes dont feel like its dead centered
\>>
Shifting the content slightly upwards from dead center can often make the design feel more "correct" to the eyes, as the visual weight is distributed in a more balanced manner.

```
<body>  
    <div id="splash-screen" class="bg-gray-100 h-screen flex justify-center relative hidden">  
        <!-- Positioned at 33% from the top -->  
        <div class="text-center absolute top-1/3 transform -translate-y-1/3">  
            <!-- First liner -->  
            <div class="text-9xl" id="first-text">  
                UI Walkthrough  
            </div>  
  
            <!-- Second liner -->  
            <div class="text-6xl mt-4" id="second-text">  
                Authoring Tool  
            </div>  
        </div>  
  
        <div class="w-full bg-gray-200 mx-auto rounded-lg overflow-hidden border border-gray-300 absolute bottom-0 left-0">  
            <div id="progress-bar-splash" class="progress-bar bg-green-500 text-xs leading-none py-1" data-loading-ai style="width:0;"></div>  
        </div>  
    </div>  
</body>
```