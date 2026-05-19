### Compare files and contents recursively

```
diff -ru folderA folderB
```

Example:

```
diff -ru ./old-site ./new-site
```

Useful options:

```
diff -ruN folderA folderB
```

`-N` treats missing files as empty files, so added/deleted files show more clearly.