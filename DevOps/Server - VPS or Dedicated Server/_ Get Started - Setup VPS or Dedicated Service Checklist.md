
Written by: Weng
Purpose: General checklist on setting up VPS or Dedicated Server, regardless if Hostinger or GoDaddy or etc.


## Checklist

**What’s the appropriate VPS package**
- RAM, number of cores, storage space, etc. 
- I will create a guide on how to communicate our full stack app’s use case, simultaneous users, memory use by the process and memory,  bandwidth use, storage disk space, etc to a server specialist that can decide the package and maybe install the architecture in the terminal.
- Does pricing include cpanel and os license?
- Or choose a free web hosting control panel and free linux distro? Downside of free may be lack of features and/or more custom terminal command work.
- Setup billing auto renewal?


**How to select for OS**


**How to select for a web hosting panel (Cpanel - monthly; Cloudpanel - free)**
- _Background: Btw web hosting control panel is what cpanel refers to their category as. They also refer to as including server and site management platform._


**How to log into Service Dashboard (Hostinger hpanel, GoDaddy’s dashboard, etc)**
- Where to view billing information
- Where to restart the VPS (for bugs)
- Where to look for server’s hardware specs (in case don’t have with you)


**How to log into Web Hosting Panel (Cpanel, Cloudpanel, etc).** 
- What’s the link with port number (Different web hosting services may assign different port for your panel). 
 eg. Cloudpanel on Hostinger [https://XX.XXX.XX.XXX:8443](https://XX.XXX.XX.XXX:8443)
- How to navigate to your panel at the Services Dashboard (if you don’t have the link handy)
- what’s their information architecture (to help remember how to navigate there).  
- eg. Hostinger’s: Hostinger believes CloudPanel manages the Ubuntu operating system with the purpose of web site and related services, hence you find CloudPanel under left panel item Settings (think VPS) → Operating System -> then “Manage Panel” button on the OS page
- What are your login credentials?


**How to setup SFTP/FTP users**
- Where to navigate to adding SSH users? Will those SSH users act as SFTP users?
- Use Filezilla to connect SFTP (SFTP chosen, Port can be empty, Logon Type is Normal)
- Stick with SFTP if possible because it’s more secured.
- If SFTP users unavailable, then where to add FTP users


**How to setup web server for basic website viewing (required: FTP)**
- Basic: We just want to see we can impact how the website looks from FTP client like FIlezilla. We don’t care about SSL Https at this point
- Where in the web hosting panel (cpanel, cloudpanel, etc) does it show you the public IP address you can visit directly in the web browser  
- Where does it give you the default domain (aka temporarily domain)  (eg. srv451789.hstgr.cloud). We want to test we can visit the webpage after uploading files with FTP. We do not care to visit the desired domain name yet because DNS propagation takes a while.
- What’s the URL that FTP client needs to upload to so web browser can see html/php pages? Aka root web directory for your website,  Aka working directory for your code and webpages. This is usually the first website you create in your web host panel or the website they already created for you, and their settings show you the associated folder path.  
  Eg. Hostinger Ubunto 22.04 CloudPanel is: `/home/DOMAIN/htdocs/DOMAIN.com`
- Using FTP, upload an empty file with some wording. See if you can visit that page on the web browser either with the public IP or human readable URL
- If fails to visit, you have further settings to perform
	- Firewall settings good to go?
	- Security settings with the ports opened good to go?
	- Determine if your server is NginX or Apache? (Either check in the terminal, or google your web host company + OS + web host panel nginx or apache, or ask customer support)
		- See if the web server process is NginX or Apache is properly running
		- For example: `sudo systemctl status nginx`  then you can restart (slight downtime) or reload (faster) in place of status .This is for Ubuntu 22.04 using 
		- Know how to restart web server process
		- Know how to configure web server process centrally (apache and nginx) and directory level (apache htaccess)
	- Is your site enabled?
		- If Apache, did it enable your website?:
			- Look into /etc/apache2/sites-enabled/ or /etc/apache2/sites-available/  
		- If NGinX, did it enable your website?
			- Look into /etc/nginx/sites-enabled/
	- Is your Apache/Nginx pointing to the correct root files to present to the web browser on visiting the highest level of your website URL (`domain` instead of `domain.com/something` )?
		- Eg. If Hostinger at Cloudpanel VHost: You might see placeholder {{root}} instead of the folder path spelled out. This page writes to the file `/etc/nginx/nginx.conf` so you have to access that file on SSH terminal (either with vi, nano, or cat)
	- Is your Apache/Nginx allowing hostname that’s IP address?
		- Eg. Hostinger at Cloudpanel Vhost by default BLOCKS visiting an IP address directly (so IP address as a hostname isn’t allowed). You have to visit the domain name you setup for it (but well, even if you setup the domain name, you have to wait for DNS propagation). In this case, add a server block with the exact IP address to after the other server blocks:
		- Note to replace YOUR_PUBLIC_IP and YOUR_HTML_FILES_PATH
		- ![](https://i.imgur.com/TZ0nPkz.png)
		- See
```
server {  
    listen 80;  
    listen [::]:80;  
    server_name YOUR_PUBLIC_IP;  

    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    {{ssl_certificate_key}}
    {{ssl_certificate}}
  
    root YOUR_HTML_FILES_PATH;  
      
    try_files $uri $uri/ /index.php?$args;  
    index index.html index.htm index.php;  
      
      
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
  
    location / {  
        try_files $uri $uri/ =404;  
    }  
}
```

- Anymore you have to edit in the server blocks? Try out on web browser that you don’t hit this:

```
31.220.18.169 didn’t send any data.

ERR_EMPTY_RESPONSE
```


![](https://i.imgur.com/S5JdFKb.png)


**How to setup SSH root access**
- Is this at the Services Dashboard (aka Hostinger hpanel, GoDaddy Dashboard) or the web hosting panel (cPanel, cloudpanel, etc)
	- What’s their information architecture (to help remember how to navigate there).
- How to access web browser SSH Root terminal navigating the Services Dashboard or the web hosting panel
	- In case you need to quick and dirty in the future
	- What’s their information architecture (to help remember how to navigate there).
- Are you able to login at the local machine terminal with password?
- Once in remote server, how to navigate to get to your website files using cd commands? (Go into CloudPanel or Cpanel for a clue). Aka root web directory for your website,  Aka working directory for your code and webpages. Alternately you could have in a text document the full path so you can copy and paste the cd path into the terminal. But knowing how to navigate there in terminal can be helpful if you don’t have the full path easily accessible to copy and paste.
- Run it as: `ssh root@REMOTE_IP -p 22`. Then enter your password when asked
- Are you able to login without password (ssh -i option to the private key file location). You may want to save this command as an alias for your local machine terminal’s .bash_profile equivalent. Run it as: `ssh root@REMOTE_IP -p 22 -i ~/.ssh/PRIVATE_KEY`)`
	- You may want to alias it (along with an echo of directories you will often cd into):
```
alias hostinger='echo -e "Local: /Users/wengffung/dev/web/weng/tools/\nRemote: /home/XX/htdocs/YY.com/"; ssh root@REMOTE_IP -p 22 -i ~/.ssh/PRIVATE_KEY'
```

**Prepare server for installing different architectures**
- Know how to reboot the server
- how see error logs based on your OS and web server type  
    eg `tail -f /var/log/nginx/error.log`
- Know how to check status of, start, stop, and restart services


**Ubuntu 22.04:**
```
sudo systemctl status nginx
```

```
sudo systemctl start nginx
```


- know what is the main installer of packages in command line (eg. `sudo apt update`  for Ubuntu 22.04)
- update installer’s repos 
- look up instructions for your OS on how to install, if applicable:
	- MySQL (if not included by your web host’s VPS)
	- PHP (if not included by your web host’s PHP)
		- Then if NginX, you would have to setup your server block to send the php files to a PHP interpreter
	- MySQL phpMyAdmin
	- MongoDB
	- Python
	- NodeJS
	- Balancers and multi workers:
		- pm2 for nodejs
		- gunicorn and flask for python
		- Docker or supervisor to restart your api app on crashes (either server crash or app crash)


**Prepare web server for public viewing and/or app use**
- do you have to buy cert files?
	- Your web host may advertise offering free SSL for wordpress or shared hosting, but you are on VPS
	- If Hostinger, their VPS includes free SSL. If GoDaddy, SSL is separate
	- How and where to install SSL HTTPS certificates? Contact customer support or google Web host + OS + Install SSL certificates
		- Even if the first SSL are free and already setup, you need to know for future manual SSL setups
		- If Hostinger CloudPanel, the Vhost page might show ssl cert and key file paths. If hidden under a variable name, then see the file the Vhost page writes to (/etc/nginx/nginx.conf)
			- Hostinger Ubunto 22.04 with Cloud Panel is:
				- - **ssl_certificate** /etc/nginx/**ssl**-certificates/DOMAIN.com.crt;
				- **ssl_certificate_key** /etc/nginx/**ssl**-certificates/DOMAIN.com.key;
- File permissions: if you will have php or python scripts that are triggered by visiting web browser, if it writes to a folder, can it write?
	- How to make sure the user that created the folders upon creating your website aka the same that would be the owner of files you create at the web hosting panel’s File Manager...
	    
	    ...how to make sure it’s the same user for Filezilla (make sure site user login into Filezilla or FTP client). If not, you could upload php scripts via filezilla that creates files (like text file of user activities) but your filezilla user didn’t own the folder so it’ll be permission error preventing creating files by php script
	    
	    When visit a php page in the web browser, can it append or write to a file using fwrite? Eg. tracking user behaviors at a user-log.txt. If it's unable, see user and group ownership of the folder it writes to and the php page that does the writing. You can see with `ls -la` and you see they do not match so no wonder the file does not have permission to write to the folder.
- Install malware and security especially when going public
	- If Hostinger, their malware scanner [https://support.hostinger.com/en/articles/8450363-vps-malware-scanner](https://support.hostinger.com/en/articles/8450363-vps-malware-scanner)
    - How to navigate to the malware from services dashboard (Hostinger hpanel, GoDaddy dashboard, etc)
    - Is malware free, times one payment, or monthly/yearly? Or keep deactivated (often they let you scan but not fix for free)


----

# Template to track all your credentials, folder paths, file paths

  

### ACC Services Dashboard
- \__which is
- \__oauth2 login creds
- \__url


\> Alt Login:  
- \__login creds

###ACC Web Hosting Panel

- \__which is
- \__login creds
- \__url


\> \__ IA and how to navigate there from Services Dashboard  


Default domain name:
\__ 


Public IP URL:
\__   


Root web directory is:
..

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

---

### VPS Checklist Applied to Hostinger

- Specs & Monthly
	- \__package + os + web host panel
	- \__number of cores, memory, bandwidth, storage
	- \__monthly/yearly, auto-renews?
- Web server process 
	- \__apache or nginx?
- Malware/Security:
	- \__which is, how to navigate to from services dashboard
	- \__inactive? how often paid?