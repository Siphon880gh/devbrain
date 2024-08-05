
Written by: Weng
Purpose: General checklist on setting up Dedicated Server. Likely there will be no web hosting admin panel (eg. Hostinger hpanel, WHM, GoDaddy My Products Dashboard)

```toc
```

## Reminder

Create a document for your webhost (eg. GoDaddy, Hostinger, etc) to refer back to as you go through this checklist. Things you can record are credentials, user flows, terminal commands

## Checklist

### Prepare your web host details document
- Besides credentials, there are commands, os specs, and other details you want to save somewhere about your web host that you may need to reference later

### What’s the appropriate Dedicated Server package
- RAM, number of cores, storage space, etc. 
- I will create a guide on how to communicate our full stack app’s use case, simultaneous users, memory use by the process and memory,  bandwidth use, storage disk space, etc to a server specialist that can decide the package and maybe install the architecture in the terminal.
- Does pricing include cpanel and os license?
- Or choose a free web hosting control panel and free linux distro? Downside of free may be lack of features and/or more custom terminal command work. Eg. Ubuntu 22 with CloudPanel
- Setup billing auto renewal?

### How to select for OS
- They usually install for you

---

### Managing your dedicated server
Likely your dedicated server does not have a web host admin panel (Hostinger hpanel, GoDaddy’s dashboard, etc). So figure out the processes other than having a GUI:
- What email to reach out to for managing billing information
- How to start a support ticket (probably email and they have a system where when the ticket is closed, that email thread will be ignored). If email, what information do they need.
- For your chosen OS, how to restart OS, and how to check if a service restarted with the OS?
- What commands to list server’s hardware specs (in case don’t have when making future business migration decisions)
-  Save the above information into your web host details document

### Login Entry Point: SSH in
- In place of a webhost admin panel or services dashboard, you'll mostly be interacting with your server via SSH and any web gui's you install. Often times their server administrator will setup SSH IP, root, and password, then hand it to you. The web host's server administrator that onboards you may also give you the range of ip addresses available for you to use. The rest is up to you.

- Are you able to login at the local machine terminal with password?
- So save to your web host document, your ssh credentials as the primary login Also save the savailable ip's for use (it might've been given to you)
	- If the available ip addresses are given to you in the form of CIDR, eg. XXX.XX.XXX.XX/29, you may want to work out the available IP addresses, then save to your document the network address, useable ip addresses, and broadcast address
	  
- You could look up how to change your root password for your OS, eg. Google: Ubuntu 22 change root password. Usually the onboarding server admin gives you a very randomized password that's hard for you to remember (you may be prompted for passwords multiple times running sudo).
	- Change your password by running `sudo passwd username`, then you will be prompted for a new password
	- Choose a password that's not related to your personal passwords because you may be sharing this password with the web host's server admin when there are problems only they can fix.

- Once in remote server, usually there is nothing much to navigate to get to your website files. There will probably be hidden folder .ssh, hidden file .bash_profile, etc, which you can see by running `ls -la`. You likely have to install nginx or apache from scratch, then setup root web directory for your website, Aka working directory for your code and webpages. 

- Optional: Are you able to login without password because you paired your local computer with the remote computer eith SSH keys (ssh -i option to the private key file location)? You may want to save this command as an alias for your local machine terminal’s .bash_profile equivalent. Run it as: `ssh root@REMOTE_IP -p 22 -i ~/.ssh/PRIVATE_KEY`)`

---

### **Dedicated server**: Web server (Nginx vs Apache)

By purchasing a dedicated server, it can become whatever server you want it to be (gaming server, blockchain server, website server). It won't be able to host websites out of the box though.

In order to have a website people can visit and a setup that makes it easy for the web developer to manage the website, you have to install a web server, FTP, and a webhost panel. Let's first install the webserver

1. Install web server

- Choose webserver (nginx or apache) and firewall (uwf or iptables). You want to install a web server AND a firewall because once you open your public IP to the internet, you need a firewall against malicious hackers. You can research pro’s and con’s of nginx vs apache (Briefly, Nginx can handle a lot more traffic than Apache, but Apache has a better developer experience with .htaccess, etc)

- Eg. Google: Ubuntu 22 install nginx with ufw
	- Brief from: https://www.digitalocean.com/community/tutorials/how-to-install-nginx-on-ubuntu-22-04
	- Run `sudo apt update` then `sudo apt install nginx`
	- Check if ufw is installed by running `sudo ufw --version`. If need to be installed, eg. Google: ubuntu 22 install ufw
	- Check if firewall is on by running `sudo ufw status`. If it says inactive, then you should enable the firewall: `sudo ufw enable`. 
	- Then open the ports with `sudo ufw allow 'Nginx HTTP'` and `sudo ufw allow 'Nginx HTTPS'`
	  
- Eg. Or Google: Ubuntu 22 install apache

2. After you've installed a firewall, do NOT close out your SSH terminal. 

- Allow port 22 by running:
```
sudo ufw allow 'OpenSSH'
```

If that didn't work then it's because OpenSSH is not a listed convention name port at `sudo ufw app list`, then try adding the numberic port instead: `sudo ufw allow 22`.

The `sudo ufw status` shows the rules, but to make sure the rules take effect, run `sudo ufw reload` 

4. Test your webserver
Get your public ip address which is not necessarily the ip given to you by the onboarding server server admin.

```
curl -4 ipinfo.io/ip
```
^ This is one of the free services that responds with your ip address

---


### How to decide on a Web Hosting Management Panel (Cpanel - monthly; Cloudpanel - free)
- *Background: Btw web hosting management panel is what cpanel refers to their category as. For managing at a bigger level like in WHM, that's web hosting admin panel.*

### **Dedicated Server**: Install a Web Hosting Management Panel

- There are web hosting management panels that require monthly payments for the license to use.
	- Not free: Cpanel, Plesk
	- Free: Ubuntu use cloudpanel. 
	- Free: AlmaLinux use webmin
- Let's say you chose CloudPanel for your Ubuntu 22:
	- Eg. Google ubuntu 22 nginx install cloudpanel
	- Brief from: https://www.cloudpanel.io/docs/v2/getting-started/other/
	- The instructions could be (Cloudpanel installations is missing the step of stopping the services):
		1. You must stop all port 80, 443, and 3306, otherwise when it installs Cloudpanel it will say the ports are in use. Run those that are applicable:
			```
			sudo systemctl stop apache2
			sudo systemctl stop nginx
			sudo systemctl stop mysql	
			```

			
		2. Updating repo list:
			```
			apt update && apt -y upgrade && apt -y install curl wget sudo
			```
		3. Install CloudPanel with MySQL 8.0 (CloudPanel requires a database):
			```
			curl -sS https://installer.cloudpanel.io/ce/v2/install.sh -o install.sh; \
			echo "2aefee646f988877a31198e0d84ed30e2ef7a454857b606608a1f0b8eb6ec6b6 install.sh" | \
			sha256sum -c && sudo bash install.sh
			```
			
	- Once done installing, the terminal will output the public IP plus the port number to visit, which could be **https://yourIpAddress:8443**
	- If firewall, you have to enable the port: `sudo ufw allow 8443`, then apply the rules right away with `sudo ufw reload`. Go to the webhosting panel and setup a username and password right away because hackers have bots constantly scanning this port for setup opportunities.
- Figure out if the web hosting management panel included other techs so you dont have to install them later. You can find out for example by running `mysql --version`, `php --version`, `profptd --version`, (Pro FTP Daemon), etc. Cloudpanel-MySQL installation includes MySQL, FTP, and PHP.
	- With CloudPanel, MySQL is installed and automatically creates a master credentials (FYI, CloudPanel actually needs two databases: Either MySQL or Maria, and then SQLite3 which stores settings in a db.sq3 file). 
		- To get the master credentials to see all databases, you run `clpctl db:show:master-credentials` and visit this url to login with those credentials https://XX.XXX.XX.XXX:8443/pma
		- Save MySQL credentials and URL to webhost details document

### How to log into Web Hosting Management Panel (Cpanel, Cloudpanel, etc)
- What’s the link with port number (Different web hosting services may assign different port for your panel). 
  eg. Cloudpanel on Hostinger [https://XX.XXX.XX.XXX:8443](https://XX.XXX.XX.XXX:8443)
- What are your login credentials?
- VPS: How to navigate to your panel at the Services Dashboard (if you don’t have the link handy)
	- what’s their information architecture (to help remember how to navigate there).  
	- eg. Hostinger’s: Hostinger believes CloudPanel manages the Ubuntu operating system with the purpose of web site and related services, hence you find CloudPanel under left panel item Settings (think VPS) → Operating System -> then “Manage Panel” button on the OS page
- Save the web hosting management panel credentials and its URL into your web host details document.


---

### How to setup web server for basic website editing and viewing (Default site)
- Basic: We just want to see we can impact how a website looks . We don’t care about SSL Https at this point
- What's the public IP address you can visit directly in the web browser (usually given to you by your onboarding server admin)  
- What’s the folder path to create/edit index.html to so web browser PRE web hosting management panel? Aka root web directory for your website, Aka working directory for your code and webpage.   
	- For the default site:
		- You figure out where the root is, possibly editing with `vi /etc/nginx/sites-enabled/default` then looking for the line with `root`, which has the path
		- List the files at that root working directory for some form of index file, eg. `ls var/www/html`
		- Then edit the page with possibly: `vi /var/www/html/index.nginx-debian.html`. You can add a word or punctuation then see if visiting the public IP in the web browser shows the change.
		- Use vi command to create an index2.html, add some words, then visit directly http://IP/index2.html to see if it displays.
		- If still problems viewing the page, refer to [[Troubleshooting - Nginx webpage not showing]]
	- That was editing and viewing for the default site, next we will cover editing and viewing for multiple sites
### How to setup web server for basic website editing and viewing (Multiple sites)
- For a site created / listed in your web hosting management panel. Eg. Hostinger Ubuntu 22.04 CloudPanel
- If no website exists in the web hosting management panel, add a website. Otherwise pay attention to the name of the website in the web hosting management panel
- Figure out what's the folder path to that website on your system. Could be `/home/DOMAIN/htdocs/DOMAIN.com`
  ^ You can `ls /home/` to figure out the path

- Using vi command in shell, or using your web hosting management panel's File Manager, edit the index file adding a word or punctuation and see if visiting the URL will show the changes.  The index file could be `/home/DOMAIN/htdocs/DOMAIN.com/index.php`
- Because you are on a dedicated server, it is likely that the web host DOES NOT provide you with a default domain name you can attach to your multi site's vhost. Make sure you've bought a domain at namecheap, etc. Then make sure you have two A records to the public domain: one for "@" and one for "\*". At your CloudPanel site's vhost, update the server_name to the domain name, eg. `server_name domain.com`
- Visit your http://domain.com directly. 
- If success, Chrome will warn you there's no secured connection or that the connection is not private and blocks you from viewing the content. We will add SSL https certificates later. The current bypass technique in 2024 is to click anywhere on the webpage then type: `thisisunsafe`. You should see the webpage content.
- Use vi command to create an index2.html, add some words, then visit directly http://domain.com/index2.html to see if it displays.
- This then assumes future websites on CloudPanel will have no problem with editing and viewing by the internet.

- Troubleshooting: Visiting the domain name goes doesnt work
	- Make sure at namecheap, etc you have A records to the public IP using `@`. Then have another A record to the public IP using "\*" instead of "www" so that any subdomains. You can check if the DNS propagation for A records pointed to your public IP at whatsmydns.
	- Make sure file permissions correct for various paths of your sites and nginx. Refer next section's "Cloudpanel vhost 500 error is because of file permission problems"
	- If still problems viewing the page, refer to [[Troubleshooting - Nginx webpage not showing

## Test web hosting management panel

Because you installed the web hosting management panel yourself rather than being on a VPS that installed it for you, there are likely kinks to be worked out because CloudPanel's install script is not perfect. Check Cloudpanel throughly to see it works:

- I. Check if Cloudpanel Vhosts can save (feel free to add a space at a whitespace area, then click Save)
	- If goes to 500 internal server error:

		- Check nginx error log to determine cause of Vhost 500 error:
		```
		tail /home/clp/logs/nginx/error.log
		```

		- If the Cloudpanel vhost 500 error is from a missing file or folder:
		```
		2024/08/03 08:27:19 [error] 154388#154388: *84 open() "/home/clp/htdocs/app/files/public/site/100pullups.app/ext-searchbox.js" failed (2: No such file or directory), client: 209.65.62.26, server: _, request: "GET /site/100pullups.app/ext-searchbox.js HTTP/2.0", host: "208.76.249.74:8443", referrer: "https://208.76.249.74:8443/site/100pullups.app/vhost"
		```

		- Then this lack of folder means the installation likely was corrupted. Go to home/ and change the permissions to 777 and owner to root on the clp or cloudpanel folder. Then rerun the installation command as root user or sudo user. The installation will later reset clp or cloudpanel to the correct ownership and permissions
			- If during the installation, it complained often about missing file error `/home/clp/htdocs/app/files/var/log/prod.dev: No such file or directory`, then create the folders like so:
			   `mkdir -p /home/clp/htdocs/app/files/var/log/`. Then rerun the installation again. 
			- When reinstallation successful, you should be able to visit the Cloudpanel in your web browser and it'll remember your previous admin user and sites.

		- If the Cloudpanel vhost 500 error is because of file permission problems:
			```
			2024/08/03 10:36:17 [crit] 266908#266908: *96 open() "/var/lib/nginx/body/0000000005" failed (13: Permission denied), client: 209.65.62.26, server: _, request: "POST /site/test3.com/vhost HTTP/2.0", host: "208.76.249.74:8443", referrer: "https://208.76.249.74:8443/site/test3.com/vhost"
			
			2024/08/03 10:36:38 [crit] 266908#266908: *110 open() "/var/lib/nginx/body/0000000006" failed (13: Permission denied), client: 209.65.62.26, server: _, request: "POST /site/test4.com/vhost HTTP/2.0", host: "208.76.249.74:8443", referrer: "https://208.76.249.74:8443/site/test4.com/vhost"
			
			2024/08/03 10:37:02 [crit] 266908#266908: *118 open() "/var/lib/nginx/body/0000000007" failed (13: Permission denied), client: 209.65.62.26, server: _, request: "POST /site/test4.com/vhost HTTP/2.0", host: "208.76.249.74:8443", referrer: "https://208.76.249.74:8443/site/test4.com/vhost"
			
			2024/08/03 10:37:07 [crit] 266908#266908: *120 open() "/var/lib/nginx/body/0000000008" failed (13: Permission denied), client: 209.65.62.26, server: _, request: "POST /site/test4.com/vhost HTTP/2.0", host: "208.76.249.74:8443", referrer: "https://208.76.249.74:8443/site/test4.com/vhost"
			
			2024/08/03 10:37:14 [crit] 266908#266908: *125 open() "/var/lib/nginx/body/0000000009" failed (13: Permission denied), client: 209.65.62.26, server: _, request: "POST /site/test4.com/vhost HTTP/2.0", host: "208.76.249.74:8443", referrer: "https://208.76.249.74:8443/site/test4.com/vhost"
			```


		- Have these checks to fix file permission errors so that cloudpanel can work with nginx:
			1. sites configs
				```
				chmod 755 -R /etc/nginx/sites-enabled; chmod 755 -R /etc/nginx/sites-available; chown root:root -R /etc/nginx/sites-enabled; chown root:root -R /etc/nginx/sites-available;
				```

			2. nginx process
			```
			chown -R root:root /var/lib/nginx; chmod -R 777 /var/lib/nginx
			```

			3. html documents
				Check that: /home/ have folder named by usernames which are named after the sites you create at cloudpanel. Each folder is owned by their respective username and group of same name. They should be drwxrwx--- permission at mod 770. For example:
				```
				drwx------  8 clp                      clp                            4096 Jun 14 01:41 clp
				
				drwxrwx---  8 wayneteachescode         wayneteachescode               4096 Jun 23 10:10 wayneteachescode
				
				drwxrwx---  8 wayneteachesproductivity wayneteachesproductivity       4096 Jun 23 10:26 wayneteachesproductivity
				
				drwxrwx--- 12 wengindustries           wengindustries                 4096 Jul 23 10:22 wengindustries
				```

			4. Try again. If still fails because of file permission issues:
			   Your CloudPanel or Nginx may have some conflict that prevents permissions from being reconciled between www-data and the new user and group pair for every new site created at Cloudpanel.
			   - Make sure nginx uses `www-data` (on Debian/Ubuntu systems) or `nginx` (on CentOS/RHEL systems). Find out by editing the nginx main conf file which could possibly be `vi /etc/nginx/nginx.conf`. It's at the top of the file like `user www-data www-data`
			   - Then every time you created a new site (and for all sites you haven't set those up for), add the web server user to the site group:
				```
				sudo usermod -aG a100pullups www-data
				```
			- Reworded: Every site I create on cloudpanel, I have to add the www-data user to the new group (which is associated with the new site user). Otherwise, the webpage wont load and when I check the error.log for that website, it shows file permission / permission denied. But if I add the www-data user to the new group, that gets fixed.
			- You will have to add to your webhost details document that this reconciliation must be done manually every time you create a new site. Also recommend adding a fake site in CloudPanel titled "00oncreate-add-www-data-to-site-group" which will remind you whenever you create a new site and return to the list of sites because this is the first item in the list. You can add the usermod command into the SSH keys section of that fake site as reference notes.
				- You add www-data to the site-group like this:
					```
					sudo usermod -aG a100pullups www-data
					```


- Check syntax when nginx config combines with site's vhost by running
	```
	sudo nginx -t
	```

	- If you get an "Unknown log format", refer to fix at [[Nginx Troubleshooting - Unknown log format]]

- II. Check that you can create free SSL with Let's Encrypt inside CloudPanel
	- Quick Review: Free SSL does not impact your SEO, but there may be benefits to a paid SSL or business regulations that require you to adopt a paid SSL. If adopting a paid SSL, you can skip this check
	- Do this: SSL/TLS -> Actions -> New Let's Encrypt Certificate -> Create and Install
	
	- If errored with: Unable to create a site with the error "SSH key... /etc/nginx/ssl-certificates..."
		- Solution: Make sure that folder exists at /etc/nginx/. If it doesn't exist, create `ssl-certificates` folder so that `/etc/nginx/ssl-certificates` exists. That way CloudPanel can create the cert and key files there. Keep the ownership and file permissions of the folder as the same as the adjacent files.
	- If errored:  domain.com/.well-known/acme-challenge/RANDOM_LETTERS... failed... Authorization result: invalid... 404
		- Solution: If you place a text file called 'test.txt' with some text like “Reached” into the folder /.well-known/acme-challenge/ can you browse to it using https://www.domain.com/.well-known/acme-challenge/test.txt - if not, you need to get that working first, as that's what's required to get this working. Could be directory like: `/home/SITE_USER/htdocs/DOMAIN/.well-known/acme-challenge/test.txt`
		- If Chrome warns you there's no secured connection or that the connection is not private and blocks you from viewing the content. We will add SSL https certificates later. The current bypass technique in 2024 is to click anywhere on the webpage then type: `thisisunsafe`. You should see the webpage content.
	- If errored:  domain.com/.well-known/acme-challenge/RANDOM_LETTERS... Domain could not be validated... 403
		- Solution: Refer above to the Cloudpanel vhost 500 error from file permission problems.

### How to setup SFTP/FTP users
- Makes life easier for web developers.
- FTP: It's strongly recommended you use SFTP instead. You can setup FTP capability then leave the port off or on as a backup. Refer to: [[Setup FTP]]
- SFTP: [[Setup FTP]] if not CloudPanel. [[CloudPanel - Setup SFTP users]] if CloudPanel.

---


### Prepare web server for basic public view - SSL, File Permissions, Security
- Do you have to setup SSL?
	- Free vs Paid SSL
		- You can get a free SSL with Let's Encrypt. Look up instructions how to run Let's Encrypt in your SSH.
		- You can also buy SSL which gives you certain advantages over SSL, and some businesses must have a paid SSL as regulation.
	- Figure out workflow to acquire and install SSL because you'll be doing this annually. Also perform it now
		- If CloudPanel, it's very simple going to the site -> SSL/TLS -> Actions -> New Let's Encrypt Certificate (however you must have a domain connected to that website already because it'll create a file then access that file through your domain URL to prove your ownership then generates the certificate).
		- If less obvious how and where to install SSL HTTPS certificates: Contact customer support or google Web host + OS + Nginx/Apache + Install SSL certificates. If the web host is not well known (very independent), google for: OS + Nginx/Apache+ Install SSL certificate
	- Know the filepaths to the SSL for future issues and code that needs SSL cert and key paths such as gunicorn (even if Cloudpanel abstracts it away)
		- If Hostinger CloudPanel, the Vhost page likely hides ssl cert and key file paths in the server block as variables. You have to find the site's nginx confi file where the final vhost is written (eg. /etc/nginx/sites-enabled/some-website.com.conf)
			- Hostinger Ubunto 22.04 with Cloud Panel paths could be:
				- **ssl_certificate** /etc/nginx/**ssl**-certificates/DOMAIN.com.crt;
				- **ssl_certificate_key** /etc/nginx/**ssl**-certificates/DOMAIN.com.key;
- File permissions: if you will have php or python scripts that are triggered by visiting web browser, if it writes to a folder, can it write?
	- How to make sure the user that created the folders upon creating your website aka the same that would be the owner of files you create at the web hosting panel’s File Manager...
	    
	    ...how to make sure it’s the same user for Filezilla (make sure site user login into Filezilla or FTP client). If not, you could upload php scripts via filezilla that creates files (like text file of user activities) but your filezilla user didn’t own the folder so it’ll be permission error preventing creating files by php script
	    
	    When visit a php page in the web browser, can it append or write to a file using fwrite? Eg. tracking user behaviors at a user-log.txt. If it's unable, see user and group ownership of the folder it writes to and the php page that does the writing. You can see with `ls -la` and you see they do not match so no wonder the file does not have permission to write to the folder.
- Install malware and security especially when going public
	- If Hostinger, their malware scanner [https://support.hostinger.com/en/articles/8450363-vps-malware-scanner](https://support.hostinger.com/en/articles/8450363-vps-malware-scanner)
    - How to navigate to the malware from services dashboard (Hostinger hpanel, GoDaddy dashboard, etc)
    - Is malware free, times one payment, or monthly/yearly? Or keep deactivated (often they let you scan but not fix for free)
    - Is there a firewall from the web hosting management panel? or do you have to run ufw?
- Domain name
	- Domain name
	- Refer to tutorial on domain and dns editing. There are many ways to do it. One way is to have namecheap domain with two A records to the public IP of your webhost at "@" and "\*" (unless you want different public ip between www and other subdomains)

---
### ADVANCED WEBSITE: Prepare server for installing different architectures (PHP, NodeJS, Python, MySQL, Mongo, Scaling Solutions)
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
- Look up instructions for your OS on how to install these language interpreters, if applicable to your server's use cases (these should be installed before installing databases because you'll be testing database connections with code):
	- PHP (if not included by your web host’s)
		- If installed CloudPanel, PHP comes included. If you don't see PHP, you should create a PHP site off CloudPanel 
		- If not installed CloudPanel and your web host management panel does not come included with PHP, look up how to install php, eg. Google: Ubuntu 22 install php
		- If installed Cloudpanel or a web hosting management panel that already has it setup for you, you can also skip this step:
		  You have to configure apache or nginx to handle php, eg. Google: `Nginx handle php`, eg. Google: `Apache handle php`
	- Python: 
		- Eg. Google: Ubuntu 22 install python
	- NodeJS
		- Eg. Google: Ubuntu 22 install nodejs
		- npm will come with nodejs
		- Prevent npm scripts having no file permission:
			- Check npm version with `npm --version`
			- If the version is v7 or v8 families, then NodeJS switches user to the user owning the folder to the package.json when running npm script which is not desirable in most cases (you would prefer to keep the same user that runs the npm script `npm run scriptX`) and usually causes file permission problems when running a npm script
				- Then you install nvm to install and change the node version. Then you make it permanent beyond your current shell session. Refer to the tutorial [[NVM - npm scripts say permission denied on the cli command]]
- Look up instructions for your OS on how to install these databases, if applicable to your server's use cases
	- MySQL (if not included by your web host’s VPS)
		- If not installed CloudPanel or a web host management panel that includes these parts, look up instructions on how to install MySQL, PHP, and PHPMyAdmin. eg. Google: Ubuntu 22 install mysql phpmyadmin
		- Ubuntu v22 with CloudPanel comes with MySQL, PHP, and phpMyAdmin, however when accessing phpMyAdmin from Cloudpanel then only the databases the user is associated with shows up.
			- To get the master credentials to see all databases, you run `clpctl db:show:master-credentials` and visit this url to login with those credentials https://XX.XXX.XX.XXX:8443/pma
			- Save mysql command for mysql shell login. For example:
			  `mysql -h 127.0.0.1 -u USER -P 3306 -p'PASSWORD' -A`
			- Test PHP wrapping MySQL works. You can write this php file then either run in web browser or terminal (`php script.php`):


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

		If PHP connecting to MySQL works (most commonly used case), then it's assume Python and NodeJS will connect with no problems
			  
	- MySQL phpMyAdmin
		- What's the URL to phpMyAdmin? If needed, can we make it show all the databases instead of only some databases (databases associated to one user) at phpMyAdmin?
		- Save phpMyAdmin URL and credentials to web host details document
	- MongoDB
		- Look up instructions how to install MongoDB: 
		  eg. Google: Ubuntu 22 install mongo
		- What's the mongo shell command? May skip adding to your web host details document. 
		  
		  MongoDB 3.4 and below, run`mongo` for mongoshell
		  Above Mongo 3.4, run `mongosh` for mongoshell
		  
		- How to check if mongo service is running? How to stop mongo service? How to restart mongo service? Save these commands to your web host details document.
		- Create an authentication account on the auth collection
		
		  While in Mongo Shell, run to create user
			```
			db.createUser({  
			  user: "USERNAME",  
			  pwd: "PASSWORD",
			  roles: [{role: "root", db: "admin"}]  
			})
			```


		Enable authorization for the mongo daemon:
		```
		sudo vi /etc/mongod.conf
		```

		
		Add or strip comment:
		```
		security: 
			authorization: enabled
		```

		Restart mongo service so the settings apply:
		```
		sudo systemctl restart mongod
		```

		Test proper login shell command based on version of your MongoDB:
		```
		mongo -u USERNAME -p PASSWORD --authenticationDatabase admin
		```
		
		or
		```
		mongosh -u USERNAME -p PASSWORD --authenticationDatabase admin
		```

		It passes if you go into the mongo shell instead of receiving the error `MongoServerError: Authentication failed.`

		Note: You may have accidentally ran `mongo` or `mongosh` and notice you can still get into the Mongo shell without the authentication options and option values; However, that doesn't matter because if you run `show databases;` while in the unauthenticated Mongo Shell, it will error: `**MongoServerError[Unauthorized]** ...` 

		- Save authenticated login shell command into your web host details documents
		  
		- Decide whether to open the Mongo to remote IPs or keep local. If you open to remote IPs, then you can connect from your Mongo Compass. The inner steps here are to enable for remote IPs / Mongo Compass

		 Enabling external connections (and Mongo Compass)
			By default `etc/mongod.conf` settings allow files on the same host as the mongo server to connect (127.0.0.1, aka localhost). Let's open Mongo to the internet/world.
			Edit your `/etc/mongod.conf`:
			
			```
			   net:
				 bindIp: 0.0.0.0
			```

		Restart mongo service so the settings apply:
		```
		sudo systemctl restart mongod
		```

		Additionally, if you have firewall (either uwf or iptables), you have to allow in internet 0.0.0.0 into port 27017:
		.. Check if ufw firewall is enabled with `sudo ufw status`. If it's enabled, you should open the Mongo port by running `sudo ufw allow 27017`. Check port allowed rules by running same `sudo ufw status`. Apply the rules immediately with `sudo ufw reload`.
		..Check if iptables is managing firewall by running `sudo service iptables status`. If it's enabled, you should open the Mongo port by running `sudo iptables -A INPUT -p tcp --dport 27017 -j ACCEPT` . Check ports allowed by running `sudo iptables -L -n`
				
		- Test MongoDB with authentication account works on Python or NodeJS
		
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


		It's assumed PHP will be able to connect to Mongo if Python and NodeJS works

- Look up instructions for your OS on how to install these scaling solutions, if applicable to your server's use cases
	- Balancers and multi workers:
		- pm2 for nodejs
			- Refer to the tutorial [[Installing PM2 and Configuring Nginx for Multiple Node.js Applications]] even if you're not on nginx (the first sections will be applicable before the section on applying it to nginx)
		- Supervisor, virtual envs, gunicorn and flask for python
			- Refer to the tutorial [[Supervisor Primer - QUICK REFERENCE]] which includes supervisor, shell file, gunicorn, flask, pyenv, pyenv-virtualenvs, pipenv
		- Docker or supervisor to restart your api app on crashes (either server crash or app crash)
			- Refer to the tutorials [[Docker Primer - General]] and [[Docker Primer - Get Started]]

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
  

Passwordless:
```
alias hostinger='echo -e "Local: /Users/wengffung/dev/web/weng/tools/\nRemote: /home/XX/htdocs/YY.com/"; ssh root@REMOTE_IP -p 22 -i ~/.ssh/PRIVATE_KEY'
```

Requires password - sshpass for one command login:
```
alias coloa='echo -e "Local: /Users/wengffung/dev/web/weng/tools/\nRemote: /home/.."; sshpass -p "YOUR_PASSWORD" ssh root@XXX.XX.XXX.XX'
```

The password one requires you to install sshpass for your computer (eg. Google: Mac brew install sshpass). The sshpass allows you to have the password in the same command where you place the username and IP address. SSH normally forces you to enter the password after the username and IP address is accepted aka interactive mode.

Dedicated server: You want a normal ssh alias because if you ever need help and the webhost's server admin reinstalls your server, sshpass won't work. You'd need to run the normal ssh command because you have to interactively accept the warning about the new fingerprint after erasing the line(s) referring to that remote host from your`known_hosts` file (could be at `/Users/XX/.ssh/konwn_hosts`). The ssh command, such as coloa-ssh, could be:

```
alias coloa-ssh='ssh root@XXX.XX.XXX.XX'
```

You want a reset alias too because if you needed help and the webhost's server admin reinstall your server, the sshpass will not work. You'd need to run the normal ssh command. Regardless which command you run, it would complain that the host doesn't match your known_hosts.  So, next you delete the line(s) referring to that remote host from the file `/Users/XX/.ssh/known_hosts`. Then you run `ssh` allowing you to input "Y" or "Yes" to the question about a new fingerprint; sshpass won't let you interactively be prompted. Therefore the reset command like `coloa-reset` could be:
```
alias coloa-reset='ssh root@XXX.XX.XXX.XX'
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

---

### ACC Web Hosting Management Panel

- \__which is
- \__login creds
- \__url

\> \__ IA and how to navigate there from Services Dashboard  

Site Credential(s)
Login:
Pass:
Url:


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
Passwordless with SSH private key: \__filepath

Restart time if known: ...

\> Can change password at
\__ui navigation and/or link

\> Browser terminal is at
\__ui navigation and/or link  

\> \__ IA and why that’s how you navigate to SSH Root access creds settings

\> Aka root web directory for your website,  Aka working directory for your code and webpages:  
...

---

### ACC SSL HTTPS Directories
- **ssl_certificate:** \__remote file path
- **ssl_certificate_key:** \__remote file path

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

### ACC Supervisor Web UI at Port 9001

_user
_pass
domain.com:9001


---

### ACC Supervisor and Related Commands:


Pyenv Virtualenv Activate
```
pyenv activate app
```

Supervisor main config settings:
```
/etc/supervisor/supervisord.conf?
```


Supervisor apps folder:
```
/etc/supervisor/conf.d?
```

Apps include:
```
/etc/supervisor/conf.d/app.conf?
```

Supervisor to sh
```
?
```



---
---


### VPS Checklist Applied to Hostinger

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

## How to access error logs for nginx etc

_...?