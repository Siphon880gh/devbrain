Read here: https://www.computerhope.com/unix/uchmod.htm

---

To give a specific user ownership of all files and folders in a directory recursively (which means the command will also affect items in subdirectories), you can use the `chown` command with the `-R` (or `--recursive`) option on a Unix-based system.

Here is an example of how to use this command:

```
sudo chown -R user123:user123 /path/to/directory
```

In this command, replace `/path/to/directory` with the path to the directory you want to modify. This command will give the user `user123` ownership of all files and folders within that directory.

However, note that changing the owner doesn't necessarily give the user all permissions. The permissions of a file or directory in Unix-based systems are defined by the file's permission bits, which you can modify using the `chmod` command.

If you want to give the user `user123` all permissions (read, write, execute) for all files and folders within a directory, you can use the `chmod` command with the `-R` option. Here's how:

```
sudo chmod -R 700 /path/to/directory
```

In this command, replace `/path/to/directory` with the path to the directory you want to modify. The permission level `700` gives the owner (which should now be `user123` if you've used the previous `chown` command) full read, write, and execute permissions, while all other users have no permissions.

Be aware that these commands give significant power to the `user123` user and no access to any other users. This might not be appropriate in all contexts, and it could potentially be a security risk if `user123` is not a trusted user. Use these commands cautiously.

<<
why is it user123: user123

>>
In Unix-based systems, the `chown` command is used to change the owner and the group of a file or directory. The syntax for changing both the owner and group is:


```bash
chown owner:group file
```

When you use `user123:user123`, you're changing both the owner and the group of the file or directory to `user123`.

- The first `user123` (before the colon) is the user you're setting as the owner.
- The second `user123` (after the colon) is the group you're assigning to the file or directory.

So, if you have a user named `user123` and a group named `user123`, `user123:user123` would assign ownership of the file to user `user123` and associate the file with the group `user123`.

If you don't specify a group (i.e., if you use `chown owner file`), only the owner will be changed. If you specify a colon but no group (i.e., if you use `chown owner: file`), the owner will be changed and the group will be changed to the owner's login group.

---

  chmod 777 filename 

or

  chmod a+x filename 


Notice the a means all users

For current user you would do chmod u+x filename 

---

Only you can read/write:
		chmod 600 FILE
		
		
Very permissible (only last resort if probs with files)
		chmod 777 FILE

---

chown:

![](WxSBEVU.png)


The building blocks (*) are the 0, 1, 2, 4

| Chmod Number | Permission               |
| ------------ | ------------------------ |
| 0            | * No permissions         |
| 1            | * Execute                |
| 2            | * Write                  |
| 3            | Write and execute        |
| 4            | * Read                   |
| 5            | Read and execute         |
| 6            | Read and write           |
| 7            | Read, write, and execute |


Explained the math:
- **4** stands for "read",
- **2** stands for "write",
- **1** stands for "execute", and
- **0** stands for "no permission."

So **7** is the combination of permissions **4**+**2**+**1** (read, write, and execute), **5** is **4**+**0**+**1** (read, no write, and execute), and **4** is **4**+**0**+**0** (read, no write, and no execute).

Fundamentally remember 0 is no permissions, and that 2 and 4 are write and read, respectively. The lower number 2 is chosen as write, so 3, 6, and 7 include write permission. The higher number 4 is chosen as read, so 5, 6, and 7 include read permissions. Consequently, 6 has both read and write. Because 1 is execute (remember executing on directory lists all the files), then the odd numbers have execute: 1,3,5,7.

> <<
> Why do you think the inventors chose 2 to mean write and 4 mean read?
> 
> \>>
> That's a good question! The use of the specific numbers 2 for write and 4 for read in chmod permissions seems somewhat arbitrary or unintuitive at first glance. There are a few potential reasons the inventors may have chosen this scheme:
> 
> 1. Using powers of 2 - The numbers 0, 1, 2, and 4 are all powers of 2 (2^0, 2^1, 2^2, 2^3). Using powers of 2 allows efficiently setting multiple permissions with a bitmask. Each permission value is a single bit.
> 
> 2. Distinguishing read and write - Using a lower number for write and higher for read may have been intended to distinguish their importance. Restricting writes is often more critical for security than restricting reads.
> 
> 3. Compatibility with octal - Using values that are octal digits allows the permissions to be expressed concisely in octal, a common representation for Unix file permissions.
> 
> 4. Accidental execution - Using 1 for execute makes accidental execution less likely. A stray 1 bit is less probable than a stray 2 or 4 bit when using a bitmask.
> 
> 5. Lower memory usage - Using lower numeric values results in more efficient storage and processing of the permission bits.
> 
> So in summary, some combination of technical considerations like bitmasks, octal notation, and performance, along with trying to assign higher priority to write restrictions seem the most likely motivations for the designers' choice of values. The specific numbers are somewhat arbitrary but using powers of 2 provides advantages.

---

SSH popular recommend
- `.ssh` directory: `700 (drwx------)`
- private key (`id_rsa`): `600 (-rw-------)`
- public key (`.pub` file): `644 (-rw-r--r--)`
- config key should be: `600` (-rw-------)
- authorized_keys file should be chmod'd to 640 (-rw-r----)
- your home directory should not be writeable by the group or others (at most `755 (drwxr-xr-x)`.

The important things are that nothing in .ssh is writeable to anyone else and none of the secret keys are readable to anyone else. **Execute permission on a directory** grants the ability to list immediate child files/dirs of that directory, files inside the folder don't "inherit" the execute bit of their parent folder

https://superuser.com/questions/215504/permissions-on-private-key-in-ssh-folder

---
SSH Official recommend

Here are some recommended file and folder permissions for OpenSSH:

- /etc/ssh/sshd_config - This file contains the SSH server configuration. It should be readable by root only (600 permissions).

- ~/.ssh/ - This is the default directory for user's SSH keys. It should have 700 permissions and be owned by the user.

- ~/.ssh/authorized_keys - This file lists the public keys authorized for SSH login. It should have 600 permissions and be owned by the user. 

- /var/log/auth.log - The SSH server logs to this file. It should be writable only by root (600 permissions).

- /usr/sbin/sshd - The SSH daemon binary. It should have 555 permissions and be owned by root.

- /etc/ssh/ssh_host_*_key - The SSH host key files should have 600 permissions and be owned by root.

In summary:

- Configuration files should be 600 and owned by root
- User SSH folders like ~/.ssh should be 700 and owned by the user
- Log files should be 600 and owned by root 
- Binaries should be 555 and owned by root
- Key files should be 600 and owned by root

Setting the right permissions helps improve security and prevent issues. The principle is to give the minimum required access.

For SSH public and private keys, the recommended permissions are:

- Private key (.ssh/id_rsa) - This should have 600 permissions and be owned by the user. It allows only the owner to read/write the private key.

- Public key (.ssh/id_rsa.pub) - This can have 644 permissions, allowing it to be readable by all users. The contents of the public key are not sensitive.

- Known hosts file (.ssh/known_hosts) - This should have 644 permissions, allowing other users to read it but only the owner can update it.

So in summary:

- Private key: 600
- Public key: 644 
- Known hosts: 644

The private key permissions are the most important, as this contains the sensitive data used for authentication. Making it only readable by the owner improves security.

The public key and known hosts file can be world readable as their contents are not sensitive. But only the owner should be able to modify them.

Properly securing the key files is important for SSH security and preventing unauthorized access. Following these recommended permissions is considered a best practice.
