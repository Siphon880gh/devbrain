Eg. To allow port 9001 through the firewall for NGINX, you will need to perform a couple of steps depending on the firewall software you are using (e.g., `ufw`, `iptables`, `firewalld`). Below are instructions for common firewalls:

### Using `ufw` (Uncomplicated Firewall)

1. **Enable the firewall** (if not already enabled):

   ```bash
   sudo ufw enable
   ```

2. **Allow port 9001**:

   ```bash
   sudo ufw allow 9001
   ```

3. **Check the status** to ensure the rule is added:

   ```bash
   sudo ufw status
   ```

### Using `iptables`

1. **Allow port 9001**:

   ```bash
   sudo iptables -A INPUT -p tcp --dport 9001 -j ACCEPT
   ```

2. **Save the rules** so they persist after a reboot. This varies based on your system. For example, on Debian-based systems:

   ```bash
   sudo sh -c "iptables-save > /etc/iptables/rules.v4"
   ```

### Using `firewalld`

1. **Allow port 9001**:

   ```bash
   sudo firewall-cmd --permanent --add-port=9001/tcp
   ```

2. **Reload firewalld** to apply the changes:

   ```bash
   sudo firewall-cmd --reload
   ```

### Configure NGINX to Listen on Port 9001

1. **Edit the NGINX configuration file**:

   ```bash
   sudo nano /etc/nginx/sites-available/default
   ```

   or the specific server block configuration file you are using.

2. **Add or modify the `server` block to listen on port 9001**:

   ```nginx
   server {
       listen 9001;
       server_name your_domain_or_IP;

       location / {
           proxy_pass http://localhost:some_port;  # Adjust as needed
           proxy_set_header Host $host;
           proxy_set_header X-Real-IP $remote_addr;
           proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
           proxy_set_header X-Forwarded-Proto $scheme;
       }
   }
   ```

3. **Save and close the configuration file**.

4. **Test the NGINX configuration**:

   ```bash
   sudo nginx -t
   ```

5. **Reload NGINX** to apply the changes:

   ```bash
   sudo systemctl reload nginx
   ```

By following these steps, you will allow traffic on port 9001 through your firewall and configure NGINX to listen on that port.