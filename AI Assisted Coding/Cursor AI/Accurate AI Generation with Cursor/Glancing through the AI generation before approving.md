
With each code generation, look through the code. you can read thru it fast to get a gist of it rather than investing a lot more cognitive energy to checking the specifics are correct. Then for the lines you suspect is a certain approach taken, ask it to “describe to me {copy line here}”

Eg.
```
Where you said: if(img.width > maxWidth || img.height > maxHeight) 
  
Describe to me
```

And the AI clarified with:
```
img.width > maxWidth: This checks if the width of the uploaded image is greater than 75% of the canvas container's width. If true, it means the image is too wide and needs to be scaled down.  
img.height > maxHeight: This checks if the height of the uploaded image is greater than 75% of the canvas container's height. If true, it means the image is too tall and needs to be scaled down.
```

If it’s in line with what makes sense, then that’s great. In this case, it’s what I wanted to hear even though that particular line didn’t show the width or the height evaluating to 75%. Neither was the variable named to hint at it, nor was the math done in the conditional. Turned out it was done much earlier in the code multiplying by .75 but that the AI didn’t name the variable to suggest there’s a threshold other than the container size. And that’s fine.