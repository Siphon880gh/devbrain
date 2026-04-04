
Base64 conversion from command line

Install to system if haven't:
```
brew install base64
```


How run:
```
base64 -i a.png -o b.txt
```


Open b.txt and add:
```
![Image](data:image/png;base64,___)
```
^ where the underline is your base64

Now should render in Obsidian


Or for html you can do the usual:
```
<img alt="Image" src="____">
```