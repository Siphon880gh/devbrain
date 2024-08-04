Location
Root

---

```
try_files $url $url/ =404
```

Can be thought of as: `try_files file dir then404`

---

server domain.tdl 

server _ (when nothing matches)

server PUBLIC_IP

---


```
[::]
```

is the IPv6 version

  

80 is http

443 is https


---


comment out by having a line start with #

---

  
Nginx main conf includes or loads in site enabled’s vhosts following thru with symbolic links

Sites enabled are symbolic links to sites available that you want to make public  
  

Why This Structure?

Organization: Keeps your configuration files organized. You can have all possible site configurations in `sites-available`  and easily enable or disable them without deleting the files.

Flexibility: You can quickly enable or disable a site by adding or removing the symbolic link in `sites-enabled` .

  

You symbolically link it:

`sudo ln -s /etc/nginx/sites-available/example.com /etc/nginx/sites-enabled/` 

  