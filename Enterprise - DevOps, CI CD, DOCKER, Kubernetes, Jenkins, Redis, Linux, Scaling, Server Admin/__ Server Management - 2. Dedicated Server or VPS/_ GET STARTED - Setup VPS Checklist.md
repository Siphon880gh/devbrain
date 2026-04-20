Written by: Weng
Purpose: General checklist on setting up VPS, regardless if Hostinger or GoDaddy or etc.
****
```toc
```
## Requirement
- Have Web Hosting Control Panel (eg. Hostinger hpanel, WHM, GoDaddy My Products Dashboard)

## Reminder

Create a document for your webhost (eg. GoDaddy, Hostinger, etc) to refer back to as you go through this checklist. Things you can record are credentials, user flows, terminal commands

## Checklist - Web Host to Website Capable

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

### How to decide on a Web Hosting Control Panel 
- Cpanel - monthly pay
- Cloudpanel - free
- Refer to [[Server OS and Control Panel Packages]]

### VPS: How to select/setup the Web Hosting Control Panel (Cpanel, Cloudpanel, etc)
- The hosting provider ...
	- May let you purchase a VPS plan, then let you choose an operating system, web server (Nginx/Apache), and control panel (cpanel, cloudpanel,etc) at any time. You can't even SSH in until you choose an operating system. They will install for you after you made choices. This is Hostinger.
	- May let you purchase a VPS plan that came with installed operating system and web server. However you can choose a control panel at any time. They will install the control panel for you. This is GoDaddy.
	- May let you purchase a VPS with an operating system installed (you choose the operating system as you're purchasing the VPS), and therefore no web server or control panel. And they don't give you options to choose, because they have no auto installation process in place. You have to install the web server and control panel manually via SSH terminal (Hetzner Cloud VPS).
- In the case of having to manually install a **web server and a control panel via SSH terminal**, you treat it as a dedicated server purchase where usually there is no control panel and web server because people buy dedicated servers for different things, not necessarily for website (Eg. Gaming server), so a lot of installations are done through terminal. You'd SSH into your server on your computer's terminal using the ssh command, the IP address of your VPS, and the credentials (whether it's plain password or piping in a SSH key)
- For instructions installing Cloudpanel with Nginx manually via the SSH terminal, refer to [[Manual installation of Cloudpanel via SSH terminal]]

### How to log into Web Hosting Control Panel (Cpanel, Cloudpanel, etc)
- What’s the link with port number (Different web hosting services may assign different port for your panel). 
 eg. Cloudpanel on Hostinger [https://XX.XXX.XX.XXX:8443](https://XX.XXX.XX.XXX:8443)
- How to navigate to your panel at the Services Dashboard (if you don’t have the link handy)
- what’s their information architecture (to help remember how to navigate there).  
- eg. Hostinger’s: Hostinger believes CloudPanel manages the Ubuntu operating system with the purpose of web site and related services, hence you find CloudPanel under left panel item Settings (think VPS) → Operating System -> then “Manage Panel” button on the OS page
- What are your login credentials?


---


### **SSH Root Access** (Option: Handed to you)
- **Dedicated Server only:** It's unlikely there will be a web gui for dedicated server. You'll mostly be interacting with your server via SSH and any web gui's you install. Often times their server administrator will setup SSH IP, root, and password, then hand it to you on email onboarding. You'll also be given a range of ip addresses available. The rest is up to you.
- **VPS only:** See if the webhost handed the SSH Root user credentials to you at the panel that appears after logging into your webhost (eg. Hostinger hpanel, GoDaddy Dashboard). How to navigate to this information?

- If they did not hand it to you, you have to setup SSH root access manually - refer to next section.
- The provider gave you root user credentials - Are you able to login into root at the local machine terminal with SSH?
- Did the provider give you non-root user credentials as well?
	- If they've tightened security, logging into root with ssh command is disabled. The command `ssh root@XXX.XX.XXX.XX` appears to work as usual, and you might not even be privy to it being disabled because it will let you enter a password and all it will ever say is that the password is incorrect. This is by design so that hackers don't get clued in to try gaining access in other ways. This may also be why the provider gave you user credentials.
	- You'd log into the that user with `ssh USER@XXX.XX.XXX.XX`, and once in the remote SSH session, you elevate by running `su`, followed by root user password; then it will switch from the normal user to the root user.
	- To disable or enable root login, refer to [[SSH with Root Login Disabled]]
- Once in remote server, how to navigate to get to your website files using cd commands? (Go into CloudPanel or Cpanel for a clue). Aka root web directory for your website,  Aka working directory for your code and webpages. Alternately you could have in a text document the full path so you can copy and paste the cd path into the terminal. But knowing how to navigate there in terminal can be helpful if you don’t have the full path easily accessible to copy and paste. There will probably be hidden folder .ssh, hidden file .bash_profile, etc, which you can see by running `ls -la`. 
- Using password authentication, run it as: `ssh root@REMOTE_IP -p 22`. Then enter your password when asked. Once that goes through, start to setup SSH key file passwordless login to toughen your SSH security.
- In case you get locked out of SSH, do you know how to access SSH terminal from the webhost's panels? Then you can restore SSH access for your local machine's terminal.
	  
- You could change your root password. Usually the root password handed to you is very randomized and hard to remember.
	- Change your password by running `sudo passwd root`, then you will be prompted for a new password
	- **Dedicated Server only**: Choose a password that's not related to your personal passwords because you may be sharing this password with the web host's server admin when there are problems only they can fix.
  
- **Dedicated Server only**: If splitting the dedicated server, you'll be setting up SSH root access again at your VPS VM at a later section. Various benefits of splitting dedicated server into one or more VPS VM includes one command restart instead of waiting on a ticket to restart dedicated service, isolated VPS that you can troubleshoot when hacked, etc.

### **SSH Root Access** (Option: Manually Setup SSH Root User Credentials)

In the case SSH Root password is not automatically setup and then handed to you, you'd still want to remotely connect to your server to manage files, configuration, and dependencies from our local machine's terminal. The SSH command allows us to do so and there are various ways to authenticate with the SSH command.

Because we don't want hackers just attempting to hack ssh, we're gonna go for passwordless ssh login for authentication method. 

At your local machine, generate a SSH key pair using your email address that you signed up with your VPS for:
- Adjust your email address
```
ssh-keygen -t ed25519 -C "your_email@example.com"
```

At your VPS, for example Hetzner, upload the public SSH key's contents (the text inside the file). This is done through a feature you press like "Add SSH key" (so no need to go into SSH terminal which you don't have access setup for yet). Keep the private and public keys on your computer.

> [!note] UI UX Confusion
> Later, after you add an SSH key, some hosting dashboards still do not clearly show that a key is already on your account. For example, as of April 2026, Hetzner may still show a menu option to create an SSH key, which can make it look like no key exists yet. But when you click that option, it actually takes you to the SSH key list, where your existing public key is shown
>

Once SSH key pair has been established, run this command at your local machine's terminal to test logging into SSH passwordless:
- Adjust private SSH key path and ip
```
ssh -i ~/.ssh/newmac2023_hetzner -p 22 root@5.55.555.555  -tt "cd .  && bash --login"
```

Sysadmin experience:
- You can now cd into a specific folder everytime (adjust the . path)
- You can also setup an alias at your .bash_profile or .z_profile so that running the alias in terminal can log you into ssh. I like to name my alias after my hostname or web host company name.
### Establish rsync connection

Note: Do this only after SSH connection is worked out.

There may be times you want to use rsync to download large files (such as backing up for restoring your server). Rsync can easily handle gigabytes of data. If the download is interrupted, it can resume the download. And - it shows the progress. However the specifics like what the command exactly looks like (authentication method, username, ip, etc) may change depending on environment.

Create a test.txt anywhere in your Linux server file system (doesn't matter if is in the web root), try to tar.gz it up, then exit SSH. Now try to download that tar.gz from remote to local using rsync.

Once the rsync command is figured out, record that to the folder where you save your webhosting credentials. It'd be a document on backup SOP. **Record rsync command**, for example:
```
rsync -avz --partial --progress -e "ssh -i ~/.ssh/some_ssh_key.pub" root@55.555.55.555:/home/wengindustries/htdocs/a.tar.gz . 
```

You may also want to **record the tar commands**. Get the unarchive command (Ask ChatGPT to reverse your command to unarchive).

Progress bar could look like real time text out and replace on the terminal:
```
Transfer starting: 1 files
a.tar.gz
     1066690237  20%    3.51MB/s   00:19:54
```

Now rename the local file then try the other direction - upload to your server. Record the upload rsync command. Could look like:
```
rsync -avz --progress --partial --append b.tar.gz root@31.220.18.169:/home/wengindustries/htdocs
```

Make sure to **record this local upload to remote server** (along with your computer basic stats because the rsync command syntax may differ by OS) in the document too.

---
## Checklist - DNS Purchase then Cloudflare

We will NOT skip this namecheap step anymore because:
![[Pasted image 20260411024546.png]]
A record to sslip.io would be pointless since it will not allow you that flexibility. It will always point to the prefix IP address. **You can skip this entire section DNS purchase then Cloudflare** if you dont plan to go public yet. But dont list your sslip.io URL to the internet. The idea is that Cloudflare will secure your domain address so you will never be able to be attacked directly by your webhost IP (even to the point it overwhelms your CPU and shuts down the server by the massive flood of bots even if you have a firewall on at the server level which is like ufw, well unless your firewall is at the web host level which is the control panel that displays immediately after logging in to your web hots account)

Go to namecheap and buy your domain. Then DO NOT adjust any DNS records. Let's delegate namecheap to cloudflare where you get the benefits of bot protection (recognized abusive IPs and human verify), edge caching, etc

Warning:
Do not ever go public without cloudflare because once your IP is online, hackers can forever attack you directly (unless you rotate out your IP which Hetzner fortunately allows with you purchasing additional addon of floating IP for a few bucks a month)

The rest below are Cloudflare steps. They are not as detailed as my other cloudflare tutorials. It assumes you are somewhat familiar with cloudflare.

Create your Cloudflare account

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

You should see whatever default index.php file is created (as of April 2026, a default index.php file would show "Hello world")

Add some basic security at Cloudflare now, while you're there:
- Allow blocking bot IPs.
- Allow challenges for suspicious visitors.
- Block other countries. Refer to [[Countries - Restrict, block all other countries]]
- At CloudPanel, Security -> Cloudflare: Allow traffic from Cloudflare only


---
## Checklist - Improve Terminal Experience

We will be doing a lot of terminal work to enhance website capabilities for things like NodeJS, Python, etc. We want to make it easier to use the terminal especially since we will keep coming back into it (and re-logging into SSH). Use these items to improve the terminal experience.

For example: Every time I log back into SSH, I don’t want to manually cd into the temp folders in my htdocs just to continue installing and testing the remaining items in this checklist.

### Improved SSH Experience
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
- Adjust the HUD echo, the PRIVATE KEY path, the IP, and the path to cd to
- Tip: Try the command inside the alias before wrapping it as an alias into your bash profile or z profile
```
alias hostinger='echo -e "Local: /Users/wengffung/dev/web/weng/apps/\nRemote: /path/to/apps"; ssh -i ~/.ssh/PRIVATE_KEY -p 22 root@XX.XX.XXX.XX -tt "cd /path/to/apps && bash --login"'
```

For other ways to authenticate with SSH and their aliases, refer to [[OpenSSH Authentication methods into the SSH Terminal and Their Aliases]], however this approach is the most secured already.
  
- Recommended: Disable non-Root Login (SSH and SFTP)
  
  As it is right now, even though you can perform passwordless authentication login with SSH keys, password login still works. Tighten security even more by blocking all non-root password login. 

1. Edit SSH config
```
sudo vi /etc/ssh/sshd_config
```

2. Find or add this line
```
PasswordAuthentication no
```


3. Optional (recommended hardening):
```
ChallengeResponseAuthentication no  
UsePAM no
```

4. Reload SSH:
```
sudo systemctl restart ssh
```

**⚠️ Warning:**
- This disables SSH AND SFTP (Filezilla, etc)
- If you want to re-enable SFTP, at Filezilla use the login method Key File and pair it to the site user's eg. `/home/wengindustries/.ssh` (sibling to htdocs folder; folder path may vary based on OS)
  ![[Pasted image 20260415221207.png]]

- Recommended: Disable Root Login too
  
  Disable root login. The normal SSH authentication flow becomes to login into SSH with a non-root user like `adminuser` OR to login with SSH key pair for the root. Depending which you choose, your SSH access is either limited to the htdocs folder or the entire file system.
  
  The key pairing command SSH authentication is long but you only run it once. The next time your SSH into the IP, it'll refer to the SSH key preferentially. And you can make it less work for you to remember the IP if you alias it.

1. Edit SSH config
```
sudo vi /etc/ssh/sshd_config
```

2. Find or add this line
```
PermitRootLogin no
```

3. Reload SSH:
```
sudo systemctl restart ssh
```


**⚠️ Warning:**
- This disables SSH AND SFTP (Filezilla, etc)
- If you want to re-enable SFTP, at Filezilla use the login method Key File and pair it to the root user's eg. `/root/.ssh` (no sibling htdocs folder because this is the root user; folder path may vary based on OS)
  ![[Pasted image 20260415221207.png]]


**⚠️ Warning:**
If you accidentally locked yourself out because you removed non-root and root password authentication AND your SSH keys are failing, log into your webhost (like Hetzner), and see if they have a console which normally overrides the SSH process. Then make configuration changes you need at `sudo vi /etc/ssh/sshd_config` to recover the server for SSH access.

### Easier file commands
**More Terminal experience improvements:**
1. Are these commonly used cli tools available (use ` --version` to check):
	- `nano`
		- A lot of online instructions use nano
	- `vi`
		- Enable copy-to-clipboard in Vim using your mouse and CMD+C
			  - Open (or create) your `~/.vimrc` file
			- Add this line:
			```
			:set mouse=v
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

---
## Checklist - Enhance Website Capabilities

Now that there's a control panel for your website and your website can be public without your IP address mined by botnets, it's time to enhance the web site capabilities while testing them.
### VPS: How to setup web server for basic website editing and viewing (Multiple sites)
- Basic: We just want to see we can impact how a website looks . We don’t care about SSL Https at this point
- Where in the web hosting panel (cpanel, cloudpanel, etc) does it show you the public IP address you can visit directly in the web browser  
- Where does it give you the default domain (aka temporarily domain)  (eg. srv451789.hstgr.cloud). We want to test we can visit the webpage after uploading files with FTP / vi file from shell / edit file from Web Hosting Control Panel. We do not care to visit the desired domain name yet because DNS propagation takes a while.
- You can **edit the index file** in the Web Hosting Control Panel's File Manager or in the terminal.
	- If in the terminal using vi: For each site on your Web Hosting Control Panel, what’s the folder path to create/edit index.html to so web browser can see a webpage? Aka root web directory for your website, Aka working directory for your code and webpages. This is usually the first website you create in your web host panel or the website they already created for you, and their settings show you the associated folder path.  
- Prepare to visit that website in the web browser to see your changes went through:
	- Edit your virtual host (vhost) configuration so that incoming requests to your server match the requested hostname or domain because once matched, the vhost can route and respond to the request correctly.:
		```
		server_name srv451789.hstgr.cloud;
		```
		- And restart nginx from SSH terminal with `sudo systemctl restart nginx`
		- Visit http://srv451789.hstgr.cloud
		- If success, Chrome will warn you there's no secured connection or that the connection is not private and blocks you from viewing the content. We will add SSL https certificates later. The current bypass technique in 2024 is to click anywhere on the webpage then type: `thisisunsafe`. You should see the webpage content.
	- Use vi command to **create an index2.html**, add some words, then visit directly http://domain.com/index2.html to see if it displays.
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
- Tip: In FileZilla, you may want to open the **Advanced** tab for both your non-root and root connections and set the **default remote directory**. That way, each time you connect, FileZilla opens directly in the folder you actually want to work in instead of making you browse there manually. You can also set the **default local directory** so FileZilla starts in the folder on your computer that you usually upload from.

---

### Prepare web server for basic public view - SSL, File Permissions, Security, Domain Names
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
		- Write down paths to where you record your web-host login, SSH login, etc
	- Multiple domains/subdomains for the same website root (maybe different domains point to deeper folder paths as roots)?
		- Setup server blocks to those domains/subdomains
		- Cloudpanel Let's Encrypt same screen just add all the domains/subdomains. It's a bit of a manual process clicking the input fields and inputting them in. But here's an automated way to fill in those fields using javascript inside the web browser console: [[CloudPanel - SSL Renew Annually (Semi Automated)]]
- Complicated permissions
	- Make sure no excessive permissions like 777 among your files you uploaded to restore your website when setting up the web server
	- User script permissions: if you will have php or python scripts that are triggered by visiting web browser, if it writes to a folder, can it write to it? Otherwise, it’ll be permission error preventing creating files by php script (eg. can it write to a file using PHP's fwrite upon opening that PHP file?)
	- Webpage viewable to public: Make sure it's the official site user that logs into Filezilla when uploading web-site public viewing files (NOT root). Setup and save your login credentials on Filezilla. Otherwise, pages may show up as forbidden on the web browser.
- Install malware and security especially when going public
	- If Hostinger, their malware scanner [https://support.hostinger.com/en/articles/8450363-vps-malware-scanner](https://support.hostinger.com/en/articles/8450363-vps-malware-scanner)
    - How to navigate to the malware from services dashboard (Hostinger hpanel, GoDaddy dashboard, etc)
    - Is malware free, times one payment, or monthly/yearly? Or keep deactivated (often they let you scan but not fix for free)
    - Is there a firewall from the Web Hosting Control Panel? or do you have to run ufw?
- Domain name
	- Refer to tutorial on domain and dns editing. There are many ways to do it. One way is to have namecheap domain with two A records to the public IP of your webhost at "@" and "\*" (unless you want different public ip between www and other subdomains)


---
### ADVANCED WEBSITE: Prepare server for installing different architectures (PHP, NodeJS, Python, MySQL, Mongo, PostgreSQL)

#### Required skills
- Know how to reboot the server per your OS and web server: 
	- eg. `sudo systemctl restart nginx`
- how see error logs based on your OS and web server type  
    - eg `tail -f /var/log/nginx/error.log`
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

##### Install PHP
- PHP (if not included by your web host’s)
	- If installed CloudPanel, PHP comes included. If you don't see PHP, you should create a PHP site off CloudPanel 
	- If not installed CloudPanel and your web host management panel does not come included with PHP, look up how to install php, eg. Google: Ubuntu 22 install php
		- You have to configure apache or nginx to handle php, eg. Google: `Nginx handle php`, eg. Google: `Apache handle php`.
	- If installed Cloudpanel or a Web Hosting Control Panel that already has PHP installed, please skip this step of installing PHP.
	
##### Match PHP Versions

The best practice is to make sure you're using the same PHP that gets called when running the `php` command in terminal and is used to render your php webpages

If the versions don't match you're going to run into problems when enhancing PHP by running command lines then expecting your PHP webpages to get those enhancements.

  - Make sure PHP matches on command line and web version
	  - At a php file:
	```
	<?php
	echo PHP_VERSION;
	```
	- Then view on web browser

	- Run the command line:
	```
	php --version
	```
	- Choose which version to stick to. For example, as of April 15th, there is no MongoDB driver for PHP 8.5 on Debian 12. However there is a MongoDB driver for PHP 8.2 on Debian 12. For that reason, I'd choose Debian 12 for both command line and php versions. 
		- To investigate whether a dependency such as MongoDB is available for one of your latest PHP versions, ask ChatGPT and include the dependency name, the PHP versions installed on your server (from `ls /usr/bin/php*` or the PHP version dropdown in CloudPanel), and mention the OS you are on (eg. Debian 12). Mongo is a good example because in the future you might choose MongoDB as your database while still using PHP. In addition to ChatGPT, you can also check what MongoDB-related PHP packages are available directly on Debian 12 by running `apt search php | grep -i mongodb`, since the package name usually includes both `mongodb` and the PHP version, such as `php8.2-mongodb/oldstable,oldstable,now 1.15.0+1.11.1+1.9.2+1.7.5-1 amd64`. You'd find out that there is no official php8.5-mongodb package for Debian 12 (Bookworm), but the latest php version that does have a mongodb package under Debian 12 is php8.2.
		- You'd install with `sudo apt install php8.2-mongodb` then verify it's installed with `php -m | grep mongodb`. When your PHP script file (eg. index.php or api.php) includes the Mongo driver like `$client = new MongoDB\Driver\Manager($uri)`, it should be no problem if per your selected PHP version, the path to Mongo exists after installing Mongo: `/etc/php/8.2/mods-available/mongodb.ini``
		- Setting the PHP version
			- If setting command line, eg. `sudo update-alternatives --set php /usr/bin/php8.2`
			- If setting web, depends on your setup. For cloudpanel, you dont have to edit anything manually - just select at dropdown:
			  ![[Pasted image 20260415044926.png]]

##### PHP's Composer installed or install now

**What is Composer**
Composer is PHP’s standard dependency manager. It lets you list the libraries your project needs, then installs and updates them for you. Same concept to Node Modules for NodeJS.


**Big Picture:**
- Composer is **installed globally** (the CLI tool)
- Dependencies are **installed per project**. You need the composer CLI tool installed globally so you can run commands at the project level to init or manage.


**Check if you have composer installed globally already**

Cloudpanel? Composer is pre-installed by default on CloudPanel

Find out if you already have composer by running this command:
```
composer --version
```

**Composer Installation Instructions at:**
[[_ Composer - Installation (Debian 12)]]

#### NodeJS

Check/install nodejs, npm (precluded in nodejs), and nvm, following instructions at [[Linux - Install node, npm, nvm (No theory)]]. Since we've chosen PHP application for CloudPanel, there's no NodeJS - and PHP is the right choice because this is the least complicated way to install all the other tech stacks.

pm2 will be installed at a later section called Scaling Solutions.
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

#### Python
- Check if you have python3 installed. It comes included with CloudPanel. Test with `python3 --version`
	- If not installed. Look up how to install: Eg. Google: Ubuntu 22 install python3
- Check if you have pip3 installed. Having python3 installed does not necessarily mean pip3 is installed. Eg. Google: Ubunutu 22 install pip3. Could be something like `sudo apt install python3-pip`. If you have CloudPanel installed, Cloudpanel installed python3, but not pip3, as of Aug 2024.
- ~~OPTIONAL: For legacy code you might need to work on in the future, you should install python2 and pip2 and bench them for when they're needed
	- ~~Could be for python2: `sudo apt install python2`~~
	- ~~Could be for pip2 (notice it's python-pip, not python2-pip): `sudo apt install python-pip`~~
	- ~~You can test they're installed successfully with `python3 --version` and `pip3 --version`~~
	- ==Python 2 reached its **End of Life (EOL)** on January 1, 2020==. Because it is no longer supported, many modern operating systems (like Ubuntu 20.04+ and recent macOS versions) have removed Python 2 and its package manager (`pip`) from their default repositories.
- Check if `python` and `pip` commands work (not limited to running `python3` and `pip`). Run `python --version` and `pip --version` to check if they've been assigned. I recommend assigning them to the newest version of python.
	- Method 1:
	  Edit ~/.bash_profile or equivalent. You can run `which python3` and `which pip3` to get their paths. Then you add to the bash profile similar to `alias python='/usr/bin/python3'` and `alias pip='/usr/bin/pip3'`. Then you source: `source ~/.bash_profile`.
	- Method 2:
	  You can run `which python3` and `which pip3` to get their paths. Then get one of the paths found in `echo $PATH`. Create symbolic links from `python` to `python3` and `pip` to `pip3` in one of the earlier $PATH paths.
- Check if pip will be annoying. Go into a new folder and run:
```
pip install mysql-connector-python
```

If you get this error then you have to configure okay to break out:
```
error: externally-managed-environment

× This environment is externally managed
╰─> To install Python packages system-wide, try apt install
    python3-xyz, where xyz is the package you are trying to
    install.
    
    If you wish to install a non-Debian-packaged Python package,
    create a virtual environment using python3 -m venv path/to/venv.
    Then use path/to/venv/bin/python and path/to/venv/bin/pip. Make
    sure you have python3-full installed.
    
    If you wish to install a non-Debian packaged Python application,
    it may be easiest to use pipx install xyz, which will manage a
    virtual environment for you. Make sure you have pipx installed.
    
    See /usr/share/doc/python3.11/README.venv for more information.

note: If you believe this is a mistake, please contact your Python installation or OS distribution provider. You can override this, at the risk of breaking your Python installation or OS, by passing --break-system-packages.
hint: See PEP 668 for the detailed specification.
```

^ If that's the case, then config python to allow possible breaking of python:
```
mkdir -p ~/.config/pip  
vi ~/.config/pip/pip.conf
```

Add to pip.conf:
```
[global]
break-system-packages = true
```

#### MySQL
- MySQL (if not included by your web host’s VPS)
	- If not installed CloudPanel or a web host management panel that includes these parts, look up instructions on how to install MySQL, PHP, and PHPMyAdmin. eg. Google: Ubuntu 22 install mysql phpmyadmin
	- Ubuntu v22 with CloudPanel comes with MySQL, PHP, and phpMyAdmin, however when accessing phpMyAdmin from Cloudpanel then only the databases the user is associated with shows up.
		- To get the master credentials to see all databases, you run `clpctl db:show:master-credentials` and visit this url to login with those credentials https://XX.XXX.XX.XXX:8443/pma or https://domain.tld:8443/pma. If behind Cloudflare, 8443 is one of the supported ports so you should be able to access via the domain name too
		- Test the same master credentials on the Mysql command:
		  `mysql -h 127.0.0.1 -u root -P 3306 -p -A`
			- Enter password when prompted to
		- Save credentials, PMA link, and MySQL command to your webhost document and possibly save to an alias that echoes credentials and then logs in via ssh/sshpass.
	- Test MySQL phpMyAdmin (if not done from previous CloudPanel step)
		- What's the URL to phpMyAdmin? If needed, can we make it show all the databases instead of only some databases (databases associated to one user) at phpMyAdmin?. 
		- If Cloudpanel:
			- The login to the phpMyAdmin (PMA) that asks you through the browser native prompt is the same as the master credentials
			- The URL is in this format:
				```
				https://domain.tld:8443/pma	
				```
		- Save phpMyAdmin URL and credentials to web host details document
	- Test MySQL daemon
		- Run `mysql --version`

##### Test MySQL on PHP
- OPTIONAL: Test PHP wrapping MySQL works. You can write this php file then either run in web browser (visit appropriate URL on web browser) or terminal (`php script.php`)
- Make sure to adjust user and password

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
##### Test MySQL on NodeJS
But if you want to test NodeJS connecting to MySQL:
```
const mysql = require("mysql2");
	
const connection = mysql.createConnection({
  host: "127.0.0.1",
  user: "YOUR_USERNAME",
  password: "YOUR_PASSWORD",
  database: "mysql",
  port: 3306
});

function showAllRows() {
	connection.query(
	  "SELECT * FROM user"
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

^ Proof this would work:
	- ![[Pasted image 20260414134454.png]]

##### Test MySQL on Python
- And if you want to test Python connecting to MySQL:
	- Make sure to have installed mysql connector:
	  `pip install mysql-connector-python`
	- Make sure to adjust user and password
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

##### Test MySQL on Python Flask
- And if you want to test Python's Flask connecting to MySQL:
- Make sure to have installed dependencies
	- `pip install flask`
	- `pip install flask-mysqldb`
- Make sure to adjust user and password
- DO NOT name your python script `flask.py` because it'll complain of circular import
- Test by visiting the port mentioned by the flask to terminal output at https//domain.tld:5000/ which is just fine because our endpoint for reading the database after seeding it is `/`
- Make sure port not blocked by ufw etc
```
from flask import Flask, jsonify
from flask_mysqldb import MySQL

app = Flask(__name__)

app.config["MYSQL_HOST"] = "127.0.0.1"
app.config["MYSQL_USER"] = "root"
app.config["MYSQL_PASSWORD"] = "PASSWORD"
app.config["MYSQL_DB"] = "mysql"
app.config["MYSQL_PORT"] = 3306
app.config["MYSQL_CURSORCLASS"] = "DictCursor"

mysql = MySQL(app)

@app.route("/")
def users():
    cur = None
    try:
        cur = mysql.connection.cursor()
        cur.execute("SELECT * FROM user")
        rows = cur.fetchall()

        for row in rows:
            for key, value in row.items():
                if isinstance(value, bytes):
                    row[key] = value.decode("utf-8", errors="replace")

        return jsonify(rows)
    except Exception as e:
        return jsonify({"error": str(e)}), 500
    finally:
        if cur:
            cur.close()

if __name__ == "__main__":
	# app.run(debug=True)
    app.run(host="0.0.0.0", port=5000, debug=False)
```

You want to visit the api endpoint in the web browser. If using Cloudflare, you either will reverse proxy it or use the free Cloudflare tunneling because you can't fetch custom ports on Cloudflare proxy protected websites. Or you can switch to DNS-only instead of Proxy at Cloudflare, but that could expose your VPS ip address (if the domain has already been on a botnet before, don't switch to DNS because they will continue to hack you directly once they detect your IP). For Cloudflare tunneling to work, you should use a subdomain, you must not have a DNS record to that subdomain, you must not have SSL certificate for that subdomain, and if your tech stack has access to routing to localhots or to the internet then it must be internet (dont use Flask's `host="0.0.0.0"`)
#### Mongo
- Installation
	- See if you have mongo already installed `mongo --version` or `mongosh --version`, as long as one of them works. Cloudpanel does NOT come with Mongo.
	- Look up instructions how to install MongoDB: 
	  eg. Google: Ubuntu 22 install mongo. 
		 - There are a lot of steps—follow the full MongoDB installations (not going to repeat it in this tutorial)
			 - Ubuntu 22/24: https://www.mongodb.com/docs/manual/tutorial/install-mongodb-on-ubuntu/
			 - Debian 12: https://www.mongodb.com/docs/manual/tutorial/install-mongodb-on-debian/
			   
			- Enable for reboot startup with: `sudo systemctl enable mongod`
			- In many cases, system needs to reboot or mongod will be in a failed state. Run `reboot` and then try to ssh back in after a couple minutes
			- Check status of mongodb:
				```
				# sudo systemctl status mongod
				> ● mongod.service - MongoDB Database Server
				Loaded: loaded (/usr/lib/systemd/system/mongod.service; disabled; preset:
				Active: active (running) since Mon 2025-07-07 00:01:49 UTC; 3s ago
				```
				
			    
			 - Prevent future mongod service failures,
				 - FYI, in a future server reboot, all MongoDB connections could fail with the error "Failed to unlink socket file" with status 14 at `sudo tail -n 200 /var/log/mongodb/mongod.log`. This is because Mongodb installation does not set the correct permissions for it to carry out some cleanup tasks (as of April 2026. It'd fail to cleanup an old socket file because it would be owned by root rather than the user mongodb.
				  - Ensure that the /tmp directory has the correct permissions: 
				    `sudo chmod 1777 /tmp`
				- And for other permission errors in the future (this is automatically fixed on installing as of April 2026 though but used to be a problem on older MongoDB's) 
					- Check the ownership of MongoDB directories: 
					   `ls -la /var/lib/mongodb /var/log/mongodb`
					- If not owned by user/group mongodb:mongodb, then run:
					  `sudo chown -R mongodb:mongodb /var/lib/mongodb /var/log/mongodb`
				  - Actually check MongoDB service and see if it's dead. If it's dead, go ahead and remove (`sudo rm -f /tmp/mongodb-27017.sock`), then restart the mongod (so it recreates a new socket into memory) `sudo systemctl restart mongod` 
					 
	- Record what's the mongo shell command? May want to add to your web host details document because it can be different from OS to OS and version to version. 
		- MongoDB 3.4 unofficial and below, run`mongo` for mongoshell
		- **Above Mongo 3.4** unofficial, run `mongosh` for mongoshell
		- If Mongo community version (maintained by the official Mongo organization), run `mongosh` while `mongod` service has started
	- Mongo service further check
		- **What's the command to check status**? Record as well
		- Make sure to reboot to check that the mongo service sticks (running mongo shell works). After reboot, check the service status.
		- Also figure out the commands for: How to stop mongo service? How to restart mongo service? 
		- How to check the logs for service starting errors (Eg. Ubuntu 22 is `sudo tail -n 100 /var/log/mongodb/mongod.log`)
		- Optional: Save these commands to your web host details document.

	- Create an authentication account on the auth collection
		- DO IMMEDIATELY. Often the bots are scanning new websites for mongo database, then you'll be surprised in Mongo Compass when all your collections disappeared and in their place is an obviously inserted collection with text stating to pay a bitcoin wallet for your data back. Typically it happens in minutes. So dont even migrate data in yet until you add authentication account
	  
		- Go into Mongo Shell (`mongo` or `mongosh`), switch into admin collection (run `use admin`), then run this to create user
			- WARNING: DO NOT create a username named "root". Some Mongo versions already created a root user to work with test as the authentication database, and it causes conflicts like the mongo invoke command saying incorrect credentials but the interactive authentication passing
			- Create user while inside admin collection (Adjust to prefer username and password):
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


- Then record the mongo shell login command and url login commands

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

	- Restart mongo service so the settings apply (or use your equivalent mongo restart command):
	```
	sudo systemctl restart mongod
	```

- Test you can be denied access without the correct authentication:
	- 1. Run `mongo` or `mongosh` depending on the version of mongo
	- 2. You'll notice you successfully got into the Mongo shell; However, run `show databases;` while in the unauthenticated Mongo Shell, it will error: `**MongoServerError[Unauthorized]** ...` .

- **Record** authenticated login shell command and URL into your web host details documents
	  
- Decide whether to open the Mongo to remote IPs (you'll have production apps) or keep local. If you open to remote IPs, then you can connect from your Mongo Compass. The inner steps here are to enable for remote IPs / Mongo Compass

	 1. Enabling external connections (and Mongo Compass) at the service level
		By default `/etc/mongod.conf` settings allow files on the same host as the mongo server to connect (127.0.0.1, aka localhost). Let's open Mongo to the internet/world.
		Edit your `/etc/mongod.conf`:
		
		```
		   net:
			 bindIp: 0.0.0.0
		```

	2. Restart mongo service so the settings apply (or use your equivalent mongo restart command):
	```
	sudo systemctl restart mongod
	```

	3. Enabling external connections (and Mongo Compass) at the OS level
	   If you have firewall (either uwf or iptables), you have to allow in internet 0.0.0.0 into port 27017:
		- Check if ufw firewall is enabled with `sudo ufw status`. If it's enabled, you should open the Mongo port by running `sudo ufw allow 27017`. Check port allowed rules by running same `sudo ufw status`. Apply the rules immediately with `sudo ufw reload`.
		- Check if iptables is managing firewall by running `sudo iptables -L -v -n` to see if there are any port rules which implies that iptables is enabled. Note that there doesn't need to be a iptables service for this firewall to work because iptables works at the kernel level. 
			- If it's enabled, you should open the Mongo port by running `sudo iptables -A INPUT -p tcp --dport 27017 -j ACCEPT`. No need to reboot; Rules are hot applied right way. Check ports allowed by running `sudo iptables -L -n`.

- Test MongoDB with authentication account works on Python or NodeJS:
##### Test MongoDB on Python
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

Errors? Refer to troubleshooting guides:
- [[Socket File Error (Troubleshooting MongoDB on Python)]]
- [[Permission Errors (Troubleshooting MongoDB on Python)]]
##### Test MongoDb on NodeJS

Optionally, test NodeJS:
Create a test.js then run `node test.js` after you've installed `npm init && npm install mongodb`:
- Make sure to adjust username and password
```
const { MongoClient } = require('mongodb');  
  
// Replace these with your actual MongoDB username and password  
const mongoUser = 'USERNAME';  
const mongoPassword = 'PASSWORD';  
const dbName = 'admin'; // Use your database name  
  
const uri = `mongodb://${mongoUser}:${mongoPassword}@localhost:27017/?authSource=${dbName}`;  
const client = new MongoClient(uri);  
  
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

##### Test MongoDb on PHP
- Let's test PHP will be able to connect to Mongo. This is more involved.

Create a test.php then run both command and web versions:
- Make sure to adjust username and password
```
<?php

$mongoUser = 'USER';
$mongoPassword = 'PASSWORD';
$authSource = 'admin';

$uri = "mongodb://$mongoUser:$mongoPassword@localhost:27017/?authSource=$authSource";

try {
    $client = new MongoDB\Driver\Manager($uri);

    $command = new MongoDB\Driver\Command([
        'listDatabases' => 1
    ]);

    $cursor = $client->executeCommand('admin', $command);
    $result = current($cursor->toArray());

    echo "Connected successfully. Databases:\n";

    foreach ($result->databases ?? [] as $db) {
        echo " - " . ($db->name ?? '[unknown]') . "\n";
    }

} catch (Throwable $e) {
    echo "Failed to connect: " . $e->getMessage() . "\n";
}
```

Problems? First make sure PHP cli and PHP web are the same PHP versions! Refer to PHP installation earlier in this checklist. And make sure it's a PHP version that has a Mongo release.
- To investigate whether a dependency such as MongoDB is available for one of your latest PHP versions, ask ChatGPT and include the dependency name, the PHP versions installed on your server (from `ls /usr/bin/php*` or the PHP version dropdown in CloudPanel), and mention the OS you are on (eg. Debian 12). Mongo is a good example because in the future you might choose MongoDB as your database while still using PHP. In addition to ChatGPT, you can also check what MongoDB-related PHP packages are available directly on Debian 12 by running `apt search php | grep -i mongodb`, since the package name usually includes both `mongodb` and the PHP version, such as `php8.2-mongodb/oldstable,oldstable,now 1.15.0+1.11.1+1.9.2+1.7.5-1 amd64`. You'd find out that there is no official php8.5-mongodb package for Debian 12 (Bookworm), but the latest php version that does have a mongodb package under Debian 12 is php8.2.
- You'd install with `sudo apt install php8.2-mongodb` then verify it's installed with `php -m | grep mongodb`. When your PHP script file (eg. index.php or api.php) includes the Mongo driver like `$client = new MongoDB\Driver\Manager($uri)`, it should be no problem if per your selected PHP version, the path to Mongo exists after installing Mongo: `/etc/php/8.2/mods-available/mongodb.ini``

If still have problems, refer to [[Indepth Installation Guide - Mongo for PHP]]


#### PostgreSQL

Check whether PostgreSQL is already installed:

```bash
psql --version
```

If it is not installed on Debian or Ubuntu:

```bash
sudo apt update
sudo apt install postgresql postgresql-contrib
```

Enable PostgreSQL to start on boot:

```bash
sudo systemctl enable postgresql
```

Check whether the service is running:

```bash
sudo systemctl status postgresql
```

**PostgreSQL service and access basics**

To open the PostgreSQL shell as the default superuser:

```bash
sudo -u postgres psql
```
^ **`-u postgres`** tells `sudo` to switch to the **`postgres` system user** (instead of root)


Should you worry about the postgres super user? No worries:
- The **`postgres` database user does NOT use a password locally**
- It uses **peer authentication** (trusts the OS user)

To restart PostgreSQL:

```bash
sudo systemctl restart postgresql
```

To quickly inspect PostgreSQL logs if something is failing:

```bash
sudo tail -n 100 /var/log/postgresql/postgresql-*.log
```

**Create authentication right away**

Just like other databases, PostgreSQL should not be left wide open. Create your application user and database early so you are not building against the default superuser workflow longer than necessary.

Create the user with a password:
- Note you must have quotes for the USER so that it's case sensitive, otherwise the username would be stored all lowercase. When logging in later with that username, it won't let you know if it's mistyped or misspelled.
```sql
CREATE USER "{USER}" WITH PASSWORD "{PASSWORD}";
```

Check that the username is what you expected (because of the lowercase/uppercase nuance):
```
\du
```
^ Means display users

Create the database:

```sql
CREATE DATABASE myapp_db;
```

Grant database privileges:

```sql
GRANT ALL PRIVILEGES ON DATABASE myapp_db TO "{USER}";
GRANT ALL ON SCHEMA public TO "{USER}";
```

A user needs `CREATE` on the database to create a schema, and `CREATE` on the target schema to create tables there. The current user is actually `postgres`, so we need to reassign the database's owner and it's NOT enough to just grant privileges:
```
ALTER DATABASE myapp_db OWNER TO "{USER}";
```

**Verify login from the command line**

Exit the psql shell (`exit` or `\q`), then test logging in as that application user.
- Note if you mistyped the username, it won't let you know that because it'll just be a password authentication failed error

```bash
psql -h 127.0.0.1 -U "{USER}" -d myapp_db
```

Use `-h 127.0.0.1` on purpose. That forces a TCP connection instead of a Unix socket, which helps avoid authentication confusion when testing.

**If having problems authenticating:**
- Check if the username was created with case sensitivity (if surrounded by quotes) or automatically all lower case (no quotes).
- Check authentication method in settings. Refer to ____

**Once connected, run a few quick checks:**

```sql
SELECT NOW();
SELECT current_user;
SELECT current_database();
```

You can also test with a one-liner from the shell:

```bash
psql -h 127.0.0.1 -U myapp_user -d myapp_db -c "SELECT NOW();"
```


**Quick test table**

To test inserts and reads, create a simple table:

```sql
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(255)
);
```

##### **Test PostgreSQL on Node.js**

Install the PostgreSQL driver:

```bash
npm install pg
```

Seed and read example:
```js
const { Client } = require('pg');

const client = new Client({
	host: '127.0.0.1',
	user: 'YOUR_USERNAME',
	password: 'YOUR_PASSWORD',
	database: 'myapp_db',
});

async function seed() {
  // 🔥 Drop table if it exists
  await client.query(`DROP TABLE IF EXISTS users`);

  // 🏗️ Recreate table
  await client.query(`
    CREATE TABLE users (
      id SERIAL PRIMARY KEY,
      name VARCHAR(100),
      email VARCHAR(255)
    )
  `);

  // 🌱 Seed data
  await client.query(
    `INSERT INTO users (name, email)
     VALUES ($1,$2), ($3,$4), ($5,$6)`,
    [
      'Abby', 'abby@example.com',
      'Bobby', 'bobby@example.com',
      'Caitlin', 'caitlin@example.com'
    ]
  );

  console.log('Seed complete');
}

async function read() {
  const result = await client.query('SELECT * FROM users');
  console.log(result.rows);
}

async function main() {
  try {
    await client.connect();
    await seed();
    await read();
  } catch (err) {
    console.error(err);
  } finally {
    await client.end();
  }
}

main();
```

##### **Test PostgreSQL on Python**

Install the driver:

```bash
pip install psycopg2-binary
```
^ Psycopg is the most popular PostgreSQL database adapter for the Python programming 
^ **`psycopg`** doesn’t stand for something clean like an acronym—it’s a **name mashup**:
- **“psyc”** → from **Python** (historically referencing “psyco,” an old Python performance project)
- **“o”** → - Filler to make the name pronounceable → _psy-co-pg_
- **“pg”** → short for **PostgreSQL**

Seed and read example:

```python
import psycopg2

conn = psycopg2.connect(
    host="127.0.0.1",
    user="YOUR_USERNAME",
    password="YOUR_PASSWORD",
    dbname="myapp_db"
)

cur = conn.cursor()

cur.execute("DROP TABLE IF EXISTS users")

cur.execute("""
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(255)
)
""")

cur.execute("""
INSERT INTO users (name, email)
VALUES (%s,%s), (%s,%s), (%s,%s)
""", (
    "Abby", "abby@example.com",
    "Bobby", "bobby@example.com",
    "Caitlin", "caitlin@example.com"
))

conn.commit()

cur.execute("SELECT * FROM users")
print(cur.fetchall())

cur.close()
conn.close()
```

##### **Test PostgreSQL on PHP**

Install the PostgreSQL extension:

```bash
sudo apt install php-pgsql
```


Seed and read example:

```php
<?php

$conn = pg_connect("host=127.0.0.1 dbname=myapp_db user=YOUR_USERNAME password=YOUR_PASSWORD");

if (!$conn) {
    die("Connection failed\n");
}

// Delete table if it already exists
pg_query($conn, "DROP TABLE IF EXISTS users");

// Create table
pg_query($conn, "
    CREATE TABLE users (
        id SERIAL PRIMARY KEY,
        name VARCHAR(100),
        email VARCHAR(255)
    )
");

// Seed data
pg_query_params(
    $conn,
    "INSERT INTO users (name, email) VALUES ($1,$2), ($3,$4), ($5,$6)",
    [
        'Abby', 'abby@example.com',
        'Bobby', 'bobby@example.com',
        'Caitlin', 'caitlin@example.com'
    ]
);

echo "Seed complete\n";

// Read data
$result = pg_query($conn, "SELECT * FROM users");

while ($row = pg_fetch_assoc($result)) {
    print_r($row);
}

pg_close($conn);
```

Either run with `php -f test.php` or open the webpage on a web browser.

---
### ADVANCED WEBSITE: Versioning, CI/CD, Scaling

Let's install these versioning and CI/CD solutions:

---
#### Git
- Make sure there is git on your system
	- Some systems come with git. Check out by running `git --version`
	- If git is not included, lookup instructions how to install git on the system
		- eg. Google: Ubuntu 22 install git
	- Verify installation successful: `git --version`
	- Install gh because that's needed to forcefully authenticate for git (if authentication becomes stale and authorized commands like git push fails). Lookup instructions on how to install gh on the system eg. Google: Ubuntu 22 install gh
	- Setup identification for git commands (or you'd be annoyed about it later when using git):
	```
	git config --global user.name "Your Name"
	git config --global user.email "youremail@domain.com"
	```

	- **Github**: Setup authorization for git commands
	  
	  1. Check if server `ls ~/.ssh` has .pub files and similarly paired file without the ".pub" file extensions (Those are the public and private keys, respectively). If not, generate a public/private key referring to:
	  https://docs.github.com/en/authentication/connecting-to-github-with-ssh/generating-a-new-ssh-key-and-adding-it-to-the-ssh-agent
		- Make sure the email address is the one used to sign into Github

		```
		ssh-keygen -t ed25519 -C "your_email@example.com"
		```

	  2. Add public key to your Github account, referring to: https://docs.github.com/en/authentication/connecting-to-github-with-ssh/adding-a-new-ssh-key-to-your-github-account
		  1. Click New SSH key at https://github.com/settings/keys
		  2. Paste the contents of the public key (eg. id_ed25519.pub) and save as a SSH key, recommended naming the key after your server provider name for organizing purposes.

	3. Point `git` command to your private SSH key file. Set it once and forget it.
	   - Edit: `~/.ssh/config`
	   - Add:
		```
		Host github.com  
		  HostName github.com  
		  User git  
		  IdentityFile ~/.ssh/my_key  
		  IdentitiesOnly yes
		```
	- Now all Git operations to GitHub will use that key automatically.


	- **Gitlab**: Setup authorization for git commands
		- Refer to Github section
		- Copy contents of the pub file (same pub file for Github and Gitlab) into Gitlab
		- Add gitlab to `~/.ssh/config` in a similar fashion as how you added github.

	- **Preferred terminal editor**: Is git using your preferred terminal text editor (default may be vi or nano)
		- To test: Run this at a git repo - `git rebase -i HEAD~2` to any cloned repo or your own repo at the remote server, and then see what terminal text editor opens
		- If you need to set a preferred terminal text editor: [[Git set which terminal text editor to use]]
#### Docker
- Make sure docker is on your system
	- Test for docker: `docker --version`
	- Lookup instructions how to install docker on the system
		- eg. Google: Ubuntu 22 install docker
		  https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-on-ubuntu-22-04
		  eg. Google: Debian 12 install docker
		  https://docs.docker.com/engine/install/debian/#install-using-the-repository
		- Note instructions differ from Mac because on Mac the recommended approach is Docker Desktop which bundles in a daemon better than installing independent packages with homebrew can.
	- Don't forget to test if Docker installed successfully: `docker --version`
	- Docker compose installation instructions: ... docker-compose-plugin ? which makes not just docker-compose possible but `docker compose build` possible because of the plugin making docker aware of compose
#### Scaling Solutions
- Look up instructions for your OS on how to install these scaling solutions, if applicable to your server's use cases
	- Balancers and multi workers:
		- **For persistent NodeJS**: pm2
			- Refer to the tutorial [[Installing PM2 and Configuring Nginx for Multiple Node.js Applications (Shortcut)]] even if you're not on nginx (the first sections will be applicable before the section on applying it to nginx)
		- **For persistent Python**: Supervisor, virtual envs, gunicorn and flask
			- Refer to [[Supervisor Primer - GET STARTED - Alternately, Install Everything.md]] which includes supervisor, gunicorn, flask, pyenv, pyenv-virtualenvs, pipenv. There it will install all the dependnecies
				- [ ] pyenv
				- [ ] pyenv-virtualenvs
				- [ ] pipenv
				- [ ] flask
				- [ ] gunicorn
				- [ ] supervisor
		- Turn on any scaling/persistence that is usually ON in your older server:
			- Docker or supervisor to restart your api app on crashes (either server crash or app crash)
				- Docker: [[Docker Primer - Get Started]]
				- Supervisor etc: [[Supervisor Primer - GET STARTED (Python stack with Sh, Pyenv-virtualenvs, Pipenv, Gunicorn)]]]]
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

As you install additional dependencies, make sure to document them in the same place where you keep your server login details, paths, and configuration notes. You can refer back to your list of dependencies when you migrate or clone your setup to another server later. This may also be a good place to write what local app scripts or published apps (with users) that need their paths updated if the server hostname changes. This document could be named: acc Web App Dependencies and URLs

---
## Checklist - Improve Future Developer Experience

Because your server is setup to handle many different tech stacks, you're probably the type of developer that will touch different stacks at different points of your career. Let's improve the developer experience so it's easy to manage such complexity

1. Tech folders
   Create folders that have symbolic links to your pm2 apps, your gunicorn apps, etc possibly named by their port numbers. Create a symbolic link to your supervisor app configs at the root (as siblings to whatever your app/ or apps/ folder is at)

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

2. Better git experience
   Create git aliases that make it easier to add/commit, see diff, and check logs. Instructions at [[Git Sugar Aliases - Small Tweaks That Make Git on the Command Line Better]]


---
## ACC - Template to track all your credentials, folder paths, file paths in your web host details document

**ACC stands for Account. It's Weng's notation for saving login credentials, key OS, key configuration information, etc**

**Keep below ACC's that are at the same level of hierarchy as separate sections in a mega ACC document**

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

Command SSH alias:
```
```

---


### ACC Provider Checklist / Statements of Facts

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

### ACC Folder structure

- Recommend have separate folders for pm2/nodejs and for python/supervisor apps
	- If for the URL you prefer all apps regardless of language belongs to one folder, eg. /app, then have the other language-based folders symbolically link, eg. /nodejs/app1 -> /app/app1
- Recommend Supervisor app config files be named with the port number ranges they use
- May have a root folder /keys that have important keys for all your apps but make sure is blocked from being visited on the web browser. It's safer if you have a build script that saves the env keys to your .bash_profile, then re-source, instead.

### ACC OS paths (error logs, configs), commands, and workflows

...

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


---

### ACC PostgreSQL

Login/pass:

Superuser (peer via being the root user on OS):
```
sudo -u postgres pqsl
```

PSQL Shell:
```
..
```

---

## acc Domain Vhost Backup _DATE_

**(Separate Document from the mega document with multiple ACC sections)**

Date: `<Date>`
Have: Eg. Metabase and VLAI Microservices with SSE connections

```
Vhost file contents here
```

Additional included vhost files here. Then use headings and subheadings so that a table of contents is possible in Obsidian or Markdown rendered, to navigate to different Vhosts

Alternately, you could just backup as vhost files near where your pm2 is inside a centralized eco/ folder (make sure to block public web access). In that case, write it so under the document so you can remember to refer to the files

---
## acc Domain Site Backup SOP

**(Separate Document from the mega document with multiple ACC sections)**

Write how to backup the domain in this SOP document, such as the different database backups (MySQL, MongoDB), file backups (or bare minimum with state data files while you have the original app code elsewhere on the computer), eco/ backup, vhosts, root SFTP SSH, and site username, and SSL domains/subdomains, etc.

Any username used by the terminal to create or modify files through PHP or Python scripts must also be updated.

Prepend document that this is useful for migrating to another server too.

Useful to tar up entire root folder for backup and restore:

**Tar command:**
```
tar -czvf a.tar.gz wengindustries.com/
```

**Rsync command (download remote -> local):**
```
rsync -avz --partial --progress -e "ssh -i ~/.ssh/newmac2023_hostinger.pub" root@55.555.55.555:/home/wengindustries/htdocs/a.tar.gz .
```

**Rsync command (upload local -> remote):**
```
rsync -avz --progress --partial --append -e "ssh -i ~/.ssh/newmac2023_hostinger.pub" b.tar.gz root@55.555.55.555:/home/wengindustries/htdocs
```
Local computer (for command variance): MacBook Pro 2021

---
## acc UFW Open Ports

**(Separate Document from the mega document with multiple ACC sections)**

8443 PMA Php MyAdmin and CloudPanel
80
443
27017 MongoDB

---

## acc Web App Dependencies and URLs

**(Separate Document from the mega document with multiple ACC sections)**

...

---
## acc Exiting Protocol

**(Separate Document from the mega document with multiple ACC sections)**

List backup and cleanup procedures here if discontinuing service.