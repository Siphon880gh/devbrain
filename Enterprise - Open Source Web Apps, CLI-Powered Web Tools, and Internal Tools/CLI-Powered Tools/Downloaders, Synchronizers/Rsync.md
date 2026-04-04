### **Using `rsync`**

`rsync` is a more advanced tool than scp that allows for incremental file transfers, meaning it only transfers the differences between the source and destination files, which can be more efficient for larger or frequently updated files.

**Syntax:**

```bash
rsync -avz /path/to/local/file username@remote_host:/path/to/remote/directory/
```

**Example:**

```bash
rsync -avz myimage.img user@remote-server:/home/user/images/
```

This command will synchronize the `myimage.img` file from your local machine to the `/home/user/images/` directory on the remote server `remote-server`.

**Summary:**
**`rsync`** is more versatile, particularly useful for large files or repeated transfers, as it can resume interrupted transfers and only update parts of files that have changed.