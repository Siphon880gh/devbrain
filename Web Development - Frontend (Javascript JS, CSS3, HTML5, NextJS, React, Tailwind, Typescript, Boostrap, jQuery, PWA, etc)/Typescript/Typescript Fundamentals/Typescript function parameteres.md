You can enforce datatype on the parameter. Here's one datatype to one parameter:
```
function heyThere(name:string) {
	console.log(`Hi ${name}`)
}

heyThere("John")

heyThere(1) // LINT ERRORS
```


Here's multiple datatypes to one parameter:
```
function heyThere(name:string|number) {
	console.log(`Hi ${name}`)
}

heyThere("John")

heyThere(1) // no errors
```

If you do not define a datatype to function parameter, it'll assume any:

```
function heyThere(name) {
	console.log(`Hi ${name}`)
}

heyThere("John")

heyThere(1) // no errors
```