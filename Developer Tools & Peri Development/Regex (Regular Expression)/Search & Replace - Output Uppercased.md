Here are some regular expressions for changing case when using regex to search and replace: 

- \\u: Changes the next character to uppercase
- \\l: Changes the next character to lowercase 
- \\U: Makes the first character lowercase and the remainder uppercase
- \\L: Makes the first character uppercase and the remainder lowercase
- \\E: Turns off case conversion 

Eg. Change attribute value to all uppercase
Search:
```
data-is-colored="([a-zA-Z]+)"
```
Replace:
```
data-is-colored="\U$1"
```


Eg. Change attribute value so that first character is uppercased
Search:
```
data-is-colored="([a-zA-Z]+)"
```
Replace:
```
data-is-colored="\u$1"
```