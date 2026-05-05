## Start with numprocs

This supervisor app's config file:
```
[program:my_app]
command=/path/to/my/app
autostart=true
autorestart=true
numprocs=5  ; Starts 5 instances of the application
process_name=%(program_name)s_%(process_num)02d
```

For example, if you have a machine with 8 CPU cores and your application is not CPU-intensive, you might configure:

- 4 instances (`numprocs=4` in Supervisor).
- 4 workers per instance (`gunicorn -w 4 your_app:app`).

Remember that the number of workers is whether you're CPU bound or I/O bound. If CPU bound, your number of workers is `2 x number of cpu cores + 1`. If I/O bound, keep the number of workers close to the number of CPU cores

For more than one instance, divide the number of workers among them..

---

## Reworded

Multiple gunicorn processes from numprocs must either listen to different ports or to different Unix sockets. If you try to start multiple Gunicorn processes listening on the same port, you will encounter a "port already in use" error.

To handle multiple Gunicorn processes, you can either:

1. **Use Different Ports for Each Process:**
   - Each Gunicorn process should listen on a different port, and you can use a reverse proxy (like Nginx or HAProxy) to distribute incoming traffic to these different ports.

2. **Use a Unix Socket:**
   - Configure Gunicorn processes to listen on different Unix sockets instead of TCP ports, and then use a reverse proxy to balance the load across these sockets.

---

## Example Configuration with Different Ports

If you choose to use different ports for each process, you need to configure Supervisor to start each process on a different port:

```ini
[program:my_app_1]
command=gunicorn -w 3 -b 127.0.0.1:5001 my_app:app
autostart=true
autorestart=true

[program:my_app_2]
command=gunicorn -w 3 -b 127.0.0.1:5002 my_app:app
autostart=true
autorestart=true

[program:my_app_3]
command=gunicorn -w 3 -b 127.0.0.1:5003 my_app:app
autostart=true
autorestart=true

[program:my_app_4]
command=gunicorn -w 3 -b 127.0.0.1:5004 my_app:app
autostart=true
autorestart=true
```

In this example, each Gunicorn process listens on a different port (5001, 5002, 5003, 5004).

To load balance traffic in Nginx with multiple Gunicorn instances listening on different ports, you need to set up an upstream block that lists all the backend servers (your Gunicorn instances), and then configure your server block to proxy requests to this upstream group.

Here's a step-by-step guide on how to achieve this:

### Step 1: Configure Gunicorn Instances

Ensure you have multiple Gunicorn instances running on different ports. For example:

- Gunicorn instance 1 on port 5001
- Gunicorn instance 2 on port 5002
- Gunicorn instance 3 on port 5003
- Gunicorn instance 4 on port 5004

### Step 2: Configure Nginx

Edit your Nginx configuration file (e.g., `/etc/nginx/nginx.conf` or a site-specific configuration file in `/etc/nginx/sites-available/`).

#### Define the Upstream Group

Add an upstream block that includes all the Gunicorn instances:

```nginx
upstream my_app {
    server 127.0.0.1:5001;
    server 127.0.0.1:5002;
    server 127.0.0.1:5003;
    server 127.0.0.1:5004;
}
```

#### Configure the Server Block

In your server block, proxy requests to the upstream group:

```nginx
server {
    listen 80;
    server_name your_domain.com;

    location / {
        proxy_pass http://my_app;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
}
```

### Example Full Nginx Configuration

Here's a complete example of an Nginx configuration file that sets up load balancing for multiple Gunicorn instances:

```nginx
http {
    upstream my_app {
        server 127.0.0.1:5001;
        server 127.0.0.1:5002;
        server 127.0.0.1:5003;
        server 127.0.0.1:5004;
    }

    server {
        listen 80;
        server_name your_domain.com;

        location / {
            proxy_pass http://my_app;
            proxy_set_header Host $host;
            proxy_set_header X-Real-IP $remote_addr;
            proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
            proxy_set_header X-Forwarded-Proto $scheme;
        }
    }
}
```

### Explanation

- **upstream my_app:** Defines a group of backend servers (Gunicorn instances) that Nginx will load balance.
- **server 127.0.0.1:5001;** etc.: Specifies the individual Gunicorn instances in the upstream group.
- **proxy_pass http://my_app;**: Proxies incoming requests to the upstream group.
- **proxy_set_header ...;**: Sets the necessary headers to pass along with the request to the backend servers.

### Load Balancing Methods

By default, Nginx uses a round-robin load balancing method, which distributes requests evenly across all backend servers. If you want to use a different load balancing method, you can specify it in the upstream block:

- **Least Connections:**

  ```nginx
  upstream my_app {
      least_conn;
      server 127.0.0.1:5001;
      server 127.0.0.1:5002;
      server 127.0.0.1:5003;
      server 127.0.0.1:5004;
  }
  ```

- **IP Hash:**

  ```nginx
  upstream my_app {
      ip_hash;
      server 127.0.0.1:5001;
      server 127.0.0.1:5002;
      server 127.0.0.1:5003;
      server 127.0.0.1:5004;
  }
  ```

### Reload Nginx

After updating your Nginx configuration, reload Nginx to apply the changes:

```bash
sudo systemctl reload nginx
```

or

```bash
sudo service nginx reload
```

This setup will enable Nginx to load balance incoming requests across multiple Gunicorn instances running on different ports.

---

## Example Configuration with Unix Sockets

Alternatively, if you want to use Unix sockets, your configuration might look like this:

```ini
[program:my_app_1]
command=gunicorn -w 3 -b unix:/tmp/my_app_1.sock my_app:app
autostart=true
autorestart=true

[program:my_app_2]
command=gunicorn -w 3 -b unix:/tmp/my_app_2.sock my_app:app
autostart=true
autorestart=true

[program:my_app_3]
command=gunicorn -w 3 -b unix:/tmp/my_app_3.sock my_app:app
autostart=true
autorestart=true

[program:my_app_4]
command=gunicorn -w 3 -b unix:/tmp/my_app_4.sock my_app:app
autostart=true
autorestart=true
```

In this case, each Gunicorn process listens on a different Unix socket (`/tmp/my_app_1.sock`, `/tmp/my_app_2.sock`, etc.). Then, you can configure Nginx or another reverse proxy to route traffic to these sockets.

### Nginx Configuration Example

Here's how you might configure Nginx to reverse proxy to the different Gunicorn processes listening on Unix sockets:

```nginx
server {
    listen 80;
    server_name your_domain.com;

    location / {
        proxy_pass http://unix:/tmp/my_app_1.sock;
        proxy_pass http://unix:/tmp/my_app_2.sock;
        proxy_pass http://unix:/tmp/my_app_3.sock;
        proxy_pass http://unix:/tmp/my_app_4.sock;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
}
```

---
## Summary

To run multiple Gunicorn processes with Supervisor, you need to configure them to listen on different ports or Unix sockets. You can then use a reverse proxy like Nginx to distribute incoming traffic to these processes. This setup ensures that each process handles a portion of the traffic, improving load distribution and fault tolerance.
