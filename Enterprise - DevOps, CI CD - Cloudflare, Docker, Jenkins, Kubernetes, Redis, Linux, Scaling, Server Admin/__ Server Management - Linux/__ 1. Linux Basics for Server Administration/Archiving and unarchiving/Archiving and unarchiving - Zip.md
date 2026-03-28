### Zip a folder

```bash
zip -r archive.zip folder-name/
```

### Zip a folder and ignore `.DS_Store`

```bash
zip -r archive.zip folder-name/ -x "*.DS_Store"
```

### Unzip a file

```bash
unzip archive.zip
```

### Unzip into a specific folder

```bash
unzip archive.zip -d output-folder
```

### List contents without extracting

For zip:

```bash
unzip -l archive.zip
```
