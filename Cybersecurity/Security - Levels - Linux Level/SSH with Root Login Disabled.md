### SSH with Root Login Disabled

If you tightened security, you have in the settings block `ssh root@XXX.XX.XXX.XX`. It would still let interactively ask for the password but will always say incorrect password (does not give hint that root ssh login has been disabled because you don't want to let the hackers know to attempt other methods)

The normal authentication flow is to login into SSH with a non-root user. Then while inside the remote SSH shell, you run `su` and enter the root password to login into root.

### Developer Experience
However it may be annoying to remember or copy and paste or memorize two separate passwords from text files. 

You can setup alias on the local machine to perform SSHPass into the non-root user, in addition to first echoing the root password. Then at your remote server, you could run `su` and copy and paste the root password from the same terminal. Another way is to install the package `expect` at the remote server that lets you write a shell script to automatically enter the password when the expected prompt is "Password:"
### Setup

This method enhances security by preventing direct remote access to the root account. Instead, users must log in with a non-privileged user account and then use the `su` (substitute user) or `sudo` (superuser do) command to elevate their privileges. Furthermore, bad actors can't tell that you've disabled SSH root login because it will only just say incorrect password to their password attempts.

Here's a step-by-step outline of how this strategy is typically implemented:

1. **Edit the SSH Configuration File:**
   Open the SSH configuration file `/etc/ssh/sshd_config` in a text editor.

   ```sh
   vi /etc/ssh/sshd_config
   ```

2. **Disable Root Login:**
   Find the line that says `PermitRootLogin` and change its value to `no`.

   ```sh
   PermitRootLogin no
   ```

3. **Restart SSH Service:**
   Save the changes and restart the SSH service to apply the new configuration.

   ```sh
   sudo systemctl restart sshd
   ```

4. **Use a Non-Root Account for SSH Login:**
   Ensure you have a non-root user account with sudo privileges. Log in with this user via SSH.

   ```sh
   ssh username@hostname
   ```

5. **Elevate Privileges:**
   After logging in, elevate privileges using `su` or `sudo`.

   ```sh
   su -      # To switch to the root user
   sudo -i   # To open a root shell
   ```

By following these steps, direct root login via SSH is disabled, and users must log in with a non-root account first, adding an extra layer of security.
