
## PROBLEM

In this example running `npm run start` gives you an Access Denied error on the python file:
```
"scripts":
	"start": "python server.py"
```

You could run `npm run where` to find out the path of the python and see if that python has the correct permissions and it probably does (why not because you could run directly in the terminal `python script.py`)
```
  "scripts": {  
    "where": "whereis python"  
  }
```


This is a problem on npm v7.X and npm v8.X (they reversed coursed on future versions). Run `npm --version` to find out if your npm is indeed the problematic v7.X or v8.X

At these versions, even though you may be logged in as root and the cli is owned by root ( /usr/loca/bin, /usr/share, /etc/, etc), the "user" running the command in the npm script might not be root. 

npm v7.X and npm v8.X runs npm scripts under the user that owns the npm project directory regardless of who is logged into the shell session

This is problematic because python and other cli that may be at /usr/loca/bin, /usr/share, /etc/, etc etc are usually owned by root. You may not want to make your npm project directory owned by root just to have npm runs scripts as root.

You can prove that the user switched on you by running `npm run test` . You can see even though you're logged in as root, npm script runs as another user.
```
"scripts":
	"test": "whoami"
```

FURTHER PROOF:
https://github.com/npm/cli/issues/4095

Changelog for [7.0.0-beta.0](https://github.com/npm/cli/blob/v8.3.0/changelogs/CHANGELOG-7.md#all-lifecycle-scripts) says:

> The user, group, uid, gid, and unsafe-perms configurations are no longer relevant. When npm is run as root, scripts are always run with the effective uid and gid of the working directory owner.

And in [docs](https://docs.npmjs.com/cli/v8/using-npm/scripts#user):

> When npm is run as root, scripts are always run with the effective uid and gid of the working directory owner.

At version 9, Node reversed course on this decision


---

## SOLUTION

Change your npm to a different version

Obstacles to the solution: 
- You would normally downgrade with `npm install -g npm@6.14.8` but on some systems, that won't work (running `npm --version` afterwards still shows the old version). 
- Then your next thought is to uninstall with `npm uninstall -g npm` then installing the other version, which doesn't work on some systems too
- Then you thought of clearing the npm cache `npm cache clean -f`, then uninstalling the old version, then installing another version. On some systems this EVEN fails

MODIFIED SOLUTION to overcome the obstacle:
- Use NVM instead to manage installation, uninstallation, and switching of Node and NPM versions
- Node version manager lets you install multiple versions of node including npm, and then lets you choose the active node/npm). 

---

## Installing different NPM using NVM

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

10. Next you have to make it the default node version because this setting only applies to your current shell session:
```
nvm alias default v14.17.0
```


Restart your server then test `npm -v` again to make sure it sticks