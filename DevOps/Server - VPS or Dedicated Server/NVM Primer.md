You can use different Node and NPM using NVM, very useful on an online server with many apps

- Features
	- Use NVM instead to manage installation, uninstallation, and switching of Node and NPM versions
	- Node version manager lets you install multiple versions of node including npm, and then lets you choose the active node/npm). 

- Why? 
	- You may need different versions of node for your different apps on the public server
	- Uninstallation is glitchy and not transparent on some OS

Use NVM to install another version of node and npm that are not npm v7.X and npm v8.X

This will revert back to using the shell's logged in user as the user to run the commands in npm script, which allow you to run root-owned commands as user root if you're logged in as root

To install `nvm` (Node Version Manager) on Ubuntu 22.04, you can follow these steps:

1. **Update your package list**:
   ```sh
   sudo apt update
   ```

2. **Install curl** (if not already installed):
   ```sh
   sudo apt install curl
   ```

3. **Download and install nvm**:
   ```sh
   curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.3/install.sh | bash
   ```

4. **Load nvm into your shell session**:
   Add the following lines to your `~/.bashrc` file to ensure nvm is loaded:
   ```sh
   export NVM_DIR="$([ -z "${XDG_CONFIG_HOME-}" ] && printf %s "${HOME}/.nvm" || printf %s "${XDG_CONFIG_HOME}/nvm")"
   [ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh" # This loads nvm
   ```

   You can do this by running:
   ```sh
   echo 'export NVM_DIR="$([ -z "${XDG_CONFIG_HOME-}" ] && printf %s "${HOME}/.nvm" || printf %s "${XDG_CONFIG_HOME}/nvm")"' >> ~/.bashrc
   echo '[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"' >> ~/.bashrc
   ```

5. **Reload your shell**:
   ```sh
   source ~/.bashrc
   ```

6. **Verify the installation**:
   ```sh
   nvm --version
   ```

7. **Install the desired Node.js version** (e.g., v14.17.0):
   ```sh
   nvm install v14.17.0
   ```

8. **Use the newly installed Node.js version**:
   ```sh
   nvm use v14.17.0
   ```

9. **Verify the npm version**:
   ```sh
   npm -v
   ```

This should show npm version 6.14.8 since it is bundled with Node.js v14.17.0.


---

## Key notes

**Install the desired Node.js version** (e.g., v14.17.0):
   ```sh
   nvm install v14.17.0
   ```

**Use the newly installed Node.js version**:
   ```sh
   nvm use v14.17.0
   ```

**Verify the npm version**:
   ```sh
   npm -v
