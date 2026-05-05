You want the following file/folder permissions for OpenSSH to work

For a deep dive into chmod file permissions:
[[Content-Published/Dev/Enterprise - DevOps, Docker, Server Admin, SaaS Scaling, Payment Systems/__Server Admin, Webhosting/__Server Admin - Linux/chmod Fundamentals]]

---


SSH popular recommend
- `.ssh` directory: `700 (drwx------)`
- private key (`id_rsa`): `600 (-rw-------)`
- public key (`.pub` file): `644 (-rw-r--r--)`
- config key should be: `600` (-rw-------)
- authorized_keys file should be chmod'd to 640 (-rw-r----)
- your home directory should not be writeable by the group or others (at most `755 (drwxr-xr-x)`.


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