## Step 1: Installing PM2
First, we need to install PM2, a process manager that allows Node.js applications to run in the background as a service. 

To install the latest version of PM2 globally, use npm:

```bash
sudo npm install pm2@latest -g
```

The `-g` flag ensures the installation is global, making PM2 available system-wide.

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

```bash
pm2 startup systemd
```

This will output a command similar to the one below. Run it with superuser privileges:

```bash
sudo env PATH=$PATH:/usr/bin /usr/lib/node_modules/pm2/bin/pm2 startup systemd -u user --hp /home/user
```

Next, save the PM2 process list and corresponding environments:

```bash
pm2 save
```

Now, you have created a systemd unit that runs PM2 for your user on boot. Start the service with:

```bash
sudo systemctl start pm2-user
```

Check the status with:

```bash
systemctl status pm2-user
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