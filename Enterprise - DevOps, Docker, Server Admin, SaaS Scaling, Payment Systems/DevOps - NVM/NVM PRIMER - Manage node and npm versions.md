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
```
npm -v
```

You can list all available npm versions you can switch to:
```
nvm list
```

---

## Installing different NPM using NVM

Use NVM to install version of node and npm you like. Recommend make sure not npm v7.X and npm v8.X because it causes probems when you use npm scripts to modify the system even if the scripts are using cli tool commands that modify the system, because the npm v7.X and v8.X decided to change the user to the owner of the root package folder instead of pertaining to the user that ran the npm script, causing workflow issues and preventing scripts from practically working.


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


   ```sh
   nvm install 20.11.0
   ```

8. **Use the newly installed Node.js version**:
   ```sh
   nvm use v14.17.0
   ```


```
nvm use 20.11.0
```

9. **Verify the node and npm version**:
   ```sh
   node -v
   npm -v
   ```

This should show npm version 6.14.8 since it is bundled with Node.js v14.17.0.

10. Next you have to make it the default node version because this setting only applies to your current shell session:
```
nvm alias default v14.17.0
```


Restart your server (`sudo reboot`) then test `npm -v` again to make sure it sticks

---

## Project based npm versions:

Yes, you can specify a Node.js version for your project using **`.nvmrc`**, a file that stores the desired Node.js version. This allows you to easily switch between Node.js versions when working on different projects.

### Steps:

1. **Create `.nvmrc` file**:
   In your project directory, create a `.nvmrc` file and specify the version of Node.js you want to use:
   ```bash
   echo "14.17.0" > .nvmrc
   ```
   Replace `"14.17.0"` with the version you want to use for this project.

2. **Use the specified version from finding a .nvmrc file**:
   To use the Node.js version specified in the `.nvmrc` file, run the following command:
   ```bash
   nvm use
   ```

3. **Automatically switch versions**:
   You can use tools like **direnv** or **avn** (Automatic Version Switcher) to automatically switch to the correct Node.js version when you `cd` into the project directory.
