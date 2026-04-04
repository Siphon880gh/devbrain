Install Webmin (skip the https):
https://www.digitalocean.com/community/tutorials/how-to-install-webmin-on-ubuntu-22-04

Uses SSH user root and their password.

Panel is at:
https://IP:10000/sysinfo.cgi?xnavigation=1

---

Features include adding virtual bridge, so webmin is really a Multi-server Control Panel:
![](J1DJ00y.png)


Its ability to actually create a virtual bridge is contested because it's a glitchy outdated control panel. It's more reliable to add virtual bridges for the purpose of setting up VMs as VPS, by editing `/etc/network/interfaces`.