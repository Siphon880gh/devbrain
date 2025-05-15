
### **Using`scp`**

`scp` (secure copy) is a straightforward command-line tool for securely transferring files between a local and a remote system.

**Syntax:**

```bash
scp /path/to/local/file username@remote_host:/path/to/remote/directory/
```

**Example:**

```bash
scp myimage.img user@remote-server:/home/user/images/
```

This command will copy `myimage.img` from your local machine to the `/home/user/images/` directory on the remote server `remote-server`.

**Summary:**
SCP is generally simple and works well for one-time transfers.