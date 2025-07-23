
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

You can have when you run `cd` to change directory to autoload the desired node version if you create a `.nvmrc` at that folder with contents like:
```
12.18.1
```
^ Only works if you properly setup nvm with your .bashrc or .zshrc