Did you buy a new server? This guide reaches how to migrate MySQL data from old server to new server.

Figure out the URL to the old server and the new server
https://X.XX.XXX.XXX:8443/phpmyadmin/index.php
[https://Y.YY.YYY.YYY:8443/phpmyadmin/index.php](https://5.78.200.132:8443/phpmyadmin/index.php)

If can't figure it out, Cloudpanel has a way for you to access PhpMyAdmin:
![[Pasted image 20260510080740.png]]

Though sometimes on a new setup, you have no "Manage" link because there are no MySQL users that are named after your site. You likely still have the root username and you have ways to get your password
![[Pasted image 20260510080841.png]]

---

  

**Export each database** from the old server:
- You can export as SQL
![[Pasted image 20260515042716.png]]

---

At remote server, make sure to **create these empty Databases** that will fill in using “Import”
- Otherwise it will complain database doesn’t exist when we import the SQL file.
![[Pasted image 20260515042744.png]]

->

![[Pasted image 20260515042813.png]]

At each database, you Import:
![[Pasted image 20260515042954.png]]
->
![[Pasted image 20260515043047.png]]

  
Success:
![[Pasted image 20260515043113.png]]