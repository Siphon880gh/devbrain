### Standard solution NOT recommended
The official documents instruct that can run `pm2 startup` after commands successfully running pm2 or pm2 ecosystem.config.js
https://pm2.keymetrics.io/docs/usage/startup/

However pm2 ecosystem actually has a lot of "catch-you's" that make their official suggestions not the best instructions to follow. Follow this guide instead

---

## More robust solution

The robust solution is to guarantee using the Makefile as the source of all truth of how to select the nodejs version for pm2 and how to run pm2 ecosystem.config.js 

Firstly, if you had pm2 startup generated, run: `pm2 unstartup`

Create a makefile if haven't yet, in the same folder as ecosystem.config.js. The make script will restart pm2 in the desired nodejs version based on installed nvm path. Here we create a make script called "restart"

Makefile:
```
# .ONESHELL tells Makefile not to run each line on its own shell but all the lines belong to the same shell (therefore not losing nvm initialization)
.ONESHELL:
SHELL := /usr/bin/bash
restart:
	@source ~/.nvm/nvm.sh && \
	nvm use v22.8.0 && \
	pm2 delete ecosystem.config.js --env production && \
	pm2 update && \
	pm2 restart ecosystem.config.js --env production
```
^ `@source ~/.nvm/nvm.sh` initiates nvm so that it can be used to switch node version
^ Use your preferred node version. To install a specific version under nvm, it's like: `nvm install v22.8.0
^ Remember `pm2 update` is necessary to update pm2 to the node you switched to

Your ecosystem.config.js also covers a lot of server edge cases to guarantee it can switch to the nodejs version (this example runs `npm run start` so note that interpreter is the node and script is the npm and args is the `run start`, and note NODE_VERSION is defined for `--env production`):
```
  {
    name: 'note-taking:3006',
    cwd: "/home/wengindustries/htdocs/wengindustries.com/app/note-taking",
    interpreter: '/root/.nvm/versions/node/v22.8.0/bin/node',
    script: '/root/.nvm/versions/node/v22.8.0/bin/npm',
    args: '--scripts-prepend-node-path=auto run start',
    env_production: {
	  NODE_VERSION: "22.8.0",
      NODE_ENV: 'production',
      PORT: 3006,
    },
```

Create the sh script that will run that make script whenever your server restarts. I created the shell script at the same folder where my Makefile and ecosystem.config.js is at

restart-node-apps-2.sh:
```
#!/bin/bash
cd "/home/wengindustries/htdocs/wengindustries.com/eco"
make restart
```

Then I test that shell script successfully runs by running it directly.

Now the first point of entry when the server restarts depends on your autostart system. (`ps -p 1` to report init or systemd)

For this tutorial, we follow systemd (which Debian 12 uses). Use your equivalent if using init:
Create with `vi /etc/systemd/system/restart-node-apps.service`:
```
# At systemd's /etc/systemd/system/restart-node-apps.service, it restarts eco/restart-node-apps-2.sh, which runs `make restart` in order to follow Makefile's commands to init nvm, set node version for the session, delete pm2 apps tracked, update pm2's node version to the session's, and start pm2's ecosystem.config.js
[Unit]
Description=Custom Startup Script for Root
After=network.target

[Service]
Type=oneshot
# Note: ExecStart must be absolute path even though WorkingDirectory points to the script's folder
ExecStart=/home/wengindustries/htdocs/wengindustries.com/eco/restart-node-apps-2.sh
WorkingDirectory=/home/wengindustries/htdocs/wengindustries.com/eco
User=root
Group=root
RemainAfterExit=yes

[Install]
WantedBy=multi-user.target
```


Now this will simply make the service available to: `service restart-nodejs-apps status` but it does not autostart yet.

Let's enable for bootup
`sudo systemctl enable restart-node-apps`

Then you can challenge if successful:
- Check if your service is correctly enabled for autostart: 
  `systemctl is-enabled restart-node-apps`
- a reboot challenge to see pm2 successfully restarts (you can open the app on the web browser). For Debian 12, it's `reboot` command

Common Misunderstandings: You have to work with init/systemd and shell sh script, NOT .bash_profile or .bashrc or equivalent. The .bash_profile etc is only for the user going into a shell session, not the server starting in the background. For example, .bash_profile initializing nvm means the SSH user in the terminal can switch the node version by running `nvm use` command.