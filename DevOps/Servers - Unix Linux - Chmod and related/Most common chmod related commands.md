
Managing Linux file permissions and understanding which users and groups have access to files are essential skills for maintaining the security and functionality of a system. Here's a quick overview of the commands you mentioned, as well as some additional ones that you might find useful:

1. **`ls -la`**: This command lists all files and directories in the current directory in a long listing format, showing detailed information including file permissions, number of links, owner, group, size, and the timestamp of last modification. The permissions are displayed at the beginning of each line.

2. **`chmod`**: This command changes the permissions of a file or directory. Permissions define what the owner of the file, members of the group that owns the file, and others can do with the file. Permissions are set with symbolic representations like `r` (read), `w` (write), and `x` (execute), or with numeric values (e.g., 755, 644).

3. **Changing the group of a file (`chgrp`)**: The command to change the group ownership of a file or directory is `chgrp`. For example, `chgrp groupname filename` will change the group ownership of the file to "groupname".
   
4. **Changing the owner or group of a file (`chown`)**: The command to change the group ownership of a file or directory is chown. 

	- Change owner: `chown johndoe myfile.txt`. 
	- Change owner and group: `chown johndoe:developers /home/johndoe/projects/todos.txt`. 
	  
	- For recursion especially on a folder, add R like `chown -R ...`

5. **Adding a user to a group (`usermod`)**: To add a user to a new group, you can use `usermod -a -G groupname username`. This adds the user to the group without removing them from other groups. Make sure to use the `-a` option with `-G` to append the user to the existing group(s).

6. **`whoami`**: This command simply prints the username of the current user.

7. **Finding out what groups you are in (`groups`)**: The `groups` command followed by a username will list all the groups that the user belongs to. If you run `groups` without specifying a username, it will show the groups for the current logged-in user.

Here is how you might use these commands:
- To see file permissions: `ls -la filename`
- To change permissions: `chmod 755 filename`
- To change the group ownership of a file: `chgrp newgroup filename`
- To add a user to a group: `usermod -a -G newgroup username`
- To check which user you are: `whoami`
- To check which groups you belong to: `groups`

These commands are crucial for managing security and access rights on Linux systems.