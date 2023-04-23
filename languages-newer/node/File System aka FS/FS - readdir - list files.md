## List files
```
function summarizeFilesInDirectory(directory) {
  return fs.readdir(directory).map(fileName => ({
    directory,
    fileName,
  }));
} // summarizeFilesInDirectory
```