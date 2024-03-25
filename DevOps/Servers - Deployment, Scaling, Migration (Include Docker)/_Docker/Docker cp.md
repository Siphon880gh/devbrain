`docker cp` is a command-line utility in Docker used to copy files or directories between a Docker container and the host machine. It allows you to transfer files in and out of a container easily. 

The basic syntax for `docker cp` command is:

```
docker cp [OPTIONS] CONTAINER:SRC_PATH DEST_PATH
docker cp [OPTIONS] SRC_PATH CONTAINER:DEST_PATH
```

- `OPTIONS`: Additional options that can be used with the command.
- `CONTAINER`: The name or ID of the container.
- `SRC_PATH`: The path to the file or directory inside or outside of the container, depending on the direction of the copy.
- `DEST_PATH`: The destination path inside or outside of the container, depending on the direction of the copy.

Here are some key points to remember about `docker cp`:

1. **Copying from container to host**: If you want to copy files from a container to the host machine, you specify the container name or ID followed by the path of the file or directory within the container, and then the destination path on the host machine.
   
   Example:
   ```
   docker cp my_container:/path/to/file.txt /host/destination/directory
   ```

2. **Copying from host to container**: If you want to copy files from the host machine to a container, you reverse the order of the paths.
   
   Example:
   ```
   docker cp /host/source/file.txt my_container:/path/inside/container
   ```

3. **Recursive copying**: You can use the `-r` or `--recursive` option to recursively copy directories.
   
   Example:
   ```
   docker cp -r my_container:/path/to/directory /host/destination/directory
   ```

4. **Multiple files or directories**: You can specify multiple source files or directories in a single command.
   
   Example:
   ```
   docker cp my_container:/path/to/file1.txt my_container:/path/to/file2.txt /host/destination/directory
   ```

5. **Copying between containers**: You can also use `docker cp` to copy files between two containers. Just replace the host path with the name or ID of the second container.

6. **Permissions and ownership**: When files are copied from the container to the host, they inherit the permissions and ownership of the user who runs the `docker cp` command on the host machine.

`docker cp` is particularly useful for scenarios like extracting logs or configuration files from a container, or injecting files into a container during development or debugging.