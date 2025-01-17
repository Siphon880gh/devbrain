## Requirement - Base64

Install to system if haven't:
```
brew install base64
```

## Convert image to base64 string

Shell command:
```
base64 -i a.png -o b.txt
```

If Obsidian, add the base64 to the underline:
```
![Image](data:image/png;base64,___)
```

If HTML, add the base64 to the underline:
```
<img src="data:image/png;base64,___">
```

## Convert base64 string to image


Prepare a txt file that contains the base64 string.
test.txt:
```
iVBORw0KGgoAAAANSUhEUgAA...
```
^ Note there's no mention of "image/png" or "base64", like there is in a MD file or img tag.

Shell command:
```
base64 -d -i test.txt -o test.png
```