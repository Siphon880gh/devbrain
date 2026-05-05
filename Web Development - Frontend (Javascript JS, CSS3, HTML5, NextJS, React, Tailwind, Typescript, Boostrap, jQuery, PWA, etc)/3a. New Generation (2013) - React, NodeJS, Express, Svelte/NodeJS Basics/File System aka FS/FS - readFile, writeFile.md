File System's most useful methods are writeFile and readFile. They have synch versions like fs.writeFileSync() and fs.readFileSync().

## readFile
For reading, the arguments are:
- name of file you are reading
- encoding
- optional error handling callback
```
jsonText = fs.readFileSync(FILE_PATH, "utf8", optionalErrorHandler);
```

## writeFile
For writing, the arguments are:
- name of file being created or written over 
- data that will write onto the file
- optional error handling callback
```
fs.writeFileSync(FILE_PATH, text, optionalErrorHandler);
```

## optionalErrorHandler
```
const optionalErrorHandler = err => { 
  if(err) throw err;
  console.log("Successful!"); 
}
```