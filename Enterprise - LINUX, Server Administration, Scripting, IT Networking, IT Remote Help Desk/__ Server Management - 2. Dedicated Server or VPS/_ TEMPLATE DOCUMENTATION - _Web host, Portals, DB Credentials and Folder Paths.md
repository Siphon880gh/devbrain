
About: This is a template document to record all your credentials, folder paths, file paths in your web host. Is geared towards unmanaged VPS and dedicated service (You manage yourself)

Notation: ACC stands for Account. It's Weng's notation for saving login credentials, key OS, key configuration information, etc

---
## ACC Services Dashboard / OR Login Via SSH Root
- os: (Eg. Debian 12)
- \__which is
- \__oauth2 login creds
- \__url


\> Alt Login:  
- \__login creds


Public IP: _ip

Available IP addresses / Floating IPs: _availabeIps


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
## ACC Provider Checklist / Statements of Facts

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

## ACC Folder structure

- Recommend have separate folders for pm2/nodejs and for python/supervisor apps
	- If for the URL you prefer all apps regardless of language belongs to one folder, eg. /app, then have the other language-based folders symbolically link, eg. /nodejs/app1 -> /app/app1
- Recommend Supervisor app config files be named with the port number ranges they use
- May have a root folder /keys that have important keys for all your apps but make sure is blocked from being visited on the web browser. It's safer if you have a build script that saves the env keys to your .bash_profile, then re-source, instead.


## ACC OS paths (error logs, configs), commands, and workflows

...

## ACC Supervisor

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
## ACC Web Hosting Control Panel

- \__which is
- \__login creds
- \__url

\> \__ IA and how to navigate there from Services Dashboard  



**Admin users (Secondaries):**


**Site users (Tertiary)**

---
## ACC PHP and PHP.ini

SOP - Make sure both cli php and web php matches version:
- Check web php version: `php -r 'echo PHP_VERSION;'`
- Check cli php version: `php --version`
- To match them: [[_Best Practice - Match PHP Version of CLI with Web]]

Our PHP paths are: 
```
/etc/php/8.2/cli/php.ini
/etc/php/8.2/fpm/php.ini
```

---

All Wordpress accounts in this section. Make sure domain and URL are recorded.
## ACC WP Wordpress - Portfolio Old Design by Sterling

For domain: DOMAIN.com
**DB Name**: ..
**DB Creds**: ../..
**WP Creds**: ../.. 
https://wengindustry.com/root/wp-admin


---

## ACC SFTP

Where to modify: \__


**SFTP as site user**
\__login creds
- Site user navigate to: \__ user navigation
- Preferred. Folders created by web host panel and by FTP - to make consistent so your php scripts can create files

**SFTP as root**
\__login creds


---

## ACC SSH Root access:
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

## ACC SSL HTTPS Directories
- **ssl_certificate:** \__remote file path
- **ssl_certificate_key:** \__remote file path

\__ Mention any necessary re-setups whenever you have new ssl certificates, eg. gunicorn command that has SSL paths in .sh file managed by Supervisor


----

## ACC MySQL/PHPMyAdmin

Hints: 
- Make sure you've enabled root@127.0.0.1, root@localhost, and root@::10
- phpMyAdmin can be accessed through Cloudpanel, then get the URL

MySQL PHPMyAdmin:
Creds:
phpMyAdmin URL:


MySQL Shell:
```
..
```

---
## ACC Mongo

Mongo URL (PHP, NodeJS, Python):
```
..
```

Mongo Shell:
```
..
```

---

## ACC PostgreSQL

Login/pass:

Superuser (peer via being the root user on OS):
```
sudo -u postgres pqsl
```

PSQL Shell:
```
..
```
