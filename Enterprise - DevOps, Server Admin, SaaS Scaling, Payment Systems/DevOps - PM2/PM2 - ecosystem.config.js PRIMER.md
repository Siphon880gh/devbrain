## Boilerplate and Explanation

The file `ecosystem.config.js` can be used instead of running `pm2 start` at every directory where you have a NodeJS app you want to run persistently and then having a historic list of apps at `npm list` that can be restarted after they've been stopped.

That ecosystem.config.js would be per server. And on your server would be all your apps. This makes it easier to manage multiple servers, each server with multiple apps.

Here's a boilerplate, but take notes that:
- A naming convention is the app name followed by the port number it listens to. This is because pm2 does not care if your script listens to a specific port - pm2 does not manage that - so `pm2 list` or `pm2 ls` doesn't show the ports being listened to
- The `script` filepath is relative to ecosystem.config.js
- interpreter (path to the node interpreter) is optional but useful if you have different node paths from nvm because of compatibility issues (like Firebase glitches on certain node versions), or you have a specified nvm node version to assure compatibility when migrating, or any other reasons. Note the internet may say the key is "exec_interpreter" but that's for older pm2.
- env is optional but useful for passing environmental variables when starting the app from pm2 and is also useful to pass in a PORT number that your express server uses from dotenv and process.env.PORT, assuring that none of your NodeJS apps will clash with port numbers

```
module.exports = {
  apps: [{
    name: 'app1:3001',
    script: './apps/app1/server.js',
    watch: false,
    exec_mode: 'fork',
    instances: 1, // Number of instances to launch (can set to "max" to scale automatically)
    autorestart: true, // Restart the app if it crashes
    interpreter: '/root/.nvm/versions/node/v22.8.0/bin/node',
    env: {
      NODE_ENV: 'development',
      PORT: 3313
    },
    env_production: {
      NODE_ENV: 'production',
      PORT: 3313
    },
    log_date_format: 'YYYY-MM-DD HH:mm Z'
  }]
};

```

The above is only for one app, but if you have more than one app, you can add further objects in the apps array option

Yes, Node.js' `dotenv` and `process.env.PORT` can pick up on the `PORT` value defined in the **PM2 ecosystem file**. We will run the ecosystem file with a pm2 ecosystem run command that can specify development or production, so you can have different PORT for each server vs local development.

More options
- Memory restart limit: You can have an app restart if its memory hit a limit, eg. `max_memory_restart: "300M"`
- Provide args:  `args: []`  to pass arguments to the node script that gets ran
	- Eg. `args: ['--port', '3001', '--env', 'development']` which will concatenate with spaces
- CWD for more robustness or if you are running the ecosystem file from another folder path or you have another script that runs the ecosystem:
	- You can provide an absolute path to `cwd: "<ABS FILE PATH>`. If you don’t have ‘cwd’, then the cwd is the path where you ran pm2 from and pm2 will try to run the script filepath which could have been a relative path. This means if your server.js creates files (like log.txt), then it’ll create it where you were at when you executed pm2. Usually you want an app to create files inside the same folder as the app. So we add cwd to fix this. Think of the `cwd:`  as where you cd into before running the file at `script:` . The order of cwd and script  in your app config object doesn’t matter, but for developer experience, if you put cwd first, then script after, it helps to think of it that way as how pm2 runs that app (cd into the folder, then run the script with `node`  command)
- exec_mode could be cluster which allows for multiple instances listening to the same port
	- `instance_var: 'INSTANCE_ID'` or another constant value, assigns an environmental variable that helps you programmatically write to a log file identifying which instance of the cluster it's from:
	  ```
		console.log(`[${process.env.INSTANCE_ID}] - Server started on port ${process.env.PORT}`);
		```

	- For "INSTANCE_ID", the logs could look like:
	```
	[0] - Server started on port 3313
	[1] - Server started on port 3313
	[0] - Server started on port 3313
	[1] - Server started on port 3313
	[0] - Handling request from 192.168.1.100
	[1] - Handling request from 192.168.1.101
	[0] - Request completed for 192.168.1.100
	[1] - Request completed for 192.168.1.101
		  
	```

	All the possible constant values are as follows, however INSTANCE_ID is the most commonly used. You cannot assign more than one constant variable or concatenate them.  
	- **INSTANCE_ID** (common usage)
	- **PM2_INSTANCE** (indicating it's related to PM2)
	- **WORKER_ID** (useful when dealing with worker processes)
	- **APP_INSTANCE** (for applications where multiple instances are deployed)
	- **CLUSTER_ID** (indicating it's part of a cluster of processes)

---

## Multiple ecosystem.config.js on the same Server

If you have completely different projects, you can keep them in separate directories with their own `ecosystem.config.js` files, and then run them individually to have each of their apps running alongside.

Example:
- `project1/ecosystem.config.js`
- `project2/ecosystem.config.js`

To start both on the same server:

```bash
pm2 start project1/ecosystem.config.js
pm2 start project2/ecosystem.config.js
```

You can see all the apps by running `pm2 ls` or `pm2 list`

You can have different apps with the same name run as long as their scripts are at different file paths, so make sure to have them as unique names for manageability.

Note this is *NOT* recommended. It's recommended you have all the apps in the same server to have a single ecosystem.config.js, for mangeability.

---

### Best Practices - Makefile to manage pm2 ecosystem commands

In order to manage the operations of pm2 ecosystem (restart, stop all, etc), it's recommended you combine with a Makefile. Then the DevOps developer can run `make restart_app1`, `make shutdown_app1`, `make restart_all`,  etc corresponding to different terminal commands to restart apps or shutdown apps. With a Makefile, any DevOps tool is possible and you do not have to recall the specific command. To read more: [[Makefile - PRIMER]]

---

## Reference - Ecosystem Commands

```
# Start all applications  
pm2 start ecosystem.config.js  
  
# Stop all  
pm2 stop ecosystem.config.js  
  
# Restart all  
pm2 restart ecosystem.config.js  
  
# Reload all  
pm2 reload ecosystem.config.js  
  
# Delete all  
pm2 delete ecosystem.config.js
```

