
This is a huge ChatGPT limitation. If you rely on ChatGPT to generate an EDL, it will have the wrong clip in and clip out, and cause an error about clips not having those "timeline extents" when you try to import

Correct:
```
TITLE: Example EDL for Images  
FCM: NON-DROP FRAME  
  
001  AX       V     C        00:00:00:00 00:00:05:00 00:00:00:00 00:00:05:00    
M2   AX             000.0                00:00:00:00  
* FROM CLIP NAME: clip01.jpg  
  
002  AX       V     C        00:00:00:00 00:00:05:00 00:00:05:00 00:00:10:00    
M2   AX             000.0                00:00:00:00  
* FROM CLIP NAME: clip02.jpg
```

But ChatGPT is wrong:
```
TITLE: Example EDL for Images  
FCM: NON-DROP FRAME  
  
001  AX       V     C        00:00:00:00 00:00:05:00 00:00:00:00 00:00:05:00    
* FROM CLIP NAME: clip01.jpg  
  
002  AX       V     C        00:00:05:00 00:00:10:00 00:00:05:00 00:00:10:00    
* FROM CLIP NAME: clip02.jpg
```


Notice clip in and out is wrong AND M2 line is missing. ChatGPT will preferably give this wrong answer even if given sample output

So just use your know how instead