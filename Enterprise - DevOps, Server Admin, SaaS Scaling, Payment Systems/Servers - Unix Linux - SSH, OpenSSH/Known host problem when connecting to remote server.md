
You get a known host error when connecting from local terminal to a remote server (VPS, dedicated server, etc with root access)

**Error could be:**
Add correct host key in /Users/wengffung/.ssh/known_hosts to get rid of this message. Offending RSA key in /Users/wengffung/.ssh/known_hosts:4 Host key for 31.220.18.169 has changed and you have requested strict checking. Host key verification failed.

Error could also be scary like this:
![](https://i.imgur.com/F7DQCxn.png)

**Explanation:**
Inside your ~/.ssh folder not only contains ssh private keys and public keys, but may also contain known_hosts

The `known_hosts` file on your local machine contains a list of host keys for remote servers (hosts) that you have previously connected to using SSH. Each entry in the `known_hosts` file corresponds to a remote server and includes the server's hostname or IP address and its associated public key.

When you connect to a remote server using SSH, the SSH client checks the server's public key against the keys stored in the `known_hosts` file to verify the server's identity. Why? This is to prevent man-in-the-middle attack where the wireless network you connected is a hacker's that will act like certain servers to intercept your login credentials etc.


If the key presented by the server matches the key stored in the `known_hosts` file, the connection proceeds without any warnings. If there is a discrepancy, SSH will issue a warning or error. However it is possible that your remote server has changed some server settings (Like Hostinger has done)

  
**Solution:**

So just remove it at line 4 (whichever line your error is about). The problem is Hostinger changed their identity settings. You can choose to comment out that line instead if you want to play more conservatively. When you connect successfully, the error is gone, and the known_hosts file will be appended with new information that won't complain on the next login.