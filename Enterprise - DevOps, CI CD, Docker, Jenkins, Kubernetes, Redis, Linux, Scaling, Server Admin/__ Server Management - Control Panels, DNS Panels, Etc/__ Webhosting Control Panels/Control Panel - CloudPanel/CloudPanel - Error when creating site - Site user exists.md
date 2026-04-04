
PROBLEM:
I create a website with a site user but it complains that site user’s value already exists.

I checked and it’s not in admin area’s users list

WHAT's GOING ON:
Actually, CloudPanel creates system users. Once CloudPanel restarts, it will erases those system users that are queued for deletion after you removed the sites

SOLUTION 1:
Restart the CloudPanel services

```
sudo systemctl restart clp-nginx.service
sudo systemctl restart clp-php-fpm.service
```  
  
SOLUTION 2:
It should work now. If it DOES NOT work:
- Run `cat /etc/passwd` or  `getent passwd`  to see if the site user exists in your system users. It will probably exist. You cannot simply remove the line. After confirmed exist, you delete the user by running:
	
	```
	sudo userdel -r USERNAME  
	```

	^ You can ignore warnings, if any, about:
	`userdel: test mail spool (/var/mail/USERNAME) not found`


- Then you confirm success:  
	```
	getent passwd | grep USERNAME  
	```


- For a more through check, verify that the user is not in the main system files:
	```
	grep test414 /etc/passwd /etc/group /etc/shadow /etc/gshadow  
	```


---

## If curious - this was my thought process to discover the fix

It is not the SQLite3 CloudPanel uses to store sites, etc:

vi /home/clp/htdocs/app/data/db.sq3  
```
>>> .tables
```

Then I ran `SELECT * from`  on user_sites, user< ssh_user, ftp_user, database_user, database_server, database, certificate
  
It is not MySQL because I checked mysql.user and I checked for other databases at PhpMyAdmin


It is not /home/clp/services/nginx/__ where it’s sites-enabled, ssl, or ssl-certificates


It is not /home. The /home/ no longer has the user's folder


It is not 
```
clpctl user:list
```

It’s not
```
./etc/group-:69:test414:x:1003:  
./etc/subgid-:3:test414:231072:65536  
./etc/gshadow-:69:test414:!::  
./etc/subuid-:3:test414:231072:65536  
./etc/passwd-:46:test414:x:1002:1003::/home/test414:/bin/bash  
./etc/shadow-:46:test414:$6$dO0vUgA8C7Q788jI$au3tMvEfdeW5TMGP4P2DhN8u9g7U27Qv8CuPLfoO/b27N4dnH.B8qycsEJvmtKZuxQ6dJ/etWbkKbYSJKuJHL/:19938:0:99999:7:  

```
^ Those are just backups

I SOLVED it.... I grepped the entire system for a specific site user that should not exist anymore, eg. user414... and only found it in backup files of the passwd.... and because I ruled out system users, mysql, and cloud panel's sqlite 3, and folder paths, and file contents, next I concluded cloudpanel was using stale data (from before the site is deleted and hence before the site user is deleted). I had to restart cloudpanel service so that it recognizes the site user no longer exists. 


As Im on Ubuntu 22, I ran `systemctl list-units --type=service --all` to list all services

Then I determined to restart like so:

```
sudo systemctl restart clp-nginx.service
sudo systemctl restart clp-php-fpm.service
```  
  

This is in addition to 
```
sudo userdel -r USERNAME  
```


It appears CloudPanel also adds SSH users when you create a site with a site user

And that fixes it