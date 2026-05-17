This is the migration and backup plan for moving to another web host or clean slate, transferring over the same app files, dependencies, database structure, configurations, etc as the older website.

Hint: Fill in placeholders with actual values once you personalize this template document into a record document for your new webhots.

How to use for instructions: Turn on floating Table of Contents.

---

## Review Cloudflare

If you decided to delay Cloudflare and wanted to setup the rest of the website first, this is a good time to setup Cloudflare. Refer back to the VPS/dedicated server's checklist for the Cloudflare section.

## Initial Items

This Migration SOP is dual purpose:
- Write how to backup the domain in this SOP document, such as the different database backups (MySQL, MongoDB), file backups (or bare minimum with state data files while you have the original app code elsewhere on the computer), eco/ backup, vhosts, root SFTP SSH, and site username, and SSL domains/subdomains, etc.
- Reference SOP when have to restore the old server's files, databases, configurations, etc into a new web hots

Any username used by the terminal to create or modify files through PHP or Python scripts must also be updated.

Useful to tar up entire root folder for backup and restore.

Make sure the dependencies are already installed (Instructions at [[Web app ready - Ffmpeg, cytypes, imagemagick, pcregrep]]):
	- ffmpeg, ctypes: videolisting saas
	- imagemagick: screenshot apps (in the future, stocks)
	- pcregrep: more flexible regexp in php for coder searching notebook brains, sleep logs, etc

## Backup/Restore Website Files via FTP/SFTP

Restore procedures (Reverse them for backing up)

Actually instead of FTP/SFTP, we'll use rsync because it's faster. To make it even faster, we archive into one file tar.gz so it's not multiple files that have to transfer.

**IF UNABLE / NOT USING TAR:**
- Recreate web root content including app/ folder
- Recreate keys/ that is outside the web root
- Migrate data: balance
- Migrate data: many prn

**IF USING TAR:**
1. move wengindustries.com/hosted/ hosted folder to outside because it's too much to tar (containing gigabytes of pictures for personal and published notes)
2. tar-download/untar-upload: wengindustries.com/ (that which contains app/)
3. tar-download/untar-upload: keys/ (sibling of wengindustries.com/)
4. tar-download/untar-upload: hosted/.. then move the hosted folder back into wengindustries.com/ folder

**COMMAND REFERENCES (FOR IF USING TAR):**

**Tar command (archive):**
```
tar -czvf a.tar.gz wengindustries.com/
```

**Tar command (unarchive)**
```
tar -xzvf a.tar.gz
```

**Rsync command (download remote -> local):**
At local computer's terminal, not ssh logged in:
```
rsync -avz --partial --progress -e "ssh -i ~/.ssh/WEBHOST_OLDER.pub" root@55.555.55.555:/home/wengindustries/htdocs/a.tar.gz .
```

```
rsync -avz --partial --progress -e "ssh -i ~/.ssh/WEBHOST_OLDER.pub" root@11.111.11.111:/home/wengindustries/htdocs/a.tar.gz .
```

```
rsync -avz --partial --progress -e "ssh -i ~/.ssh/WEBHOST_NEWER.pub" root@5.55.555.555:/home/wengindustries/htdocs/a.tar.gz .
```

**Rsync command (upload local -> remote):**
```
rsync -avz --progress --partial --append -e "ssh -i ~/.ssh/WEBHOST_OLDER.pub" b.tar.gz root@55.555.55.555:/home/wengindustries/htdocs
```
Local computer (for command variance): MacBook Pro 2021

```
rsync -avz --progress --partial --append -e "ssh -i ~/.ssh/WEBHOST_OLDER.pub" b.tar.gz root@11.111.11.111:/home/wengindustries/htdocs
```

```
rsync -avz --progress --partial --append -e "ssh -i ~/.ssh/WEBHOST_NEWER.pub" a.tar.gz root@5.55.555.555:/home/wengindustries/htdocs
```

## After restoring files on a new server - Ownerships and Permissions

Make sure they have proper ownerships and permissions. Refer to [[Website files and folders with proper ownership and permissions]]

## After restoring files on a new server - Resync app data
### App sync ups - Quiz Gsheet

For keys/ check that the apps that rely on them work after migration:
- quiz-gsheet

Hardcoded domain with some base url (If domain changed, we need to re-code it in):
- quiz-gsheet/public/assets/formatters/format-question-text.js: was hard coded to `DOMAIN.com/hosted/quiz-gsheet/...`

### App sync ups - Brains / Notebooks

#### **Test first**
During migration, you may want to test that Devbrain works from the nested path before spending time wiring it to the subdomain.

In that case, temporarily comment out the 404 block on the main vhost:
```
# location ^~ /app/devbrain/ {
#     return 404;
# }
```

This lets you access and test:
wengindustries.com/app/devbrain/

FYI only - Once Devbrain is working and the subdomain is ready, add the block back:
```
location ^~ /app/devbrain/ {
    return 404;
}
```
Then you will use the subdomain as the public URL:
codernotes.wengindustries.com

This keeps the migration easier while still preventing duplicate URLs and brand confusion after launch. We dont want visitors have two ways to access our brain/notebooks.

But in the meantime, we need to do further testing, so no wiring to subdomain yet

#### **Test integration**

Reminder:
- Obsidian Content-Published/Dev/ <-> codernotes.wengindustries.com (web root wengindustries.com/app/devbrain)
- Obsidian Content-Published/Dev/ <-> 3dnotes.wengindustries.com (web root wengindustries.com/app/devbrain)
- Obsidian Content-Published/Dev/ <-> biznotes.wengindustries.com (web root wengindustries.com/app/devbrain)
- Obsidian Content-Published/Dev/ <-> healthnotes.wengindustries.com (web root wengindustries.com/app/devbrain)
- github for devbrain, gitlab for others


If URL/domain changed, we need to change Obsidian scripts (Obsidian that syncs to online coder notes) (eg. 3dbrain, bizbrain, etc)
- Modify `/Users/wengffung/Library/CloudStorage/GoogleDrive-MY_EMAIL_ADDRESS@gmail.com/My Drive/_Obsidian MD/upload_diff_images.js` (If aliased on local machine: `cdobs`)
	- Update IP (for SFTP), username, password, and web root to image hosting address
- At each 3D/, Biz/, Dev/,  Health/, adjust package.json's build script that opens the remote php file to make sure the remote url to server-update.php and the ?secret is correct.

SSH into each notebook (eg. 3dbrain, bizbrain, devbrain, healthbrain) at apps/. 
- **Very Important**. Switch to your site user because all git calls from the updating script will be your site user! `su wengindustries`
- Go into curriculum/  and run `git status`  to see if:
```
fatal: detected dubious ownership in repository at '/home/wengindustries/htdocs/wengindustries.com/app/bizbrain'
To add an exception for this directory, call:

	git config --global --add safe.directory /home/wengindustries/htdocs/wengindustries.com/app/bizbrain
```
- If you do, then just run the command it suggests (copy and paste)
- See if you can run `git pull origin main` (without errors. Already up to date is fine)
- Change the owner of the entire app folder at the server to the demoted/site user. Use the recursive flag so ownership applies to `.git`, other dot files, and deeper folders too:   `chown -R wengindustries:wengindustries devbrain`  (replace with 3dbrain, bizbrain, healthbrain, as appropriately). You may have to exit su back to root user in order to perform the ownership change on the folder, but don't forget to su back into the demoted site user for the rest of this checklist
		- Explanation: This is necessary because when deploying notes from Obsidian to Wengindustries using the `package.json` `npm run deploy` scripts, the deploy runs as the `wengindustries` user. That user needs access to update `curriculum/.git`, so the `curriculum` folder must be owned by the site user.
		- Explanation: `env/` also needs to be owned by the demoted/site user recursively because the update script changes env template files. These files are used to resolve special icons for certain topics and display special strings.
		- Explanation: The entire app folder should be owned by the site user because the script creates cache files at the app root for navigation topic model and a prerendered topics navigation panel.
- Run the php script file that's in the curriculum at the server:
	- Run `php -d display_errors=1 -d error_reporting=E_ALL server-update.php` or redirect to a temp file: `php -d display_errors=1 -d error_reporting=E_ALL server-update.php > report.log
	- Exit codes 0 is good meaning completed successfully
	- Look for Permission Denied as well.
-Run the php script file by triggering a deployment from Obsidian (`npm run deploy` inside a folder like Dev/ that contains the MD files and a package.json that will open the remote server-update.php in the web browser)
- Does the app's navigation of topics reflect most recent changes? Or were there errors in the update report webpage that opened?
	- Remote app not showing updates? Or there were errors in the report?
		- Firstly, is github.com repository being updated? Fix that first
		- SSH cd into curriculum folder and see if it's updated. That helps you identify if it's a building script problem or a git pull problem. Go to next step with the problem in mind.
		- What does the webpage report say? 
			- Search for "Denied" for permission denied in the webpage report. Fix this by problem by recursively changing ownership to site user for the app folder (eg. `devbrain`)
			- Git fetch + hard reset to origin/main Failed errors? They could be:
				- `HOME` env var not set — PHP-FPM strips environment by default. Git needs `$HOME` to find `~/.gitconfig` and `~/.ssh/`. Without it, git fails on auth before printing anything useful.
				- SSH origin (`git@github.com:...`) but the web process has no SSH key / `known_hosts`.
					- Quick reference 1 - Make sure you're demoted user (`su wengindustries`. Cd into `~/.ssh`, then generate SSH pair at server with `ssh-keygen -t ed25519 -C "MY_EMAIL_ADDRESS@gmail.com"`. Name it github-gitlab-2026 or whatever year. Passphrase not necessary when asked.
						- MAKE SURE the SSH pairing is done as the demoted user aka site user so it's under the site user's .ssh/ folder. Otherwise it will continue to fail authentication because root isn't it when the update script is triggered to pull from git. You can run `sh wengindustries` to switch user.
					- Quick reference 2 - upload SSH pub key contents to Github.com repo owner's ssh settings -> SSH and GPC Keys -> Authentication key. You can name it something like "Hetzner/wengindustries/github-gitlab-2026.pub"
					- Quick reference 3 - Is there a ~/.ssh/config at server? And does it contain github.com as a host? Is that pointing to the private SSH file as expected?
					- `~/.ssh/config` should have:
						```
						                Host github.com
						                  HostName github.com
						                  User git
						                  IdentityFile /home/wengindustries/.ssh/github-gitlab-2026
						                  IdentitiesOnly yes
						
						
						                Host gitlab.com
						                  HostName gitlab.com
						                  User git
						                  IdentityFile /home/wengindustries/.ssh/github-gitlab-2026
						                  IdentitiesOnly yes
						```
					- ^ DO NOT use ~/.ssh/github-gitlab-2026. 
				- `safe.directory` "dubious ownership" — if `.git` is owned by a different user than the web process.
			- Some other error but there's no error message? The report tells you the command that's ran. Run it as ssh demoted user in the terminal. It may have been redirected elsewhere



### Cloudflare with notebook apps

Setup non interactive challenges at all notebook apps to prevent scraper bots spiking my cpu %:
You only need this one rule for all notebooks
![[Pasted image 20260425043544.png]]

Setup cache rules to let our nginx use 304:
- You need to setup for each notebook, so x4
![[cache-cloudflare-bypass-so-origin-takes-over.png]]
^ Use Duplicate then rewrite the hostnames:
![[Pasted image 20260425044219.png]]

---

## Databases (MySQL, MongoDB)

### Mongo DB
Restore MongoDB from old database to new database.
Refer to [[MongoDb Backup and Restore with CLI - All Databases]]

You may realize that the root password for MongoDB may differ on this machine than from the app env variables. We'll fix that later. We have to focus on MySQL next because that can easily have the same problem (outdated password in app env variables)

### MySQL
Restore MySQL databases using phpMyAdmin. Refer to [[phpMyAdmin - Migrate from old server to new server]]

---

## .env migration including database credentials

A lot of your apps may have .env files that have the database credentials. Your new server’s database may have a different set of login credentials or different passwords

1. Do we need to copy over .env files? (Likely nto)
	
	.env migrate
	
	if zipped and unzip was method of transferring app files, you’re good
	
	otherwise at original server: `find . -type f -name ".env*"` 
	
	You have locations of env files now. So copy them over to the new server

2. Did mongo or mysql credentials changed?
	
	grep for old mysql password and old php password excluding .git and .node\_modules.
	
	This would fix a lot of failed starts with pm2 ecosystem.config
	
	Look at your old ACC document (where you keep web hosting credentials) for old passwords for mongo and mysql to fill `-E “MONGO_PASSWORD_OLD|MYSQL_PASSWORD_OLD”` . You go on file matches (like .env) to replace them with the new server database’s credentials
	
	However if your database on the new server uses same username AND password, then you dont have to replace them
	
	The command to look for files to replace passwords is:
	
	- This uses `grep` recursively, excluding `.git`, `node_modules`, and `.node_modules`:
	
	```
	grep -RIn --binary-files=without-match \
	  --exclude-dir=.git \
	  --exclude-dir=node_modules \
	  --exclude-dir=.node_modules \
	  -E "MONGO_PASSWORD_OLD|MYSQL_PASSWORD_OLD" .
	```
	
	
	Example matches output from the command:
	
	```
	./company1/product1/.env.local:8:MONGO_PASSWORD=MONGO_PASSWORD_OLD
	./company2/product1/build-scripts/Template-Host1-Env:8:MONGO_PASSWORD=MONGO_PASSWORD_OLD
	./backend/a/api/.env:12:MONGODB_PASSWORD=MONGO_PASSWORD_OLD
	./backend/b/api/.env:4:MONGODB_PASSWORD=MONGO_PASSWORD_OLD
	./wp-portfolio/wp-config.php:29:define( 'DB_PASSWORD', 'MYSQL_PASSWORD_OLD' );
	./wp-store/wp-config.php:29:define( 'DB_PASSWORD', 'MYSQL_PASSWORD_OLD' );
	./app/app1/.env:4:MONGODB_URI=mongodb://root:MONGO_PASSWORD_OLD@wengindustries.com:27017/app1?authSource=admin
	./app/app2/.env:2:MONGODB_URI=mongodb://root:MONGO_PASSWORD_OLD@wengindustries.com:27017/app2?authSource=admin
	./app/app3/.env:2:MONGODB_URI=mongodb://root:MONGO_PASSWORD_OLD@wengindustries.com:27017/app3?authSource=admin
	
	```
	
	
	If your username (Mongo or MySQL) is the same on the old server as is on the new server, you only need to substitute the old password to the new password recursively via terminal command:
	
	- Note you enter the old password at two places, and the new password at one place only:
	- Note yes there’s a `\E/`  between original string and substituting string
	
	```
	grep -rlZ --exclude-dir=.git --binary-files=without-match -- 'PASSWORD_OLD' . | xargs -0 -r perl -pi -e 's/\QPASSWORD_OLD\E/PASSWORD_NEW/g'
	
	```


**Audit**:

You can check globally if the old password exists and check globally if the new password is spelled correctly (no extra character prefixed or appended)

Btw, if your eco system config or supervisor apps were crashing on the new server, that could be why - wrong credentials

---

## Wordpress site migrations
About: You may have multiple wordpress sites. A wordpress site could be your root, independent of reverse proxied nodejs/python apps, and individual php sites nested deeper

Setup your Wordpress websites. You have already copied all the html,php,js,css,etc files for your website including those wordpress websites that are at deeper paths.

Before visiting the wordpress page, remove or disable `wp-config.php`:
![[Pasted image 20260515031425.png]]

Then you can configure the database details so the website is tethered to your database. If you need a review on how to setup wordpress, refer to [[_ PRIMER - Wordpress (Includes Setup)]]

Afterwards, you may want to restore your wordpress site to fix anything that didn't carry over from just files (especially database data). You should have exported a wpress file using Wordpress All-in-One Migrations (free version okay) at the older server. Now you import it in. If you need to review how to import/restore using that plugin, refer to [[_ Import into All-in-One Migration Free using Backup Wpress File]]

---

## Making sure 'localhost' works for Linux level commands

Check `/etc/hosts/`  and make sure there is a line for localhost to point to 127.0.0.1

---

## Making sure 'localhost' works for MySQL

Many NodeJS apps connecting to MySQL may be configured to connect to `localhost` instead of `127.0.0.1`. On some systems that may be okay. On our newer server, let's make sure `localhost` will work for MySQL.

Refer to [[Required Setup - For localhost to work as a host equivalent to 127.0.0.1]]. Once those steps completed, return here

---
## Vhost Proper Restoration - Preface

```
You may have already done a preliminary vhost restore from the VPS or dedicated server checklist. At this point, the main website should mostly work because Nginx matches incoming requests using the `server_name` directive, then serves the website files from the path set by the `root` directive.

Before doing the full restoration, make sure the main page at least loads.

During this proper restoration, we will not enable every include at once. Instead, we will keep reverse proxies, subdomains, and extra domain configs commented out, then bring them online one by one.

Over time, your vhost may move through stages like this:

```nginx
# Inside 443/80 server block:
# include /etc/nginx/sites-enabled/somedomain1.conf;

# Bottom of main site vhost:
# include /etc/nginx/sites-enabled/somesubdomain1.conf;
# include /etc/nginx/sites-enabled/reverse-proxies.conf;
````

->

```nginx
# Inside 443/80 server block:
include /etc/nginx/sites-enabled/somedomain1.conf;

# Bottom of main site vhost:
# include /etc/nginx/sites-enabled/somesubdomain1.conf;
# include /etc/nginx/sites-enabled/reverse-proxies.conf;
```

->

```nginx
# Inside 443/80 server block:
include /etc/nginx/sites-enabled/somedomain1.conf;

# Bottom of main site vhost:
include /etc/nginx/sites-enabled/somesubdomain1.conf;
# include /etc/nginx/sites-enabled/reverse-proxies.conf;
```

->

```nginx
# Inside 443/80 server block:
include /etc/nginx/sites-enabled/somedomain1.conf;

# Bottom of main site vhost:
include /etc/nginx/sites-enabled/somesubdomain1.conf;
include /etc/nginx/sites-enabled/reverse-proxies.conf;
```

> **Note:** Domain and subdomain include lines are often placed outside individual `server` blocks or near the bottom of the main site vhost, depending on how the backup was organized. Reverse proxy includes are often placed inside the HTTPS `server` block, usually the block listening on port `443`, because app routing commonly depends on SSL/HTTPS behavior.

---
## Vhost Proper Restoration - Enable Each Subdomain or Domain as You Update SSL and DNS Records

Some include lines point to normal websites that do **not** depend on a running Node.js or Python process. For example, the site may be a static HTML website, PHP website, or WordPress site.

You may also have extra domain configurations that serve files from nested folders inside the main web root. For example, `domain1.com` and `domain2.com` may serve files from folders inside the web root of `domain0.com`. This may not look as clean inside CloudPanel, but it can make management easier because everything stays under one SFTP account or one main project folder. These include lines are often placed near the bottom of the main vhost so they do not affect the rest of the website.

For those domains and subdomains, restore them one at a time:
1. Uncomment one domain or subdomain include.
2. Run:

```bash
sudo nginx -t
sudo systemctl reload nginx
````

3. Update its DNS records to point to the new server.
4. Add or recreate SSL, such as with Let’s Encrypt.
5. Visit the domain in your browser and confirm it loads correctly.

Hint:
Before updating DNS or recreating SSL, make sure you know which domain or subdomain the included vhost is for that you are uncommenting. You need this so you choose the correct domain in Cloudflare or your DNS registrar. You also need it so you add the correct domain or subdomain when recreating SSL, such as with Let’s Encrypt.
* If the restored vhost is well documented, it may have a comment showing which domain the included vhost controls.
* Otherwise, open the included vhost file and check the `server_name` value to see which domain or subdomain it points to.

Repeat this process for each HTML/PHP domain or subdomain before moving on to reverse proxies and app-based sites.

As you uncomment and test each domain or subdomain, the SSL re-certification process can feel annoying because you may think you need to include every previously working domain each time you generate a new SSL certificate. You do **not** have to do that. While you are still troubleshooting, focus only on creating SSL for the **current domain or subdomain** you are trying to fix. Once that one works, move on to the next one. After **all domains and subdomains are working correctly**, recreate the SSL certificate one final time and include the full list of domains and subdomains. This final certificate should cover everything together. Once you have the full list of working domains and subdomains you can create a script that helps recreate the SSL when the certificate expires, referring to [[CloudPanel - SSL Renew Annually (Semi Automated)]] or you can have a cron job running a sh script.

---

## Vhost Proper Restoration - Enable Apps from PM2 or Supervisord

### Enabling Parts of the Vhost

**TLDR:** Uncomment the app-related reverse proxy lines only when you are ready to test the matching apps from `pm2 list`, Supervisor, or your migration notes.

A common pattern is having **one included vhost file dedicated to all reverse proxies** for Python, Node.js, Gunicorn, PM2, Flask, FastAPI, Express, or other app servers. This reverse proxy include is usually located inside the `443` HTTPS server block.

A lot of this restoration happens while you are updating `.env` files and confirming each app works one by one. You may also need to fix app issues caused by the new server environment, such as missing packages, wrong Node/Python versions, missing system dependencies, or incorrect paths.

Normally you have to be cd'ing into the app folder and running `rm -rf node_modules && npm install --legacy-peer-deps at the web root level then again at any nested part of the stack like `client/`, `server/`, or `frontend/`, or `backend/` which tends to have their own npm packages

Your .env file should've been updated per `.env migration including database credentials`. Any localhost connection for NodeJS Sequelize/Mysql or Mongo should work per section `Making sure 'localhost' works for Linux level commands` and `Making sure 'localhost' works for MySQL`

Mongo connections should be to 127.0.0.1 and NOT domain.com, especially if you have Cloudflare or other firewall or anti-bot mechanisms, because it'd timeout on connecting to database in your app usage or app startup.

Before you actually test by running the app, make sure to seed in case that's essential for the app to even run. That is - `npm run seed` or `npm run seeds` - if seeds exist in the app. It might complain a database doesn't exist, which means the seed isn't programmed to create the database - you have to create it manually using MySQL shell.

Finally, try running locally at the root folder with: `node server.js` or `npm start`:

With reverse proxy or subdomain or domain pointing to that folder uncommented at vhost, visit in the web browser too to see if it loads.

If the app works, then it should work with pm2 as well. If `pm2 list` shows the app not working, proceed to next subsection on troubleshooting techniques.

### Troubleshooting PM2 Apps

After restoring packages and environment files per section `.env migration including database credentials`, many apps should work again. Still, check that they are not crashing, restarting constantly, or spiking CPU.

Start with:

```bash
pm2 list
```

One quick auditing method is to run `pm2 list` repeatedly for at least one minute. Watch whether each app’s uptime is increasing normally, restarting, or staying at `0s`.

Some apps do not crash immediately. They may crash 30–60 seconds later because of a missing environment variable, database issue, API call, or delayed startup task.

You can also monitor it by rapid pressing up and enter to keep recalling `pm2 list`. You'll see the time accrue up to 60 seconds of runtime on any of the apps that do still work.

Check CPU usage:

```bash
htop
```

For example, a simple idle Node.js app constantly using around 20% CPU may still have a problem.

Useful PM2 commands:

```bash
pm2 status
pm2 logs
pm2 monit
```

After moving servers or changing Node.js versions, consider running:

```bash
pm2 update
```

A stale PM2 daemon can sometimes cause strange behavior, including high CPU usage or unstable restarts.

For Supervisor apps, check:

```bash
supervisorctl status
supervisorctl restart appname
supervisorctl tail appname
```

Make sure all PM2 and Supervisor apps run without crashing, constant restarts, or unexpected CPU spikes.

Follow the rest of the PM2 troubleshooting approach here: [[PM2 - Troubleshooting Approach]]

---

## Emails

Required knowledge:
- Many web hosting companies offer both web-host service and email service, usually as independent services you subscribe to.

Are you keeping the same email service?

Here are [[Reasons to change email service provider]]. Review them to decide whether to stay with the same email service provider.

If deciding to migrate email service providers:
1. Firstly, export all previous emails so you have a place to review them. You can import into Apple Mail or into your new email service. How to export from Hostinger, for example: [[Export Emails (Hostinger)]]
2. Secondly, update the MX record (for pointing to mail server IPs) and TXT records (for authentication) to the new email service's information
	- Your email service should have documents on how to obtain TXT/MX record information. You just add the records to your DNS registrar or whichever DNS registrar has been delegated to (for example, Cloudflare). You can google with `__service_name__ mx records` and `__service_name__ TXT email records`. For example, Hostinger: https://www.hostinger.com/support/4407237-hostinger-email-mx-records/ and https://www.hostinger.com/support/1583664-how-to-manage-txt-records-at-hostinger/
	- The theory how these email DNS records work are at: https://biznotes.wengindustries.com/?open=Siteground%20Email%20Setup%20-%20SPF,%20Dkim,%20Dmarc%20-%20Quick%20Guide

---

Done.