
## STOP!

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

---

## Logs

If Xen is managed by Cloudmin, you can find Xen logs in several places depending on your configuration. Here’s where to look:

### 1. **Xen Logs**

**a. System Logs:**
Xen logs are often found in the system log directories. Check these locations:

- **For Debian/Ubuntu:**
  ```bash
  /var/log/xen
  /var/log/syslog
  /var/log/messages
  ```

- **For Red Hat/CentOS:**
  ```bash
  /var/log/xen
  /var/log/messages
  ```

**b. Xen-Specific Logs:**
If you have Xen-specific logs, they might be in:
```bash
/var/log/xen
```

### Cloudmin Logs

Cloudmin also maintains its own logs which can be useful for troubleshooting:

**a. Cloudmin Logs:**
- **For Cloudmin logs, check:**
  ```bash
  /var/webmin/miniserv.log
  /var/webmin/miniserv.error
  ```

**b. Cloudmin System Logs:**
Cloudmin may log system-specific events in:
```bash
/var/webmin/system.log
```

### 3. **Accessing Logs via Cloudmin Interface**

Cloudmin might also provide a way to view logs directly from its web interface:

1. **Log into Cloudmin.**
2. **Navigate to the VM or Xen server management section.**
3. **Look for options or tabs related to logs or system status.**

If you need more details on where to find specific logs or encounter issues, feel free to ask!