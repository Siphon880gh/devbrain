
\<
In linux how to find a folder abc globally and recursively from / onwards?

\>
To find a folder named "abc" globally and recursively starting from the root directory ("/") in Linux, you can use the `find` command in the terminal. Here's the command you can use:

```bash
find / -type d -name "abc"
```

Let's break down this command:

- `find`: The `find` command is used to search for files and directories.
- `/`: This is the starting directory for the search, which is the root directory.
- `-type d`: This option specifies that you're looking for directories (folders).
- `-name "abc"`: This option specifies that you want to find directories with the name "abc".

Running this command will search your entire file system recursively, starting from the root directory, and it will display the paths of any directories with the name "abc" that it finds. Please note that you may need superuser privileges (root) to search certain directories, and you may see some "Permission denied" errors for directories you don't have access to.

---

\<
How to hide the Permission denied" errors for directories I dont have access to?

\>
To hide "Permission denied" errors for directories you don't have access to when using the `find` command, you can redirect the error messages to `/dev/null`, which is a special device file that discards any data written to it. This way, you won't see the error messages in your terminal. Here's the modified command:

```bash
find / -type d -name "abc" 2>/dev/null
```

In this command, `2>/dev/null` redirects standard error (file descriptor 2) to `/dev/null`, effectively suppressing any error messages that result from permission denied errors. This will only hide the error messages and still display the paths of directories with the name "abc" that you do have permission to access.