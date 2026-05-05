A clean way to build portable paths at sendFile:
```
const DIR_PUBLIC = { 
    root: path.join(__dirname, "public") 
};

res.sendFile('index1.html', DIR_PUBLIC);
```

A quick way is:
```
res.sendFile('index1.html', { root: path.join(__dirname, "public") });
```