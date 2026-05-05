
**Requirements**:
- Nvm already setup globally. If not setup yet, refer to [[_PRIMER - NVM - Setup way to manage node and npm versions]]


---

## Install the nvm's node version

**Install the desired Node.js version** (e.g., v14.17.0):
```sh
nvm install v14.17.0
```

**Use the newly installed Node.js version. The compatible npm version will be bundled in as well:**
```sh
nvm use v14.17.0
```

**Verify the node version**:
```
node -v
```

You can list all available npm versions you can switch to:
```
nvm list
```

---

## Optional - Set it permanently per project folder

You can have when you run `cd` to change directory to autoload the desired node version if you create a `.nvmrc` at that folder with contents like:
```
12.18.1
```
^ Only works if you properly setup nvm with your .bashrc or .zshrc, so that nvm can always check if there's a .nvmrc file in the folder you cd into

A more automated way than writing .nvmrc manually is to get the current version you switched into and then redirect it to the file `.nvmrc`:
```
node -v > .nvmrc
```