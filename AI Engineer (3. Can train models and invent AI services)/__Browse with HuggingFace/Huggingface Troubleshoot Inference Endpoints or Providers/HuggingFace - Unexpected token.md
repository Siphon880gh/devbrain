
You get an error like:
```
Unexpected token '<', "<!DOCTYPE "... is not valid JSON???
```

Change your output:
`console.log(JSON.stringify(_response_));` → `console.log(_response_);`

This could happen despite the code snippet when clicking Deploy options suggested parsing JSON:
![[Pasted image 20250219194139.png]]