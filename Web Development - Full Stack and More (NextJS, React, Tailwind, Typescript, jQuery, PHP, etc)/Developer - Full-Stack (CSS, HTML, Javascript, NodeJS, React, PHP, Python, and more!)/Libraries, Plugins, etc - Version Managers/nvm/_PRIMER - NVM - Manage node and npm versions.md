
**Sneak Peak / Quick Review**:
- Requires you have nvm installed on your computer.
- You can add a .nvmrc that has the version number of node you want, and this file can be placed at the app's root level.
- Requires you to have installed that node version inside .nvmrc: `nvm install v***`.
- nvm must have created a file at ~/.nvm/nvm.sh that initializes nvm. Your bash_profile or equivalent normally loads this line.
- At the app's root level, you run `nvm use` so it can refer to .nvmrc for the node version, then it will switch the node interpreter path, so you can confirm the node version with `node --version`.

---

## Installation

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
   Add the following lines to your `~/.bashrc` or `/.zshrc` file to ensure nvm is loaded:
   
   Refer to [[Auto-switch based on presence of .nvmrc file in folder]]

5. **Reload your shell**:
   ```sh
   source ~/.bashrc
   ```

	Or:
	```
	source ~/.zshrc
	```

6. **Verify the installation**:
   ```sh
   nvm --version
   ```


---

## Warning

Do not install nvm using npm, not even globally. The correct way is to install via the remote .sh file like outlined above. Otherwise, running nvm would give you error of: [[Troubleshooting - This is not the package you are looking for]]
