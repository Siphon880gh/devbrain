
Written by: Weng
Purpose: General checklist on setting up Dedicated Server. Likely there will be no web hosting admin panel (eg. Hostinger hpanel, WHM, GoDaddy My Products Dashboard)

```toc
```

## Reminder

Create a document for your provider / webhost (eg. GoDaddy, Hostinger, etc) to refer back to as you go through this checklist. Things you can record are credentials, user flows, terminal commands

## Checklist

### Prepare your web host details document
- Besides credentials, there are commands, os specs, and other details you want to save somewhere about your web host that you may need to reference later

### What’s the appropriate Company and Dedicated Server package
- RAM, number of cores, storage space, etc. 
- Create a guide on how to communicate your full stack app or business use cas:, simultaneous users, memory use by the process and memory,  bandwidth use, storage disk space, etc to a server specialist that can decide the package and maybe install the architecture in the terminal.
- Does pricing include cpanel and os license?
	- Cpanel requires monthly payments and some Linux distros also require monthly payments. Or choose a free web hosting control panel and free linux distro? Downside of free may be lack of features and/or more custom terminal command work. Eg. Ubuntu 22 with CloudPanel
- If rented colocation (may have to ask their sales / support / etc)
	- Do we have an online remote access tool like IPMI (Intelligent Platform Management Interface) so we can do recovery, reinstallation, etc. Otherwise we have to ask support team to reinstall which could take hours and have our website downtime for hours.
	- Is there hardware virtualization supported on the CPU? This lets me create VMs that act like VPS, so I can house all business logic in the VPS and restart the VPS from my dedicated server SSH. Crashes would affect the in-housed VPS instead of the dedicated server. This prevents having to rely on the support team and I can get right to restarting, minimizing downtime. 
		- If there's hardware virtualization, is KVM (kernel) type of hardware virtualization supported? That's faster than the other types of hardware virtualization
		- How many VMs are supported with our current cpu cores and threads? For calculations, refer to [[Calculating number of VMs supported]]
		- If there's no hardware virtualization, is the server specs fast enough for OS based virtualization into VPS?
- Setup billing auto renewal?

### How to select for OS and identify package installer
- They usually install for you so you choose the OS
	- Ubuntu has many things setup to work for Linux admin
	- Debian is barebones and require some setup (installing sudo, etc) but has so much more hard disk available for you and less CPU use
- And then find out what the package installer is based on the OS name (Search Google)
	-  Eg., Google: Ubuntu package installer
	- For Ubuntu, it’s apt
- You will update the package installer's repository source lists because you just had a fresh installation

---

### Managing your dedicated server
Likely your dedicated server does not have a web host admin panel (Hostinger hpanel, GoDaddy’s dashboard, etc). So figure out the processes other than having a GUI:
- What email to reach out to for managing billing information
- How to start a support ticket (probably email and they have a system where when the ticket is closed, that email thread will be ignored). If email, what information do they need.
- For your chosen OS, how to restart OS, and how to check if a service restarted with the OS?
- What commands to list server’s hardware specs (in case don’t have when making future business migration decisions)
-  Save the above information into your web host details document

---

### Login Entry Point: SSH in
- In place of a webhost admin panel or services dashboard, you'll mostly be interacting with your server via SSH and any web gui's you install. Often times their server administrator will setup SSH IP, root, and password, then hand it to you. The provider's server administrator that onboards you may also give you the range of ip addresses available for you to use. The rest is up to you.

Are you able to login into root at the local machine terminal with SSH?
- Did the provider give you non-root user credentials as well?
	- If they've tightened security, logging into root with ssh command is disabled. The command `ssh root@XXX.XX.XXX.XX` appears to work as usual, and you might not even be privy to it being disabled because it will let you enter a password and all it will ever say is that the password is incorrect. This is by design so that hackers don't get clued in to try gaining access in other ways. This may also be why the provider gave you user credentials.
	- You'd log into the that user with `ssh USER@XXX.XX.XXX.XX`, and once in the remote SSH session, you elevate by running `su`, followed by root user password; then it will switch from the normal user to the root user.
	- To disable or enable root login, refer to [[SSH with Root Login Disabled
- So save to your web host document, your ssh credentials as the primary login. And, also save the available ip's for use (if given to you)
	- If the available ip addresses are given to you in the form of CIDR, eg. XXX.XX.XXX.XX/29, you may want to work out the available IP addresses, then save to your document the network address, useable ip addresses, and broadcast address
	  
- You could look up how to change your root password for your OS, eg. Google: Ubuntu 22 change root password. Usually the onboarding server admin gives you a very randomized password that's hard for you to remember (you may be prompted for passwords multiple times running sudo).
	- Change your password by running `sudo passwd root`, then you will be prompted for a new password
	- Choose a password that's not related to your personal passwords because you may be sharing this password with the web host's server admin when there are problems only they can fix.

- Once in remote server, usually there is nothing much to navigate to get to your website files. There will probably be hidden folder .ssh, hidden file .bash_profile, etc, which you can see by running `ls -la`. You likely have to install nginx or apache from scratch, then setup root web directory for your website, Aka working directory for your code and webpages. 

### Dedicated Server: Is Linux Admin Ready?
- With dedicated server, they might install a bare bones OS version. This means some commands you expect to help with Linux administration like sudo might be missing! Package installer might be missing sources to search packages from. 
- This is especially true for Debian 12, etc. although it's performant because it's bare minimum. In that case, refer to the folder to finish setting up the OS so you can admin the server properly: [[Debian breaking into new shoes]]


---

### Dedicated Server: Split Dedicated Server into VPS
Do your own the dedicated server or are you renting it from a colocation?

If renting: When you reinstall the server (often times you're setting up the dedicated server from scratch and you mess up locking yourself out, you ask support team to reinstall the server), there could be hours of downtime while waiting on support team.

If you virtualized a VM in the form of a VPS inside the dedicated server, then you can isolate these lockouts to the VPS. Then from within the dedicated server, you have the ability to reinstall / restore the VPS without needing to contact support.

If you want this ability: First you need to find out if you will perform OS virtualization or hardware virtualization (the faster). Then with hardware virtualization, are we performing KVM hardware virtualization (the fastest) or other types of hardware virtualizations. In addition, you have to find out if the dedicated server is itself virtualized by the provider, then is nested virtualization enabled. All these questions should've been asked to the provider before deciding on the dedicated server.

BACKGROUND KNOWLEDGE: In order to know how to virtualize VMs, you need to understand the concepts at: [[Splitting Dedicated Server into VPS (via VMs) - Fundamental Concepts]]

BACKGROUND KNOWLEDGE: You also need to understand some basic Networking because you will have to setup the internet traffic flow to your VMs that act as VPS and know how to setup DHCP to assign the VPS public IPs that the internet network understands.

And to find out if your dedicated server can support the VM - say the customer support or sales team won't elevate your questions - you can find out through command line (and hopefully you are not locked into a one year contract): [[Splitting Dedicated Server into VPS (via VMs) - Find out if can support]]

ACTION: Once you found out the right type of virtualization and that it'll be performant, you'll look up guides on how to perform the virtualization on your OS. You do this before installing any web servers, etc. For example, eg. Google: Ubuntu 22 KVM virtualization. Some other tools could be Cockpit, Proxmox, Xen

For example, This is a guide for Xen (type 1 hypervisor, no KVM): [[Setup XEN VMs (Type 1 Hypervisor, no KMV) - Part 1]]


---

### **Dedicated server**: Install Web server (Nginx vs Apache) VS Install CloudPanel Instead

By purchasing a dedicated server, it can become whatever server you want it to be (gaming server, blockchain server, website server). It won't be able to host websites out of the box though.

In order to have a website people can visit and a setup that makes it easy for the web developer to manage the website, you have to install a web server, FTP, and a webhost panel. You can first  install the webserver

**MAJOR CHECKPOINT**
Do you plan to install the web hosting panel CloudPanel? It is best to install WITHOUT nginx having been installed. In that case, skip to the next section "How to decide on a Web Hosting Management Panel...". Proof per their documentation's instructions: "For the installation, you need an empty server with Ubuntu 24.04 or 22.04 or Debian 12 or 11 with root access." (https://www.cloudpanel.io/docs/v2/getting-started/other/). This means you DO NOT install nginx or any web server. The CloudPanel will install nginx and other technologies with it. If you messed up, CloudPanel will still work but `apt` could potentially always bother you about an incomplete Cloudpanel post installation script, you could potentially have to add www-data to every new group that is created when you create a new site, just so webpage can show and many cloudpanel features work for that site. In addition, Cloudpanel logs can keep complaining about a half-configured cloudpanel. Cloudpanel would still work, however. It's because Cloudpanel's nginx couldn't replace your nginx that already exists, so the post installation script can never finish.
- TLDR: If doing Cloudpanel, forego installing nginx because Cloudpanel will install it for you.
- Otherwise, there may be weird error logs and extra steps for every new site you create (www-data added to new group). Cloudpanel will still work.
- Cloudpanel has no clean way of uninstallation or reinstallation as of 8/2024 and the recommended route is to reinstall your entire server.


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
	- Brief from: https://www.cloudpanel.io/docs/v2/getting-started/other/. Notice the URL; Look up if there are newer versions of the documentation. Make sure you're not following an old version's instructions, like v1
	- The instructions could be (Cloudpanel installations is missing the step of stopping the services):
		1. You must stop all port 80, 443, and 3306, if they've been installed (Ideally, they were never installed because Cloudpanel installs best on an empty system). Otherwise, when it installs Cloudpanel it will say the ports are in use. Run those that are applicable:
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
- Figure out if the web hosting management panel included other techs so you dont have to install them later. Cloudpanel-MySQL installation should include MySQL and PHP. You can find out for example by running:
	- `mysql --version`
	- `php --version
	- `which nginx`
	- If MySQL installed (which is on CloudPanel unless you installed with their MariaDB option). FYI: You may poke around CloudPanel's core files and see a db.sq3 file. CloudPanel uses SQLite3 internally but installs MySQL for web developer use. 
		- To get the master credentials to see all databases, you run `clpctl db:show:master-credentials` and visit this url to login with those credentials 
			- https://XX.XXX.XX.XXX:8443/pma
		- Save the MySQL URL and credentials into your webhost details document. If you have an alias for quick SSH login, you might want to also save it as an echo before the ssh or sshpass command.

### How to log into Web Hosting Management Panel (Cpanel, Cloudpanel, etc)
- What’s the link with port number (Different web hosting services may assign different port for your panel). 
  eg. Cloudpanel on Hostinger [https://XX.XXX.XX.XXX:8443](https://XX.XXX.XX.XXX:8443)
- What are your login credentials?
- VPS: How to navigate to your panel at the Services Dashboard (if you don’t have the link handy)
	- what’s their information architecture (to help remember how to navigate there).  
	- eg. Hostinger’s: Hostinger believes CloudPanel manages the Ubuntu operating system with the purpose of web site and related services, hence you find CloudPanel under left panel item Settings (think VPS) → Operating System -> then “Manage Panel” button on the OS page
- Save the web hosting management panel URL and credentials into your web host details document. If you have an alias for quick SSH login, you might want to also save it as an echo before the ssh or sshpass command.


---

### How to setup web server for basic website editing and viewing (Default site)
- **CHECKPOINT**: If you installed nginx stone alone, you can perform this step. If you installed Cloudpanel to include nginx, then there is no default site - Skip to Multiple Sites (next section).
- Basic: We just want to see we can impact how a website looks . We don’t care about SSL https at this point
- Identify what's the public IP address you can visit directly in the web browser (usually given to you by your onboarding server admin)  
- What’s the folder path to create/edit index.html to so web browser PRE web hosting management panel? Aka root web directory for your website, Aka working directory for your code and webpage.   
	- For the default site:
		- You figure out where the root is, possibly editing with `vi /etc/nginx/sites-enabled/default` then looking for the line with `root`, which has the path
		- List the files at that root working directory for some form of index file, eg. `ls var/www/html`
		- Then edit the page with possibly: `vi /var/www/html/index.nginx-debian.html`. You can add a word or punctuation then see if visiting the public IP in the web browser shows the change.
		- Use vi command to create an index2.html, add some words, then visit directly http://IP/index2.html to see if it displays.
		- If still problems viewing the page, refer to [[Troubleshooting - Nginx webpage not showing]]
	- That was editing and viewing for the default site, next we will cover editing and viewing for multiple sites
### Dedicated Server: How to setup web server for basic website editing and viewing (Multiple sites)
- For a site created / listed in your web hosting management panel. Eg. Hostinger Ubuntu 22.04 CloudPanel
- If no website exists in the web hosting management panel, add a website (If unsure what type of website, I recommend PHP site). Otherwise pay attention to the name of the website in the web hosting management panel
- Figure out what's the folder path to that website on your system. Could be `/home/DOMAIN/htdocs/DOMAIN.com`
  ^ You can `ls /home/` to figure out the path
  ^ You figure it out because you should add it to your webhost details document and your ssh/sshpass echo

- Using vi command in shell, or using your web hosting management panel's File Manager, edit the index file adding a word or punctuation and see if visiting the URL will show the changes.  The index file could be `/home/DOMAIN/htdocs/DOMAIN.com/index.php`
- Because you are on a dedicated server, it is likely that the web host DOES NOT provide you with a user domain name (eg. srv451789.hstgr.cloud on Hostinger Cloudpanel package) that you can match in one of the server blocks in a site's vhost. Make sure you've bought a domain at namecheap, etc. Then make sure you have two A records to the public domain: one for "@" and one for "\*". At your CloudPanel site's vhost, update the server_name to the domain name, eg. `server_name domain.com`
- Visit your http://domain.com directly. 
- If success, Chrome will warn you there's no secured connection or that the connection is not private and blocks you from viewing the content. We will add SSL https certificates later. The current bypass technique in 2024 is to click anywhere on the webpage then type: `thisisunsafe`. You should see the webpage content.
- Use vi command to create an index2.html, add some words, then visit directly http://domain.com/index2.html to see if it displays.
	- If failed, because it says Access Denied on the web browser, fix the permissions, making the bad index2.php permissions match the good index.php permissions. Likely it's just the user and group that are problematic.
	- Keep in mind that when you upload files via SFTP later, this will be the user you sign into Filezilla, etc's SFTP. This makes sure uploads are the correct permissions. 
	- If passed, this then assumes future websites on CloudPanel will have no problem with editing and viewing by the internet. 
- Optional: If you want to continue testing other sites on CloudPanel, you could use other domains at namecheap etc creating A record to the same public IP. Or if you run out of domains, you can create subdomains under one domain, creating CName to the public domain name. For more information on A records and Cnames, refer to [[DNS Domain PRIMER]]. Make sure a site's vhost at your web host catches what servername (subdomain and/or domain and tld) is hoisted by the internet connecting to your public IP.

- Troubleshooting: Visiting the domain doesnt work
	- Make sure at namecheap, etc you have A records to the public IP using `@`. Then have another A record to the public IP using "\*" instead of "www" so that any subdomains. You can check if the DNS propagation for A records pointed to your public IP at whatsmydns.
	- Make sure it's not a caching issue if whatsmydns shows it's propagated but the page still doesn't show: Open in Incognito.
	- Make sure file permissions correct for various paths of your sites and nginx. Refer next section's "Cloudpanel vhost 500 error is because of file permission problems"
	- Try typing with page clicked: `thisisunsafe`
	- If still problems viewing the page, refer to [[Troubleshooting - Nginx webpage not showing

## Test web hosting management panel

Because you installed the web hosting management panel yourself rather than being on a VPS that installed it for you, there could be broken chains. Check Cloudpanel throughly to see it works:

Briefly:
- Check if Cloudpanel Vhosts can save
- Check that you can create free SSL with Let's Encrypt inside CloudPanel

- I. Check if Cloudpanel Vhosts can save (feel free to add a space at a whitespace area, then click Save)
  
  Quick outline of Vhost not saving errors:
  - If gives a "redirect loop detected" error
  - If gives a 404 Let's Encrypt error
  - If goes to 500 internal server Let's Encrypt error
  - Vague general error that something went wrong when saving Vhost
  	  
	- If gives a "redirect loop detected" error:
			```
			www.videolistings.ai: Domain could not be validated, error message: error type: urn:ietf:params:acme:error:connection, error detail: 208.76.249.75: Fetching https://www.domain.com/.well-known/acme-challenge/zU7VjGctj6VPEv1eR_HtEjq-e54zb_39pHNOFygQGD8: Redirect loop detected
			```
		- Notice it said Redirect loop detected. It’s because the Let’s Encrypt is visiting to a www.
		- This will correlate to visiting http://www.domain.com giving this error:
			![](https://i.imgur.com/v3Cnk6m.png)
		- Solution:
			1. Remove this server block (feel free to backup to your some document if you’re concerned)
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
					return 301 https://www.videolistings.ai$request_uri;  
				}
				```
			1. Comment out https scheme rewrite at the other block
			```
			#if ($scheme != "https") {  
			#  rewrite ^ https://$host$request_uri permanent;  
			#}  
			```
			
			2. At your main server block for 80 and 443, add the www (See server_name line):
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
				  server_name videolistings.ai www1.videolistings.ai www.videolistings.ai;  
				  {{root}}
				  # ...
				```

			3. At your 8080 port server block, also do the same:
				```
				server {  
				  listen 8080;  
				  listen [::]:8080;  
				  server_name videolistings.ai www1.videolistings.ai www.videolistings.ai;  
				  {{root}} 
				  # ...
				```

	- If gives a 404 Let's Encrypt error:
			```
			app.videolistings.ai: Domain could not be validated, error message: error type: urn:ietf:params:acme:error:unauthorized, error detail: 208.76.249.75: Invalid response from http://domain.com/.well-known/acme-challenge/hj0GXFJ_sW2VzVOjxxYaeyp9AXnPyz800-C3WL0zgEU: 404
			```
		- **Solution 1 to 404 Let's Encrypt error**: 
		  See if can recreate the folder path and add a file to see if you can visit it on your web browser. The folders are missing because the way Let's Encrypt works is it creates the folders and file then removes them.
				- Make sure you've cd into your document root. Then create a file from here:
				```
				mkdir -p .well-known/acme-challenge/
				vi .well-known/acme-challenge/test.txt
				```
				- Add some unique text in the file. Then visit the link in your web browser
				- If successfully visited, then this solution isn't it. Before going to "Solution 2", remove the test file and folders leading to it with
				```
				rm -rf .well-known
				```
		- **Solution 2 to 404 Let's Encrypt error**: 
		  Did you modify the server root manually so that another folder is served?
				- Set it back to the original document root for now because CloudPanel creates the .well-known/... path to the document root that had been saved into Cloudpanel (instead of reading the vhost).
				  ^  Dont forget to change it at both 80/443 server block and 8080 block.
			- Once SSL is done generating, you can change the document root back to your desired location. Don’t forget to change it at both 80/443 server block and 8080 block.
		
	- If goes to 500 internal server Let's Encrypt error:

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
				chmod 755 -R /etc/nginx/sites-enabled; chmod 755 -R /etc/nginx/sites-enabled; chown root:root -R /etc/nginx/sites-enabled; chown root:root -R /etc/nginx/sites-enabled;
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

	- Vague general error that something went wrong when saving Vhost
		- Check syntax where the nginx primary config combines with site's vhost by running
		```
		sudo nginx -t
		```
	
		- If you get an "Unknown log format", refer to fix at [[Nginx Troubleshooting - Unknown log format]]

- II. Check that you can create free SSL with Let's Encrypt inside CloudPanel
	- REQUIREMENT: Your A records are pointing to the public IP and have propagated already.
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
	- CloudPanel's Let's Encrypt SSL failing? Refer to section "Test web hosting management panel" -> ~ SSL
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
### ADVANCED WEBSITE: Prepare server for installing different architectures (Languages: PHP, NodeJS, Python, MySQL, Mongo, Scaling Solutions; Pipes: Git, Docker; Scaling Solutions)
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
	- PHP (if not included by your web host’s)
		- If installed CloudPanel, PHP comes included. If you don't see PHP, you should create a PHP site off CloudPanel 
		- If not installed CloudPanel and your web host management panel does not come included with PHP, look up how to install php, eg. Google: Ubuntu 22 install php
		- If installed Cloudpanel or a web hosting management panel that already has it setup for you, you can also skip this step:
		  You have to configure apache or nginx to handle php, eg. Google: `Nginx handle php`, eg. Google: `Apache handle php`.
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
		- Sometimes npm comes with nodejs. Check if it did install: `npm --version`. If not, see if npm installation instructions are at the same guide for installing nodejs. Otherwise, look up how to install npm. eg. Google: Ubuntu 22 install npm
			- Check `npm --version` and `npx --version` (npx helps forcefully run)
		- Prevent npm scripts having no file permission:
			- Check npm version with `npm --version`
			- If the version is v7 or v8 families, then NodeJS switches user to the user owning the folder to the package.json when running npm script which is not desirable in most cases (you would prefer to keep the same user that runs the npm script `npm run scriptX`) and usually causes file permission problems when running a npm script
				- Then you install nvm to install and change the node version. Then you make it permanent beyond your current shell session. Refer to the tutorial [[NVM - npm scripts say permission denied on the cli command]]
	- Yarn
		- Eg. Google: Ubuntu 22 install yarn
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

		If PHP connecting to MySQL works (most commonly used case), then it's assume Python and NodeJS will connect with no problems. 
		
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


	- MySQL phpMyAdmin
		- What's the URL to phpMyAdmin? If needed, can we make it show all the databases instead of only some databases (databases associated to one user) at phpMyAdmin?
		- Save phpMyAdmin URL and credentials to web host details document
	- MongoDB
		- Look up instructions how to install MongoDB: 
		  eg. Google: Ubuntu 22 install mongo
		- What's the mongo shell command? May skip adding to your web host details document. 
		  
		  MongoDB 3.4 and below, run`mongo` for mongoshell
		  Above Mongo 3.4, run `mongosh` for mongoshell
		  
		- Check if mongo service is running? 
		- Make sure to reboot to check that the mongo service sticks (running mongo shell works). Eg. google: ubuntu 22 how to reboot

		- Also figure out the commands for: How to stop mongo service? How to restart mongo service? How to check the logs for service starting errors (Eg. Ubuntu 22 is `sudo tail -n 100 /var/log/mongodb/mongod.log`)
		
		- Save these commands to your web host details document.
		- 
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

	  1. Add public key to your Github account, referring to: https://docs.github.com/en/authentication/connecting-to-github-with-ssh/adding-a-new-ssh-key-to-your-github-account
		  1. Click New SSH key at https://github.com/settings/keys
		  2. Paste the contents of the public key (eg. id_ed25519.pub) and save as a SSH key, recommended naming the key after your server provider name for organizing purposes.

- Make sure docker is on your system
	- Lookup instructions how to install docker on the system
		- eg. Google: Ubuntu 22 install docker
		  https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-on-ubuntu-22-04

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
$ PROVIDER_NAME
Local: /Users/local_username/dev/web/weng/apps/
Remote: /home/XXX/public_html/apps
---------------------------------------------------
VPS console in from host shell: `sudo xl console vps0`
VPS console exit back to hots shell: CTRL + ]
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

Root web directory is:****
..

How to change password:
`sudo passwd root` OR UI: ...

---

### ACC Mounted VPS
hostname: .. 
bridge: xenbr0
public ip: ..

user: ..
password: ..
SSH in from local computer: 
```
ssh root@208.76.249.75
```


Console in from host shell: 
```
sudo xl console vps0
```

Installation Summary (xen-create-image):
```
Installation Summary  
---------------------  
Hostname        :  vps0  
Distribution    :  bookworm  
MAC Address     :  00:..  
IP Address(es)  :  dynamic  
SSH Fingerprint :  SHA256:... (DSA)  
SSH Fingerprint :  SHA256:... (ECDSA)  
SSH Fingerprint :  SHA256:... (ED25519)  
SSH Fingerprint :  SHA256:... (RSA)  
Root Password   :  <IMPORTANT>
```



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

## OS paths (error logs, configs), commands, and workflows

_...?