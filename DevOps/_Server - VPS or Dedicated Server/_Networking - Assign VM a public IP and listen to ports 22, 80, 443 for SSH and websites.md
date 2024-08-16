
### Checkpoint

Although your VM can connect to the internet when you install packages (`apt install ..`), for example. It can because it's connected to the router. However to make the VM discoverable so it can be requested for webpages (in other words, internet users can visit a webpage on your VM), several setups will be done in this section:
- Assign a static IP address to your VM 
	- Explanation: You need a static IP which is a public IP address that never changes. Dynamic IP addresses changes based on a first come first server basis (if you have multiple VMs and some start crashing, now the IP addresses could get changed)
	- You will assign your purchased domain name to a specific IP address.
- Install a web server so that ports 80 (http) and 443 (https) are open to listening to internet requests using a daemon / background process. Those internet requests are delivered to the VM through the gateway/router. Then your VM delivers a webpage or other files back to the internet. This is synonymous with receiving and sending packets. 

### Requirements

Requirement 1:
- Your dedicated server aka host machine can SEE your VM aka guest os (for instance, from running `xl list` to show all VMs). This means a virtual bridge has been setup in your `/etc/network/interfaces`. If this is not the case, follow instructions at [[_Networking - Create virtual bridge to make guest VM accessible by host machine at dedicated server]]

Requirement 2: You should be consoled into the VM from your dedicated server, eg. `xl console vps0`

### Choose a public IP for your VM

You will modify the VM's /etc/network/interfaces by making its IP address different and making sure it is one of the available IPs that your provider has given you and that is not already assigned to your host machine, your gateway aka router, or any other VMs you may have created and exposed to the internet. 
- The provider gave you IP addresses of your dedicated server aka host machine and the IP address of your gateway aka router
- The provider could have given a CIDR IP address that ends with /24, or /29, etc. Or they could have given you a netmask. Or they could have given you a list of available IPs.
	- If given a CIDR form ip address, you have to do some computer math on paper to convert that into a netmask
	- If given a netmask or have arrived to a netmask, you do some computer math on paper to convert that into a list of available IPs
	- How to do this math is beyond the scope of this tutorial. Just google how to do it. Or ask ChatGPT to convert it to a list of available IPs

Make sure that the IP you choose to be the VM's Public IP isn't the dedicated server's IP nor the gateway aka router's IP. Write it down on paper. We can't change the IP yet.

We have to know what the virtual network card of this virtual computer is called. It might not go with the same name as the physical network card that your physical dedicated server has. Run

### Find out the virtual network card name

Run
   ```bash
   ip addr
   ```
^ A shortcut is running `ip a`

Your VM's could look like:
```
1: lo: <LOOPBACK,UP,LOWER_UP> mtu 65536 qdisc noqueue state UNKNOWN group default qlen 1000
    link/loopback 00:00:00:00:00:00 brd 00:00:00:00:00:00
    inet 127.0.0.1/8 scope host lo
       valid_lft forever preferred_lft forever
    inet6 ::1/128 scope host noprefixroute 
       valid_lft forever preferred_lft forever
2: enX0: <BROADCAST,MULTICAST,UP,LOWER_UP> mtu 1500 qdisc fq_codel state UP group default qlen 1000
    link/ether 00:16:3e:5f:9a:cb brd ff:ff:ff:ff:ff:ff
    inet 222.22.222.24/29 brd 222.22.222.29 scope global enX0
       valid_lft forever preferred_lft forever
    inet6 fe80::216:3eff:fe5f:9acb/64 scope link 
       valid_lft forever preferred_lft forever

```

This tells us that the virtual network card's name is enX0. 
^ FYI: Not all VMs will have similar name. Sometimes it could be enp#s#, ens##, eno#, and on even older VM OS: ethX, wlan#. The naming convention changes based on OS distro. enp3s3 and ens33 is very specific and helpful to the IT staff at the dedicated server's location because it specifies PCI bus and slots.

### Modify the VM's network settings with the bridge name and an appropriate public IP

Modify the VM's network settings with the bridge name and an appropriate public IP. For instance, `/etc/network/interfaces`:
```
/etc/network/interfaces look like:
source /etc/network/interfaces.d/*

# The loopback network interface
auto lo
iface lo inet loopback

# The primary network interface
auto enX0
# iface eth0 inet dhcp
iface enX0 inet static
        address 222.22.222.24
        netmask 255.255.255.248
        gateway 222.22.222.23
		dns-nameservers 198.51.100.2 198.51.100.3 8.8.8.8
		dns-search example.rdns.provider.com
```

### Test You Didn't Break the Outbound Internet Connections
Then restart the networking service at VM to apply the interface changes: `sudo systemctl restart networking`. 

Then test for packets received back when pinging gateway and an internet domain which also proves DNS resolution works:

```
ping -c 4 222.22.222.23  # Test gateway connectivity
ping -c 4 google.com     # Test domain resolution
```

^ Remember your network settings have dns servers which helps resolve domain names to their public IPs that you can connect to over the internet.

#### Troubleshooting

If your VM's internet connection is broken, you need to troubleshoot:
For instance, checking if the VM can recognize the same gateway aka router which the dedicated server aka host machine can recognize. Run `ip route` and it could look like:
```
default via 222.22.222.23 dev enX0 onlink 
222.22.222.22/29 dev enX0 proto kernel scope link src 222.22.222.24
```

Some checks you may not have considered:
- The host's `xenbr0` interface should have its own static IP
- The VM should have a different IP from the same subnet (really make sure)

Worse case, you destroy the VM and start a new VM instance from the image, which are instructions you can find from [[Setup XEN VMs (Type 1 Hypervisor, no KMV) - Part 2]]

---

### Connect to SSH from Local Computer

Since your VM should be discoverable by the internet, then a computer user can SSH into your VPS.

While still consoled into the VM from your dedicated server,  check if ssh service is on by running:

```
systemctl status ssh
```

#### Check 1 for SSH connections - Firewall
Also check if ssh is blocked by firewall. Example scenario: I see if ufw firewall is installed or enabled sudo ufw status and if it's enabled and shows port 22 not opened, then I open port listening with sudo ufw allow 22. 

If firewall not installed, it's fine for now. We'll worry about security after we have a working VPS. 

#### Check 2 for SSH connections - PermitRootLogin
Now I check if I had root login permitted. At the VM console, I edit the /etc/ssh/sshd_config, making sure there's `PermitRootLogin yes` (and no other conflicting PermitRootLogin options). I saved the file then refreshed the SSH service by running `sudo systemctl restart ssh`. If I didn't permit root login, it could keep asking for the root password and will always say the password is incorrect when I ssh into the VPS from local machine (so it doesn't clue in the hacker that root login was ever disabled). Then at my local computer, I attempt to SSH into the VM with its public IP. On success: If I had disabled checking fingerprints at known_hosts, I will now re-enable at local computer's `~/.ssh/config` by removing `StrictHostKeyChecking no` and `UserKnownHostsFile /dev/null` and remove old domain entries from local computer's `~/.ssh/known_hosts`

#### Check 3 for SSH connections - Password Authentication is allowed
Ensure this option is NOT set to `no`. It should either be commented out (which defaults to `yes`) or explicitly set to `yes`. We don't want to setup SSH keys for passwordless login yet because we just want a quick and dirty test that we can connect via SSH from your local computer across the internet. The option:
```
PasswordAuthentication yes
```


#### Checks Afterwards

If you had done check 2 and check 3 modifying the ssh config, you need to restart the ssh service with:

```
sudo systemctl restart ssh
```

### SSH into your VM aka VPS

On your local computer, open a terminal and run ssh command to log into the public IP of your VM. You will login as `root` user. The password is the root password when you saw "Installation Summary" when you ran `xen create vps0` or the like, which started the VM. For instance:
```
ssh root@222.22.222.25
```

If successfully SSH, that meant you connected to the VM's port 22 that it was listening to, and it can send and receive packets. This also means you're communicating with the VM from your computer's terminal via the internet! We can proceed with opening ports for delivering websites when users visit your server via the web browser.

Reworded on what successful SSH means: If you successfully ssh into the VM from a user computer, then you’ll be able to setup a website that someone can visit from a user computer. SSH was simply port 22 listening for inbound traffic requests then sending packets of data to the gateway/router to be routed over the internet to the user computer! (Majorly simplified though). Then next, reasonably you could assume a web server through nginx / Apache / Coudpanel (includes nginx) will work after installation because it’s simply opening ports 80 and 433 to perform the same tasks.

----

## Creating websites for the internet (Refer to)


By being able to connect to your specific VPS server from your computer with SSH, bypassing having to connect to your dedicated server with SSH, then running like `xl console vps0`, you've proven that the VM can potentially act as web server because you just need ports 80 (http) and 443 (https) in addition what already worked from a computer user connecting to the server (port 22).

Overview:
- You will continue with [[_ GET STARTED - Setup Dedicated Server Checklist]] on creating a web server with nginx/apache/cloudpanel. As a quick review, cloudpanel installs nginx for you and it's preferred to install cloudpanel on an empty system without any webserver.
- Then you will use any domains you purchased at namecheap, porkbun, DAN, etc and create A records to the public IP of your server (your dedicated server or your VPS, but likely your VPS so your dedicated server can manage restarting and scaling of the VPS as VM instances)
- Then when a domain exists, you can in cloudpanel, for example, prove ownership and create a SSL for free. If regulations require your business to have more strict SSL, then you will have to pay for SSL

Proceed with [[_ GET STARTED - Setup Dedicated Server Checklist]]

