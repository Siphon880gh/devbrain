
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

## SOLUTION EXPLANATION

Change your npm to a different version

**FYI:** **Obstacles** to the solution: 
- You would normally downgrade with `npm install -g npm@6.14.8` but on some systems, that won't work (running `npm --version` afterwards still shows the old version). 
- Then your next thought is to uninstall with `npm uninstall -g npm` then installing the other version, which doesn't work on some systems too
- Then you thought of clearing the npm cache `npm cache clean -f`, then uninstalling the old version, then installing another version. On some systems this EVEN fails

MODIFIED SOLUTION to overcome the obstacle:
- Use NVM instead to manage installation, uninstallation, and switching of Node and NPM versions
- Node version manager lets you install multiple versions of node including npm, and then lets you choose the active node/npm). 

---

## SOLUTION

Refer to  [[NVM PRIMER - Manage node and npm versions]] and install and default a version of node/npm that isn't npm v7.X or npm x8.X
