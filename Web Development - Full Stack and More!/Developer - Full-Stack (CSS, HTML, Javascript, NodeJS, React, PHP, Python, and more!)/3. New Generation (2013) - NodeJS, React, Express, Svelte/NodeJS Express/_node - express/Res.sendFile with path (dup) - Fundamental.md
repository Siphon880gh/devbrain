In Express, sendFile sends the html file as a response from the server back to the client. The sendFile is passed the file path to the html file. However, if you have folders, using forward-slashes might not work if you the operating system uses backward-slashes. Even if you deploy Express on an online server, that server is an operating system.

That's where path module and __dirname variable comes in. The __dirname is a variable that node gives you: That's the path to the folder where the current script file is. For any folders, you want to use the path module to pass it folder names, then it will concatenate using forward-slash or backward-slash based on the operating system that node detects:
```
res.sendFile(path.join(__dirname, 'public', 'index.html'));
```