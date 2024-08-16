
Written by: Weng
Purpose: General checklist on setting up VPS, regardless if Hostinger or GoDaddy or etc.

```toc
```
## Requirement
- Have web hosting admin panel (eg. Hostinger hpanel, WHM, GoDaddy My Products Dashboard)

## Reminder

Create a document for your webhost (eg. GoDaddy, Hostinger, etc) to refer back to as you go through this checklist. Things you can record are credentials, user flows, terminal commands

## Checklist

### Prepare your web host details document
- Besides credentials, there are commands, os specs, and other details you want to save somewhere about your web host that you may need to reference later

### What’s the appropriate package and plan
- RAM, number of cores, storage space, etc. 
- I will create a guide on how to communicate our full stack app’s use case, simultaneous users, memory use by the process and memory,  bandwidth use, storage disk space, etc to a server specialist that can decide the package and maybe install the architecture in the terminal.
- Does pricing include cpanel and os license?
	- Cpanel requires monthly payments and some Linux distros also require monthly payments. Or choose a free web hosting control panel and free linux distro? Downside of free may be lack of features and/or more custom terminal command work. Eg. Ubuntu 22 with CloudPanel
- Setup billing auto renewal?

### How to select for OS
- They usually install for you so you choose the OS
	- Ubuntu has many things setup to work for Linux admin
	- Debian is barebones and require some setup (installing sudo, etc) but has so much more hard disk available for you and less CPU use
- And then find out what the package installer is based on the OS name (Search Google)
	-  Eg., Google: Ubuntu package installer
	- For Ubuntu, it’s apt
- You will update the package installer's repository source lists because you just had a fresh installation

---

### Managing your VPS
Likely your VPS has a web host admin panel (Hostinger hpanel, GoDaddy’s dashboard, etc). So figure out how to navigate it:
- Where to manage billing information
- For your chosen OS, how to restart OS, and how to check if a service restarted with the OS?
- Where to find server’s hardware specs (in case don’t have when making future business migration decisions)

### Login Entry Point: How to log into Service Dashboard (Hostinger hpanel, GoDaddy’s dashboard, etc)
- Save to your webhost details document the URL to the services dashboard and the credential information.

---

### How to decide on a Web Hosting Management Panel (Cpanel - monthly; Cloudpanel - free)
- *Background: Btw web hosting management panel is what cpanel refers to their category as. For managing at a bigger level like in WHM, that's web hosting admin panel.*

### VPS: How to select the Web Hosting Management Panel (Cpanel, Cloudpanel, etc)
- The webhost might have offered OS options separately from the VPS options or it might have offered options of OS and webhost management panel combo's.

### How to log into Web Hosting Management Panel (Cpanel, Cloudpanel, etc)
- What’s the link with port number (Different web hosting services may assign different port for your panel). 
 eg. Cloudpanel on Hostinger [https://XX.XXX.XX.XXX:8443](https://XX.XXX.XX.XXX:8443)
- How to navigate to your panel at the Services Dashboard (if you don’t have the link handy)
- what’s their information architecture (to help remember how to navigate there).  
- eg. Hostinger’s: Hostinger believes CloudPanel manages the Ubuntu operating system with the purpose of web site and related services, hence you find CloudPanel under left panel item Settings (think VPS) → Operating System -> then “Manage Panel” button on the OS page
- What are your login credentials?


---

### **VPS**: How to setup SSH root access
- Is this at the Services Dashboard (aka Hostinger hpanel, GoDaddy Dashboard) or the web hosting panel (cPanel, cloudpanel, etc)
	- What’s their information architecture (to help remember how to navigate there).
- How to access web browser SSH Root terminal navigating the Services Dashboard or the web hosting panel
	- In case you need to quick and dirty in the future
	- What’s their information architecture (to help remember how to navigate there).
- Are you able to login into root at the local machine terminal with SSH?
- Did the provider give you non-root user credentials as well?
	- If they've tightened security, logging into root with ssh command is disabled. The command `ssh root@XXX.XX.XXX.XX` appears to work as usual, and you might not even be privy to it being disabled because it will let you enter a password and all it will ever say is that the password is incorrect. This is by design so that hackers don't get clued in to try gaining access in other ways. This may also be why the provider gave you user credentials.
	- You'd log into the that user with `ssh USER@XXX.XX.XXX.XX`, and once in the remote SSH session, you elevate by running `su`, followed by root user password; then it will switch from the normal user to the root user.
	- To disable or enable root login, refer to [[SSH with Root Login Disabled]]
- Once in remote server, how to navigate to get to your website files using cd commands? (Go into CloudPanel or Cpanel for a clue). Aka root web directory for your website,  Aka working directory for your code and webpages. Alternately you could have in a text document the full path so you can copy and paste the cd path into the terminal. But knowing how to navigate there in terminal can be helpful if you don’t have the full path easily accessible to copy and paste.
- Run it as: `ssh root@REMOTE_IP -p 22`. Then enter your password when asked.

---
### VPS: How to setup web server for basic website editing and viewing (Multiple sites)
- Basic: We just want to see we can impact how a website looks . We don’t care about SSL Https at this point
- Where in the web hosting panel (cpanel, cloudpanel, etc) does it show you the public IP address you can visit directly in the web browser  
- Where does it give you the default domain (aka temporarily domain)  (eg. srv451789.hstgr.cloud). We want to test we can visit the webpage after uploading files with FTP / vi file from shell / edit file from web hosting management panel. We do not care to visit the desired domain name yet because DNS propagation takes a while.
- You can edit the index file in the web hosting management panel's File Manager or in the terminal.
	- If in the terminal using vi: For each site on your web hosting management panel, what’s the folder path to create/edit index.html to so web browser can see a webpage? Aka root web directory for your website, Aka working directory for your code and webpages. This is usually the first website you create in your web host panel or the website they already created for you, and their settings show you the associated folder path.  
- Prepare to visit that website in the web browser to see your changes went through:
	- Edit the vhost to your site such that:
	```
	server_name srv451789.hstgr.cloud;
	```
	- And restart nginx from SSH terminal with `sudo systemctl restart nginx`
	- Visit http://srv451789.hstgr.cloud
	- If success, Chrome will warn you there's no secured connection or that the connection is not private and blocks you from viewing the content. We will add SSL https certificates later. The current bypass technique in 2024 is to click anywhere on the webpage then type: `thisisunsafe`. You should see the webpage content.
	- This then assumes future websites on CloudPanel will have no problem with editing and viewing by the internet.

### How to setup SFTP/FTP users
- Makes life easier for web developers.
- Skip FTP: It's strongly recommended you use SFTP instead. You can setup FTP capability then leave the port off or on as a backup. Refer to: [[Setup FTP and SFTP]]
- SFTP: 
	- If not CloudPanel: [[Setup FTP and SFTP]]
	- If CloudPanel: [[CloudPanel - Setup SFTP users]]

---

### Prepare web server for basic public view - SSL, File Permissions, Security
- Do you have to setup SSL?
	- Free vs Paid SSL
		- You can get a free SSL with Let's Encrypt. Look up instructions how to run Let's Encrypt in your SSH.
		- You can also buy SSL which gives you certain advantages over SSL, and some businesses must have a paid SSL as regulation.
	- Figure out workflow to acquire and install SSL because you'll be doing this annually. Also perform it now
		- If CloudPanel, it's very simple going to the site -> SSL/TLS -> Actions -> New Let's Encrypt Certificate (however you must have a domain connected to that website already because it'll create a file then access that file through your domain URL to prove your ownership then generates the certificate).
		- If less obvious how and where to install SSL HTTPS certificates: Contact customer support or google Web host + OS + Nginx/Apache + Install SSL certificates. If the web host is not well known (very independent), google for: OS + Nginx/Apache+ Install SSL certificate
	-  CloudPanel's Let's Encrypt SSL failing? Refer to section "Test web hosting management panel" -> ~ SSL
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
    - Is there a firewall from the web hosting management panel? or do you have to run ufw?
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

- Know what is the main installer of packages in command line (eg. `sudo apt update`  for Ubuntu 22.04). Save to your web host's details document if it's not something you're intimately familiar with.
- Update installer’s repos 
- Look up instructions for your OS on how to install these language interpreters, if applicable to your server's use cases (these should be installed before installing databases because you'll be testing database connections with code):
	- PHP (if not included by your web host’s PHP)
		- Then if NginX, you would have to setup your server block to send the php files to a PHP interpreter
	- Python: 
		- Check if you have python3 installed. It comes included with CloudPanel. Test with `python3 --version`
			- If not installed. Look up how to install: Eg. Google: Ubuntu 22 install python3
		- Check if you have pip3 installed. Having python3 installed does not necessarily mean pip3 is installed. Eg. Google: Ubunutu 22 install pip3. Could be something like `sudo apt install python3-pip`. If you have CloudPanel installed, cloudpanel
		- For legacy code you might need to work on in the future, you can similarly look up instructions how to install python2 and pip2
			- Could be for python2: `sudo apt install python2`
			- Could be for pip2 (notice it's python-pip, not python2-pip): `sudo apt install python-pip`
			- You can test they're installed successfully with `python3 --version` and `pip3 --version`
		- Set aliases to `python` and `pip`. Run `python --version` and `pip --version` to check if they've been assigned. I recommend assigning them to the newest version of python. Edit ~/.bash_profile or equivalent
	- NodeJS
		- Eg. Google: Ubuntu 22 install nodejs
		- npm will come with nodejs
		- Prevent npm scripts having no file permission:
			- Check npm version with `npm --version`
			- If the version is v7 or v8 families, then NodeJS switches user to the user owning the folder to the package.json when running npm script which is not desirable in most cases (you would prefer to keep the same user that runs the npm script `npm run scriptX`) and usually causes file permission problems when running a npm script
				- Then you install nvm to install and change the node version. Then you make it permanent beyond your current shell session. Refer to the tutorial [[NVM - npm scripts say permission denied on the cli command]]
	- Yarn
		- Make sure Node is at least v20.11.0 to install a newer yarn (https://www.redswitches.com/blog/install-yarn-in-ubuntu/), otherwise look up classic yarn installation instructions.
			- Install npm's repo corepack (tool to help with managing versions of your package managers) which allows you to install yarn
			- Follow each step to install latest yarn:
				```
				sudo npm install -g corepack
				corepack enable
				corepack prepare yarn@stable --activate
				yarn --version
				yarn set version stable
				```

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

		If PHP connecting to MySQL works (most commonly used case), then it's assume Python and NodeJS will connect to MySQL with no problems
			  
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
  

Choose alias strategy depending on your method of login

- SSH (interactive password)
	```
	alias coloa='ssh root@XXX.XX.XXX.XX'
	```

	- You won't have to copy and paste the public IP or memorize it.
	- But you'll be prompted interactively to enter your password. If you want an even more streamlined developer experience, check out the next alias strategy.

- SSHPass (workaround to interactive password)
```
alias coloa='echo -e "Local: /Users/wengffung/dev/web/weng/tools/\nRemote: /home/.."; sshpass -p "YOUR_PASSWORD" ssh root@XXX.XX.XXX.XX'
```
- You don't have to memorize or copy and paste the public IP or the password
- Downside is you need to install sshpass because ssh command forces you to interactively enter a password. Look for installation instructions. eg. Google: Mac brew install sshpass

- Passwordless Authentication (aliased path to private key)
```
alias hostinger='echo -e "Local: /Users/wengffung/dev/web/weng/tools/\nRemote: /home/XX/htdocs/YY.com/"; ssh root@REMOTE_IP -p 22 -i ~/.ssh/PRIVATE_KEY'
```

- If you want the tightest security, you have paired SSH keys. The ssh command requires you to enter the path to the SSH private key on your local computer. But with an alias, you won't have to copy and paste the private key path or memorize it.
  
- SSH with Root Login Disabled

	If you tightened security, you have in the settings block `ssh root@XXX.XX.XXX.XX`. It would still let interactively ask for the password but will always say incorrect password (does not give hint that root ssh login has been disabled because you don't want to let the hackers know to attempt other methods)
	
	The normal authentication flow is to login into SSH with a non-root user. Then while inside the remote SSH shell, you run `su` and enter the root password to login into root.
	
	However it may be annoying to remember or copy and paste or memorize two separate passwords from text files. 
	
	You can setup alias on the local machine to perform SSHPass into the non-root user, in addition to first echoing the root password. Then at your remote server, you could run `su` and copy and paste the root password from the same terminal. Another way is to install the package `expect` at the remote server that lets you write a shell script to automatically enter the password when the expected prompt is "Password:"

When you reinstall the server (often times you're setting up the dedicated server from scratch and you mess up locking yourself out, you ask support team to reinstall the server), the SSH fingerprint changes. This will cause SSH to deny the connection due to a mismatch with the fingerprint stored in the `~/.ssh/known_hosts` file. You would remove the old SSH fingerprint (has the webhost domain name or webhost public IP), then re-attempt to connect with SSH to be asked to accept the new fingerprint.

If using sshpass, it won't ask you interactively to accept new fingerprint, and therefore you can't connect to the reinstalled server. Either run normal ssh command when the server is reinstalled, or come up with an alias for normal ssh for your webhost (eg. if your webhost company is called coloa).

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

---

### ACC Web Hosting Management Panel

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


## OS paths (error logs, configs), commands, and workflows
_...?