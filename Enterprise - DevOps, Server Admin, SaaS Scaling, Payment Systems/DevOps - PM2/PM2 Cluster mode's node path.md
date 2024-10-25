While having an --interpreter in the pm2 command options or in the ecosystem.config.js works for fork mode (exec_mode is "fork"), it doesn't work when exec_mode is cluster

And for production, you want cluster mode so that worker processes spawn as needed based on traffic load. However, some of your node.js modules might not be compatible with the version of node that cluster spawns the initial worker process and the subsequent worker processes under, and --interpreter whether it's from the command line or the ecosystem.config.js is IGNORED. 
- Cluster mode runs the node that was global on your computer the last time pm2 was installed or the last time pm2 looked into your global node
- To switch to another node, you can use nvm (eg. nvm install VERSION, nvm use VERSION, node --version); Or you can update the node on your system.
- Then you need to tell pm2 to update its filepath reference to the new global node by running: `pm2 update`

You can see what version of node that pm2 is running by replacing the script.js that you're running pm2 with with another script.js:
```
console.log("Node interpreter path:", process.execPath);
```

Then you can restart ecosystem or pm2, but make sure you delete first (because if the app is listed as stop, restarting it will simply use the cached node script).

With that script running, see what it console logs by looking into that app's pm2 logger:
```
pm2 logs --lines 100 | grep -i "app"
```
^ Make sure to replace app with the proper app name which you can get from `pm2 list` if you forgot it