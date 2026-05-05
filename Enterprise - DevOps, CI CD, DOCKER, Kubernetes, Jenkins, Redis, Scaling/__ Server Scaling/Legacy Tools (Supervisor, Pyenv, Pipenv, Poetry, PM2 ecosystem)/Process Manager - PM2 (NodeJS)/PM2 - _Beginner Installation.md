
Purpose: Installing PM2 and Configuring Nginx for Multiple Node.js Applications

## Step 1: Installing PM2
First, we need to install PM2, a process manager that allows Node.js applications to run in the background as a service. 

To install the latest version of PM2 globally, use npm:

```bash
sudo npm install pm2@latest -g
```

The `-g` flag ensures the installation is global, making PM2 available system-wide.

Let's create a dummy js file to run with PM2:
```
touch hello.js
```

Now, let's start your application, `hello.js`, with PM2:

```bash
pm2 start hello.js
```

This command will run `hello.js` in the background and add it to PM2’s process list, displaying the following output:

```
[PM2] Spawning PM2 daemon with pm2_home=/home/user/.pm2
[PM2] PM2 Successfully daemonized
[PM2] Starting /home/user/hello.js in fork_mode (1 instance)
[PM2] Done.
┌────┬─────────┬───────┬─────┬─────────┬───────┬────────┐
│ id │ name    │ mode  │ ↺   │ status  │ cpu   │ memory │
├────┼─────────┼───────┼─────┼─────────┼───────┼────────┤
│ 0  │ hello   │ fork  │ 0   │ online  │ 0%    │ 25.2mb │
└────┴─────────┴───────┴─────┴─────────┴───────┴────────┘
```

PM2 assigns an app name based on the filename and maintains information such as PID, status, and memory usage.

To ensure your application starts on system boot, use the following command to generate and configure a startup script:
- **Generate the service:** Run `sudo pm2 startup`.
- **Execute the output:** The command above will provide the service name like in
```
Target path
/etc/systemd/system/pm2-root.service
Command list
[ 'systemctl enable pm2-root' ]
```
^ The service name is in the format of pm2-{USERNAME}

**Then run:**
- Adjust username / service name; in my case, it was root
```
sudo systemctl enable pm2-root
```

**Check if daemon is alive:**
- Adjust username / service name; in my case, it was root
```
sudo systemctl status pm2-root
```

**Save the current list:** Once your apps are running, run `pm2 save`. This "freezes" the current process list so PM2 knows what to resurrect after a reboot

**CHECKPOINT:** **Is active saying dead?**
1. Before creating a new one, you must remove the existing, non-functional service. 
	- Run the unstartup command: `sudo pm2 unstartup`

2. And then force a restart:
```
systemctl restart pm2-root
```

3. Check again:
```
sudo systemctl status pm2-root
```
## Step 2: Managing PM2 Processes
PM2 offers several commands to manage your applications:

- **Stop an application:**

  ```bash
  pm2 stop app_name_or_id
  ```

- **Restart an application:**

  ```bash
  pm2 restart app_name_or_id
  ```

- **List all applications managed by PM2:**

  ```bash
  pm2 list
  ```

- **Get information about a specific application:**

  ```bash
  pm2 info app_name
  ```

- **Monitor application status, CPU, and memory usage:**

  ```bash
  pm2 monit
  ```

Running `pm2` without any arguments will display a help page with usage examples.

## Step 3: Setting Up Nginx as a Reverse Proxy Server
With your Node.js application running and managed by PM2, the next step is to configure Nginx to act as a reverse proxy.

Open your Nginx configuration file for editing:

```bash
sudo nano /etc/nginx/sites-available/example.com
```

Within the server block, replace the contents of the existing `location /` block with the following configuration, updating the port number if necessary:

```nginx
server {
    ...
    location /app1 {
        proxy_pass http://localhost:3000;
        proxy_http_version 1.1;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection 'upgrade';
        proxy_set_header Host $host;
        proxy_cache_bypass $http_upgrade;
    }
    ...
}
```

This configuration directs requests to `hello.js`, running on port 3000. To add another Node.js application on port 3001, include an additional location block:

```nginx
server {
    ...
    location /app2 {
        proxy_pass http://localhost:3001;
        proxy_http_version 1.1;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection 'upgrade';
        proxy_set_header Host $host;
        proxy_cache_bypass $http_upgrade;
    }
    ...
}
```

After editing, save and close the file. Verify the Nginx configuration syntax:

```bash
sudo nginx -t
```

Then, restart Nginx:

```bash
sudo systemctl restart nginx
```

Now, assuming your Node.js application is running and your configurations are correct, you should be able to access your application via the Nginx reverse proxy. Try accessing your server’s URL (public IP address or domain name) in a web browser to confirm everything is working correctly.

## Clean up (hello.js)

`hello.js` is actually a bad script to keep running because it has no throttling through a `listen`, `setInterval`, `setTimeout`, or any other waiting mechanism (eg. Express server's **listen**). It is just a `console.log`, so the script can finish almost immediately. Under PM2, that means the process exits and then gets started again, over and over, which can create a very fast restart loop. That causes PM2 to keep writing logs repeatedly, and over time the log handling can become increasingly expensive on the CPU due to the larger log file size. After a few days, depending on the hardware and how quickly the script keeps restarting, you may see CPU usage climb to around 10% more. Because of that, `hello.js` should be stopped or shut down. 

> [!note] For more information on writing scripts that don't repeatedly restart
> Refer to [[PM2 - _Beginner Pitfalls - Preventing Infinite Restart Loops and High CPU Usage 1 (Script that restarts)]]
> 

Proper shut down is as follows:

See what's the name:
```
pm2 list
```

Stop by name:
```
pm2 stop NAME
```

That isn't enough because it'll just be in stopped status and will restart when pm2 restarts (due to server reboot, etc). You can see that `pm2 list` just shows stopped status

Remove from pm2 list:
```
pm2 delete NAME
```

And the shut off process is not entirely done yet even when `pm2 list` no longer shows the process. Without running `pm2 update`, the daemon isn’t fully refreshed, so it may keep trying to manage something that no longer exists especially after pm2 restarts from a server reboot. Run this to wrap it up:
```
pm2 update
```

If you want to really make sure, restart the server (like `reboot` command in Debian 12). Then once the server is back online, run `pm2 list` again to confirm if it really is removed/not restarted.
