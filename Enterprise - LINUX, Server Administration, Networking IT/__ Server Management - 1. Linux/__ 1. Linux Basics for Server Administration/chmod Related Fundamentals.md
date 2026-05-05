## Various lessons on group, user, and permissions


group root
group wheel

The "wheel" group is a Unix or Unix-like operating system group that is often associated with administrative or superuser privileges. Its use can vary depending on the specific Unix or Linux distribution, but it is commonly used in systems that implement the "wheel" group for granting administrative access.


The origin of the name "wheel" for the group associated with administrative privileges in Unix-like operating systems has been a subject of speculation and debate over the years, and the exact reason remains uncertain. There are a few theories and explanations for why this name was chosen:
Wheel as a High-Level Term: Some believe that the term "wheel" was chosen because it is a high-level metaphor that suggests a circle, cycle, or loop, and in the context of computer systems, it may symbolize a full circle or complete access, indicating full control or authority.
Password on an Imaginary Combination Lock: Another theory suggests that "wheel" was chosen to represent a combination lock with a wheel that users must spin to the correct position to gain access. In this context, "wheel" might signify a password or combination that grants access to superuser privileges.
Reference to Old MIT ITS System: It has been suggested that the use of "wheel" as an administrative group might have originated in the MIT Incompatible Timesharing System (ITS) in the 1960s. In this system, the "wheel" group was used for administrative access.
Wheel Group at Stanford: The use of "wheel" for administrative access might have also been influenced by its use at Stanford University's computer systems. According to some accounts, the name was borrowed from the practice at Stanford.
It's worth noting that the true origin of the name "wheel" may remain a bit of a mystery, and it has likely evolved and been adopted by different Unix and Unix-like systems over time. Regardless of its origin, the "wheel" group has historically been associated with elevated privileges, typically allowing members to execute commands as the superuser or root user.




drwxr-xr-x  6 bse7iy70lkjz wheel        4096 May 29  2020 notes-viewer

owner.group.others etc user group etc etc etc

Owner: The primary owner of the file or directory, who has full control over it.
Group: You can assign a group to a file or directory. Users who are members of that group will inherit the group's permissions for the file or directory.
Others: All other users who are not the owner or members of the group. They have permissions defined as "others" or "world" permissions.

----

Here's a table that shows the numeric representation of the "drwxr-xr-x" permission set:

| Permission Set | Numeric Representation |
|----------------|------------------------|
| drwxr-xr-x     | 755                    |

In the numeric representation, each digit corresponds to a set of permissions for a specific user or group:

- The first digit (7) represents the owner's permissions.
- The second digit (5) represents the group's permissions.
- The third digit (5) represents the permissions for others (everyone else).

Each digit is calculated by adding up the values of the individual permissions:

- Read (r) = 4
- Write (w) = 2
- Execute (x) = 1

So, in the case of "drwxr-xr-x":

- Owner has read (4) + write (2) + execute (1) permissions, which is 7.
- Group has read (4) + execute (1) permissions, which is 5.
- Others have read (4) + execute (1) permissions, which is 5.

Hence, the numeric representation is 755.


Certainly! Here are more examples of permission sets and their numeric representations in a table:

| Permission Set | Numeric Representation |
|----------------|------------------------|
| drwxr-xr-x     | 755                    |
| -rwxrwxrwx     | 777                    |
| -rw-r--r--     | 644                    |
| -rwxr--r--     | 744                    |
| drwx------     | 700                    |
| -rw-rw-r--     | 664                    |
| -r--------     | 400                    |
| -rwx--x---     | 711                    |
| -r-xr-xr-x     | 555                    |
| -rw-rw----     | 660                    |

These examples show different combinations of file permissions and their corresponding numeric representations. Remember that the numeric representation is a convenient way to represent permissions in a concise format, making it easier to set and understand file permissions.

---

To change the group ownership of a file or directory in a Unix-like operating system (such as Linux), you can use the `chown` command with the `-c` (optional, for verbose output), `-R` (optional, for recursive operation), and `:groupname` options. Here's the basic syntax:

```bash
sudo chown :newgroup filename_or_directory
```

Here's a breakdown of the options and arguments:

- `sudo`: You may need superuser privileges to change ownership, so you might need to use the `sudo` command.

- `chown`: The command for changing ownership.

- `:newgroup`: Specify the new group to which you want to change ownership. Make sure to replace `newgroup` with the actual name of the group you want to use.



chmod vs chown
chown :group vs chown user

- `filename_or_directory`: Specify the file or directory for which you want to change the group ownership.

If you want to change the group ownership recursively for all files and directories within a directory, you can use the `-R` option:

```bash
sudo chown -R :newgroup directory_name
```

After running this command with the appropriate options and arguments, the group ownership of the specified file or directory will be changed to the new group you specified.

You can find out what group(s) a user belongs to by running groups username 


If you want to change the group ownership to the "wheel" group, you can use the `chown` command as follows:

```bash
sudo chown :wheel filename_or_directory
```

Replace `filename_or_directory` with the name of the file or directory for which you want to change the group ownership. This command will change the group ownership to the "wheel" group.

If you want to change the group ownership recursively for all files and directories within a directory, you can use the `-R` option:

```bash
sudo chown -R :wheel directory_name
```

Again, replace `directory_name` with the name of the directory for which you want to change the group ownership and its contents to the "wheel" group.

---


Yes, you can add the "wheel" group to the "root" user on a Unix-like system. Doing so allows the "root" user to have the privileges associated with the "wheel" group. Typically, on Unix-like systems, members of the "wheel" group are granted elevated privileges through the use of tools like `sudo`.

To add the "root" user to the "wheel" group, you can use the `usermod` command with the `-aG` option (append to group). Here's the command:

```bash
sudo usermod -aG wheel root
```

This command appends the "root" user to the "wheel" group, allowing the "root" user to use `sudo` to execute commands with elevated privileges. Make sure to run this command with superuser privileges (using `sudo` or while logged in as the root user) to make the change.

After running this command, you may need to log out and log back in for the group membership changes to take effect.