
Hetzner -> Cloud item at the main nav:
https://www.hetzner.com/cloud/

Choose General Purpose (Cost Optimized and Regular Performance for shared resource or very low CPU usage)
https://www.hetzner.com/cloud/general-purpose

Choose a specific package (eg. CCX13). Comparable for multi mixed web server (python, nodejs, etc), you can go for ~$20 which is 2 VCPU, 8GB Ram, 80GB Disk Local. No need to install volumes (that's adding volumes on top of the baseline disk space you selected when choosing a VPS)

---

## Immediately establish ssh connection 

We're gonna go for passwordless ssh login. 

At your local machine, generate a SSH key pair using your email address that you signed up with your VPS for:
```
ssh-keygen -t ed25519 -C "your_email@example.com"
```

At your VPS, for example Hetzner, upload the public SSH key's contents. This is done through a feature you press add SSH key (so no need to go into SSH terminal which you don't have access setup for yet). Keep the private and public keys on your computer.

> [!note] UI UX Confusion
> Note that later on, after you have an SSH key, the dashboard doesn't tell you that you have an SSH key. It gives you the menu item for creating SSH key, which can lead to some confusion. But clicking that menu item will go to the SSH key list, showing your public key. 
>

Once SSH key pair has been established, run this command at your local machine's terminal to test logging into SSH passwordless:
```
.ssh % ssh -i ~/.ssh/newmac2023_hetzner -p 22 root@5.55.555.555  -tt "cd .  && bash --login"
```

Sysadmin experience:
- You can now cd into a specific folder everytime (adjust the . path)
- You can also setup an alias at your .zshrc so that running the alias in terminal can log you into ssh. I like to name my alias after my hostname

---
## Prepare to install cloudpanel and nginx

We will prepare to install cloudpanel and nginx.

Cloudpanel will bundle in nginx web server

But to install Cloudpanel, it expects a hostname to already be set up on the server before installation. That is because their installer is built around normal domain-based web hosting, and has to configure your nginx for that hostname.

**Overview** what we will do:
- Firstly you have to **setup the server-side to self-identify as the specific hostname** (appearing on cloudpanel, settings, etc). This is because CloudPanel will use that exposed setting to configure nginx and itself to deliver/match to the hostname
- Then, because soon after installing Cloudpanel, we focus on making webpage changes and seeing them on the web-browser, setting up SSL, etc, we want when someone visits your hostname or domain on the web browser, that hostname resolves into an IP so that the internet can send a request directly to your web host. Therefore you would need to register your domain at a DNS registrar, typically. But let's say we dont want to buy a DNS domain right away - **we will take advantage of the free sslip.io**


Investigation:
- Adjust sslip.io server by prefixing your webhost's IP to sslip - no need to sign up for anything:
You'd visit https://5.55.555.555.sslip.io or http://5.55.555.555.sslip.io
- But it own't open anything because we dont have a web server setup to match to that hostname and respond with webpage content. In normal situations, it would allow your webhost to deliver a webpage. This works without a DNS registrar like namecheap because sslip.io is a generously free wildcard domain address that takes your ip address as a subdomain, then points to your IP address, so internet connection can make a request to your webhost's IP address

Firstly, setup server side to  identify your server as a specific hostname
```
hostnamectl set-hostname 5.55.555.555.sslip.io
```

Install CloudPanel:
```
curl -sSL https://installer.cloudpanel.io/ce/v2/install.sh | bash
```


Then check nginx bundled with cloudpanel is installed:
```
nginx -version
```

CloudPanel would have installed nginx for you and also configured your nginx's vhost (which you can access ats the cloudpanel GUI - more later). It'd have. configured the nginx vhost to accept incoming connections and match if those incoming connections are asking for a specific hostname to respond (in this case 5.55.555.555.sslip.io)


---


Access CloudPanel GUI:
https://panel.5.55.555.555.sslip.io:8443

^ Cloudpanel already setup that hostname matching for you because it referred to the settings at `hostnamectl`

OR:
https://5.55.555.555:8443

Might fail. Check if ufw enabled and scopes limited:
```
ufw status
ufw disable
```

Do you get this message?
![[Pasted image 20260411010948.png]]

CloudPanel’s admin interface on port 8443 is meant to be opened as at https://..., not http://.. YES it's dumb because you don't have SSL setup at this point

If Chrome blocking you because of the lack of SSL certificate, hit Advanced -> Proceed. If they're even stricter than that, free type without spaces "thisisunsafe" to bypass and proceed the lack of SSL certificate

Now visiting https version:
![[Pasted image 20260411011448.png]]


![[Pasted image 20260411012009.png]]

Add a new website. Then best bang for the buck is PHP site (because it does PHP already, and it can handle Wordpress, and you can SSH install NodeJS and Python later, and reverse proxy is easily done through vhost anyways):
![[Pasted image 20260411012715.png]]

On the php questions, you can choose Generic for Application instead of one of the CMS. This will allow maximum flexibility. Make sure to enter your domain name, preferred site user, and preferred site user password

---

We can enhance the default vhost they provide to prevent certain gotcha's when setting up SSL etc later:
```
server {
  listen 80;
  listen [::]:80;
  listen 443 quic;
  listen 443 ssl;
  listen [::]:443 quic;
  listen [::]:443 ssl;
  http2 on;
  http3 off;
  {{ssl_certificate_key}}
  {{ssl_certificate}}
  server_name www.wengindustries.com;
  return 301 https://wengindustries.com$request_uri;
}

server {
  listen 80;
  listen [::]:80;
  listen 443 quic;
  listen 443 ssl;
  listen [::]:443 quic;
  listen [::]:443 ssl;
  http2 on;
  http3 off;
  {{ssl_certificate_key}}
  {{ssl_certificate}}
  server_name wengindustries.com www1.wengindustries.com;
  {{root}}

  {{nginx_access_log}}
  {{nginx_error_log}}

  if ($scheme != "https") {
    rewrite ^ https://$host$request_uri permanent;
  }

  location ~ /.well-known {
    auth_basic off;
    allow all;
  }

  {{settings}}

  location / {
    {{varnish_proxy_pass}}
    proxy_set_header Host $host;
    proxy_set_header X-Forwarded-Host $host;
    proxy_set_header X-Real-IP $remote_addr;
    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    proxy_hide_header X-Varnish;
    proxy_redirect off;
    proxy_max_temp_file_size 0;
    proxy_connect_timeout      720;
    proxy_send_timeout         720;
    proxy_read_timeout         720;
    proxy_buffer_size          128k;
    proxy_buffers              4 256k;
    proxy_busy_buffers_size    256k;
    proxy_temp_file_write_size 256k;
  }

  location ~* ^.+\.(css|js|jpg|jpeg|gif|png|ico|gz|svg|svgz|ttf|otf|woff|woff2|eot|mp4|ogg|ogv|webm|webp|zip|swf|map|mjs)$ {
    add_header Access-Control-Allow-Origin "*";
    add_header alt-svc 'h3=":443"; ma=86400';
    expires max;
    access_log off;
  }

  location ~ /\.(ht|svn|git) {
    deny all;
  }

  if (-f $request_filename) {
    break;
  }
}

server {
  listen 8080;
  listen [::]:8080;
  server_name wengindustries.com www1.wengindustries.com;
  {{root}}

  include /etc/nginx/global_settings;

  try_files $uri $uri/ /index.php?$args;
  index index.php index.html;

  location ~ \.php$ {
    include fastcgi_params;
    fastcgi_intercept_errors on;
    fastcgi_index index.php;
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    try_files $uri =404;
    fastcgi_read_timeout 3600;
    fastcgi_send_timeout 3600;
    fastcgi_param HTTPS "on";
    fastcgi_param SERVER_PORT 443;
    fastcgi_pass 127.0.0.1:{{php_fpm_port}};
    fastcgi_param PHP_VALUE "{{php_settings}}";
  }

  if (-f $request_filename) {
    break;
  }
}
```

UPDATE VHOST: We will collide the www and non-www server blocks into one - full vhost:
```
server {
  listen 80;
  listen [::]:80;
  listen 443 quic;
  listen 443 ssl;
  listen [::]:443 quic;
  listen [::]:443 ssl;
  http2 on;
  http3 off;
  {{ssl_certificate_key}}
  {{ssl_certificate}}
  server_name wengindustries.com www1.wengindustries.com www.wengindustries.com;
  {{root}}

  {{nginx_access_log}}
  {{nginx_error_log}}

  if ($scheme != "https") {
    rewrite ^ https://$host$request_uri permanent;
  }

  location ~ /.well-known {
    auth_basic off;
    allow all;
  }

  {{settings}}

  location / {
    {{varnish_proxy_pass}}
    proxy_set_header Host $host;
    proxy_set_header X-Forwarded-Host $host;
    proxy_set_header X-Real-IP $remote_addr;
    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    proxy_hide_header X-Varnish;
    proxy_redirect off;
    proxy_max_temp_file_size 0;
    proxy_connect_timeout      720;
    proxy_send_timeout         720;
    proxy_read_timeout         720;
    proxy_buffer_size          128k;
    proxy_buffers              4 256k;
    proxy_busy_buffers_size    256k;
    proxy_temp_file_write_size 256k;
  }

  location ~* ^.+\.(css|js|jpg|jpeg|gif|png|ico|gz|svg|svgz|ttf|otf|woff|woff2|eot|mp4|ogg|ogv|webm|webp|zip|swf|map|mjs)$ {
    add_header Access-Control-Allow-Origin "*";
    add_header alt-svc 'h3=":443"; ma=86400';
    expires max;
    access_log off;
  }

  location ~ /\.(ht|svn|git) {
    deny all;
  }

  if (-f $request_filename) {
    break;
  }
}

server {
  listen 8080;
  listen [::]:8080;
  server_name wengindustries.com www1.wengindustries.com;
  {{root}}

  include /etc/nginx/global_settings;

  try_files $uri $uri/ /index.php?$args;
  index index.php index.html;

  location ~ \.php$ {
    include fastcgi_params;
    fastcgi_intercept_errors on;
    fastcgi_index index.php;
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    try_files $uri =404;
    fastcgi_read_timeout 3600;
    fastcgi_send_timeout 3600;
    fastcgi_param HTTPS "on";
    fastcgi_param SERVER_PORT 443;
    fastcgi_pass 127.0.0.1:{{php_fpm_port}};
    fastcgi_param PHP_VALUE "{{php_settings}}";
  }

  if (-f $request_filename) {
    break;
  }
}
```

UPDATE VHOST: Server block matching 80 and 443 is going to cause problems later when you create a SSL Let's Encrypt because it needs to find a challenge file it generated at a http URL, so we shouldn't redirect to https right away which makes the file undiscoverable because we don't have https setup yet! Notice there's the  `if ($scheme != "https") { rewrite ^ https://$host$request_uri permanent;  }` logic in the server block. Instead of commenting that out when initiating or renewing SSL with Let's Encrypt, we can separate out the server 80 and server 443 blocks. For server block 80, we will open the website instead of redirecting the the connection and also allow through challenge file. For server block 443, we will do the rest that we have going on (therefore no need to comment out the http redirect at certain times). Notice server. block 80 besides the acme challenge file, all else gets directed to port 8080 which is the php processor. If you want to be a purist and have http redirect to https, you can remove the 8080 proxy pass and return the https rewrite, like the original vhost, but that's highly NOT recommended right now because you want to be able to test your website quickly (like visiting http://.../index.php).
Full Vhost:
```
server {
    listen 80;
    listen [::]:80;
    http2 on;
    http3 off;
    server_name wengindustries.com www1.wengindustries.com www.wengindustries.com;
    
    location ^~ /.well-known/acme-challenge/ {
        root /home/wengindustries/htdocs/wengindustries.com/;
        allow all;
        auth_basic off;
    }

    location / {
        proxy_pass http://127.0.0.1:8080;
        proxy_set_header Host $host;
        proxy_set_header X-Forwarded-Host $host;
        proxy_set_header X-Forwarded-Proto $scheme;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_redirect off;
    }
}

server {
  listen 443 quic;
  listen 443 ssl;
  listen [::]:443 quic;
  listen [::]:443 ssl;
  http2 on;
  http3 off;
  {{ssl_certificate_key}}
  {{ssl_certificate}}
  server_name wengindustries.com www1.wengindustries.com www.wengindustries.com;
  {{root}}

  {{nginx_access_log}}
  {{nginx_error_log}}

  if ($scheme != "https") {
    rewrite ^ https://$host$request_uri permanent;
  }

  location ~ /.well-known {
    auth_basic off;
    allow all;
  }

  {{settings}}

  location / {
    {{varnish_proxy_pass}}
    proxy_set_header Host $host;
    proxy_set_header X-Forwarded-Host $host;
    proxy_set_header X-Real-IP $remote_addr;
    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    proxy_hide_header X-Varnish;
    proxy_redirect off;
    proxy_max_temp_file_size 0;
    proxy_connect_timeout      720;
    proxy_send_timeout         720;
    proxy_read_timeout         720;
    proxy_buffer_size          128k;
    proxy_buffers              4 256k;
    proxy_busy_buffers_size    256k;
    proxy_temp_file_write_size 256k;
  }

  location ~* ^.+\.(css|js|jpg|jpeg|gif|png|ico|gz|svg|svgz|ttf|otf|woff|woff2|eot|mp4|ogg|ogv|webm|webp|zip|swf|map|mjs)$ {
    add_header Access-Control-Allow-Origin "*";
    add_header alt-svc 'h3=":443"; ma=86400';
    expires max;
    access_log off;
  }

  location ~ /\.(ht|svn|git) {
    deny all;
  }

  if (-f $request_filename) {
    break;
  }
}

server {
  listen 8080;
  listen [::]:8080;
  server_name wengindustries.com www1.wengindustries.com;
  {{root}}

  include /etc/nginx/global_settings;

  try_files $uri $uri/ /index.php?$args;
  index index.php index.html;

  location ~ \.php$ {
    include fastcgi_params;
    fastcgi_intercept_errors on;
    fastcgi_index index.php;
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    try_files $uri =404;
    fastcgi_read_timeout 3600;
    fastcgi_send_timeout 3600;
    fastcgi_param HTTPS "on";
    fastcgi_param SERVER_PORT 443;
    fastcgi_pass 127.0.0.1:{{php_fpm_port}};
    fastcgi_param PHP_VALUE "{{php_settings}}";
  }

  if (-f $request_filename) {
    break;
  }
}
```

VHOST UPDATE: Actually this is when you have a host purchased through DNS. We should add in the sslip.io:
```
server {
    listen 80;
    listen [::]:80;
    http2 on;
    http3 off;
    server_name wengindustries.com www1.wengindustries.com www.wengindustries.com 5.55.555.555.sslip.io;
    
    location ^~ /.well-known/acme-challenge/ {
        root /home/wengindustries/htdocs/wengindustries.com/;
        allow all;
        auth_basic off;
    }

    location / {
        proxy_pass http://127.0.0.1:8080;
        proxy_set_header Host $host;
        proxy_set_header X-Forwarded-Host $host;
        proxy_set_header X-Forwarded-Proto $scheme;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_redirect off;
    }
}

server {
  listen 443 quic;
  listen 443 ssl;
  listen [::]:443 quic;
  listen [::]:443 ssl;
  http2 on;
  http3 off;
  {{ssl_certificate_key}}
  {{ssl_certificate}}
  server_name wengindustries.com www1.wengindustries.com www.wengindustries.com 5.55.555.555.sslip.io;
  {{root}}

  {{nginx_access_log}}
  {{nginx_error_log}}

  if ($scheme != "https") {
    rewrite ^ https://$host$request_uri permanent;
  }

  location ~ /.well-known {
    auth_basic off;
    allow all;
  }

  {{settings}}

  location / {
    {{varnish_proxy_pass}}
    proxy_set_header Host $host;
    proxy_set_header X-Forwarded-Host $host;
    proxy_set_header X-Real-IP $remote_addr;
    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    proxy_hide_header X-Varnish;
    proxy_redirect off;
    proxy_max_temp_file_size 0;
    proxy_connect_timeout      720;
    proxy_send_timeout         720;
    proxy_read_timeout         720;
    proxy_buffer_size          128k;
    proxy_buffers              4 256k;
    proxy_busy_buffers_size    256k;
    proxy_temp_file_write_size 256k;
  }

  location ~* ^.+\.(css|js|jpg|jpeg|gif|png|ico|gz|svg|svgz|ttf|otf|woff|woff2|eot|mp4|ogg|ogv|webm|webp|zip|swf|map|mjs)$ {
    add_header Access-Control-Allow-Origin "*";
    add_header alt-svc 'h3=":443"; ma=86400';
    expires max;
    access_log off;
  }

  location ~ /\.(ht|svn|git) {
    deny all;
  }

  if (-f $request_filename) {
    break;
  }
}

server {
  listen 8080;
  listen [::]:8080;
  server_name wengindustries.com www1.wengindustries.com;
  {{root}}

  include /etc/nginx/global_settings;

  try_files $uri $uri/ /index.php?$args;
  index index.php index.html;

  location ~ \.php$ {
    include fastcgi_params;
    fastcgi_intercept_errors on;
    fastcgi_index index.php;
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    try_files $uri =404;
    fastcgi_read_timeout 3600;
    fastcgi_send_timeout 3600;
    fastcgi_param HTTPS "on";
    fastcgi_param SERVER_PORT 443;
    fastcgi_pass 127.0.0.1:{{php_fpm_port}};
    fastcgi_param PHP_VALUE "{{php_settings}}";
  }

  if (-f $request_filename) {
    break;
  }
}
```

Remember to save, then at SSH reload the nginx with:
```
sudo systemctl reload nginx
```


Now visit either:
https://5.55.555.555.sslip.io
or https://5.55.555.555

Again if it warns connection not private, go to Private -> Proceed or free type "thisisunsafe"

You should see whatever default index.php file is created (as of April 2026, it's an index.php file showing "Hello world")

---

## DNS purchase then Cloudflare

We will NOT skip this namecheap step anymore because:
![[Pasted image 20260411024546.png]]
A record to sslip.io would be pointless since it will not allow you that flexibility. It will always point to the prefix IP address. **You can skip this entire section DNS purchase then Cloudflare** if you dont plan to go public yet. But dont list your sslip.io URL to the internet. The idea is that Cloudflare will secure your domain address so you will never be able to be attacked directly by your webhost IP (even to the point it overwhelms your CPU and shuts down the server by the massive flood of bots even if you have a firewall on at the server level which is like ufw, well unless your firewall is at the web host level which is the control panel that displays immediately after logging in to your web hots account)

Go to namecheap and buy your domain. Then DO NOT adjust any DNS records. Let's delegate namecheap to cloudflare where you get the benefits of bot protection (recognized abusive IPs and human verify), edge caching, etc

Warning:
Do not ever go public without cloudflare because once your IP is online, hackers can forever attack you directly (unless you rotate out your IP which Hetzner fortunately allows with you purchasing additional addon of floating IP for a few bucks a month)

The rest below are cloudflare steps. They are not as detailed as my other cloudflare tutorials. It assumes you are somewhat familiar with cloudflare.

Create your cloudflare account

Over at left sidebar Domains -> Overview, add your domain by clicking "Onboard domain"
- You may be given two nameserver addresses. **Since you're following this section to this point on, then you have purchased with namecheap or another DNS registrar**, so go ahead and pop them over at namecheap, etc so that Cloudflare can take care of the DNS configuration instead of namecheap.

Under your domain's DNS records, you should have:
- Create **A record** with name of hostname (domain.tld) pointing to the web host's IP. Make it **Proxied** only so that we can leverage Cloudflare preventing traffic from even hitting your webhost and causing DDoS if there's a bot attack
- You may want the A record to the eventual or current hostname/domain you ~~will~~ have ~~and another A record to the sslip.io domain that you will have temporarily for testing purposes~~.
![[Pasted image 20260411025347.png]]

Complains of SSL? That's fine
![[Pasted image 20260411024600.png]]

We'll eventually fix that later.

A more full setup of A-records would be:
![[Pasted image 20260411034518.png]]

Now go on whatsmydns.net to check if your ip address has propagated. If it's taking a while to reach your location, and it has already reached other locations, you can use a VPN service to browse as that location, then your domain should be able to display the file

You should see whatever default index.php file is created (as of April 2026, it's an index.php file showing "Hello world")

---

### VPS: How to setup web server for basic website editing and viewing (Multiple sites)
- Basic: We just want to see we can impact how a website looks . We don’t care about SSL Https at this point
- Where in the web hosting panel (cpanel, cloudpanel, etc) does it show you the public IP address you can visit directly in the web browser  
- Where does it give you the default domain (aka temporarily domain)  (eg. srv451789.hstgr.cloud). We want to test we can visit the webpage after uploading files with FTP / vi file from shell / edit file from Web Hosting Control Panel. We do not care to visit the desired domain name yet because DNS propagation takes a while.
- You can edit the index file in the Web Hosting Control Panel's File Manager or in the terminal.
	- If in the terminal using vi: For each site on your Web Hosting Control Panel, what’s the folder path to create/edit index.html to so web browser can see a webpage? Aka root web directory for your website, Aka working directory for your code and webpages. This is usually the first website you create in your web host panel or the website they already created for you, and their settings show you the associated folder path.  
- Prepare to visit that website in the web browser to see your changes went through:
	- Edit your virtual host (vhost) configuration so that incoming requests to your server match the requested hostname or domain because once matched, the vhost can route and respond to the request correctly.:
		```
		server_name srv451789.hstgr.cloud;
		```
		- And restart nginx from SSH terminal with `sudo systemctl restart nginx`
		- Visit http://srv451789.hstgr.cloud
		- If success, Chrome will warn you there's no secured connection or that the connection is not private and blocks you from viewing the content. We will add SSL https certificates later. The current bypass technique in 2024 is to click anywhere on the webpage then type: `thisisunsafe`. You should see the webpage content.
	- Use vi command to create an index2.html, add some words, then visit directly http://domain.com/index2.html to see if it displays.
		- If failed, because it says Access Denied on the web browser, fix the permissions, making the bad index2.php permissions match the good index.php permissions. Likely it's just the user and group that are problematic.
		- Keep in mind that when you upload files via SFTP later, this will be the user you sign into Filezilla, etc's SFTP. This makes sure uploads are the correct permissions. 
		- If passed, this then assumes future websites on CloudPanel will have no problem with editing and viewing by the internet. 
	- This then assumes future websites on CloudPanel will have no problem with editing and viewing by the internet.
	- Optional: If you want to continue testing other sites on CloudPanel, you could use other domains at namecheap etc creating A record to the same public IP. Or if you run out of domains, you can create subdomains under one domain, creating CName to the public domain name. For more information on A records and Cnames, refer to [[DNS Domain PRIMER]]. Make sure a site's vhost at your web host catches what servername (subdomain and/or domain and tld) is hoisted by the internet connecting to your public IP.

---
### How to setup SFTP/FTP users
- Makes life easier for web developers.
- Skip FTP: It's strongly recommended you use SFTP instead. You can setup FTP capability then leave the port off or on as a backup. Refer to: [[Setup FTP and SFTP]]
- SFTP: 
	- If not CloudPanel: [[Setup FTP and SFTP]]
	- If CloudPanel: [[CloudPanel - Setup SFTP users]]
- If you have html/php websites developed, go ahead and upload them on your FTP Client (eg. Filezilla)

---

### Prepare web server for basic public view - SSL, File Permissions, Security
- Do you have to setup SSL?
	- Free vs Paid SSL
		- You can get a free SSL with Let's Encrypt. Look up instructions how to run Let's Encrypt in your SSH.
		- You can also buy SSL which gives you certain advantages over SSL, and some businesses must have a paid SSL as regulation.
	- Figure out workflow to acquire and install SSL because you'll be doing this annually. Also perform it now
		- If CloudPanel, it's very simple going to the site -> SSL/TLS -> Actions -> New Let's Encrypt Certificate (however you must have a domain connected to that website already because it'll create a file then access that file through your domain URL to prove your ownership then generates the certificate).
			- Errors about accessing ACME challenge file? Try adding a server block for http and the specific path to the ACME challenge file, to the very top of the vhost:
				```
				server {
				    listen 80;
				    listen [::]:80;
				    http2 on;
				    http3 off;
				    server_name wengindustries.com www1.wengindustries.com www.wengindustries.com;
				    
				    location ^~ /.well-known/acme-challenge/ {
				        root /home/wengindustries/htdocs/wengindustries.com/;
				        allow all;
				        auth_basic off;
				    }
				
				    location / {
				        proxy_pass http://127.0.0.1:8080;
				        proxy_set_header Host $host;
				        proxy_set_header X-Forwarded-Host $host;
				        proxy_set_header X-Forwarded-Proto $scheme;
				        proxy_set_header X-Real-IP $remote_addr;
				        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
				        proxy_redirect off;
				    }
				}
				```
		- If less obvious how and where to install SSL HTTPS certificates: Contact customer support or google Web host + OS + Nginx/Apache + Install SSL certificates. If the web host is not well known (very independent), google for: OS + Nginx/Apache+ Install SSL certificate
	- CloudPanel's Let's Encrypt SSL failing? Refer to section "Test Web Hosting Control Panel" -> ~ SSL
	- Know the filepaths to the SSL for future issues and code that needs SSL cert and key paths such as gunicorn (even if Cloudpanel abstracts it away)
		- If Hostinger CloudPanel, the Vhost page likely hides ssl cert and key file paths in the server block as variables. You have to find the site's nginx confi file where the final vhost is written (eg. /etc/nginx/sites-enabled/some-website.com.conf)
			- Hostinger Ubunto 22.04 with Cloud Panel paths could be:
				- **ssl_certificate** /etc/nginx/**ssl**-certificates/DOMAIN.com.crt;
				- **ssl_certificate_key** /etc/nginx/**ssl**-certificates/DOMAIN.com.key;
- File permissions: if you will have php or python scripts that are triggered by visiting web browser, if it writes to a folder, can it write?
	- How to make sure the user that created the folders upon creating your website aka the same that would be the owner of files you create at the web hosting panel’s File Manager...
	    
	    ...how to make sure it’s the same user for Filezilla (make sure site user login into Filezilla or FTP client). If not, you could upload php scripts via filezilla that creates files (like text file of user activities) but your filezilla user didn’t own the folder so it’ll be permission error preventing creating files by php script
	    
	    When visit a php page in the web browser, can it append or write to a file using fwrite? Eg. tracking user behaviors at a user-log.txt. If it's unable, see user and group ownership of the folder it writes to and the php page that does the writing. You can see with `ls -la` and you see they do not match so no wonder the file does not have permission to write to the folder.
- Install malware and security especially when going public
	- If Hostinger, their malware scanner [https://support.hostinger.com/en/articles/8450363-vps-malware-scanner](https://support.hostinger.com/en/articles/8450363-vps-malware-scanner)
    - How to navigate to the malware from services dashboard (Hostinger hpanel, GoDaddy dashboard, etc)
    - Is malware free, times one payment, or monthly/yearly? Or keep deactivated (often they let you scan but not fix for free)
    - Is there a firewall from the Web Hosting Control Panel? or do you have to run ufw?
- Domain name
	- Refer to tutorial on domain and dns editing. There are many ways to do it. One way is to have namecheap domain with two A records to the public IP of your webhost at "@" and "\*" (unless you want different public ip between www and other subdomains)


---
### ADVANCED WEBSITE: Prepare server for installing different architectures (PHP, NodeJS, Python, MySQL, Mongo, Scaling Solutions)

#### Skill up
- Know how to reboot the server
- how see error logs based on your OS and web server type  
    eg `tail -f /var/log/nginx/error.log`
- Know how to check status of, start, stop, and restart any service

**Ubuntu 22.04.. we are just using nginx as example:**
```
sudo systemctl status nginx
```

```
sudo systemctl start nginx
```

- Know what is the main installer of packages in command line (eg. `sudo apt update`  for Ubuntu 22.04). Save to your web host's details document if it's not something you're intimately familiar with.
- Update installer’s repos 
- Look up instructions for your OS on how to install these language interpreters and related or adjacent package managers, if applicable to your server's use cases (these should be installed before installing databases because you'll be testing database connections with code):
#### PHP
- PHP (if not included by your web host’s)
	- If installed CloudPanel, PHP comes included. If you don't see PHP, you should create a PHP site off CloudPanel 
	- If not installed CloudPanel and your web host management panel does not come included with PHP, look up how to install php, eg. Google: Ubuntu 22 install php
	- If installed Cloudpanel or a Web Hosting Control Panel that already has it setup for you, you can also skip this step:
		  - You have to configure apache or nginx to handle php, eg. Google: `Nginx handle php`, eg. Google: `Apache handle php`.
#### Python
- Check if you have python3 installed. It comes included with CloudPanel. Test with `python3 --version`
	- If not installed. Look up how to install: Eg. Google: Ubuntu 22 install python3
- Check if you have pip3 installed. Having python3 installed does not necessarily mean pip3 is installed. Eg. Google: Ubunutu 22 install pip3. Could be something like `sudo apt install python3-pip`. If you have CloudPanel installed, Cloudpanel installed python3, but not pip3, as of Aug 2024.
- OPTIONAL: For legacy code you might need to work on in the future, you should install python2 and pip2 and bench them for when they're needed
	- Could be for python2: `sudo apt install python2`
	- Could be for pip2 (notice it's python-pip, not python2-pip): `sudo apt install python-pip`
	- You can test they're installed successfully with `python3 --version` and `pip3 --version`
- Check if `python` and `pip` commands work (not limited to running `python3` and `pip`). Run `python --version` and `pip --version` to check if they've been assigned. I recommend assigning them to the newest version of python.
	- Method 1:
	  Edit ~/.bash_profile or equivalent. You can run `which python3` and `which pip3` to get their paths. Then you add to the bash profile similar to `alias python='/usr/bin/python3'` and `alias pip='/usr/bin/pip3'`. Then you source: `source ~/.bash_profile`.
	- Method 2:
	  You can run `which python3` and `which pip3` to get their paths. Then get one of the paths found in `echo $PATH`. Create symbolic links from `python` to `python3` and `pip` to `pip3` in one of the earlier $PATH paths.

#### NodeJS and NVM
- Check if you have node installed. Run `node --version`. If you have CloudPanel installed, NodeJS may not be installed globally.
- If installing node, look up how to install node. Eg. Google: Ubuntu 22 install nodejs. Could look similar to: `apt install nodejs`. After installation, run `node --version` to check it succeeded.
- Sometimes npm comes with nodejs. Check if it did install: `npm --version`. If not, see if npm installation instructions are at the same guide for installing nodejs. Otherwise, look up how to install npm. eg. Google: Ubuntu 22 install npm. 
	- Could look similar to: `apt install nodejs`. 
	- Check npm and its utility `npm --version` and `npx --version` (npx helps forcefully run)
- Prevent npm scripts having "no file permission" error:
	- Check npm version with `npm --version`
	- If the version is v7 or v8 families, then NodeJS switches user to the user owning the folder to the package.json when running npm script which is not desirable in most cases (you would prefer to keep the same user that runs the npm script `npm run scriptX`) and usually causes file permission problems when running a npm script
		- Then you install nvm to install and change the node version. Then you make it permanent beyond your current shell session. Refer to the tutorial [[NVM - npm scripts say permission denied on the cli command]]
- Install NVM
	- Why: If you're developing apps, you sometimes want a specific version of NodeJS at a folder especially if package conflicts or legacy packages. NVM makes this possible.
	- NVM installation instructions at: https://github.com/nvm-sh/nvm?tab=readme-ov-file#installing-and-updating
		- You may want to test nvm is installed by listing: `ls ~/.nvm`
		- And you want to test their cli/alias is installed by running in the command line: `nvm`
		- If the cli/alias refuses to install, then you have to copy the init script that the Readme mentions the cURL/wget install command should've added. To figure out if you're editing .bash_profile/.bashrc/.zprofile/.zshrc, run `echo $SHELL`.
		
#### Yarn
- Make sure Node is at least v20.11.0 to install a newer yarn (https://www.redswitches.com/blog/install-yarn-in-ubuntu/), otherwise look up classic yarn installation instructions.
	- Install npm's repo corepack (tool to help with managing versions of your package managers) which allows you to install yarn
	- Follow each step to install latest yarn:
		```
		sudo npm install -g corepack
		corepack enable
		corepack prepare yarn@stable --activate
		yarn set version stable
		yarn --version
		```

- Look up instructions for your OS on how to install these databases, if applicable to your server's use cases
#### MySQL
- MySQL (if not included by your web host’s VPS)
	- If not installed CloudPanel or a web host management panel that includes these parts, look up instructions on how to install MySQL, PHP, and PHPMyAdmin. eg. Google: Ubuntu 22 install mysql phpmyadmin
	- Ubuntu v22 with CloudPanel comes with MySQL, PHP, and phpMyAdmin, however when accessing phpMyAdmin from Cloudpanel then only the databases the user is associated with shows up.
		- To get the master credentials to see all databases, you run `clpctl db:show:master-credentials` and visit this url to login with those credentials https://XX.XXX.XX.XXX:8443/pma
		- Test the same master credentials on the Mysql command:
		  `mysql -h 127.0.0.1 -u USER -P 3306 -p'PASSWORD' -A`
		- Save credentials, PMA link, and MySQL command to your webhost document and possibly save to an alias that echoes credentials and then logs in via ssh/sshpass.
	- Test MySQL phpMyAdmin (if not done from previous CloudPanel step)
		- What's the URL to phpMyAdmin? If needed, can we make it show all the databases instead of only some databases (databases associated to one user) at phpMyAdmin?
		- Save phpMyAdmin URL and credentials to web host details document
	- Test MySQL daemon
		- Run `mysql --version`
		
	- OPTIONAL: Test PHP wrapping MySQL works. You can write this php file then either run in web browser or terminal (`php script.php`):

		```
		<?php
		$server = "127.0.0.1";
		$username = "YOUR_USERNAME";
		$password = "YOUR_PASSWORD";
		$port = 3306;
		$conn = new mysqli($server, $username, $password, "", $port);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} else {
				echo "Success: PHP connected to MySQL. Here are databases: <br/><br/>

		";
		}
		$result = $conn->query("SHOW DATABASES");
		while ($row = $result->fetch_assoc()) {
				echo $row['Database'] . "<br>
		";
		}
		$conn->close();
		?>
		```

	If PHP connecting to MySQL works (most commonly used case), then it's assumed Python and NodeJS will connect with no problems. 
	
	But if you want to test NodeJS connecting to MySQL:
	```
	const mysql = require("mysql2");
	
	/**
	 * Requirements:
	 * PHP database: someDb
	 * PHP table: someTable
	 * PHP columns: id, someColumn
	 * PHP port set to 8888
	 * Insert some rows
	 * Have MAMP started database server
	 * 
	 */
	
	const connection = mysql.createConnection({
	  host: "127.0.0.1",
	  user: "YOUR_USERNAME",
	  password: "YOUR_PASSWORD",
	  database: "someDb",
	  port: 3306
	});
	
	function showAllRows() {
		connection.query(
		  "SELECT * FROM mysql"
		, function(err, results, fields) {
		  console.log(results);    
		});
	  }
	
	connection.connect(function (err) {
		if (err) {
			console.error(err);
		} else {
			showAllRows();
		}
	  
	});
	```

- And if you want to test Python connecting to MySQL:
```
# pip install mysql-connector-python 
import mysql.connector
from mysql.connector import Error

# Database connection details
connection_config = {
	'host': '127.0.0.1',
	'user': 'root',
	'password': 'root',
	'database': 'mysql',
	'port': 3306
}

def show_all_rows():
	connection = None
	try:
		connection = mysql.connector.connect(**connection_config)
		if connection.is_connected():
			cursor = connection.cursor()

			# Check if the table exists
			cursor.execute("SHOW TABLES LIKE 'user'")
			result = cursor.fetchone()
			if result:
				cursor.execute("SELECT * FROM user")
				results = cursor.fetchall()
				for row in results:
					print(row)
			else:
				print("Table does not exist.")
	except Error as e:
		print(f"Error: {e}")
	finally:
		if connection is not None and connection.is_connected():
			cursor.close()
			connection.close()

if __name__ == '__main__':
	show_all_rows()
```


- And if you want to test Python's Flask connecting to MySQL:
```
# pip install flask
# pip install flask-mysqldb

from flask import Flask
from flask_mysqldb import MySQL

app = Flask(__name__)

# Required
app.config["MYSQL_USER"] = "root"
app.config["MYSQL_PASSWORD"] = "root"
app.config["MYSQL_DB"] = "someDb"

# Required for testing: 
# MySQL: root/root
# Database: someDb
# Table: someTable
#         id PK Auto-Increments
#         someColumn varchar(255)
# Seeded
""" 
INSERT INTO `someTable` (`id`, `someColumn`) VALUES (NULL, 'Abby');
INSERT INTO `someTable` (`id`, `someColumn`) VALUES (NULL, 'Bobby');
INSERT INTO `someTable` (`id`, `someColumn`) VALUES (NULL, 'Caitlin'); 
"""

# Extra configs, optional:
app.config["MYSQL_CURSORCLASS"] = "DictCursor"
app.config["MYSQL_CUSTOM_OPTIONS"] = {"ssl": {"ca": "/path/to/ca-file"}}  # https://mysqlclient.readthedocs.io/user_guide.html#functions-and-attributes

# Init
mysql = MySQL(app)

# http://127.0.0.1:5000/
@app.route("/")
def users():
	cur = mysql.connection.cursor()
	cur.execute("""SELECT * from someTable""")
	rv = cur.fetchall()
	return str(rv)

if __name__ == "__main__":
	app.run(debug=True)
```


#### Mongo
- Installation
	- See if you have mongo already installed `mongo --version` or `mongosh --version`, as long as one of them works. Cloudpanel does NOT come with Mongo.
	- Look up instructions how to install MongoDB: 
	  eg. Google: Ubuntu 22 install mongo. 
		 - There are a lot of steps—follow the full MongoDB installations (not going to repeat it in this tutorial)
			 - Ubuntu 22/24: https://www.mongodb.com/docs/manual/tutorial/install-mongodb-on-ubuntu/
			 - Debian 12: https://www.mongodb.com/docs/manual/tutorial/install-mongodb-on-debian/
			   
			- Verification instructions on making sure MongoDB is installed, is on the instructions page as well.
			- Caveat - Make sure it's Enabled for rebooting. This status of `sudo systemctl status mongodb` has not been enabled for reboot because notice the word "disabled" at the Loaded line:
				```
				# sudo systemctl status mongod
				> ● mongod.service - MongoDB Database Server
				Loaded: loaded (/usr/lib/systemd/system/mongod.service; disabled; preset:
				Active: active (running) since Mon 2025-07-07 00:01:49 UTC; 3s ago
				```
				- Enable for reboot startup with: `sudo systemctl enable mongod`
			    
			 - If status of mongod service is failure, check `tail /var/log/mongodb/mongod.log`.
				  - If the `mongod.log` has the line "Permission denied" (You can specifically check with 
				 `tail /var/log/mongodb/mongod.log | grep Permission`):
					  - And if the "Permission denied" error is because "Failed to unlink socket file"
						  - 1. Check and remove the socket file: `sudo rm /tmp/mongodb-27017.sock`
						  - 2. Ensure that the /tmp directory has the correct permissions: `sudo chmod 1777 /tmp`
						  - 3. Check the ownership of MongoDB directories: `sudo chown -R mongodb:mongodb /var/lib/mongodb /var/log/mongodb`
						  - 4. Restart MongoDB: `sudo systemctl restart mongod`
						  - 5. Verify no more mongo service problem: `sudo systemctl status mongod`
	- What's the mongo shell command? May want to add to your web host details document. 
		- MongoDB 3.4 unofficial and below, run`mongo` for mongoshell
		- Above Mongo 3.4 unofficial, run `mongosh` for mongoshell
		- If Mongo community version (maintained by the official Mongo organization), run `mongosh` while `mongod` service has started
	- Mongo service
		- Check if mongo service is running? What's the command to check status?
		- Make sure to reboot to check that the mongo service sticks (running mongo shell works). After reboot, check the service status.
		- Also figure out the commands for: How to stop mongo service? How to restart mongo service? 
		- How to check the logs for service starting errors (Eg. Ubuntu 22 is `sudo tail -n 100 /var/log/mongodb/mongod.log`)
		- Optional: Save these commands to your web host details document.

	- Create an authentication account on the auth collection
	  Go into Mongo Shell (`mongo` or `mongosh`), switch into admin collection (run `use admin`), then run this to create user
	  WARNING: DO NOT create a username named "root". Some Mongo versions already created a root user to work with test as the authentication database, and it causes conflicts like the mongo invoke command saying incorrect credentials but the interactive authentication passing
	  
	  Create user while inside admin collection:
		```
		db.createUser({ user: 'USERNAME', pwd: 'PASSWORD', roles: [{role: "root", db: "admin"}] })
		```

	^Make sure you've switched into admin collection (`use admin`), otherwise the db.createUser will silently work, but later the mongo invoke command will say incorrect credentials. The reason is because if you haven't switched into another collection, the authentication collection on the outside is "test", despite you specifying admin in the createUser method. The "admin" db setting passed to createUser would be ignored because you haven't proven access yet by successfully changing into admin collection.

	- Verify login in the SSH session. Test you can invoke mongo with credentials (mongo or mongosh depending on version):
	```
	mongosh -u 'USERNAME' -p 'PASSWORD' --authenticationDatabase 'admin'
	```

- Verify login the other way too with..  a URL because that will be roughly the URL you will use in your backend for NodeJS, etc to authenticate (your code would have the domain address instead of the numeric localhost IP)... if using characters like #, they must be in their url encoded form like `%23` for `#`:
```
mongosh 'mongodb://USERNAME:PASSWORD@127.0.0.1:27017/?authSource=admin'
```

^ If fails, check port and bindIp in `/etc/mongod.conf` have 127.0.0.1 and 27017. If you have special characters like "!", you have to encode into URI (! is %21).
^ We are using single quotes to reduce the chances of the shell interpreting and rewriting characters when inside double quotes.

- **Authentication is disabled by default** when you install MongoDB. This is one of the most common and dangerous misconfigurations. Hackers often scan new servers for mongo and try to ransom the data. Without authentication, hackers can log into your Mongo database without needing credentials then have full permission to read/write/delete databases.
	- Enable authorization for the mongo daemon (so that you can't just run `mongosh` or `mongo` then be able to show any databases):
	```
	sudo vi /etc/mongod.conf
	```

	- Add or strip comment (be careful with spacing otherwise starting service will say illegal map value for a YAML config file):
	```
	security: 
	  authorization: enabled
	```

	- Restart mongo service so the settings apply:
	```
	sudo systemctl restart mongod
	```

- Test you can be denied access without the correct authentication:
	- 1. Run `mongo` or `mongosh` depending on the version of mongo
	- 2. You'll notice you successfully got into the Mongo shell; However, run `show databases;` while in the unauthenticated Mongo Shell, it will error: `**MongoServerError[Unauthorized]** ...` .

- Save authenticated login shell command and URL into your web host details documents
	  
- Decide whether to open the Mongo to remote IPs or keep local. If you open to remote IPs, then you can connect from your Mongo Compass. The inner steps here are to enable for remote IPs / Mongo Compass

	 1. Enabling external connections (and Mongo Compass) at the service level
		By default `etc/mongod.conf` settings allow files on the same host as the mongo server to connect (127.0.0.1, aka localhost). Let's open Mongo to the internet/world.
		Edit your `/etc/mongod.conf`:
		
		```
		   net:
			 bindIp: 0.0.0.0
		```

	2. Restart mongo service so the settings apply:
	```
	sudo systemctl restart mongod
	```

	3. Enabling external connections (and Mongo Compass) at the OS level
	   If you have firewall (either uwf or iptables), you have to allow in internet 0.0.0.0 into port 27017:
		- Check if ufw firewall is enabled with `sudo ufw status`. If it's enabled, you should open the Mongo port by running `sudo ufw allow 27017`. Check port allowed rules by running same `sudo ufw status`. Apply the rules immediately with `sudo ufw reload`.
		- Check if iptables is managing firewall by running `sudo iptables -L -v -n` to see if there are any port rules which implies that iptables is enabled. Note that there doesn't need to be a iptables service for this firewall to work because iptables works at the kernel level. 
			- If it's enabled, you should open the Mongo port by running `sudo iptables -A INPUT -p tcp --dport 27017 -j ACCEPT`. No need to reboot; Rules are hot applied right way. Check ports allowed by running `sudo iptables -L -n`.
		  
- Test MongoDB Compass works with the URL.

- Test MongoDB with authentication account works on Python or NodeJS:
	
	Test Python:
	Create a test.py then run `python test.py` after you've installed `pip install pymongo`:
	```
	from pymongo import MongoClient
	
	# Replace these with your actual MongoDB username and password
	mongo_user = "USERNAME"
	mongo_password = "PASSWORD"
	
	uri = f"mongodb://{mongo_user}:{mongo_password}@localhost:27017/?authSource=admin"
	client = MongoClient(uri)
	
	try:
		# Check the connection by listing the databases
		databases = client.list_database_names()
		print("Connected successfully. Databases:", databases)
	
	except Exception as e:
		print("Failed to connect to MongoDB:", e)
	
	```


	Optionally, test NodeJS:
	Create a test.py then run `python test.py` after you've installed `pip install pymongo`:
	```
	const { MongoClient } = require('mongodb');  
	  
	// Replace these with your actual MongoDB username and password  
	const mongoUser = 'USERNAME';  
	const mongoPassword = 'PASSWORD';  
	const dbName = 'admin'; // Use your database name  
	  
	const uri = `mongodb://${mongoUser}:${mongoPassword}@localhost:27017/?authSource=${dbName}`;  
	const client = new MongoClient(uri, { useNewUrlParser: true, useUnifiedTopology: true });  
	  
	async function run() {  
		try {  
			// Connect to the MongoDB cluster  
			await client.connect();  
	  
			// List databases  
			const databasesList = await client.db().admin().listDatabases();  
	  
			console.log("Connected successfully. Databases:");  
			databasesList.databases.forEach(db => console.log(` - ${db.name}`));  
		} catch (e) {  
			console.error("Failed to connect to MongoDB:", e);  
		} finally {  
			// Close the connection  
			await client.close();  
		}  
	}  
	  
	run().catch(console.dir);
	```

	- It's assumed PHP will be able to connect to Mongo if Python and NodeJS works


Let's install these CI/CD solutions:
#### Git
- Make sure there is git on your system
	- Some systems come with git. Check out by running `git --version`
	- If git is not included, lookup instructions how to install git on the system
		- eg. Google: Ubuntu 22 install git
	- Setup identification for git commands (a bit involved):
	```
	git config --global user.name "Your Name"
	git config --global user.email "youremail@domain.com"
	```

	- Setup authorization for git commands
	  
	  1. Check if `ls ~/.ssh` has .pub files and similarly named files without file extensions (Those are the public and private keys, respectively). If not, generate a public/private key referring to:
	  https://docs.github.com/en/authentication/connecting-to-github-with-ssh/generating-a-new-ssh-key-and-adding-it-to-the-ssh-agent

		```
		ssh-keygen -t ed25519 -C "your_email@example.com"
		```

	  2. Add public key to your Github account, referring to: https://docs.github.com/en/authentication/connecting-to-github-with-ssh/adding-a-new-ssh-key-to-your-github-account
		  1. Click New SSH key at https://github.com/settings/keys
		  2. Paste the contents of the public key (eg. id_ed25519.pub) and save as a SSH key, recommended naming the key after your server provider name for organizing purposes.
		  
	- Is git using your preferred terminal text editor
		- To test: Run this at a git repo - `git rebase -i HEAD~2` and see what terminal text editor opens
		- If you need to set a preferred terminal text editor: [[Git set which terminal text editor to use]]
#### Docker
- Make sure docker is on your system
	- Test for docker: `docker --version`
	- Lookup instructions how to install docker on the system
		- eg. Google: Ubuntu 22 install docker
		  https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-on-ubuntu-22-04
		  eg. Google: Debian 12 install docker
		  https://docs.docker.com/engine/install/debian/#install-using-the-repository

#### Scaling Solutions
- Look up instructions for your OS on how to install these scaling solutions, if applicable to your server's use cases
	- Balancers and multi workers:
		- pm2 for nodejs
			- Refer to the tutorial [[Installing PM2 and Configuring Nginx for Multiple Node.js Applications]] even if you're not on nginx (the first sections will be applicable before the section on applying it to nginx)
		- Supervisor, virtual envs, gunicorn and flask for python
			- Refer to the tutorial [[Supervisor Primer - QUICK REFERENCE]] which includes supervisor, shell file, gunicorn, flask, pyenv, pyenv-virtualenvs, pipenv
		- Docker or supervisor to restart your api app on crashes (either server crash or app crash)
			- Refer to the tutorials [[Docker Primer - General]] and [[Docker Primer - Get Started]]

### ADVANCED WEBSITE: Timeouts

Are users waiting on something generating for a long time? Their fetch will wait for that long then expect a response unless you're doing web sockets, SSE, etc. You need to raise up the allowed wait time before a timeout error. Skip this if not applicable.

Inside a server block:
```
    location /api/ {
        proxy_read_timeout 300s;   # Adjust as needed
        proxy_connect_timeout 300s; # Adjust as needed
        proxy_send_timeout 300s;   # Adjust as needed
    }
```

If you're proxy passing to a backend to hide non-web ports and increase security, it could ultimately be:
```
location /api {
	proxy_pass https://127.0.0.1:5001;
	proxy_read_timeout 300s;   # Adjust as needed
	proxy_connect_timeout 300s; # Adjust as needed
	proxy_send_timeout 300s;   # Adjust as needed
	proxy_set_header Host $host;
	proxy_set_header X-Real-IP $remote_addr;
	proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
	proxy_set_header X-Forwarded-Proto $scheme;
}
```

Keep in mind in the future when making the app, you have to adjust Gunicorn/PHP's timeouts too:

Timeout of Gunicorn (Flask and Python):
```
gunicorn --timeout 300 myapp:app...
```

Timeout of PHP:
```
ini_set('max_execution_time', 300);  // Adjust as needed
ini_set('default_socket_timeout', 300);  // Adjust as needed
```

### ADVANCED WEBSITE: Prepare for web app features
Install ffmpeg, ctypes, imagemagick, and pcregrep for various web apps and their testing of python wrapping ffmpeg and php wrapping imagemagick. Refer to tutorial [[Web app ready - Ffmpeg, cytypes, imagemagick, pcregrep]]


---

### Improve Developer Experience

1. You may want to setup alias to easily SSH in from your computer's terminal (along with an echo of directories you will often cd into). You might want to add echo useful commands too (since the commands might change from local machine to different servers):

```
$ godaddy
Local: /Users/local_username/dev/web/weng/apps/
Remote: /home/XXX/public_html/apps
---------------------------------------------------
Mongo restart: sudo service mongod restart
Mongo shell: mongo -u admin -p password
MySQL phpMyAdmin:
MySQL shell:
---------------------------------------------------
Supervision stop: ...
Supervision start: ...
Supervision config - main: ...
Supervision config - apps: ...
Supervision dashboard: ...
---------------------------------------------------
Pm2 start: ...
Pm2 dashboard: ...
$
```
  

Even better, you can configure your SSH login to automatically change into the directory where you’ll be working—typically the website’s htdocs folder.

^ How? Below is various alias strategies depending your method of login. The command changes depending on your choice. For example, you can have the session automatically cd into a specific folder if using SSH root key-pair login with an alias:
```
alias hotsinger='echo -e "Local: /Users/wengffung/dev/web/weng/apps/\nRemote: /path/to/apps"; ssh -i ~/.ssh/PRIVATE_KEY -p 22 root@XX.XX.XXX.XX -tt "cd /path/to/apps && bash --login"'
```

Choose alias strategy depending on your method of login

- **SSH (interactive password) (NOT RECOMMENDED)**
	```
	alias coloa='ssh root@XXX.XX.XXX.XX'
	```

	- You won't have to copy and paste the public IP or memorize it.
	- But you'll be prompted interactively to enter your password. If you want an even more streamlined developer experience, check out the next alias strategy.

- **SSHPass (workaround to interactive password) (Also NOT RECOMMENDED)**
```
alias coloa='echo -e "Local: /Users/wengffung/dev/web/weng/apps/\nRemote: /home/.."; sshpass -p "YOUR_PASSWORD" ssh root@XXX.XX.XXX.XX'
```
- You don't have to memorize or copy and paste the public IP or the password
- Downside is you need to install sshpass because ssh command forces you to interactively enter a password. Look for installation instructions. eg. Google: Mac brew install sshpass

- **Passwordless Authentication (aliased path to private key) (RECOMMENDED)**
```
alias hostinger='echo -e "Local: /Users/wengffung/dev/web/weng/apps/\nRemote: /home/XX/htdocs/YY.com/"; ssh -i ~/.ssh/PRIVATE_KEY -p 22 root@XX.XX.XXX.XX'
```

- You have paired SSH keys. The ssh command requires you to enter the path to the SSH private key on your local computer. This is enough to authenticate you since you've placed the public key into the server. Thereby, no more need to enter password, making automated scripts on your computer possible. As an example of automation, you can add an alias so you don't have to memorize or copy and paste this long SSH command - you can just type the alias in the terminal and it'll repeat the SSH key login command for you.
  
- Recommended Addon: Disable SSH Password Login
  
  As it is right now, even though you can perform passwordless authentication login with SSH keys, password login still works. Tighten security even more by blocking all password login. As part of the security feature, it would mislead hackers by still allowing their shell interactively to ask for the password, meanwhile all password attempts including the correct password says incorrect password. This misleads brute-force attackers, making it appear like their credentials are just wrong, not that password login is entirely disabled.
	
- Recommended Addon: Disable Root Login
  
  Disable root login. This means your SSH key login needs to change. The normal authentication flow is to login into SSH with a non-root user like `adminuser`. Then while inside the remote SSH shell, you run `su` and enter the root password to login into root.
	
	However this may get annoying. 
	
	You can setup alias on the local machine to also echo the su command to copy and paste and also the password for the higher privilege while inside the shell session (assuming no one will have their eyes on your screen). Then at your remote server, you could run the `su` and copy and paste the root password from the same terminal. 
	
	Another way is to install the package `expect` at the remote server that lets you write a shell script to automatically enter the password when the expected prompt is "Password:"
#### Caveat about SSH Login

You may get a fingerprint mismatch error some time in the future. When you reinstall the server or it gets reinstalled for server updates, this could cause SSH to deny the connection due to a mismatch with the fingerprint stored in the fingerprint file `~/.ssh/known_hosts` file. You would remove the old SSH fingerprint from that file (has the webhost domain name or webhost public IP), then re-attempt to connect with SSH, then you'll be asked if you want to accept the new fingerprint.

If using sshpass, it won't ask you interactively to accept new fingerprint, and therefore you can't connect to the reinstalled server even with old outdated fingerprints removed. Either run normal ssh command when the server is reinstalled, or come up with an alias for normal ssh for your webhost (eg. if your webhost company is called coloa).

```
alias coloa-ssh='ssh root@XXX.XX.XXX.XX'
```

2. You may want to add better searching capabilities from the SSH terminal because you don't have a friendly UI to browse files. Add to ~/.bash_profile or equivalent:

```
# - fd: Find files with string in their filenames. Eg: fd *Untitled*.jpg  
function fd() {   
clear;   
echo '* Running: find . ! -path "*/.git/*" ! -path "*/node_modules/*" -a \( -type f -iname "*${1}*" -o -type d -iname "*${1}*" \);  
eg. fd Untitled  
';  
find . ! -path "*/.git/*" ! -path "*/node_modules/*" -a \( -type f -iname "*${1}*" -o -type d -iname "*${1}*" \);  
} # fd -  
  
# - gr: Find files with string in their file contents. Eg: gr "= new"  
function gr() {   
    clear;   
    VAR1="";   
    [ $# -lt 1 ] && echo "Error. Must provide string you are searching files" && return;  
  
    # for i ({1..$#});do VAR1+=" --exclude-dir \"${!i:1}\""; done  
  
    # [ ${!i:0:1} != / ] && VAR1+=" --exclude \"${!i}\"";   
      
    # done;   
  
    # cho $#;  
      
    VAR0="grep -nriI ./ --exclude={.git,\*.sql,package-lock.json,webpack.config.js,composer.lock,\*.chunk.css,\*.chunk.js,\*.css.map,\*.js.map} --exclude-dir={.git,.git/index,bower_components,node_modules,.sass-cache,vendor\*,\*backup\*,\*cached\*}${VAR1} -e \"${1}\"";   
      
    echo "* Running: $VAR0  
Eg. gr "= new"  
  
* Tip: If you are searching a phrase or sentence, place the expression in quotation marks:  
gr \"fox jumps over fence\"  
* Tip: If excluding directories, prepend with forward slash /. If excluding files, do not prepend. These are additional arguments after the expression argument. There is no restriction on the number of arguments.  
gr \"fox jumps over fence\" /cached .gitignore README.md  
Btw, the cached folder and .gitignore file is automatically ignored because I know how common those are in projects.  
* Tip: Go to top of results on Macs with CMC+Up, or Ctrl+Home on Windows.  
* Tip: Open the file and line in Visual Code:  
code -g filepath:line  
";  
eval $VAR0;   
  # Old bash version kept below. Now zshell complains of syntax error at )  
  # function gr() { clear; VAR1=""; [ $# -gt 1 ] && for((i=2;i<=$#;i++)) do [ ${!i:0:1} == / ] && VAR1+=" --exclude-dir \"${!i:1}\""; [ ${!i:0:1} != / ] && VAR1+=" --exclude \"${!i}\""; done; VAR0="grep -nriI ./ --exclude={.git,*.sql,package-lock.json,*.chunk.css,*.chunk.js,*.css.map,*.js.map} --exclude-dir={.git,.git/index,bower_components,node_modules,.sass-cache,vendor*,*backup*,*cached*}${VAR1} -e \"${1}\""; echo "* Running: $VAR0  
} # gr -
```


3. Also improves developer experience: Create folders that have symbolic links to your pm2 apps, your gunicorn apps, etc possibly named by their port numbers. Create a symbolic link to your supervisor app configs

	- app
		- or whatever folder name. this contains your websites and/or web apps
	- app-mysql
	- app-mongo
	- app-node-pm2
	- app-python-ssgp
		- These are your python application folders symbolically linked
		- Text explains ssgp: supervisor against sh, sh loads gunicorn in virtual environment (pyenv-virtualenv leveraging pipenv
	- app-supervisor-configs
		- These are your supervisor app configs which have paths to your shell sh files, and those shell sh files have the folder path to their python application and the sh file loads the virtual environment, then loads gunicorn against the python application folder path that has wsgi.py and server.py (or app.py)

----

## Template to track all your credentials, folder paths, file paths in your web host details document


### ACC Services Dashboard / OR Login Via SSH Root
- os: (Eg. Debian 12)
- \__which is
- \__oauth2 login creds
- \__url


\> Alt Login:  
- \__login creds


Public IP: _ip

Available IP addresses: _availabeIps


Default domain name:
\__ 


Public IP URL:
\__   

Available IPs (If dedicated server)
- CIDR to expand to below: ??
- Network Address:  ??
- Usable IP Addresses:  ?? to  ??
- Broadcast Address:  ??

Root web directory is:
..

How to change password:
`sudo passwd root` OR UI: ...

Firewall managed with:
iptables / firewalld / ufw

---

### ACC Web Hosting Control Panel

- \__which is
- \__login creds
- \__url

\> \__ IA and how to navigate there from Services Dashboard  



**Admin users (Secondaries):**


**Site users (Tertiary)**




---

### ACC SFTP

Where to modify: \__


**SFTP as site user**
\__login creds
- Site user navigate to: \__ user navigation
- Preferred. Folders created by web host panel and by FTP - to make consistent so your php scripts can create files

**SFTP as root**
\__login creds


---

### ACC SSH Root access:
- \__login creds
- `ssh root@... -p 22` 

\> Alt Login:
Passwordless with SSH private key: \__filepath

Restart time if known: ...

\> Can change password at
\__ui navigation and/or link

\> Browser terminal is at
\__ui navigation and/or link  

\> \__ IA and why that’s how you navigate to SSH Root access creds settings

\> Aka root web directory for your website,  Aka working directory for your code and webpages:  
...

---

### ACC SSL HTTPS Directories
- **ssl_certificate:** \__remote file path
- **ssl_certificate_key:** \__remote file path

\__ Mention any necessary re-setups whenever you have new ssl certificates, eg. gunicorn command that has SSL paths in .sh file managed by Supervisor


----

### ACC MySQL/PHPMyAdmin

MySQL PHPMyAdmin:
_creds
_url


MySQL Shell:
```
..
```

---
### ACC Mongo

Mongo URL (PHP, NodeJS, Python):
```
..
```

Mongo Shell:
```
..
```


----
### ACC Supervisor

**Web UI at Port 9001:**
??
??
wengindustries.com:9001

**Directories:**

/etc/supervisor/conf.d/*
/etc/supervisor/supervisord.conf

**Commands:**

Pyenv Virtualenv Activate
```
pyenv activate app
```

Restart Supervisor:
```
supervisord -c /etc/supervisor/supervisord.conf -l /var/log/supervisor/supervisord.log
```

**Supervisor to app data flow:**
Supervisor watches .sh file which runs pyenv environment and gunicorn


---

### Vhost Backup
Date: `<Date>`
Have: Eg. Metabase and VLAI Microservices with SSE connections

```
Vhost file here
```

---

### Provider Checklist / Statements of Facts

- Specs & Monthly
	- \__package + os + web host panel
	- \__number of cores, memory, bandwidth, storage
	- \__monthly/yearly, auto-renews?
- Web server process 
	- \__apache or nginx?
- Security - Firewall is ufw or iptables?
	- ufw
- Security - Malware?:
	- \__which is, how to navigate to from services dashboard
	- \__inactive? how often paid?

---

## Folder structure:

- Recommend have separate folders for pm2/nodejs and for python/supervisor apps
	- If for the URL you prefer all apps regardless of language belongs to one folder, eg. /app, then have the other language-based folders symbolically link, eg. /nodejs/app1 -> /app/app1
- Recommend Supervisor app config files be named with the port number ranges they use
- May have a root folder /keys that have important keys for all your apps but make sure is blocked from being visited on the web browser. It's safer if you have a build script that saves the env keys to your .bash_profile, then re-source, instead.


## OS paths (error logs, configs), commands, and workflows
_...?


---

## Exiting Protocol

List backup and cleanup procedures here if discontinuing service.