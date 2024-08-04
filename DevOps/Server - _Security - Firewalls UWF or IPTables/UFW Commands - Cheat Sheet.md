
When using ufw, you'd run `sudo ufw status` which shows you conventional named ports that are opened and in what manner it's opened.

If you want to show opened ports with conventional names AND port numbers: `sudo ufw status verbose`

You can figure out what other ports you can open by conventional name by running `sudo ufw app list`

Example output:
```
root@cs727:~# sudo ufw app list  
Available applications:  
  Nginx Full  
  Nginx HTTP  
  Nginx HTTPS  
  OpenSSH
```

You can allow convention name or port numbers with:
```
sudo ufw allow XX
sudo ufw allow ##
```

You can deny or block with:
```
sudo ufw deny XX
sudo ufw deny ##
```

In other words, you could've  ran `sudo ufw allow "Nginx HTTP"` or `sudo ufw allow 80`

---

You can remove the a line from `sudo ufw status`, but first you need to get the line number:
```
sudo ufw status numbered
```

Your output could be:
```

     To                         Action      From
     --                         ------      ----
[ 1] Nginx HTTP                 ALLOW IN    Anywhere                  
[ 2] Nginx HTTPS                ALLOW IN    Anywhere                  
[ 3] OpenSSH                    ALLOW IN    Anywhere                  
[ 4] 22                         DENY IN     Anywhere                  
[ 5] Nginx HTTP (v6)            ALLOW IN    Anywhere (v6)             
[ 6] Nginx HTTPS (v6)           ALLOW IN    Anywhere (v6)             
[ 7] OpenSSH (v6)               ALLOW IN    Anywhere (v6)             
[ 8] 22 (v6)                    DENY IN     Anywhere (v6)
```

Then you can delete line 4 and 8 with:
```
sudo ufw delete 8
sudo ufw delete 4
```

