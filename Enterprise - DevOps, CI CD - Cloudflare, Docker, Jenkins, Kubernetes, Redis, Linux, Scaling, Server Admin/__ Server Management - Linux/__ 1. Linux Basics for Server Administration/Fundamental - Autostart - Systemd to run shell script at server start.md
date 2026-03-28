Goal: Run .sh script when server starts or restarts

Create the sh script that will run your commands

restart-node-apps-2.sh:
```
#!/bin/bash
cd "/home/wengindustries/htdocs/....."
# your commands
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