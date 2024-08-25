
STOP! Has been outdated and not keeping up with more recent OS distros like Debian 12. It will break. Virtualmin has taken is place. 
- Instead, refer to [[Virtualmin]] which is both a webhosting control panel as well as a multi-server control panel capable of starting Xen VMs (which are VMs that use hardware virtualizations except KVM hardware virtualizations)

---

## Archived for historical reasons

![](https://i.imgur.com/LQptMoh.png)


**Cloudmin GPL** **is a module on top of the Control Panel Webmin. Requires [[Webmin]] to be installed first. Cloudmin works inside Webmin.

Cloudmin is free for managing a single Xen or KVM host system. Pro version lets you manage across multiple hosts.

Prerequisites: 
- Webmin
- Xen (Not Xen-NG or Xen-Server, but Xen).

Installation instructions: [https://webmin.com/cloudmin/](https://webmin.com/cloudmin/)

```
wget http://cloudmin.virtualmin.com/gpl/scripts/cloudmin-gpl-debian-install.sh  
chmod 777 cloudmin-gpl-debian-install.sh  
sudo ./cloudmin-gpl-debian-install.sh
```
^In the URL, virtualmin is the name of a control panel, but it is also the name of the company that had developed cloudmin (that is now outdated). They later developed virtualmin in place of cloudmin.

![](https://i.imgur.com/hKDyIj5.png)


![](https://i.imgur.com/xgOryf4.png)
