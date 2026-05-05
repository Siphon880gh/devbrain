
The package expect lets you write a script that runs a command and automatically respond to interactive prompts (like su asking interactively for root user password)

Here's an example where the user logs in as a non-root user, and they sometimes run su to go into root user:

1. **Install `expect`:** If it's not already installed, you can install it using your package manager. For example, on a Debian-based system, you would use:
   ```sh
   sudo apt-get install expect
   ```

2. **Create a script that uses `expect`:** Create a script that automates the `su` command and includes the password. Here's an example script:

   ```sh
   #!/usr/bin/expect -f

   # Usage: ./su_with_password.sh root_password
   set password [lindex $argv 0]

   spawn su
   expect "Password:"
   send "$password\r"
   interact
   ```

3. **Make the script executable:**
   ```sh
   chmod +x su_with_password.sh
   ```

4. **Create an alias in your shell configuration file (e.g., `.bashrc` or `.zshrc`):**

   Add the following line to your shell configuration file:
   ```sh
   alias su_with_password='~/path/to/su_with_password.sh your_root_password'
   ```

5. **Reload your shell configuration:**
   ```sh
   source ~/.bashrc
   # or for zsh
   source ~/.zshrc
   ```

Now you can use the alias `su_with_password` to switch to the root user without being prompted for a password.
