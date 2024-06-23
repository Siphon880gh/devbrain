
FTP clients uploading many files and folders take a long time. Instead you should zip the entire folder then upload that one file, then extract with SSH terminal access.

However this presents another problem of the archiving including the .git folder which slows down archiving considerably. The solution is to exclude .git folders recursively.

Archiving excluding .git recursively:
```
tar --exclude='*/.git' -czvf archive_name.tar.gz path/to/myfolder
```

Unarchiving:
```
tar -xzvf archive_name.tar.gz
```


---

## Troubleshooting - Extra \_ files after unarchiving

If you are noticing additional files named with an underline `_` after extracting, there are a couple of potential reasons for this:

1. **Existing Files:** The files starting with `_` could have already been in your `path/to/myfolder` before you created the archive, but you might not have noticed them until you extracted everything again. It's good to check what files are present before archiving to ensure they are what you expect.

2. **Extraction Location:** If you extracted the files in a different directory or there were existing files with similar names, `tar` might not overwrite them but might handle duplicates differently depending on your system settings or specific environment.

3. **Archive Viewer Issue:** Sometimes, the tool or method used to view the contents of an archive (or the filesystem viewer itself) might display files differently or include hidden files that you weren’t previously aware of.

4. **Backup or Temporary Files:** Some applications or systems create backup or temporary files (often starting with `_`) as part of their operations. If such applications were running when you created your archive, these files might have been inadvertently included.

To further investigate, you can list the contents of the archive before extracting to see exactly what's inside:
```bash
tar -tzvf archive_name.tar.gz
```
This command will show you all the files included in your `tar.gz` archive, allowing you to verify if the `_` files were indeed packed in the archive initially or if they are a result of some other operation post-extraction.