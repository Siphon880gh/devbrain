
Written by: Weng
Purpose: General checklist on setting up Dedicated Server. Likely there will be no web hotsing admin panel (eg. Hostinger hpanel, WHM, GoDaddy My Products Dashboard)

```toc
```

## Reminder

Create a document for your webhost (eg. GoDaddy, Hostinger, etc) to refer back to as you go through this checklist. Things you can record are credentials, user flows, terminal commands

## Checklist

### Prepare your web host details document
- Besides credentials, there are commands, os specs, and other details you want to save somewhere about your web host that you may need to reference later

### What’s the appropriate Dedicated Server package
- RAM, number of cores, storage space, etc. 
- I will create a guide on how to communicate our full stack app’s use case, simultaneous users, memory use by the process and memory,  bandwidth use, storage disk space, etc to a server specialist that can decide the package and maybe install the architecture in the terminal.
- Does pricing include cpanel and os license?
- Or choose a free web hosting control panel and free linux distro? Downside of free may be lack of features and/or more custom terminal command work. Eg. Ubuntu 22 with CloudPanel
- Setup billing auto renewal?

### How to select for OS
- They usually install for you

---

### Managing your dedicated server
Likely your dedicated server does not have a web host admin panel (Hostinger hpanel, GoDaddy’s dashboard, etc). So figure out the processes other than having a GUI:
- What email to reach out to for managing billing information
- How to start a support ticket (probably email and they have a system where when the ticket is closed, that email thread will be ignored). If email, what information do they need. Save this information to your web host details document
- For your chosen OS, how to restart OS, and how to check if a service restarted with the OS?
- What commands to list server’s hardware specs (in case don’t have when making future business migration decisions)

### Login Entry Point: SSH in
- In place of a webhost admin panel or services dashboard, you'll be mostly interact with your server via SSH and any web gui's you install. Often times their server administrator will setup SSH IP, root, and password, then hand it to you. The web host's server administrator that onboards you may also give you the range of ip addresses available for you to use. The rest is up to you.

- Are you able to login at the local machine terminal with password?
- So save to your web host document, your ssh credentials as the primary login Also save the savailable ip's for use (it might've been given to you)
	- If the available ip addresses are given to you in the form of CIDR, eg. XXX.XX.XXX.XX/29, you may want to work out the available IP addresses, then save to your document the network address, useable ip addresses, and broadcast address
	  
- You could look up how to change your root password for your OS, eg. Google: Ubuntu 22 change root password. Usually the onboarding server administrator gives you a very randomized password that's hard for you to remember (you may be prompted for passwords multiple times running sudo). Then update your web host details document.

- Once in remote server, usually there is nothing much to navigate to get to your website files. There will probably be hidden folder .ssh, hidden file .bash_profile, etc, which you can see by running `ls -la`. You likely have to install nginx or apache from scratch, then setup root web directory for your website, Aka working directory for your code and webpages. 

- Optional: Are you able to login without password (ssh -i option to the private key file location). You may want to save this command as an alias for your local machine terminal’s .bash_profile equivalent. Run it as: `ssh root@REMOTE_IP -p 22 -i ~/.ssh/PRIVATE_KEY`)`

---

### **Dedicated server**: Web server
You have to install a web server, FTP, and a webhost panel. These steps are my guesses based on researching  

1. Install web server

- Choose webserver (nginx or apache) and firewall (uwf or iptables). Once you open your website to be discoverable, you need a firewall against malicious hackers. You can research pro’s and con’s of nginx vs apache

- Eg. Google: Ubuntu 22 install nginx with ufw
	- Brief from: https://www.digitalocean.com/community/tutorials/how-to-install-nginx-on-ubuntu-22-04
	- Run `sudo apt update` then `sudo apt install nginx`
	- Then open the ports with `sudo ufw allow 'Nginx HTTP'` and `sudo ufw allow 'Nginx HTTPS'`
	- If the http and https port still don't open up when you ran `sudo ufw status` saying it's inactive, then you should enable the firewall: `sudo ufw enable`. If you can't open the ports because ufw doesn't exist, look up how to install ufw, eg. Google: ubuntu 22 install ufw
	  
- Eg. Google: Ubuntu 22 install apache

2. After you've installed a firewall, do NOT close out your SSH terminal. Check that SSH port 22 is allowed. When using ufw, you'd run `sudo ufw status`

If SSH port 22 is not allowed, you’ve just setup UFW (if had to enable ufw), and you would need to unblock port 22 (SSH) right away so you don’t lose access.

Run the following:
```
sudo ufw allow 22
sudo ufw reload
sudo ufw status
```

4. Test your webserver
Get your public ip address which is not necessarily the ip given to you by the onboarding server server admin.

```
curl -4 ipinfo.io/ip
```
^ This is one of the free services that responds with your ip address

---


### How to select for a Web Hosting Management Panel (Cpanel - monthly; Cloudpanel - free)
- *Background: Btw web hosting management panel is what cpanel refers to their category as. For managing at a bigger level like in WHM, that's web hosting admin panel.*

### **Dedicated Server**: Install a Web Hosting Management Panel
- Eg. ubuntu 22 nginx install cloudpanel
- Free: Ubuntu use cloudpanel. AlmaLinux use webmin
- Not free: Cpanel, Plesk

### How to log into Web Hosting Management Panel (Cpanel, Cloudpanel, etc)
- What’s the link with port number (Different web hosting services may assign different port for your panel). 
 eg. Cloudpanel on Hostinger [https://XX.XXX.XX.XXX:8443](https://XX.XXX.XX.XXX:8443)
- How to navigate to your panel at the Services Dashboard (if you don’t have the link handy)
- what’s their information architecture (to help remember how to navigate there).  
- eg. Hostinger’s: Hostinger believes CloudPanel manages the Ubuntu operating system with the purpose of web site and related services, hence you find CloudPanel under left panel item Settings (think VPS) → Operating System -> then “Manage Panel” button on the OS page
- What are your login credentials?

---

### How to setup web server for basic website viewing
- Basic: We just want to see we can impact how a website looks . We don’t care about SSL Https at this point
- Where in the web hosting panel (cpanel, cloudpanel, etc) does it show you the public IP address you can visit directly in the web browser  
- Where does it give you the default domain (aka temporarily domain)  (eg. srv451789.hstgr.cloud). We want to test we can visit the webpage after uploading files with FTP / vi file from shell / edit file from web hosting management panel. We do not care to visit the desired domain name yet because DNS propagation takes a while.
- What’s the folder path to create/edit index.html to so web browser can see a webpage? Aka root web directory for your website,  Aka working directory for your code and webpages. This is usually the first website you create in your web host panel or the website they already created for you, and their settings show you the associated folder path.  
  Eg. Hostinger Ubunto 22.04 CloudPanel is: `/home/DOMAIN/htdocs/DOMAIN.com`
- Create an index.html either through uploading via FTP, using vi command in shell, or using your web hosting management panel's File Manager.
- See if you can visit that page on the web browser either with the public IP or human readable URL
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

- Anymore you have to edit in the server blocks? Confirm on web browser that you don’t hit this:

```
31.220.18.169 didn’t send any data.

ERR_EMPTY_RESPONSE
```


![](https://i.imgur.com/S5JdFKb.png)


### How to setup SFTP/FTP users
- Where to navigate to adding SSH users? Will those SSH users act as SFTP users?
- Use Filezilla to connect SFTP (SFTP chosen, Port can be empty, Logon Type is Normal)
- Stick with SFTP if possible because it’s more secured.
- If SFTP users unavailable, then where to add FTP users
- Test FTP by seeing if you can upload to it. Doesnt have to be a webpage.

---
### Prepare server for installing different architectures (PHP, NodeJS, Python, MySQL, Mongo, Scaling Solutions)
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

- Know what is the main installer of packages in command line (eg. `sudo apt update`  for Ubuntu 22.04). Save to your web host's details document if it's not something you're intimately familiar with.
- Update installer’s repos 
- Look up instructions for your OS on how to install these language interpreters, if applicable to your server's use cases (these should be installed before installing databases because you'll be testing database connections with code):
	- PHP (if not included by your web host’s PHP)
		- Then if NginX, you would have to setup your server block to send the php files to a PHP interpreter
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
		- Ubuntu v22 with CloudPanel comes with MySQL, however when accessing phpMyAdmin from Cloudpanel then only the databases the user is associated with shows up.
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
		.. Check if ufw firewall is enabled with `sudo ufw status`. If it's enabled, you should open the Mongo port by running `sudo ufw allow 27017`. Check ports allowed by running same `sudo ufw status`
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

### Prepare web server for public - SSL, File Permissions, Security
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
    - Is there a firewall from the web hotsing management panel? or do you have to run ufw?
- Domain name
	- Refer to tutorial on domain and dns editing

### Prepare for web app features
Install ffmpeg, ctypes, imagemagick, and pcregrep for various web apps and their testing of python wrapping ffmpeg and php wrapping imagemagick. Refer to tutorial [[Web app ready - Ffmpeg, cytypes, imagemagick, pcregrep]]

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

Requires password:
```
alias coloa='echo -e "Local: /Users/wengffung/dev/web/weng/tools/\nRemote: /home/.."; sshpass -p "Prq0yIvE" ssh root@XXX.XX.XXX.XX'
```

The password one requires you to install sshpass for your computer (eg. Google: Mac brew install sshpass). The sshpass allows you to have the password in the same command where you place the username and IP address. SSH normally forces you to enter the password after the username and IP address is accepted aka interactive mode.

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


Root web directory is:
..

---

### ACC Web Hosting Panel

- \__which is
- \__login creds
- \__url


\> \__ IA and how to navigate there from Services Dashboard  

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

