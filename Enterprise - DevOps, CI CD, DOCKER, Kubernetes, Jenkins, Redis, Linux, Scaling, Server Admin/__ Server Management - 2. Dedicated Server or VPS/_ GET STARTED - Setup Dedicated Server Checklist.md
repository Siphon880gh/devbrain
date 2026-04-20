Written by: Weng
Purpose: General checklist on setting up Dedicated Server. 

This guide walks you through setting up a dedicated server that you access by SSH from your computer’s terminal.

The dedicated server itself will not host a public website or a control panel such as cPanel or CloudPanel. Instead, we will divide **that** server into partitions that act like multiple VPS instances (Section "Dedicated Server: Split Dedicated Server into VPS").

Each VPS can then have its own web hosting setup, public-facing website, control panel, and even its own SSH access.

This gives you more control. If one web server has a problem, you can restart only that VPS via a simple command at the dedicated server's SSH or the VPS' dedicated server. This is instead of restarting the entire dedicated server. That matters because, with some providers, restarting the full dedicated server may require submitting a support ticket and waiting for them to handle it.

Setting up a dedicated server and splitting it into VPS-like partitions requires solid Linux knowledge which this guide will cover. You’ll be working across multiple layers—disk partitioning, running virtualized Linux environments, and configuring networking. One key part is setting up a virtual network bridge, which allows each VPS to have its own IP address that routes through the main IP of the dedicated server. When done correctly, each VPS appears as its own independent server on the internet, even though they all share the same physical machine.

```toc
```
## Reminder

Create a document for your provider / webhost (eg. GoDaddy, Hostinger, etc) to refer back to as you go through this checklist. Things you can record are credentials, user flows, terminal commands

## Checklist - Web Host to Website Capable

### Prepare your web host details document
- Besides credentials, there are commands, os specs, and other details you want to save somewhere about your web host that you may need to reference later

### What’s the appropriate Company and Dedicated Server package
- RAM, number of cores, storage space, etc. 
- Create a guide on how to communicate your full stack app or business use cas:, simultaneous users, memory use by the process and memory,  bandwidth use, storage disk space, etc to a server specialist that can decide the package and maybe install the architecture in the terminal.
- Does pricing include cpanel and os license?
	- Cpanel requires monthly payments and some Linux distros also require monthly payments. Or choose a free web hosting control panel and free linux distro? Downside of free may be lack of features and/or more custom terminal command work. Eg. Ubuntu 22 with CloudPanel
- If rented colocation (may have to ask their sales / support / etc)
	- Do we have an online remote access tool like IPMI (Intelligent Platform Management Interface) so we can do recovery, reinstallation, etc. Otherwise we have to ask support team to reinstall which could take hours and have our website downtime for hours.
	- Is there hardware virtualization supported on the CPU? This lets me create VMs that act like VPS, so I can house all business logic in the VPS and restart the VPS from my dedicated server SSH. Crashes would affect the in-housed VPS instead of the dedicated server. This prevents having to rely on the support team and I can get right to restarting, minimizing downtime. 
		- If there's hardware virtualization, is KVM (kernel) type of hardware virtualization supported? That's faster than the other types of hardware virtualization
		- How many VMs are supported with our current cpu cores and threads? For calculations, refer to [[Calculating number of VMs supported]]
		- If there's no hardware virtualization, is the server specs fast enough for OS based virtualization into VPS?
- Setup billing auto renewal?

### How to select for the hardware of dedicated server
- How much processing power do you need vs how cost effective is it

	- Is their offered cpu or gpu chip slow for your apps? A quick way to find out is: 
		- See if it's an old chip. You may need a contemporary chip especially if your app requires more power or you will/currently have competitors in the market who could beat you with more performance:
			- For example, you can AI prompt for: "How old is this intel : Intel(R) Xeon(R) CPU E3-1270 v5 @ 3.60GHz"
		- Do you need GPU (aka video card, aka NVIDIA) or a CPU chip?
			- GPU is more appropriate for AI / video generation / crypto mining
			- You can initially forego GPU if you can go for a 2018 or above CPU chip, which have special hardware for video encoding, etc.
		- Do you need consumer chip or enterprise chip?
			- Enterprise in other words is server or data center
				- Google: nvidia "data center" or server or enterprise processors list
				- Google: AMD "data center" or server or enterprise processors list
					- eg. AMD Epyc server with the 4004 series as cost-effective
				- Google: intel "data center" or server or enterprise processors list
			- Normal chips being fine:
				- Google: nvidia processors list
				- Google: AMD  processors list
					- eg. 3rd gen Ryzens
				- Google: intel processors list
		- Do you need AI / video generation / crypto mining?
			- Are you going CPU ($75/mo) or Video cards / GPU / Nividia ($200/mo)?
			- GPU is better for AI, video processing, and crypto mining
			- Refer to "Do you need GPU (aka video card, aka NVIDIA) or a CPU chip?"
		- What's the clock speed of the chip?
			- Eg. 3.60Ghz vs 4.70GHz
		- How is the chip's extra bells and whistles?
			- How much L3 cache is in the chip? 
				- Multiple concurrent users generating videos? You need a large L3 cache (Not Intel Xeon CPU E3-1270 v5's)
					- When one user generating video, it's able to work in cache more frequently
						- With a larger L3 cache, more data can be stored closer to the GPU cores, reducing the number of cache misses.
					- With multiple users, it work in cache less frequently
						- In summary, with multiple users, the cache is less likely to hold the relevant data for any given user at a given time, reducing its overall effectiveness and leading to more frequent accesses to the slower main memory RAM
					- The memory manager is the slowest component in the CPU and accessing RAM or flushing the cache is another few cycles wasted
						- The memory manager is responsible for managing the flow of data between different levels of memory (e.g., L1, L2, L3 caches, and RAM). When the GPU frequently accesses RAM, the memory manager has to work harder to coordinate these data transfers, manage cache coherency, and ensure efficient use of memory resources. This increased workload can create overhead, indirectly affecting performance.
						- If the L3 cache is larger, it can store more frequently accessed data, reducing the need to access the slower RAM.
						- A larger L3 cache may also reduce the frequency of cache flushes, as it can hold more data before needing to evict older data to make room for new data.
						- Eg. Intel Xeon CPU E3-1270 (Q4 2015 release) has 8MB L3 cache shared among the cores
				- Background: Larger L3 cache means more performance. While CPU and GPU's have different caching strategies (GPU's have additional caches than just L1, L2, L3 caches because they're focus in parallel processing tasks like rendering or running machine learning models in order to reduce latency by mitigating need to access memory and in order to improve throughput) (CPU's have usually L1, L2, L3 cache and does not have as extreme of a goal as GPU's). You can read more on CPU/GPU caching at [[_Computer Architecture - Processor L3 Cache and Clock Speed]]

- How many cores? How many threads per core?
- How much RAM memory?
	- Depending on your CPU/GPU chip, it supports only certain types of RAM technology, eg. DDR4, DDR5, EEC. You'll want to consider the power of that type of RAM, its memory size, and the price - to balance cost effectiveness and business requirements.
	- For more details, refer to [[_Computer Architecture - RAM types (DDR4, DDR5, ECC, etc)]]
- How much file storage?
- How many IPs are you given (to setup other VPS, other services on their own IP for performance, etc)

### How to select for OS and identify package installer
- They usually install for you so you choose the OS
	- Ubuntu has many things setup to work for Linux admin
	- Debian is barebones and require some setup (installing sudo, etc) but has so much more hard disk available for you and less CPU use
- And then find out what the package installer is based on the OS name (Search Google)
	-  Eg., Google: Ubuntu package installer
	- For Ubuntu, it’s apt
- You will update the package installer's repository source lists because you just had a fresh installation

---

### Managing your dedicated server
Likely your dedicated server does not have a web host admin panel (Hostinger hpanel, GoDaddy’s dashboard, etc). So figure out the processes other than having a GUI:
- What email to reach out to for managing billing information
- How to start a support ticket (probably email and they have a system where when the ticket is closed, that email thread will be ignored). If email, what information do they need.
- For your chosen OS, how to restart OS, and how to check if a service restarted with the OS?
- What commands to list server’s hardware specs (in case don’t have when making future business migration decisions)
-  Save the above information into your web host details document

---

### **SSH Root Access** (Option: Handed to you)
- **Dedicated Server only:** It's unlikely there will be a web gui for dedicated server. You'll mostly be interacting with your server via SSH and any web gui's you install. Often times their server administrator will setup SSH IP, root, and password, then hand it to you on email onboarding. You'll also be given a range of ip addresses available. The rest is up to you.
- **VPS only:** See if the webhost handed the SSH Root user credentials to you at the panel that appears after logging into your webhost (eg. Hostinger hpanel, GoDaddy Dashboard). How to navigate to this information?

- If they did not hand it to you, you have to setup SSH root access manually - refer to next section.
- The provider gave you root user credentials - Are you able to login into root at the local machine terminal with SSH?
- Did the provider give you non-root user credentials as well?
	- If they've tightened security, logging into root with ssh command is disabled. The command `ssh root@XXX.XX.XXX.XX` appears to work as usual, and you might not even be privy to it being disabled because it will let you enter a password and all it will ever say is that the password is incorrect. This is by design so that hackers don't get clued in to try gaining access in other ways. This may also be why the provider gave you user credentials.
	- You'd log into the that user with `ssh USER@XXX.XX.XXX.XX`, and once in the remote SSH session, you elevate by running `su`, followed by root user password; then it will switch from the normal user to the root user.
	- To disable or enable root login, refer to [[SSH with Root Login Disabled]]
- Once in remote server, how to navigate to get to your website files using cd commands? (Go into CloudPanel or Cpanel for a clue). Aka root web directory for your website,  Aka working directory for your code and webpages. Alternately you could have in a text document the full path so you can copy and paste the cd path into the terminal. But knowing how to navigate there in terminal can be helpful if you don’t have the full path easily accessible to copy and paste. There will probably be hidden folder .ssh, hidden file .bash_profile, etc, which you can see by running `ls -la`. 
- Using password authentication, run it as: `ssh root@REMOTE_IP -p 22`. Then enter your password when asked. Once that goes through, start to setup SSH key file passwordless login to toughen your SSH security.
- In case you get locked out of SSH, do you know how to access SSH terminal from the webhost's panels? Then you can restore SSH access for your local machine's terminal.
	  
- You could change your root password. Usually the root password handed to you is very randomized and hard to remember.
	- Change your password by running `sudo passwd root`, then you will be prompted for a new password
	- **Dedicated Server only**: Choose a password that's not related to your personal passwords because you may be sharing this password with the web host's server admin when there are problems only they can fix.
  
- **Dedicated Server only**: If splitting the dedicated server, you'll be setting up SSH root access again at your VPS VM at a later section. Various benefits of splitting dedicated server into one or more VPS VM includes one command restart instead of waiting on a ticket to restart dedicated service, isolated VPS that you can troubleshoot when hacked, etc.

### **SSH Root Access** (Option: Manually Setup SSH Root User Credentials)

In the case SSH Root password is not automatically setup and then handed to you, you'd still want to remotely connect to your server to manage files, configuration, and dependencies from our local machine's terminal. The SSH command allows us to do so and there are various ways to authenticate with the SSH command.

Because we don't want hackers just attempting to hack ssh, we're gonna go for passwordless ssh login for authentication method. 

At your local machine, generate a SSH key pair using your email address that you signed up with your VPS for:
- Adjust your email address
```
ssh-keygen -t ed25519 -C "your_email@example.com"
```

At your VPS, for example Hetzner, upload the public SSH key's contents (the text inside the file). This is done through a feature you press like "Add SSH key" (so no need to go into SSH terminal which you don't have access setup for yet). Keep the private and public keys on your computer.

> [!note] UI UX Confusion
> Later, after you add an SSH key, some hosting dashboards still do not clearly show that a key is already on your account. For example, as of April 2026, Hetzner may still show a menu option to create an SSH key, which can make it look like no key exists yet. But when you click that option, it actually takes you to the SSH key list, where your existing public key is shown
>

Once SSH key pair has been established, run this command at your local machine's terminal to test logging into SSH passwordless:
- Adjust private SSH key path and ip
```
ssh -i ~/.ssh/newmac2023_hetzner -p 22 root@5.55.555.555  -tt "cd .  && bash --login"
```

Sysadmin experience:
- You can now cd into a specific folder everytime (adjust the . path)
- You can also setup an alias at your .bash_profile or .z_profile so that running the alias in terminal can log you into ssh. I like to name my alias after my hostname or web host company name.
### Establish rsync connection

Note: Do this only after SSH connection is worked out.

There may be times you want to use rsync to download large files (such as backing up for restoring your server). Rsync can easily handle gigabytes of data. If the download is interrupted, it can resume the download. And - it shows the progress. However the specifics like what the command exactly looks like (authentication method, username, ip, etc) may change depending on environment.

Create a test.txt anywhere in your Linux server file system (doesn't matter if is in the web root), try to tar.gz it up, then exit SSH. Now try to download that tar.gz from remote to local using rsync.

Once the rsync command is figured out, record that to the folder where you save your webhosting credentials. It'd be a document on backup SOP. **Record rsync command**, for example:
```
rsync -avz --partial --progress -e "ssh -i ~/.ssh/some_ssh_key.pub" root@55.555.55.555:/home/wengindustries/htdocs/a.tar.gz . 
```

You may also want to **record the tar command**s. Get the unarchive command (Ask ChatGPT to reverse your command to unarchive).

Progress bar could look like real time text out and replace on the terminal:
```
Transfer starting: 1 files
a.tar.gz
     1066690237  20%    3.51MB/s   00:19:54
```

Now rename the local file then try the other direction - upload to your server. Record the upload rsync command. Could look like:
```
rsync -avz --progress --partial --append b.tar.gz root@31.220.18.169:/home/wengindustries/htdocs
```

Make sure to **record this local upload to remote server** (along with your computer basic stats because the rsync command syntax may differ by OS) in the document too.

---
## Dedicated Server: Is Linux Admin Ready?
- With dedicated server, they might install a bare bones OS version. This means some commands you expect to help with Linux administration like sudo might be missing! Package installer might be missing sources to search packages from. 
- This is especially true for Debian 12, etc. although it's performant because it's bare minimum. In that case, refer to the folder to finish setting up the OS so you can admin the server properly: [[Debian breaking into new shoes]]

---

## Dedicated Server: Split Dedicated Server into VPS
Do your own the dedicated server or are you renting it from a colocation?

If renting: When you reinstall the server (often times you're setting up the dedicated server from scratch and you mess up locking yourself out, you ask support team to reinstall the server), there could be hours of downtime while waiting on support team.

If you virtualized a VM in the form of a VPS inside the dedicated server, then you can isolate these lockouts to the VPS. Then from within the dedicated server, you have the ability to reinstall / restore the VPS without needing to contact support.

If you want this ability: First you need to find out if you will perform OS virtualization or hardware virtualization (the faster). Then with hardware virtualization, are we performing KVM hardware virtualization (the fastest) or other types of hardware virtualizations. In addition, you have to find out if the dedicated server is itself virtualized by the provider, then is nested virtualization enabled. All these questions should've been asked to the provider before deciding on the dedicated server.

BACKGROUND KNOWLEDGE: In order to know how to virtualize VMs, you need to understand the concepts at: [[Splitting Dedicated Server into VPS (via VMs) - Fundamental Concepts]]

BACKGROUND KNOWLEDGE: You also need to understand some basic Networking because you will have to setup the internet traffic flow to your VMs that act as VPS and know how to setup DHCP to assign the VPS public IPs that the internet network understands.

And to find out if your dedicated server can support the VM - say the customer support or sales team won't elevate your questions - you can find out through command line (and hopefully you are not locked into a one year contract): [[Splitting Dedicated Server into VPS (via VMs) - Find out if can support]]

ACTION: Once you found out the right type of virtualization and that it'll be performant, you'll look up guides on how to perform the virtualization on your OS. You do this before installing any web servers, etc. For example, eg. Google: Ubuntu 22 KVM virtualization. Some other tools could be Cockpit, Proxmox, Xen

For example, This is a guide for Xen (type 1 hypervisor, no KVM): [[Xen - Setup XEN VMs (Type 1 Hypervisor, no KMV) - Part 1]] which could continue into part 2 [[Xen - Setup XEN VMs (Type 1 Hypervisor, no KMV) - Part 2]]


#### Summary by the time you are done creating a VPS:

Note this is a summary. These are not instructions to be followed. Follow the instructions from the tutorial links above.

lscpu to show about cpu. I read what type of hardware virtualization. I decided Xen because KVM (kernel-based vm) hardware virtualization wasn’t available, which is unfortunate because that’s faster. If no hardware virtualization available, I would have went with OS which is the slowest.

I installed xen

Then I setup the system to boot into the xen hypervisor that works with hardware virtualization so I’ll be capable of creating VMs. I went to edit: `vi /etc/default/grub`. And I edited in `GRUB_DEFAULT="Debian GNU/Linux, with Xen 4.17-amd64 and Linux 6.1.0-22-amd64"`. I know the values are gonna be different system to system so I arrived at this by running `grep -E "menuentry " /boot/grub/grub.cfg`  to find out what fits my system’s Xen version that I would be booting into. Before I reboot, I ran `sudo update-grub` to apply the settings, otherwise it'd boot back into the same system rather than the Xen hypervisor version. Rebooted running `sudo reboot`

Because it was booted into Xen, I could verify the xen hypervisor was working:  `xl info`. And it was fine with no errors, so it reported Xen information. I could've ran `xl info | grep caps`  just to verify the type of hardware virtualizations was possible, but I already knew from earlier that hardware virtualization is possible, but the faster KVM hardware virtualization was not possible.

Then I looked at my computer resources and network speed to make determinations on how much Im allocating to the VM. Usually 90% if Im only going to ever have one VPS on the dedicated server (for the purpose of having an isolated system I could restart or restore without the dedicated server being down, since I dont own the physical machine in front of me and have to ask support for help which could mean the website is down for half a day). 

Keeping those resources in mind, I created a partition for the new VM. Initially actually I could not create new partitions because there is only one main partition and it's the root filesystem my SSH session is on, so I reached out to partition to help. In the end of partition, I reviewed my partitions with `lsblk`. It looked like:
```
NAME               MAJ:MIN RM  SIZE RO TYPE MOUNTPOINTS  
sda                  8:0    0  223G  0 disk   
├─sda1               8:1    0 14.9G  0 part [SWAP]  
├─sda2               8:2    0 46.6G  0 part /  
├─sda3               8:3    0 46.6G  0 part /backup  
├─sda4               8:4    0    1K  0 part   
└─sda5               8:5    0  115G  0 part   
sr0                 11:0    1 1024M  0 rom   
```

  
I then start the chain of commands that will make sda5 into a volume group (eg. called vg0) because xen-create-image needs a volume group that designates your partition can be split into further "partitions" (actually called logical volumes) for the purposes of VM. There was actually a lot involved because it wasn't a straight partition to volume group. The support team left unallocated sectors from sda for me to allocate as I wished, so I allocated it as extended partition of 115gb, then designated all the extended partition as logical partition. The logical partition is sda5, which is the partition that can be mountable, so that's the partition that becomes volume group (but firstly I must assign it as physical volume, then I can assign them as volume group). Xen-create-image then slices the sda5 logical partition via its volume group assignment, into 15GB swap and 99GB VM (I had to use less than 100GB because it couldn't take). When you run the more detailed command `sudo fdisk -l /dev/sda`, you'll see:
```
Device     Boot     Start       End   Sectors  Size Id Type
/dev/sda1            2048  31250431  31248384 14.9G 82 Linux swap / Solaris
/dev/sda2  *     31250432 128907263  97656832 46.6G 83 Linux
/dev/sda3       128907264 226564095  97656832 46.6G 83 Linux
/dev/sda4       226564096 467664895 241100800  115G  5 Extended
/dev/sda5       226566144 467664895 241098752  115G 83 Linux
```
And running `lsblk` after all that was:
```
NAME               MAJ:MIN RM  SIZE RO TYPE MOUNTPOINTS
sda                  8:0    0  223G  0 disk 
├─sda1               8:1    0 14.9G  0 part [SWAP]
├─sda2               8:2    0 46.6G  0 part /
├─sda3               8:3    0 46.6G  0 part /backup
├─sda4               8:4    0    1K  0 part 
└─sda5               8:5    0  115G  0 part 
  ├─vg0-vps0--swap 254:0    0   15G  0 lvm  
  └─vg0-vps0--disk 254:1    0   99G  0 lvm  
sr0                 11:0    1 1024M  0 rom  
```

xen-create-image was assigned to the volume group along with the computer resource: allocations: `sudo xen-create-image --force --verbose --hostname=vps0 --dhcp --lvm=vg0 --size=99G --memory=24G --swap=15G --debootstrap --dist=bookworm --arch=amd64 --mirror=[http://deb.debian.org/debian/](http://deb.debian.org/debian/) --debootstrap-cmd='/usr/sbin/debootstrap'`

That command not only created an image I could start a VM from, but it also created the config file for the mounting, further splitting of the partition into logical volumes for the VM and its swap file, and resource allocations for the VM

When I ran `xen create vps0`  which is the name of the hostname I assigned during xen-create-image, it creates the VM if a virtual bridge had existed to allow computers to virtually connect to the physical network of the host machine (dedicated server) and the gateway (aka router). The virtual bridge is coded into existence by editing the networking existence at `/etc/network/interfaces` 

Upon successful start of the VM, I console into the VM and edit its networking settings at the VM’s `/etc/network/interfaces`  and assign it a static public IP so that the internet can connect to my VM as though it’s a VPS offering webpages. I can figure out public IPs are available to my VM by looking at the information my provider / web host given to me (either it’s a CIDR IP, a netmask, or an actual list of available IPs) and making sure the IP I choose is not the already taken by other devices on the network (and I run commands to check the ip addresses of connected devices).

Because there’s a public IP and I have a root username and password (it was announced in an installation instructions output when I started the VM with `xen create vps0` ), then I tried connecting SSH into the VPS from my home computer. By being successful, it meant I connected over the internet to the VPS via port 20.

  
#### Outline summary by the time you are done creating a VPS:

- Partitioning the dedicated server to have a VM partition
- Convert the VM partition into a VPS that can host website with a virtual bridge and think about a static IP assignment
- VPS gets assigned a static IP
- VPS is hosting the web app and the wordpress promotional website, for example
- Rundown on the server side is: Dedicated server partitioned to have a VM that is exposable as a VPS on the internet
  
- Allocate resources on the VPS to the microservices with gunicorn
- Consistent environment with pyenv (substitute forDocker + AWS)
- Process supervision for always on
- Rundown on the VPS side is: Supervisor -> Sh files -> Gunicorn allocating resources to microservices


The rest of hosting a webpage on the VPS is a matter of installing nginx/apache/cloudpanel which opens up ports 80 and 443. Then pointing a purchased domain name to the VM’s public IP so people can practically visit it from the domain name. Then adding SSL through cloudpanel for free, unless I need to buy a SSL for stricter business regulations purposes.

---

### **Dedicated server's VPS VM partition**: Install Web server (Nginx vs Apache) VS Install CloudPanel Instead

By purchasing a dedicated server, it can become whatever server you want it to be (gaming server, blockchain server, website server). It won't be able to host websites out of the box though.

However we took advantage of dedicated server being able to be molded into pretty much anything: We created partitions out of it. The dedicated server was partitioned to have one or more VMs that are exposable on the internet with an assigned a static IP

---

**MAJOR CHECKPOINT**
If you indeed split the dedicated server - all instructions below is setting up one of your VM aka VPS:

---

In order to have a website people can visit and a setup that makes it easy for the web developer to manage the website, you have to install a web server, FTP, and a webhost panel. You can first  install the webserver

**MAJOR CHECKPOINT**
Do you plan to install the web hosting panel CloudPanel (Recommended that you do)? It is best to install WITHOUT nginx having been installed. **In that case, skip to the next section "How to decide on a Web Hosting Control Panel...".** 
- Proof per their documentation's instructions: "For the installation, you need an empty server with Ubuntu 24.04 or 22.04 or Debian 12 or 11 with root access." (https://www.cloudpanel.io/docs/v2/getting-started/other/). This means you DO NOT install nginx or any web server. The CloudPanel will install nginx and other technologies with it. If you messed up, CloudPanel will still work but `apt` could potentially always bother you about an incomplete Cloudpanel post installation script, you could potentially have to add www-data to every new group that is created when you create a new site, just so webpage can show and many cloudpanel features work for that site. In addition, Cloudpanel logs can keep complaining about a half-configured cloudpanel. Cloudpanel would still work, however. It's because Cloudpanel's nginx couldn't replace your nginx that already exists, so the post installation script can never finish.
- Otherwise, there may be weird error logs and extra steps for every new site you create (www-data added to new group). Cloudpanel will still work.
- Cloudpanel has no clean way of uninstallation or reinstallation as of 8/2024 and the recommended route is to reinstall your entire server.

If you DO NOT plan to install CloudPanel, you may proceed with directly installing the web server Nginx or Apache by continuing this section:

1. Install web server

- Choose webserver (nginx or apache) and firewall (uwf or iptables). You want to install a web server AND a firewall because once you open your public IP to the internet, you need a firewall against malicious hackers. You can research pro’s and con’s of nginx vs apache (Briefly, Nginx can handle a lot more traffic than Apache, but Apache has a better developer experience with .htaccess, etc)

- Eg. Google: Ubuntu 22 install nginx with ufw
	- Brief from: https://www.digitalocean.com/community/tutorials/how-to-install-nginx-on-ubuntu-22-04
	- Run `sudo apt update` then `sudo apt install nginx`
	- Check if ufw is installed by running `sudo ufw --version`. If need to be installed, eg. Google: ubuntu 22 install ufw
	- Check if firewall is on by running `sudo ufw status`. If it says inactive, then you should enable the firewall: `sudo ufw enable`. 
	- Then open the ports with `sudo ufw allow 'Nginx HTTP'` and `sudo ufw allow 'Nginx HTTPS'`
	  
- Eg. Or Google: Ubuntu 22 install apache

2. After you've installed a firewall, do NOT close out your SSH terminal. 

- Allow port 22 by running:
```
sudo ufw allow 'OpenSSH'
```

If that didn't work then it's because OpenSSH is not a listed convention name port at `sudo ufw app list`, then try adding the numberic port instead: `sudo ufw allow 22`.

The `sudo ufw status` shows the rules, but to make sure the rules take effect, run `sudo ufw reload` 

4. Test your webserver
Get your public ip address which is not necessarily the ip given to you by the onboarding server server admin.

```
curl -4 ipinfo.io/ip
```
^ This is one of the free services that responds with your ip address

---

### How to decide on a Web Hosting Control Panel
- Cpanel - monthly pay
- Cloudpanel - free
- Refer to [[Server OS and Control Panel Packages]]

### **Dedicated server's VPS VM partition**: Install a Web Hosting Control Panel

- There are Web Hosting Control Panels that require monthly payments for the license to use.
	- Not free: Cpanel, Plesk
	- Free: Ubuntu use cloudpanel. 
	- Free: AlmaLinux use webmin
- Let's say you chose CloudPanel for your Ubuntu 22:
	- See if your server has a hostname configured. You can check in one of these ways:
		- See the default hostname at the control panel that appears after logging into your web host (if they provide a default hostname)
		- Or it's the A record you pointed to your web-host IP at your DNS Registrar and you're able to visit your website via that domain address. 
		- Or you can run `hostnamectl status` and look for a "Static hostname" value in the terminal output. If there's no hostname, you need to set a hostname at the server side as explained at the "If dont have a hostname" section of the Cloudpanel instructions here at [[Manual installation of Cloudpanel via SSH terminal]]
		- Without a hostname, Cloudpanel won't properly install
	- Eg. Google ubuntu 22 nginx install cloudpanel
	- Brief from: https://www.cloudpanel.io/docs/v2/getting-started/other/. Notice the URL; Look up if there are newer versions of the documentation. Make sure you're not following an old version's instructions, like v1
	- The instructions could be (Cloudpanel installations is missing the step of stopping the services):
		1. You must stop all port 80, 443, and 3306, if they've been installed (Ideally, they were never installed because Cloudpanel installs best on an empty system). Otherwise, when it installs Cloudpanel it will say the ports are in use. Run those that are applicable:
			```
			sudo systemctl stop apache2
			sudo systemctl stop nginx
			sudo systemctl stop mysql	
			```

			
		2. Updating repo list:
			```
			apt update && apt -y upgrade && apt -y install curl wget sudo
			```
		3. Install CloudPanel with MySQL 8.0 (CloudPanel requires a database):
			```
			curl -sS https://installer.cloudpanel.io/ce/v2/install.sh -o install.sh; \
			echo "2aefee646f988877a31198e0d84ed30e2ef7a454857b606608a1f0b8eb6ec6b6 install.sh" | \
			sha256sum -c && sudo bash install.sh
			```
			
	- Once done installing, the terminal will output the public IP plus the port number to visit, which could be **https://yourIpAddress:8443**
	- If firewall, you have to enable the port: `sudo ufw allow 8443`, then apply the rules right away with `sudo ufw reload`. Go to the webhosting panel and setup a username and password right away because hackers have bots constantly scanning this port for setup opportunities.
	- Save the URL and CloudPanel credentials into your webhost details document. If you have an alias for quick SSH login, you might want to also save it as an echo before the ssh or sshpass command.
- Figure out if the Web Hosting Control Panel included other techs so you dont have to install them later. Cloudpanel-MySQL installation should include MySQL and PHP. You can find out for example by running:
	- `mysql --version`
	- `php --version
	- `which nginx`
	- If MySQL installed (which is on CloudPanel unless you installed with their MariaDB option). FYI: You may poke around CloudPanel's core files and see a db.sq3 file. CloudPanel uses SQLite3 internally but installs MySQL for web developer use. 
		- To get the master credentials to see all databases, you run `clpctl db:show:master-credentials` and visit this url to login with those credentials 
			- https://XX.XXX.XX.XXX:8443/pma
		- Save the MySQL URL and credentials into your webhost details document. If you have an alias for quick SSH login, you might want to also save it as an echo before the ssh or sshpass command.

### How to log into Web Hosting Control Panel (Cpanel, Cloudpanel, etc)
- What’s the link with port number (Different web hosting services may assign different port for your panel). 
  eg. Cloudpanel on Hostinger [https://XX.XXX.XX.XXX:8443](https://XX.XXX.XX.XXX:8443)
- What are your login credentials?
- VPS: How to navigate to your panel at the Services Dashboard (if you don’t have the link handy)
	- what’s their information architecture (to help remember how to navigate there).  
	- eg. Hostinger’s: Hostinger believes CloudPanel manages the Ubuntu operating system with the purpose of web site and related services, hence you find CloudPanel under left panel item Settings (think VPS) → Operating System -> then “Manage Panel” button on the OS page
- Save the Web Hosting Control Panel URL and credentials into your web host details document. If you have an alias for quick SSH login, you might want to also save it as an echo before the ssh or sshpass command.

asdf

---

## Dedicated Server: Test Web Hosting Control Panel that You Manually Installed

Because you installed the Web Hosting Control Panel yourself rather than being on a VPS that installed it for you, there could be broken chains. Check Cloudpanel throughly to see it works:

Briefly:
- Check if Cloudpanel Vhosts can save
- Check that you can create free SSL with Let's Encrypt inside CloudPanel

Brief outline of what we are testing specifically:
- If gives a "redirect loop detected" error when visiting http://www.domain.com
- If gives a 404 Let's Encrypt error
- If goes to 500 internal server Let's Encrypt error
- Vague general error that something went wrong when saving Vhost
- After Let's Encrypt successful, opening http doesn't redirect to https
- After Let's Encrypt successful, opening www fails (this is only for your root domain and not for subdomains)

If the Let's Encrypt Self-SSL certification has errors, the big picture is: Let's Encrypt looks at the document root to create the file to perform the validation, and that document root can be set in the web hosting control panel (CloudPanel -> Settings -> Root Directory). And also you may have to disable https redirect so the Let’s Encrypt can check for the file at http.

- **TESTS BEGIN**
  
	- **If gives a "redirect loop detected" error when visiting http://www.domain.com:**
		
		- Notice it said Redirect loop detected. It’s because the Let’s Encrypt is visiting to a www.
		- This will correlate to visiting http://www.domain.com giving this error:
			![](v3Cnk6m.png)
	
		- Solution:
			1. Comment out this server block (you'll make it active again after installing SSL in the future, but at the moment this will fix the loop problem)
				```
				server {  
					listen 80;  
					listen [::]:80;  
					listen 443 quic;  
					listen 443 ssl;  
					listen [::]:443 quic;  
					listen [::]:443 ssl;  
					http2 on;  
					http3 off;  
					{{ssl_certificate_key}}  
					{{ssl_certificate}}  
					return 301 https://www.domain.tld$request_uri;  
				}
				```
			2. Comment out https scheme rewrite at the other block (You'll make it active again after installing SSL in the future, but at the moment this will fix the loop problem)
			```
			#if ($scheme != "https") {  
			#  rewrite ^ https://$host$request_uri permanent;  
			#}  
			```
			
			3. At your main server block for 80 and 443, add the www (See server_name line):
				```
				server {  
				  listen 80;  
				  listen [::]:80;  
				  listen 443 quic;  
				  listen 443 ssl;  
				  listen [::]:443 quic;  
				  listen [::]:443 ssl;  
				  http2 on;  
				  http3 off;  
				  {{ssl_certificate_key}}  
				  {{ssl_certificate}}  
				  server_name domain.tld www1.domain.tld www.domain.tld;  
				  {{root}}
				  # ...
				```

			4. At your 8080 port server block, also do the same:
				```
				server {  
				  listen 8080;  
				  listen [::]:8080;  
				  server_name domain.tld www1.domain.tld www.domain.tld;  
				  {{root}} 
				  # ...
				```

	- **If gives a 404 Let's Encrypt error:**
			```
			app.domain.tld: Domain could not be validated, error message: error type: urn:ietf:params:acme:error:unauthorized, error detail: 222.22.222.25: Invalid response from http://domain.com/.well-known/acme-challenge/hj0GXFJ_sW2VzVOjxxYaeyp9AXnPyz800-C3WL0zgEU: 404
			```
		- **Solution 1 to 404 Let's Encrypt error**:
			1. Comment out this server block (you'll make it active again after installing SSL in the future, but at the moment this will fix the loop problem)
				```
				server {  
					listen 80;  
					listen [::]:80;  
					listen 443 quic;  
					listen 443 ssl;  
					listen [::]:443 quic;  
					listen [::]:443 ssl;  
					http2 on;  
					http3 off;  
					{{ssl_certificate_key}}  
					{{ssl_certificate}}  
					return 301 https://www.domain.tld$request_uri;  
				}
				```
			2. Comment out https scheme rewrite at the other block (You'll make it active again after installing SSL in the future, but at the moment this will fix the loop problem)
			```
			#if ($scheme != "https") {  
			#  rewrite ^ https://$host$request_uri permanent;  
			#}  
			```
			
			3. At your main server block for 80 and 443, add the www (See server_name line). Skip this step if your domain is a subdomain (like app.domain.tld):
				1. 
				```
				server {  
				  listen 80;  
				  listen [::]:80;  
				  listen 443 quic;  
				  listen 443 ssl;  
				  listen [::]:443 quic;  
				  listen [::]:443 ssl;  
				  http2 on;  
				  http3 off;  
				  {{ssl_certificate_key}}  
				  {{ssl_certificate}}  
				  server_name domain.tld www1.domain.tld www.domain.tld;  
				  {{root}}
				  # ...
				```

				2. At your 8080 port server block, also do the same:
				```
				server {  
				  listen 8080;  
				  listen [::]:8080;  
				  server_name domain.tld www1.domain.tld www.domain.tld;  
				  {{root}} 
				  # ...
				```


			4. Restart your nginx server: `systemctl restart nginx` Then try to create the SSL again.

		- **Solution 2 to 404 Let's Encrypt error**: 
		  See if can recreate the folder path and add a file to see if you can visit it on your web browser. The folders are missing because the way Let's Encrypt works is it creates the folders and file then removes them.
			- Make sure you've cd into your document root (Refer to vhost for whats the folder path to your document root when someone visits your domain at top level /). Then create a file from here:
				```
				mkdir -p .well-known/acme-challenge/
				vi .well-known/acme-challenge/test.txt
				```
			- Add some unique text in the file. Then visit the link in your web browser like domain.tld/.well-known/acme-challenge/
			- If successfully visited, then this solution isn't it. Before going to "Solution 2", remove the test file and folders leading to it with
			```
			rm -rf .well-known
			```
			
		- **Solution 3 to 404 Let's Encrypt error**: 
		  Did you modify the server root manually so that another folder is served?
				- Set it back to the original document root for now because CloudPanel creates the .well-known/... path to the document root that had been saved into Cloudpanel (instead of reading the vhost). OR: Go to CloudPanel -> Settings -> Root Directory and permanently adjust the root directory there
				  ^  Dont forget to change it at both 80/443 server block and 8080 block.
			- Once SSL is done generating, you can change the document root back to your desired location. Don’t forget to change it at both 80/443 server block and 8080 block.
		- **Solution Last resort to 404 Let's Encrypt**:
			- Remove `www....` as one of the domain names for New Let's Encrypt
			- You'd forego users visiting with "www"
		
	- **If goes to 500 internal server Let's Encrypt error:**

		- Check nginx error log to determine cause of Vhost 500 error:
		```
		tail /home/clp/logs/nginx/error.log
		```

		- If the Cloudpanel vhost 500 error is from a missing file or folder:
		```
		2024/08/03 08:27:19 [error] 154388#154388: *84 open() "/home/clp/htdocs/app/files/public/site/100pullups.app/ext-searchbox.js" failed (2: No such file or directory), client: 209.65.62.26, server: _, request: "GET /site/100pullups.app/ext-searchbox.js HTTP/2.0", host: "222.22.222.24:8443", referrer: "https://222.22.222.24:8443/site/100pullups.app/vhost"
		```

		- Then this lack of folder means the installation likely was corrupted. Go to home/ and change the permissions to 777 and owner to root on the clp or cloudpanel folder. Then rerun the installation command as root user or sudo user. The installation will later reset clp or cloudpanel to the correct ownership and permissions
			- If during the installation, it complained often about missing file error `/home/clp/htdocs/app/files/var/log/prod.dev: No such file or directory`, then create the folders like so:
			   `mkdir -p /home/clp/htdocs/app/files/var/log/`. Then rerun the installation again. 
			- When reinstallation successful, you should be able to visit the Cloudpanel in your web browser and it'll remember your previous admin user and sites.

		- If the Cloudpanel vhost 500 error is because of file permission problems:
			```
			2024/08/03 10:36:17 [crit] 266908#266908: *96 open() "/var/lib/nginx/body/0000000005" failed (13: Permission denied), client: 209.65.62.26, server: _, request: "POST /site/test3.com/vhost HTTP/2.0", host: "222.22.222.24:8443", referrer: "https://222.22.222.24:8443/site/test3.com/vhost"
			
			2024/08/03 10:36:38 [crit] 266908#266908: *110 open() "/var/lib/nginx/body/0000000006" failed (13: Permission denied), client: 209.65.62.26, server: _, request: "POST /site/test4.com/vhost HTTP/2.0", host: "222.22.222.24:8443", referrer: "https://222.22.222.24:8443/site/test4.com/vhost"
			
			2024/08/03 10:37:02 [crit] 266908#266908: *118 open() "/var/lib/nginx/body/0000000007" failed (13: Permission denied), client: 209.65.62.26, server: _, request: "POST /site/test4.com/vhost HTTP/2.0", host: "222.22.222.24:8443", referrer: "https://222.22.222.24:8443/site/test4.com/vhost"
			
			2024/08/03 10:37:07 [crit] 266908#266908: *120 open() "/var/lib/nginx/body/0000000008" failed (13: Permission denied), client: 209.65.62.26, server: _, request: "POST /site/test4.com/vhost HTTP/2.0", host: "222.22.222.24:8443", referrer: "https://222.22.222.24:8443/site/test4.com/vhost"
			
			2024/08/03 10:37:14 [crit] 266908#266908: *125 open() "/var/lib/nginx/body/0000000009" failed (13: Permission denied), client: 209.65.62.26, server: _, request: "POST /site/test4.com/vhost HTTP/2.0", host: "222.22.222.24:8443", referrer: "https://222.22.222.24:8443/site/test4.com/vhost"
			```


		- Have these checks to fix file permission errors so that cloudpanel can work with nginx:
			1. sites configs
				```
				chmod 755 -R /etc/nginx/sites-enabled; chmod 755 -R /etc/nginx/sites-enabled; chown root:root -R /etc/nginx/sites-enabled; chown root:root -R /etc/nginx/sites-enabled;
				```

			2. nginx process
			```
			chown -R root:root /var/lib/nginx; chmod -R 777 /var/lib/nginx
			```

			3. html documents
				Check that: /home/ have folder named by usernames which are named after the sites you create at cloudpanel. Each folder is owned by their respective username and group of same name. They should be drwxrwx--- permission at mod 770. For example:
				```
				drwx------  8 clp                      clp                            4096 Jun 14 01:41 clp
				
				drwxrwx---  8 wayneteachescode         wayneteachescode               4096 Jun 23 10:10 wayneteachescode
				
				drwxrwx---  8 wayneteachesproductivity wayneteachesproductivity       4096 Jun 23 10:26 wayneteachesproductivity
				
				drwxrwx--- 12 wengindustries           wengindustries                 4096 Jul 23 10:22 wengindustries
				```

			4. Try again. If still fails because of file permission issues:
			   Your CloudPanel or Nginx may have some conflict that prevents permissions from being reconciled between www-data and the new user and group pair for every new site created at Cloudpanel.
			   - Make sure nginx uses `www-data` (on Debian/Ubuntu systems) or `nginx` (on CentOS/RHEL systems). Find out by editing the nginx main conf file which could possibly be `vi /etc/nginx/nginx.conf`. It's at the top of the file like `user www-data www-data`
			   - Then every time you created a new site (and for all sites you haven't set those up for), add the web server user to the site group:
				```
				sudo usermod -aG a100pullups www-data
				```
			- Reworded: Every site I create on cloudpanel, I have to add the www-data user to the new group (which is associated with the new site user). Otherwise, the webpage wont load and when I check the error.log for that website, it shows file permission / permission denied. But if I add the www-data user to the new group, that gets fixed.
			- You will have to add to your webhost details document that this reconciliation must be done manually every time you create a new site. Also recommend adding a fake site in CloudPanel titled "00oncreate-add-www-data-to-site-group" which will remind you whenever you create a new site and return to the list of sites because this is the first item in the list. You can add the usermod command into the SSH keys section of that fake site as reference notes.
				- You add www-data to the site-group like this:
					```
					sudo usermod -aG a100pullups www-data
					```

	- **Vague general error that something went wrong when saving Vhost**
		- Check syntax where the nginx primary config combines with site's vhost by running
		```
		sudo nginx -t
		```
	
		- If you get an "Unknown log format", refer to fix at [[Nginx Troubleshooting - Unknown log format]]

		
	- **After Let's Encrypt successful, opening http doesn't redirect to https:**
		- Undo the commenting out that you've done to fix previous Let's Encrypt errors. Rationale: You no longer have to permit staying on http:// without redirection in order for Let's Encrypt to see its own file it generated at the http url in order to prove you pointed to it with DNS
		  
	- **After Let's Encrypt successful, opening www fails (this is only for your root domain and not for subdomains):**
		- Make sure to add the "www" alternate domains in the 40/443 server block and the 8080 server block.


- II. Check that you can create free SSL with Let's Encrypt inside CloudPanel
	- REQUIREMENT: Your A records are pointing to the public IP and have propagated already.
	- Quick Review: Free SSL does not impact your SEO, but there may be benefits to a paid SSL or business regulations that require you to adopt a paid SSL. If adopting a paid SSL, you can skip this check
	- Do this: SSL/TLS -> Actions -> New Let's Encrypt Certificate -> Create and Install
	
	- If errored with: Unable to create a site with the error "SSH key... /etc/nginx/ssl-certificates..."
		- Solution: Make sure that folder exists at /etc/nginx/. If it doesn't exist, create `ssl-certificates` folder so that `/etc/nginx/ssl-certificates` exists. That way CloudPanel can create the cert and key files there. Keep the ownership and file permissions of the folder as the same as the adjacent files.
	- If errored:  domain.com/.well-known/acme-challenge/RANDOM_LETTERS... failed... Authorization result: invalid... 404
		- Solution: If you place a text file called 'test.txt' with some text like “Reached” into the folder /.well-known/acme-challenge/ can you browse to it using https://www.domain.com/.well-known/acme-challenge/test.txt - if not, you need to get that working first, as that's what's required to get this working. Could be directory like: `/home/SITE_USER/htdocs/DOMAIN/.well-known/acme-challenge/test.txt`
		- If Chrome warns you there's no secured connection or that the connection is not private and blocks you from viewing the content. We will add SSL https certificates later. The current bypass technique in 2024 is to click anywhere on the webpage then type: `thisisunsafe`. You should see the webpage content.
	- If errored:  domain.com/.well-known/acme-challenge/RANDOM_LETTERS... Domain could not be validated... 403
		- Solution: Refer above to the Cloudpanel vhost 500 error from file permission problems.


---
## Checklist - DNS Purchase then Cloudflare

We will NOT skip this namecheap step anymore because:
![[Pasted image 20260411024546.png]]
A record to sslip.io would be pointless since it will not allow you that flexibility. It will always point to the prefix IP address. **You can skip this entire section DNS purchase then Cloudflare** if you dont plan to go public yet. But dont list your sslip.io URL to the internet. The idea is that Cloudflare will secure your domain address so you will never be able to be attacked directly by your webhost IP (even to the point it overwhelms your CPU and shuts down the server by the massive flood of bots even if you have a firewall on at the server level which is like ufw, well unless your firewall is at the web host level which is the control panel that displays immediately after logging in to your web hots account)

Go to namecheap and buy your domain. Then DO NOT adjust any DNS records. Let's delegate namecheap to cloudflare where you get the benefits of bot protection (recognized abusive IPs and human verify), edge caching, etc

Warning:
Do not ever go public without cloudflare because once your IP is online, hackers can forever attack you directly (unless you rotate out your IP which Hetzner fortunately allows with you purchasing additional addon of floating IP for a few bucks a month)

The rest below are Cloudflare steps. They are not as detailed as my other cloudflare tutorials. It assumes you are somewhat familiar with cloudflare.

Create your Cloudflare account

Over at left sidebar Domains -> Overview, add your domain by clicking "Onboard domain"
- You may be given two nameserver addresses. **Since you're following this section to this point on, then you have purchased with namecheap or another DNS registrar**, so go ahead and pop them over at namecheap, etc so that Cloudflare can take care of the DNS configuration instead of namecheap.

Under your domain's DNS records, you should have:
- Create **A record** with name of hostname (domain.tld) pointing to the web host's IP. Make it **Proxied** only so that we can leverage Cloudflare preventing traffic from even hitting your webhost and causing DDoS if there's a bot attack
- You may want the A record to the eventual or current hostname/domain you ~~will~~ have ~~and another A record to the sslip.io domain that you will have temporarily for testing purposes~~.
![[Pasted image 20260411025347.png]]

Complains of SSL? That's fine
![[Pasted image 20260411024600.png]]

We'll eventually fix that later.

A more full setup of A-records would be:
![[Pasted image 20260411034518.png]]

Now go on whatsmydns.net to check if your ip address has propagated. If it's taking a while to reach your location, and it has already reached other locations, you can use a VPN service to browse as that location, then your domain should be able to display the file

You should see whatever default index.php file is created (as of April 2026, a default index.php file would show "Hello world")

Add some basic security at Cloudflare now, while you're there:
- Allow blocking bot IPs.
- Allow challenges for suspicious visitors.
- Block other countries. Refer to [[Countries - Restrict, block all other countries]]
- At CloudPanel, Security -> Cloudflare: Allow traffic from Cloudflare only

---
## Checklist - Improve Terminal Experience

We will be doing a lot of terminal work to enhance website capabilities for things like NodeJS, Python, etc. We want to make it easier to use the terminal especially since we will keep coming back into it (and re-logging into SSH). Use these items to improve the terminal experience.

For example: Every time I log back into SSH, I don’t want to manually cd into the temp folders in my htdocs just to continue installing and testing the remaining items in this checklist.

### Improved SSH Experience
1. You may want to setup alias to easily SSH in from your computer's terminal (along with an echo of directories you will often cd into). You might want to add echo useful commands too (since the commands might change from local machine to different servers):

```
$ godaddy
Local: /Users/local_username/dev/web/weng/apps/
Remote: /home/XXX/public_html/apps
---------------------------------------------------
Mongo restart: sudo service mongod restart
Mongo shell: mongo -u admin -p password
MySQL phpMyAdmin:
MySQL shell:
---------------------------------------------------
Supervision stop: ...
Supervision start: ...
Supervision config - main: ...
Supervision config - apps: ...
Supervision dashboard: ...
---------------------------------------------------
Pm2 start: ...
Pm2 dashboard: ...
$
```
  
Even better, you can configure your SSH login to automatically change into the directory where you’ll be working—typically the website’s htdocs folder.

^ How? Below is various alias strategies depending your method of login. The command changes depending on your choice. For example, you can have the session automatically cd into a specific folder if using SSH root key-pair login with an alias:
- Adjust the HUD echo, the PRIVATE KEY path, the IP, and the path to cd to
- Tip: Try the command inside the alias before wrapping it as an alias into your bash profile or z profile
```
alias hostinger='echo -e "Local: /Users/wengffung/dev/web/weng/apps/\nRemote: /path/to/apps"; ssh -i ~/.ssh/PRIVATE_KEY -p 22 root@XX.XX.XXX.XX -tt "cd /path/to/apps && bash --login"'
```

For other ways to authenticate with SSH and their aliases, refer to [[OpenSSH Authentication methods into the SSH Terminal and Their Aliases]], however this approach is the most secured already.
  
- Recommended: Disable non-Root Login (SSH and SFTP)
  
  As it is right now, even though you can perform passwordless authentication login with SSH keys, password login still works. Tighten security even more by blocking all non-root password login. 

1. Edit SSH config
```
sudo vi /etc/ssh/sshd_config
```

2. Find or add this line
```
PasswordAuthentication no
```


3. Optional (recommended hardening):
```
ChallengeResponseAuthentication no  
UsePAM no
```

4. Reload SSH:
```
sudo systemctl restart ssh
```

**⚠️ Warning:**
- This disables SSH AND SFTP (Filezilla, etc)
- If you want to re-enable SFTP, at Filezilla use the login method Key File and pair it to the site user's eg. `/home/wengindustries/.ssh` (sibling to htdocs folder; folder path may vary based on OS)
  ![[Pasted image 20260415221207.png]]

- Recommended: Disable Root Login too
  
  Disable root login. The normal SSH authentication flow becomes to login into SSH with a non-root user like `adminuser` OR to login with SSH key pair for the root. Depending which you choose, your SSH access is either limited to the htdocs folder or the entire file system.
  
  The key pairing command SSH authentication is long but you only run it once. The next time your SSH into the IP, it'll refer to the SSH key preferentially. And you can make it less work for you to remember the IP if you alias it.

1. Edit SSH config
```
sudo vi /etc/ssh/sshd_config
```

2. Find or add this line
```
PermitRootLogin no
```

3. Reload SSH:
```
sudo systemctl restart ssh
```


**⚠️ Warning:**
- This disables SSH AND SFTP (Filezilla, etc)
- If you want to re-enable SFTP, at Filezilla use the login method Key File and pair it to the root user's eg. `/root/.ssh` (no sibling htdocs folder because this is the root user; folder path may vary based on OS)
  ![[Pasted image 20260415221207.png]]


**⚠️ Warning:**
If you accidentally locked yourself out because you removed non-root and root password authentication AND your SSH keys are failing, log into your webhost (like Hetzner), and see if they have a console which normally overrides the SSH process. Then make configuration changes you need at `sudo vi /etc/ssh/sshd_config` to recover the server for SSH access.

### Easier file commands
**More Terminal experience improvements:**
1. Are these commonly used cli tools available (use ` --version` to check):
	- `nano`
		- A lot of online instructions use nano
	- `vi`
		- Enable copy-to-clipboard in Vim using your mouse and CMD+C
			  - Open (or create) your `~/.vimrc` file
			- Add this line:
			```
			:set mouse=v
			```
2. You may want to add better searching capabilities from the SSH terminal because you don't have a friendly UI to browse files. Add to ~/.bash_profile or equivalent:

```
# - fd: Find files with string in their filenames. Eg: fd *Untitled*.jpg  
function fd() {   
clear;   
echo '* Running: find . ! -path "*/.git/*" ! -path "*/node_modules/*" -a \( -type f -iname "*${1}*" -o -type d -iname "*${1}*" \);  
eg. fd Untitled  
';  
find . ! -path "*/.git/*" ! -path "*/node_modules/*" -a \( -type f -iname "*${1}*" -o -type d -iname "*${1}*" \);  
} # fd -  
  
# - gr: Find files with string in their file contents. Eg: gr "= new"  
function gr() {   
    clear;   
    VAR1="";   
    [ $# -lt 1 ] && echo "Error. Must provide string you are searching files" && return;  
  
    # for i ({1..$#});do VAR1+=" --exclude-dir \"${!i:1}\""; done  
  
    # [ ${!i:0:1} != / ] && VAR1+=" --exclude \"${!i}\"";   
      
    # done;   
  
    # cho $#;  
      
    VAR0="grep -nriI ./ --exclude={.git,\*.sql,package-lock.json,webpack.config.js,composer.lock,\*.chunk.css,\*.chunk.js,\*.css.map,\*.js.map} --exclude-dir={.git,.git/index,bower_components,node_modules,.sass-cache,vendor\*,\*backup\*,\*cached\*}${VAR1} -e \"${1}\"";   
      
    echo "* Running: $VAR0  
Eg. gr "= new"  
  
* Tip: If you are searching a phrase or sentence, place the expression in quotation marks:  
gr \"fox jumps over fence\"  
* Tip: If excluding directories, prepend with forward slash /. If excluding files, do not prepend. These are additional arguments after the expression argument. There is no restriction on the number of arguments.  
gr \"fox jumps over fence\" /cached .gitignore README.md  
Btw, the cached folder and .gitignore file is automatically ignored because I know how common those are in projects.  
* Tip: Go to top of results on Macs with CMC+Up, or Ctrl+Home on Windows.  
* Tip: Open the file and line in Visual Code:  
code -g filepath:line  
";  
eval $VAR0;   
  # Old bash version kept below. Now zshell complains of syntax error at )  
  # function gr() { clear; VAR1=""; [ $# -gt 1 ] && for((i=2;i<=$#;i++)) do [ ${!i:0:1} == / ] && VAR1+=" --exclude-dir \"${!i:1}\""; [ ${!i:0:1} != / ] && VAR1+=" --exclude \"${!i}\""; done; VAR0="grep -nriI ./ --exclude={.git,*.sql,package-lock.json,*.chunk.css,*.chunk.js,*.css.map,*.js.map} --exclude-dir={.git,.git/index,bower_components,node_modules,.sass-cache,vendor*,*backup*,*cached*}${VAR1} -e \"${1}\""; echo "* Running: $VAR0  
} # gr -
```

---
## Checklist - Enhance Website Capabilities

Now that there's a control panel for your website and your website can be public without your IP address mined by botnets, it's time to enhance the web site capabilities while testing them.
### VPS: How to setup web server for basic website editing and viewing (Multiple sites)
- Basic: We just want to see we can impact how a website looks . We don’t care about SSL Https at this point
- Where in the web hosting panel (cpanel, cloudpanel, etc) does it show you the public IP address you can visit directly in the web browser  
- Where does it give you the default domain (aka temporarily domain)  (eg. srv451789.hstgr.cloud). We want to test we can visit the webpage after uploading files with FTP / vi file from shell / edit file from Web Hosting Control Panel. We do not care to visit the desired domain name yet because DNS propagation takes a while.
- You can **edit the index file** in the Web Hosting Control Panel's File Manager or in the terminal.
	- If in the terminal using vi: For each site on your Web Hosting Control Panel, what’s the folder path to create/edit index.html to so web browser can see a webpage? Aka root web directory for your website, Aka working directory for your code and webpages. This is usually the first website you create in your web host panel or the website they already created for you, and their settings show you the associated folder path.  
- Prepare to visit that website in the web browser to see your changes went through:
	- Edit your virtual host (vhost) configuration so that incoming requests to your server match the requested hostname or domain because once matched, the vhost can route and respond to the request correctly.:
		```
		server_name srv451789.hstgr.cloud;
		```
		- And restart nginx from SSH terminal with `sudo systemctl restart nginx`
		- Visit http://srv451789.hstgr.cloud
		- If success, Chrome will warn you there's no secured connection or that the connection is not private and blocks you from viewing the content. We will add SSL https certificates later. The current bypass technique in 2024 is to click anywhere on the webpage then type: `thisisunsafe`. You should see the webpage content.
	- Use vi command to **create an index2.html**, add some words, then visit directly http://domain.com/index2.html to see if it displays.
		- If failed, because it says Access Denied on the web browser, fix the permissions, making the bad index2.php permissions match the good index.php permissions. Likely it's just the user and group that are problematic.
		- Keep in mind that when you upload files via SFTP later, this will be the user you sign into Filezilla, etc's SFTP. This makes sure uploads are the correct permissions. 
		- If passed, this then assumes future websites on CloudPanel will have no problem with editing and viewing by the internet. 
	- This then assumes future websites on CloudPanel will have no problem with editing and viewing by the internet.
	- Optional: If you want to continue testing other sites on CloudPanel, you could use other domains at namecheap etc creating A record to the same public IP. Or if you run out of domains, you can create subdomains under one domain, creating CName to the public domain name. For more information on A records and Cnames, refer to [[DNS Domain PRIMER]]. Make sure a site's vhost at your web host catches what servername (subdomain and/or domain and tld) is hoisted by the internet connecting to your public IP.

---
### How to setup SFTP/FTP users
- Makes life easier for web developers.
- Skip FTP: It's strongly recommended you use SFTP instead. You can setup FTP capability then leave the port off or on as a backup. Refer to: [[Setup FTP and SFTP]]
- SFTP: 
	- If not CloudPanel: [[Setup FTP and SFTP]]
	- If CloudPanel: [[CloudPanel - Setup SFTP users]]
- If you have html/php websites developed, go ahead and upload them on your FTP Client (eg. Filezilla)
- Tip: In FileZilla, you may want to open the **Advanced** tab for both your non-root and root connections and set the **default remote directory**. That way, each time you connect, FileZilla opens directly in the folder you actually want to work in instead of making you browse there manually. You can also set the **default local directory** so FileZilla starts in the folder on your computer that you usually upload from.

---

### Prepare web server for basic public view - SSL, File Permissions, Security, Domain Names
- Do you have to setup SSL?
	- Free vs Paid SSL
		- You can get a free SSL with Let's Encrypt. Look up instructions how to run Let's Encrypt in your SSH.
		- You can also buy SSL which gives you certain advantages over SSL, and some businesses must have a paid SSL as regulation.
	- Figure out workflow to acquire and install SSL because you'll be doing this annually. Also perform it now
		- If CloudPanel, it's very simple going to the site -> SSL/TLS -> Actions -> New Let's Encrypt Certificate (however you must have a domain connected to that website already because it'll create a file then access that file through your domain URL to prove your ownership then generates the certificate).
			- Errors about accessing ACME challenge file? Try adding a server block for http and the specific path to the ACME challenge file, to the very top of the vhost:
				```
				server {
				    listen 80;
				    listen [::]:80;
				    http2 on;
				    http3 off;
				    server_name wengindustries.com www1.wengindustries.com www.wengindustries.com;
				    
				    location ^~ /.well-known/acme-challenge/ {
				        root /home/wengindustries/htdocs/wengindustries.com/;
				        allow all;
				        auth_basic off;
				    }
				
				    location / {
				        proxy_pass http://127.0.0.1:8080;
				        proxy_set_header Host $host;
				        proxy_set_header X-Forwarded-Host $host;
				        proxy_set_header X-Forwarded-Proto $scheme;
				        proxy_set_header X-Real-IP $remote_addr;
				        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
				        proxy_redirect off;
				    }
				}
				```
		- If less obvious how and where to install SSL HTTPS certificates: Contact customer support or google Web host + OS + Nginx/Apache + Install SSL certificates. If the web host is not well known (very independent), google for: OS + Nginx/Apache+ Install SSL certificate
	- CloudPanel's Let's Encrypt SSL failing? Refer to section "Test Web Hosting Control Panel" -> ~ SSL
	- Know the filepaths to the SSL for future issues and code that needs SSL cert and key paths such as gunicorn (even if Cloudpanel abstracts it away)
		- If Hostinger CloudPanel, the Vhost page likely hides ssl cert and key file paths in the server block as variables. You have to find the site's nginx confi file where the final vhost is written (eg. /etc/nginx/sites-enabled/some-website.com.conf)
			- Hostinger Ubunto 22.04 with Cloud Panel paths could be:
				- **ssl_certificate** /etc/nginx/**ssl**-certificates/DOMAIN.com.crt;
				- **ssl_certificate_key** /etc/nginx/**ssl**-certificates/DOMAIN.com.key;
		- Write down paths to where you record your web-host login, SSH login, etc
	- Multiple domains/subdomains for the same website root (maybe different domains point to deeper folder paths as roots)?
		- Setup server blocks to those domains/subdomains
		- Cloudpanel Let's Encrypt same screen just add all the domains/subdomains. It's a bit of a manual process clicking the input fields and inputting them in. But here's an automated way to fill in those fields using javascript inside the web browser console: [[CloudPanel - SSL Renew Annually (Semi Automated)]]
- Complicated permissions
	- Make sure no excessive permissions like 777 among your files you uploaded to restore your website when setting up the web server
	- User script permissions: if you will have php or python scripts that are triggered by visiting web browser, if it writes to a folder, can it write to it? Otherwise, it’ll be permission error preventing creating files by php script (eg. can it write to a file using PHP's fwrite upon opening that PHP file?)
	- Webpage viewable to public: Make sure it's the official site user that logs into Filezilla when uploading web-site public viewing files (NOT root). Setup and save your login credentials on Filezilla. Otherwise, pages may show up as forbidden on the web browser.
- Install malware and security especially when going public
	- If Hostinger, their malware scanner [https://support.hostinger.com/en/articles/8450363-vps-malware-scanner](https://support.hostinger.com/en/articles/8450363-vps-malware-scanner)
    - How to navigate to the malware from services dashboard (Hostinger hpanel, GoDaddy dashboard, etc)
    - Is malware free, times one payment, or monthly/yearly? Or keep deactivated (often they let you scan but not fix for free)
    - Is there a firewall from the Web Hosting Control Panel? or do you have to run ufw?
- Domain name
	- Refer to tutorial on domain and dns editing. There are many ways to do it. One way is to have namecheap domain with two A records to the public IP of your webhost at "@" and "\*" (unless you want different public ip between www and other subdomains)


---
### ADVANCED WEBSITE: Prepare server for installing different architectures (PHP, NodeJS, Python, MySQL, Mongo, PostgreSQL)

#### Required skills
- Know how to reboot the server per your OS and web server: 
	- eg. `sudo systemctl restart nginx`
- how see error logs based on your OS and web server type  
    - eg `tail -f /var/log/nginx/error.log`
- Know how to check status of, start, stop, and restart any service

**Ubuntu 22.04.. we are just using nginx as example:**
```
sudo systemctl status nginx
```

```
sudo systemctl start nginx
```

- Know what is the main installer of packages in command line (eg. `sudo apt update`  for Ubuntu 22.04). Save to your web host's details document if it's not something you're intimately familiar with.
- Update installer’s repos 
- Look up instructions for your OS on how to install these language interpreters and related or adjacent package managers, if applicable to your server's use cases (these should be installed before installing databases because you'll be testing database connections with code):
#### PHP

##### Install PHP
- PHP (if not included by your web host’s)
	- If installed CloudPanel, PHP comes included. If you don't see PHP, you should create a PHP site off CloudPanel 
	- If not installed CloudPanel and your web host management panel does not come included with PHP, look up how to install php, eg. Google: Ubuntu 22 install php
		- You have to configure apache or nginx to handle php, eg. Google: `Nginx handle php`, eg. Google: `Apache handle php`.
	- If installed Cloudpanel or a Web Hosting Control Panel that already has PHP installed, please skip this step of installing PHP.
	
##### Match PHP Versions

The best practice is to make sure you're using the same PHP that gets called when running the `php` command in terminal and is used to render your php webpages

If the versions don't match you're going to run into problems when enhancing PHP by running command lines then expecting your PHP webpages to get those enhancements.

  - Make sure PHP matches on command line and web version
	  - At a php file:
	```
	<?php
	echo PHP_VERSION;
	```
	- Then view on web browser

	- Run the command line:
	```
	php --version
	```
	- Choose which version to stick to. For example, as of April 15th, there is no MongoDB driver for PHP 8.5 on Debian 12. However there is a MongoDB driver for PHP 8.2 on Debian 12. For that reason, I'd choose Debian 12 for both command line and php versions. 
		- To investigate whether a dependency such as MongoDB is available for one of your latest PHP versions, ask ChatGPT and include the dependency name, the PHP versions installed on your server (from `ls /usr/bin/php*` or the PHP version dropdown in CloudPanel), and mention the OS you are on (eg. Debian 12). Mongo is a good example because in the future you might choose MongoDB as your database while still using PHP. In addition to ChatGPT, you can also check what MongoDB-related PHP packages are available directly on Debian 12 by running `apt search php | grep -i mongodb`, since the package name usually includes both `mongodb` and the PHP version, such as `php8.2-mongodb/oldstable,oldstable,now 1.15.0+1.11.1+1.9.2+1.7.5-1 amd64`. You'd find out that there is no official php8.5-mongodb package for Debian 12 (Bookworm), but the latest php version that does have a mongodb package under Debian 12 is php8.2.
		- You'd install with `sudo apt install php8.2-mongodb` then verify it's installed with `php -m | grep mongodb`. When your PHP script file (eg. index.php or api.php) includes the Mongo driver like `$client = new MongoDB\Driver\Manager($uri)`, it should be no problem if per your selected PHP version, the path to Mongo exists after installing Mongo: `/etc/php/8.2/mods-available/mongodb.ini``
		- Setting the PHP version
			- If setting command line, eg. `sudo update-alternatives --set php /usr/bin/php8.2`
			- If setting web, depends on your setup. For cloudpanel, you dont have to edit anything manually - just select at dropdown:
			  ![[Pasted image 20260415044926.png]]

##### PHP's Composer installed or install now

**What is Composer**
Composer is PHP’s standard dependency manager. It lets you list the libraries your project needs, then installs and updates them for you. Same concept to Node Modules for NodeJS.


**Big Picture:**
- Composer is **installed globally** (the CLI tool)
- Dependencies are **installed per project**. You need the composer CLI tool installed globally so you can run commands at the project level to init or manage.


**Check if you have composer installed globally already**

Cloudpanel? Composer is pre-installed by default on CloudPanel

Find out if you already have composer by running this command:
```
composer --version
```

**Composer Installation Instructions at:**
[[_ Composer - Installation (Debian 12)]]

#### NodeJS

Check/install nodejs, npm (precluded in nodejs), and nvm, following instructions at [[Linux - Install node, npm, nvm (No theory)]]. Since we've chosen PHP application for CloudPanel, there's no NodeJS - and PHP is the right choice because this is the least complicated way to install all the other tech stacks.

pm2 will be installed at a later section called Scaling Solutions.
#### Yarn
- Make sure Node is at least v20.11.0 to install a newer yarn (https://www.redswitches.com/blog/install-yarn-in-ubuntu/), otherwise look up classic yarn installation instructions.
	- Install npm's repo corepack (tool to help with managing versions of your package managers) which allows you to install yarn
	- Follow each step to install latest yarn:
		```
		sudo npm install -g corepack
		corepack enable
		corepack prepare yarn@stable --activate
		yarn set version stable
		yarn --version
		```

- Look up instructions for your OS on how to install these databases, if applicable to your server's use cases
#### Python
- Check if you have python3 installed. It comes included with CloudPanel. Test with `python3 --version`
	- If not installed. Look up how to install: Eg. Google: Ubuntu 22 install python3
- Check if you have pip3 installed. Having python3 installed does not necessarily mean pip3 is installed. Eg. Google: Ubunutu 22 install pip3. Could be something like `sudo apt install python3-pip`. If you have CloudPanel installed, Cloudpanel installed python3, but not pip3, as of Aug 2024.
- ~~OPTIONAL: For legacy code you might need to work on in the future, you should install python2 and pip2 and bench them for when they're needed
	- ~~Could be for python2: `sudo apt install python2`~~
	- ~~Could be for pip2 (notice it's python-pip, not python2-pip): `sudo apt install python-pip`~~
	- ~~You can test they're installed successfully with `python3 --version` and `pip3 --version`~~
	- ==Python 2 reached its **End of Life (EOL)** on January 1, 2020==. Because it is no longer supported, many modern operating systems (like Ubuntu 20.04+ and recent macOS versions) have removed Python 2 and its package manager (`pip`) from their default repositories.
- Check if `python` and `pip` commands work (not limited to running `python3` and `pip`). Run `python --version` and `pip --version` to check if they've been assigned. I recommend assigning them to the newest version of python.
	- Method 1:
	  Edit ~/.bash_profile or equivalent. You can run `which python3` and `which pip3` to get their paths. Then you add to the bash profile similar to `alias python='/usr/bin/python3'` and `alias pip='/usr/bin/pip3'`. Then you source: `source ~/.bash_profile`.
	- Method 2:
	  You can run `which python3` and `which pip3` to get their paths. Then get one of the paths found in `echo $PATH`. Create symbolic links from `python` to `python3` and `pip` to `pip3` in one of the earlier $PATH paths.
- Check if pip will be annoying. Go into a new folder and run:
```
pip install mysql-connector-python
```

If you get this error then you have to configure okay to break out:
```
error: externally-managed-environment

× This environment is externally managed
╰─> To install Python packages system-wide, try apt install
    python3-xyz, where xyz is the package you are trying to
    install.
    
    If you wish to install a non-Debian-packaged Python package,
    create a virtual environment using python3 -m venv path/to/venv.
    Then use path/to/venv/bin/python and path/to/venv/bin/pip. Make
    sure you have python3-full installed.
    
    If you wish to install a non-Debian packaged Python application,
    it may be easiest to use pipx install xyz, which will manage a
    virtual environment for you. Make sure you have pipx installed.
    
    See /usr/share/doc/python3.11/README.venv for more information.

note: If you believe this is a mistake, please contact your Python installation or OS distribution provider. You can override this, at the risk of breaking your Python installation or OS, by passing --break-system-packages.
hint: See PEP 668 for the detailed specification.
```

^ If that's the case, then config python to allow possible breaking of python:
```
mkdir -p ~/.config/pip  
vi ~/.config/pip/pip.conf
```

Add to pip.conf:
```
[global]
break-system-packages = true
```


#### MySQL
- MySQL (if not included by your web host’s VPS)
	- If not installed CloudPanel or a web host management panel that includes these parts, look up instructions on how to install MySQL, PHP, and PHPMyAdmin. eg. Google: Ubuntu 22 install mysql phpmyadmin
	- Ubuntu v22 with CloudPanel comes with MySQL, PHP, and phpMyAdmin, however when accessing phpMyAdmin from Cloudpanel then only the databases the user is associated with shows up.
		- To get the master credentials to see all databases, you run `clpctl db:show:master-credentials` and visit this url to login with those credentials https://XX.XXX.XX.XXX:8443/pma or https://domain.tld:8443/pma. If behind Cloudflare, 8443 is one of the supported ports so you should be able to access via the domain name too
		- Test the same master credentials on the Mysql command:
		  `mysql -h 127.0.0.1 -u root -P 3306 -p -A`
			- Enter password when prompted to
		- Save credentials, PMA link, and MySQL command to your webhost document and possibly save to an alias that echoes credentials and then logs in via ssh/sshpass.
	- Test MySQL phpMyAdmin (if not done from previous CloudPanel step)
		- What's the URL to phpMyAdmin? If needed, can we make it show all the databases instead of only some databases (databases associated to one user) at phpMyAdmin?. 
		- If Cloudpanel:
			- The login to the phpMyAdmin (PMA) that asks you through the browser native prompt is the same as the master credentials
			- The URL is in this format:
				```
				https://domain.tld:8443/pma	
				```
		- Save phpMyAdmin URL and credentials to web host details document
	- Test MySQL daemon
		- Run `mysql --version`

##### Test MySQL on PHP
- OPTIONAL: Test PHP wrapping MySQL works. You can write this php file then either run in web browser (visit appropriate URL on web browser) or terminal (`php script.php`)
- Make sure to adjust user and password

```
<?php
$server = "127.0.0.1";
$username = "YOUR_USERNAME";
$password = "YOUR_PASSWORD";
$port = 3306;
$conn = new mysqli($server, $username, $password, "", $port);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
} else {
		echo "Success: PHP connected to MySQL. Here are databases: <br/><br/>

";
}
$result = $conn->query("SHOW DATABASES");
while ($row = $result->fetch_assoc()) {
		echo $row['Database'] . "<br>
";
}
$conn->close();
?>
```

If PHP connecting to MySQL works (most commonly used case), then it's assumed Python and NodeJS will connect with no problems. 
##### Test MySQL on NodeJS
But if you want to test NodeJS connecting to MySQL:
```
const mysql = require("mysql2");
	
const connection = mysql.createConnection({
  host: "127.0.0.1",
  user: "YOUR_USERNAME",
  password: "YOUR_PASSWORD",
  database: "mysql",
  port: 3306
});

function showAllRows() {
	connection.query(
	  "SELECT * FROM user"
	, function(err, results, fields) {
	  console.log(results);    
	});
  }

connection.connect(function (err) {
	if (err) {
		console.error(err);
	} else {
		showAllRows();
	}
  
});
```

^ Proof this would work:
	- ![[Pasted image 20260414134454.png]]

##### Test MySQL on Python
- And if you want to test Python connecting to MySQL:
	- Make sure to have installed mysql connector:
	  `pip install mysql-connector-python`
	- Make sure to adjust user and password
```
# pip install mysql-connector-python 
import mysql.connector
from mysql.connector import Error

# Database connection details
connection_config = {
	'host': '127.0.0.1',
	'user': 'root',
	'password': 'root',
	'database': 'mysql',
	'port': 3306
}

def show_all_rows():
	connection = None
	try:
		connection = mysql.connector.connect(**connection_config)
		if connection.is_connected():
			cursor = connection.cursor()

			# Check if the table exists
			cursor.execute("SHOW TABLES LIKE 'user'")
			result = cursor.fetchone()
			if result:
				cursor.execute("SELECT * FROM user")
				results = cursor.fetchall()
				for row in results:
					print(row)
			else:
				print("Table does not exist.")
	except Error as e:
		print(f"Error: {e}")
	finally:
		if connection is not None and connection.is_connected():
			cursor.close()
			connection.close()

if __name__ == '__main__':
	show_all_rows()
```

##### Test MySQL on Python Flask
- And if you want to test Python's Flask connecting to MySQL:
- Make sure to have installed dependencies
	- `pip install flask`
	- `pip install flask-mysqldb`
- Make sure to adjust user and password
- DO NOT name your python script `flask.py` because it'll complain of circular import
- Test by visiting the port mentioned by the flask to terminal output at https//domain.tld:5000/ which is just fine because our endpoint for reading the database after seeding it is `/`
- Make sure port not blocked by ufw etc
```
from flask import Flask, jsonify
from flask_mysqldb import MySQL

app = Flask(__name__)

app.config["MYSQL_HOST"] = "127.0.0.1"
app.config["MYSQL_USER"] = "root"
app.config["MYSQL_PASSWORD"] = "PASSWORD"
app.config["MYSQL_DB"] = "mysql"
app.config["MYSQL_PORT"] = 3306
app.config["MYSQL_CURSORCLASS"] = "DictCursor"

mysql = MySQL(app)

@app.route("/")
def users():
    cur = None
    try:
        cur = mysql.connection.cursor()
        cur.execute("SELECT * FROM user")
        rows = cur.fetchall()

        for row in rows:
            for key, value in row.items():
                if isinstance(value, bytes):
                    row[key] = value.decode("utf-8", errors="replace")

        return jsonify(rows)
    except Exception as e:
        return jsonify({"error": str(e)}), 500
    finally:
        if cur:
            cur.close()

if __name__ == "__main__":
	# app.run(debug=True)
    app.run(host="0.0.0.0", port=5000, debug=False)
```

You want to visit the api endpoint in the web browser. If using Cloudflare, you either will reverse proxy it or use the free Cloudflare tunneling because you can't fetch custom ports on Cloudflare proxy protected websites. Or you can switch to DNS-only instead of Proxy at Cloudflare, but that could expose your VPS ip address (if the domain has already been on a botnet before, don't switch to DNS because they will continue to hack you directly once they detect your IP). For Cloudflare tunneling to work, you should use a subdomain, you must not have a DNS record to that subdomain, you must not have SSL certificate for that subdomain, and if your tech stack has access to routing to localhots or to the internet then it must be internet (dont use Flask's `host="0.0.0.0"`)
#### Mongo
- Installation
	- See if you have mongo already installed `mongo --version` or `mongosh --version`, as long as one of them works. Cloudpanel does NOT come with Mongo.
	- Look up instructions how to install MongoDB: 
	  eg. Google: Ubuntu 22 install mongo. 
		 - There are a lot of steps—follow the full MongoDB installations (not going to repeat it in this tutorial)
			 - Ubuntu 22/24: https://www.mongodb.com/docs/manual/tutorial/install-mongodb-on-ubuntu/
			 - Debian 12: https://www.mongodb.com/docs/manual/tutorial/install-mongodb-on-debian/
			   
			- Enable for reboot startup with: `sudo systemctl enable mongod`
			- In many cases, system needs to reboot or mongod will be in a failed state. Run `reboot` and then try to ssh back in after a couple minutes
			- Check status of mongodb:
				```
				# sudo systemctl status mongod
				> ● mongod.service - MongoDB Database Server
				Loaded: loaded (/usr/lib/systemd/system/mongod.service; disabled; preset:
				Active: active (running) since Mon 2025-07-07 00:01:49 UTC; 3s ago
				```
				
			    
			 - Prevent future mongod service failures,
				 - FYI, in a future server reboot, all MongoDB connections could fail with the error "Failed to unlink socket file" with status 14 at `sudo tail -n 200 /var/log/mongodb/mongod.log`. This is because Mongodb installation does not set the correct permissions for it to carry out some cleanup tasks (as of April 2026. It'd fail to cleanup an old socket file because it would be owned by root rather than the user mongodb.
				  - Ensure that the /tmp directory has the correct permissions: 
				    `sudo chmod 1777 /tmp`
				- And for other permission errors in the future (this is automatically fixed on installing as of April 2026 though but used to be a problem on older MongoDB's) 
					- Check the ownership of MongoDB directories: 
					   `ls -la /var/lib/mongodb /var/log/mongodb`
					- If not owned by user/group mongodb:mongodb, then run:
					  `sudo chown -R mongodb:mongodb /var/lib/mongodb /var/log/mongodb`
				  - Actually check MongoDB service and see if it's dead. If it's dead, go ahead and remove (`sudo rm -f /tmp/mongodb-27017.sock`), then restart the mongod (so it recreates a new socket into memory) `sudo systemctl restart mongod` 
					 
	- Record what's the mongo shell command? May want to add to your web host details document because it can be different from OS to OS and version to version. 
		- MongoDB 3.4 unofficial and below, run`mongo` for mongoshell
		- **Above Mongo 3.4** unofficial, run `mongosh` for mongoshell
		- If Mongo community version (maintained by the official Mongo organization), run `mongosh` while `mongod` service has started
	- Mongo service further check
		- **What's the command to check status**? Record as well
		- Make sure to reboot to check that the mongo service sticks (running mongo shell works). After reboot, check the service status.
		- Also figure out the commands for: How to stop mongo service? How to restart mongo service? 
		- How to check the logs for service starting errors (Eg. Ubuntu 22 is `sudo tail -n 100 /var/log/mongodb/mongod.log`)
		- Optional: Save these commands to your web host details document.

	- Create an authentication account on the auth collection
		- DO IMMEDIATELY. Often the bots are scanning new websites for mongo database, then you'll be surprised in Mongo Compass when all your collections disappeared and in their place is an obviously inserted collection with text stating to pay a bitcoin wallet for your data back. Typically it happens in minutes. So dont even migrate data in yet until you add authentication account
	  
		- Go into Mongo Shell (`mongo` or `mongosh`), switch into admin collection (run `use admin`), then run this to create user
			- WARNING: DO NOT create a username named "root". Some Mongo versions already created a root user to work with test as the authentication database, and it causes conflicts like the mongo invoke command saying incorrect credentials but the interactive authentication passing
			- Create user while inside admin collection (Adjust to prefer username and password):
		```
		db.createUser({ user: 'USERNAME', pwd: 'PASSWORD', roles: [{role: "root", db: "admin"}] })
		```

	^Make sure you've switched into admin collection (`use admin`), otherwise the db.createUser will silently work, but later the mongo invoke command will say incorrect credentials. The reason is because if you haven't switched into another collection, the authentication collection on the outside is "test", despite you specifying admin in the createUser method. The "admin" db setting passed to createUser would be ignored because you haven't proven access yet by successfully changing into admin collection.

	- Verify login in the SSH session. Test you can invoke mongo with credentials (mongo or mongosh depending on version):
	```
	mongosh -u 'USERNAME' -p 'PASSWORD' --authenticationDatabase 'admin'
	```

- Verify login the other way too with..  a URL because that will be roughly the URL you will use in your backend for NodeJS, etc to authenticate (your code would have the domain address instead of the numeric localhost IP)... if using characters like #, they must be in their url encoded form like `%23` for `#`:
```
mongosh 'mongodb://USERNAME:PASSWORD@127.0.0.1:27017/?authSource=admin'
```

^ If fails, check port and bindIp in `/etc/mongod.conf` have 127.0.0.1 and 27017. If you have special characters like "!", you have to encode into URI (! is %21).
^ We are using single quotes to reduce the chances of the shell interpreting and rewriting characters when inside double quotes.


- Then record the mongo shell login command and url login commands

- **Authentication is disabled by default** when you install MongoDB. This is one of the most common and dangerous misconfigurations. Hackers often scan new servers for mongo and try to ransom the data. Without authentication, hackers can log into your Mongo database without needing credentials then have full permission to read/write/delete databases.
	- Enable authorization for the mongo daemon (so that you can't just run `mongosh` or `mongo` then be able to show any databases):
	```
	sudo vi /etc/mongod.conf
	```

	- Add or strip comment (be careful with spacing otherwise starting service will say illegal map value for a YAML config file):
	```
	security: 
	  authorization: enabled
	```

	- Restart mongo service so the settings apply (or use your equivalent mongo restart command):
	```
	sudo systemctl restart mongod
	```

- Test you can be denied access without the correct authentication:
	- 1. Run `mongo` or `mongosh` depending on the version of mongo
	- 2. You'll notice you successfully got into the Mongo shell; However, run `show databases;` while in the unauthenticated Mongo Shell, it will error: `**MongoServerError[Unauthorized]** ...` .

- **Record** authenticated login shell command and URL into your web host details documents
	  
- Decide whether to open the Mongo to remote IPs (you'll have production apps) or keep local. If you open to remote IPs, then you can connect from your Mongo Compass. The inner steps here are to enable for remote IPs / Mongo Compass

	 1. Enabling external connections (and Mongo Compass) at the service level
		By default `/etc/mongod.conf` settings allow files on the same host as the mongo server to connect (127.0.0.1, aka localhost). Let's open Mongo to the internet/world.
		Edit your `/etc/mongod.conf`:
		
		```
		   net:
			 bindIp: 0.0.0.0
		```

	2. Restart mongo service so the settings apply (or use your equivalent mongo restart command):
	```
	sudo systemctl restart mongod
	```

	3. Enabling external connections (and Mongo Compass) at the OS level
	   If you have firewall (either uwf or iptables), you have to allow in internet 0.0.0.0 into port 27017:
		- Check if ufw firewall is enabled with `sudo ufw status`. If it's enabled, you should open the Mongo port by running `sudo ufw allow 27017`. Check port allowed rules by running same `sudo ufw status`. Apply the rules immediately with `sudo ufw reload`.
		- Check if iptables is managing firewall by running `sudo iptables -L -v -n` to see if there are any port rules which implies that iptables is enabled. Note that there doesn't need to be a iptables service for this firewall to work because iptables works at the kernel level. 
			- If it's enabled, you should open the Mongo port by running `sudo iptables -A INPUT -p tcp --dport 27017 -j ACCEPT`. No need to reboot; Rules are hot applied right way. Check ports allowed by running `sudo iptables -L -n`.

- Test MongoDB with authentication account works on Python or NodeJS:
##### Test MongoDB on Python
Test Python:
Create a test.py then run `python test.py` after you've installed `pip install pymongo`:
```
from pymongo import MongoClient

# Replace these with your actual MongoDB username and password
mongo_user = "USERNAME"
mongo_password = "PASSWORD"

uri = f"mongodb://{mongo_user}:{mongo_password}@localhost:27017/?authSource=admin"
client = MongoClient(uri)

try:
	# Check the connection by listing the databases
	databases = client.list_database_names()
	print("Connected successfully. Databases:", databases)

except Exception as e:
	print("Failed to connect to MongoDB:", e)

```

Errors? Refer to troubleshooting guides:
- [[Socket File Error (Troubleshooting MongoDB on Python)]]
- [[Permission Errors (Troubleshooting MongoDB on Python)]]
##### Test MongoDb on NodeJS

Optionally, test NodeJS:
Create a test.js then run `node test.js` after you've installed `npm init && npm install mongodb`:
- Make sure to adjust username and password
```
const { MongoClient } = require('mongodb');  
  
// Replace these with your actual MongoDB username and password  
const mongoUser = 'USERNAME';  
const mongoPassword = 'PASSWORD';  
const dbName = 'admin'; // Use your database name  
  
const uri = `mongodb://${mongoUser}:${mongoPassword}@localhost:27017/?authSource=${dbName}`;  
const client = new MongoClient(uri);  
  
async function run() {  
	try {  
		// Connect to the MongoDB cluster  
		await client.connect();  
  
		// List databases  
		const databasesList = await client.db().admin().listDatabases();  
  
		console.log("Connected successfully. Databases:");  
		databasesList.databases.forEach(db => console.log(` - ${db.name}`));  
	} catch (e) {  
		console.error("Failed to connect to MongoDB:", e);  
	} finally {  
		// Close the connection  
		await client.close();  
	}  
}  
  
run().catch(console.dir);
```

##### Test MongoDb on PHP
- Let's test PHP will be able to connect to Mongo. This is more involved.

Create a test.php then run both command and web versions:
- Make sure to adjust username and password
```
<?php

$mongoUser = 'USER';
$mongoPassword = 'PASSWORD';
$authSource = 'admin';

$uri = "mongodb://$mongoUser:$mongoPassword@localhost:27017/?authSource=$authSource";

try {
    $client = new MongoDB\Driver\Manager($uri);

    $command = new MongoDB\Driver\Command([
        'listDatabases' => 1
    ]);

    $cursor = $client->executeCommand('admin', $command);
    $result = current($cursor->toArray());

    echo "Connected successfully. Databases:\n";

    foreach ($result->databases ?? [] as $db) {
        echo " - " . ($db->name ?? '[unknown]') . "\n";
    }

} catch (Throwable $e) {
    echo "Failed to connect: " . $e->getMessage() . "\n";
}
```

Problems? First make sure PHP cli and PHP web are the same PHP versions! Refer to PHP installation earlier in this checklist. And make sure it's a PHP version that has a Mongo release.
- To investigate whether a dependency such as MongoDB is available for one of your latest PHP versions, ask ChatGPT and include the dependency name, the PHP versions installed on your server (from `ls /usr/bin/php*` or the PHP version dropdown in CloudPanel), and mention the OS you are on (eg. Debian 12). Mongo is a good example because in the future you might choose MongoDB as your database while still using PHP. In addition to ChatGPT, you can also check what MongoDB-related PHP packages are available directly on Debian 12 by running `apt search php | grep -i mongodb`, since the package name usually includes both `mongodb` and the PHP version, such as `php8.2-mongodb/oldstable,oldstable,now 1.15.0+1.11.1+1.9.2+1.7.5-1 amd64`. You'd find out that there is no official php8.5-mongodb package for Debian 12 (Bookworm), but the latest php version that does have a mongodb package under Debian 12 is php8.2.
- You'd install with `sudo apt install php8.2-mongodb` then verify it's installed with `php -m | grep mongodb`. When your PHP script file (eg. index.php or api.php) includes the Mongo driver like `$client = new MongoDB\Driver\Manager($uri)`, it should be no problem if per your selected PHP version, the path to Mongo exists after installing Mongo: `/etc/php/8.2/mods-available/mongodb.ini``

If still have problems, refer to [[Indepth Installation Guide - Mongo for PHP]]


#### PostgreSQL

Check whether PostgreSQL is already installed:

```bash
psql --version
```

If it is not installed on Debian or Ubuntu:

```bash
sudo apt update
sudo apt install postgresql postgresql-contrib
```

Enable PostgreSQL to start on boot:

```bash
sudo systemctl enable postgresql
```

Check whether the service is running:

```bash
sudo systemctl status postgresql
```

**PostgreSQL service and access basics**

To open the PostgreSQL shell as the default superuser:

```bash
sudo -u postgres psql
```
^ **`-u postgres`** tells `sudo` to switch to the **`postgres` system user** (instead of root)


Should you worry about the postgres super user? No worries:
- The **`postgres` database user does NOT use a password locally**
- It uses **peer authentication** (trusts the OS user)

To restart PostgreSQL:

```bash
sudo systemctl restart postgresql
```

To quickly inspect PostgreSQL logs if something is failing:

```bash
sudo tail -n 100 /var/log/postgresql/postgresql-*.log
```

**Create authentication right away**

Just like other databases, PostgreSQL should not be left wide open. Create your application user and database early so you are not building against the default superuser workflow longer than necessary.

Create the user with a password:
- Note you must have quotes for the USER so that it's case sensitive, otherwise the username would be stored all lowercase. When logging in later with that username, it won't let you know if it's mistyped or misspelled.
```sql
CREATE USER "{USER}" WITH PASSWORD "{PASSWORD}";
```

Check that the username is what you expected (because of the lowercase/uppercase nuance):
```
\du
```
^ Means display users

Create the database:

```sql
CREATE DATABASE myapp_db;
```

Grant database privileges:

```sql
GRANT ALL PRIVILEGES ON DATABASE myapp_db TO "{USER}";
GRANT ALL ON SCHEMA public TO "{USER}";
```

A user needs `CREATE` on the database to create a schema, and `CREATE` on the target schema to create tables there. The current user is actually `postgres`, so we need to reassign the database's owner and it's NOT enough to just grant privileges:
```
ALTER DATABASE myapp_db OWNER TO "{USER}";
```

**Verify login from the command line**

Exit the psql shell (`exit` or `\q`), then test logging in as that application user.
- Note if you mistyped the username, it won't let you know that because it'll just be a password authentication failed error

```bash
psql -h 127.0.0.1 -U "{USER}" -d myapp_db
```

Use `-h 127.0.0.1` on purpose. That forces a TCP connection instead of a Unix socket, which helps avoid authentication confusion when testing.

**If having problems authenticating:**
- Check if the username was created with case sensitivity (if surrounded by quotes) or automatically all lower case (no quotes).
- Check authentication method in settings. Refer to ____

**Once connected, run a few quick checks:**

```sql
SELECT NOW();
SELECT current_user;
SELECT current_database();
```

You can also test with a one-liner from the shell:

```bash
psql -h 127.0.0.1 -U myapp_user -d myapp_db -c "SELECT NOW();"
```


**Quick test table**

To test inserts and reads, create a simple table:

```sql
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(255)
);
```

##### **Test PostgreSQL on Node.js**

Install the PostgreSQL driver:

```bash
npm install pg
```

Seed and read example:
```js
const { Client } = require('pg');

const client = new Client({
	host: '127.0.0.1',
	user: 'YOUR_USERNAME',
	password: 'YOUR_PASSWORD',
	database: 'myapp_db',
});

async function seed() {
  // 🔥 Drop table if it exists
  await client.query(`DROP TABLE IF EXISTS users`);

  // 🏗️ Recreate table
  await client.query(`
    CREATE TABLE users (
      id SERIAL PRIMARY KEY,
      name VARCHAR(100),
      email VARCHAR(255)
    )
  `);

  // 🌱 Seed data
  await client.query(
    `INSERT INTO users (name, email)
     VALUES ($1,$2), ($3,$4), ($5,$6)`,
    [
      'Abby', 'abby@example.com',
      'Bobby', 'bobby@example.com',
      'Caitlin', 'caitlin@example.com'
    ]
  );

  console.log('Seed complete');
}

async function read() {
  const result = await client.query('SELECT * FROM users');
  console.log(result.rows);
}

async function main() {
  try {
    await client.connect();
    await seed();
    await read();
  } catch (err) {
    console.error(err);
  } finally {
    await client.end();
  }
}

main();
```

##### **Test PostgreSQL on Python**

Install the driver:

```bash
pip install psycopg2-binary
```
^ Psycopg is the most popular PostgreSQL database adapter for the Python programming 
^ **`psycopg`** doesn’t stand for something clean like an acronym—it’s a **name mashup**:
- **“psyc”** → from **Python** (historically referencing “psyco,” an old Python performance project)
- **“o”** → - Filler to make the name pronounceable → _psy-co-pg_
- **“pg”** → short for **PostgreSQL**

Seed and read example:

```python
import psycopg2

conn = psycopg2.connect(
    host="127.0.0.1",
    user="YOUR_USERNAME",
    password="YOUR_PASSWORD",
    dbname="myapp_db"
)

cur = conn.cursor()

cur.execute("DROP TABLE IF EXISTS users")

cur.execute("""
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(255)
)
""")

cur.execute("""
INSERT INTO users (name, email)
VALUES (%s,%s), (%s,%s), (%s,%s)
""", (
    "Abby", "abby@example.com",
    "Bobby", "bobby@example.com",
    "Caitlin", "caitlin@example.com"
))

conn.commit()

cur.execute("SELECT * FROM users")
print(cur.fetchall())

cur.close()
conn.close()
```

##### **Test PostgreSQL on PHP**

Install the PostgreSQL extension:

```bash
sudo apt install php-pgsql
```


Seed and read example:

```php
<?php

$conn = pg_connect("host=127.0.0.1 dbname=myapp_db user=YOUR_USERNAME password=YOUR_PASSWORD");

if (!$conn) {
    die("Connection failed\n");
}

// Delete table if it already exists
pg_query($conn, "DROP TABLE IF EXISTS users");

// Create table
pg_query($conn, "
    CREATE TABLE users (
        id SERIAL PRIMARY KEY,
        name VARCHAR(100),
        email VARCHAR(255)
    )
");

// Seed data
pg_query_params(
    $conn,
    "INSERT INTO users (name, email) VALUES ($1,$2), ($3,$4), ($5,$6)",
    [
        'Abby', 'abby@example.com',
        'Bobby', 'bobby@example.com',
        'Caitlin', 'caitlin@example.com'
    ]
);

echo "Seed complete\n";

// Read data
$result = pg_query($conn, "SELECT * FROM users");

while ($row = pg_fetch_assoc($result)) {
    print_r($row);
}

pg_close($conn);
```

Either run with `php -f test.php` or open the webpage on a web browser.

---
### ADVANCED WEBSITE: Versioning, CI/CD, Scaling

Let's install these versioning and CI/CD solutions:

---
#### Git
- Make sure there is git on your system
	- Some systems come with git. Check out by running `git --version`
	- If git is not included, lookup instructions how to install git on the system
		- eg. Google: Ubuntu 22 install git
	- Verify installation successful: `git --version`
	- Install gh because that's needed to forcefully authenticate for git (if authentication becomes stale and authorized commands like git push fails). Lookup instructions on how to install gh on the system eg. Google: Ubuntu 22 install gh
	- Setup identification for git commands (or you'd be annoyed about it later when using git):
	```
	git config --global user.name "Your Name"
	git config --global user.email "youremail@domain.com"
	```

	- **Github**: Setup authorization for git commands
	  
	  1. Check if server `ls ~/.ssh` has .pub files and similarly paired file without the ".pub" file extensions (Those are the public and private keys, respectively). If not, generate a public/private key referring to:
	  https://docs.github.com/en/authentication/connecting-to-github-with-ssh/generating-a-new-ssh-key-and-adding-it-to-the-ssh-agent
		- Make sure the email address is the one used to sign into Github

		```
		ssh-keygen -t ed25519 -C "your_email@example.com"
		```

	  2. Add public key to your Github account, referring to: https://docs.github.com/en/authentication/connecting-to-github-with-ssh/adding-a-new-ssh-key-to-your-github-account
		  1. Click New SSH key at https://github.com/settings/keys
		  2. Paste the contents of the public key (eg. id_ed25519.pub) and save as a SSH key, recommended naming the key after your server provider name for organizing purposes.

	3. Point `git` command to your private SSH key file. Set it once and forget it.
	   - Edit: `~/.ssh/config`
	   - Add:
		```
		Host github.com  
		  HostName github.com  
		  User git  
		  IdentityFile ~/.ssh/my_key  
		  IdentitiesOnly yes
		```
	- Now all Git operations to GitHub will use that key automatically.


	- **Gitlab**: Setup authorization for git commands
		- Refer to Github section
		- Copy contents of the pub file (same pub file for Github and Gitlab) into Gitlab
		- Add gitlab to `~/.ssh/config` in a similar fashion as how you added github.

	- **Preferred terminal editor**: Is git using your preferred terminal text editor (default may be vi or nano)
		- To test: Run this at a git repo - `git rebase -i HEAD~2` to any cloned repo or your own repo at the remote server, and then see what terminal text editor opens
		- If you need to set a preferred terminal text editor: [[Git set which terminal text editor to use]]

#### Docker
- Make sure docker is on your system
	- Test for docker: `docker --version`
	- Lookup instructions how to install docker on the system
		- eg. Google: Ubuntu 22 install docker
		  https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-on-ubuntu-22-04
		  eg. Google: Debian 12 install docker
		  https://docs.docker.com/engine/install/debian/#install-using-the-repository
		- Note instructions differ from Mac because on Mac the recommended approach is Docker Desktop which bundles in a daemon better than installing independent packages with homebrew can.
	- Don't forget to test if Docker installed successfully: `docker --version`
	- Docker compose installation instructions: ... docker-compose-plugin ? which makes not just docker-compose possible but `docker compose build` possible because of the plugin making docker aware of compose
#### Scaling Solutions
- Look up instructions for your OS on how to install these scaling solutions, if applicable to your server's use cases
	- Balancers and multi workers:
		- **For persistent NodeJS**: pm2
			- Refer to the tutorial [[Installing PM2 and Configuring Nginx for Multiple Node.js Applications (Shortcut)]] even if you're not on nginx (the first sections will be applicable before the section on applying it to nginx)
		- **For persistent Python**: Supervisor, virtual envs, gunicorn and flask
			- Refer to [[Supervisor Primer - GET STARTED - Alternately, Install Everything.md]] which includes supervisor, gunicorn, flask, pyenv, pyenv-virtualenvs, pipenv. There it will install all the dependnecies
				- [ ] pyenv
				- [ ] pyenv-virtualenvs
				- [ ] pipenv
				- [ ] flask
				- [ ] gunicorn
				- [ ] supervisor
		- Turn on any scaling/persistence that is usually ON in your older server:
			- Docker or supervisor to restart your api app on crashes (either server crash or app crash)
				- Docker: [[Docker Primer - Get Started]]
				- Supervisor etc: [[Supervisor Primer - GET STARTED (Python stack with Sh, Pyenv-virtualenvs, Pipenv, Gunicorn)]]
### ADVANCED WEBSITE: Timeouts

Are users waiting on something generating for a long time? Their fetch will wait for that long then expect a response unless you're doing web sockets, SSE, etc. You need to raise up the allowed wait time before a timeout error. Skip this if not applicable.

Inside a server block:
```
    location /api/ {
        proxy_read_timeout 300s;   # Adjust as needed
        proxy_connect_timeout 300s; # Adjust as needed
        proxy_send_timeout 300s;   # Adjust as needed
    }
```

If you're proxy passing to a backend to hide non-web ports and increase security, it could ultimately be:
```
location /api {
	proxy_pass https://127.0.0.1:5001;
	proxy_read_timeout 300s;   # Adjust as needed
	proxy_connect_timeout 300s; # Adjust as needed
	proxy_send_timeout 300s;   # Adjust as needed
	proxy_set_header Host $host;
	proxy_set_header X-Real-IP $remote_addr;
	proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
	proxy_set_header X-Forwarded-Proto $scheme;
}
```

Keep in mind in the future when making the app, you have to adjust Gunicorn/PHP's timeouts too:

Timeout of Gunicorn (Flask and Python):
```
gunicorn --timeout 300 myapp:app...
```

Timeout of PHP:
```
ini_set('max_execution_time', 300);  // Adjust as needed
ini_set('default_socket_timeout', 300);  // Adjust as needed
```

### ADVANCED WEBSITE: Prepare for web app features
Install ffmpeg, ctypes, imagemagick, and pcregrep for various web apps and their testing of python wrapping ffmpeg and php wrapping imagemagick. Refer to tutorial [[Web app ready - Ffmpeg, cytypes, imagemagick, pcregrep]]

As you install additional dependencies, make sure to document them in the same place where you keep your server login details, paths, and configuration notes. You can refer back to your list of dependencies when you migrate or clone your setup to another server later. This may also be a good place to write what local app scripts or published apps (with users) that need their paths updated if the server hostname changes. This document could be named: acc Web App Dependencies and URLs

---

## Checklist - Improve Future Developer Experience

Because your server is setup to handle many different tech stacks, you're probably the type of developer that will touch different stacks at different points of your career. Let's improve the developer experience so it's easy to manage such complexity

1. Tech folders
   Create folders that have symbolic links to your pm2 apps, your gunicorn apps, etc possibly named by their port numbers. Create a symbolic link to your supervisor app configs at the root (as siblings to whatever your app/ or apps/ folder is at)

	- app
		- or whatever folder name. this contains your websites and/or web apps
	- app-mysql
	- app-mongo
	- app-node-pm2
	- app-python-ssgp
		- These are your python application folders symbolically linked
		- Text explains ssgp: supervisor against sh, sh loads gunicorn in virtual environment (pyenv-virtualenv leveraging pipenv
	- app-supervisor-configs
		- These are your supervisor app configs which have paths to your shell sh files, and those shell sh files have the folder path to their python application and the sh file loads the virtual environment, then loads gunicorn against the python application folder path that has wsgi.py and server.py (or app.py)

2. Better git experience
   Create git aliases that make it easier to add/commit, see diff, and check logs. Instructions at [[Git Sugar Aliases - Small Tweaks That Make Git on the Command Line Better]]

----

## ACC - Template to track all your credentials, folder paths, file paths in your web host details document

**ACC stands for Account. It's Weng's notation for saving login credentials, key OS, key configuration information, etc**

**Keep below ACC's that are at the same level of hierarchy as separate sections in a mega ACC document**

### ACC Services Dashboard / OR Login Via SSH Root
- os: (Eg. Debian 12)
- \__which is
- \__oauth2 login creds
- \__url


\> Alt Login:  
- \__login creds


Public IP: _ip

Available IP addresses: _availabeIps


Default domain name:
\__ 


Public IP URL:
\__   


Available IPs (If dedicated server)
- CIDR to expand to below: ??
- Network Address:  ??
- Usable IP Addresses:  ?? to  ??
- Broadcast Address:  ??

Root web directory is:****
..

How to change password:
`sudo passwd root` OR UI: ...

Firewall managed with:
iptables / firewalld / ufw

Command SSH alias:
```
```

----
### ACC Provider Checklist / Statements of Facts

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

### ACC Folder structure

- Recommend have separate folders for pm2/nodejs and for python/supervisor apps
	- If for the URL you prefer all apps regardless of language belongs to one folder, eg. /app, then have the other language-based folders symbolically link, eg. /nodejs/app1 -> /app/app1
- Recommend Supervisor app config files be named with the port number ranges they use
- May have a root folder /keys that have important keys for all your apps but make sure is blocked from being visited on the web browser. It's safer if you have a build script that saves the env keys to your .bash_profile, then re-source, instead.

### ACC OS paths (error logs, configs), commands, and workflows

...
### ACC Supervisor

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

### ACC Mounted VPS

**(May have this section and all subsequent sections, for each additional VPS/VM)**

hostname: .. 
bridge: xenbr0
public ip: ..

user: ..
password: ..
SSH in from local computer: 
```
ssh root@222.22.222.25
```


Console in from host shell: 
```
sudo xl console vps0
```

Installation Summary (xen-create-image):
```
Installation Summary  
---------------------  
Hostname        :  vps0  
Distribution    :  bookworm  
MAC Address     :  00:..  
IP Address(es)  :  dynamic  
SSH Fingerprint :  SHA256:... (DSA)  
SSH Fingerprint :  SHA256:... (ECDSA)  
SSH Fingerprint :  SHA256:... (ED25519)  
SSH Fingerprint :  SHA256:... (RSA)  
Root Password   :  <IMPORTANT>
```



---

### ACC Web Hosting Control Panel

- \__which is
- \__login creds
- \__url

\> \__ IA and how to navigate there from Services Dashboard  


**Admin users (Secondaries):**


**Site users (Tertiary)**



---

### ACC SFTP

Where to modify: \__


**SFTP as site user**
\__login creds
- Site user navigate to: \__ user navigation
- Preferred. Folders created by web host panel and by FTP - to make consistent so your php scripts can create files

**SFTP as root**
\__login creds


---

### ACC SSH Root access:
- \__login creds
- `ssh root@... -p 22` 

\> Alt Login:
Passwordless with SSH private key: \__filepath

Restart time if known: ...

\> Can change password at
\__ui navigation and/or link

\> Browser terminal is at
\__ui navigation and/or link  

\> \__ IA and why that’s how you navigate to SSH Root access creds settings

\> Aka root web directory for your website,  Aka working directory for your code and webpages:  
...

---

### ACC SSL HTTPS Directories
- **ssl_certificate:** \__remote file path
- **ssl_certificate_key:** \__remote file path

\__ Mention any necessary re-setups whenever you have new ssl certificates, eg. gunicorn command that has SSL paths in .sh file managed by Supervisor


----


### ACC MySQL/PHPMyAdmin

MySQL PHPMyAdmin:
_creds
_url


MySQL Shell:
```
..
```

---

### ACC Mongo

Mongo URL (PHP, NodeJS, Python):
```
..
```

Mongo Shell:
```
..
```


---

### ACC PostgreSQL

Login/pass:

Superuser (peer via being the root user on OS):
```
sudo -u postgres pqsl
```

PSQL Shell:
```
..
```

---
## acc Domain Site Backup SOP

**(Separate Document from the mega document with multiple ACC sections)**

Write how to backup the domain in this SOP document, such as the different database backups (MySQL, MongoDB), file backups (or bare minimum with state data files while you have the original app code elsewhere on the computer), eco/ backup, vhosts, root SFTP SSH, and site username, and SSL domains/subdomains, etc.

Any username used by the terminal to create or modify files through PHP or Python scripts must also be updated.

Prepend document that this is useful for migrating to another server too.

Useful to tar up entire root folder for backup and restore:

**Tar command:**
```
tar -czvf a.tar.gz wengindustries.com/
```

**Rsync command (download remote -> local):**
```
rsync -avz --partial --progress -e "ssh -i ~/.ssh/newmac2023_hostinger.pub" root@55.555.55.555:/home/wengindustries/htdocs/a.tar.gz .
```

**Rsync command (upload local -> remote):**
```
rsync -avz --progress --partial --append -e "ssh -i ~/.ssh/newmac2023_hostinger.pub" b.tar.gz root@55.555.55.555:/home/wengindustries/htdocs
```
Local computer (for command variance): MacBook Pro 2021

---

## acc Network settings

**(Separate Document from the mega document with multiple ACC sections)**

This document keeps the original and modified network configurations in case have to replicate it or reverse some configurations.******
### Original

/etc/network/interfaces:
```
# This file describes the network interfaces available on your system  
# and how to activate them. For more information, see interfaces(5).  
  
source /etc/network/interfaces.d/*  
  
# The loopback network interface  
auto lo  
iface lo inet loopback  
  
# The primary network interface  
allow-hotplug eno1  
iface eno1 inet static  
        address ../29  
        gateway ..  
        # dns-* options are implemented by the resolvconf package, if installed  
        dns-nameservers .. .. 8.8.8.8  
        dns-search ..
```

### Modified to have a restartable VM / VPS:

If separated dedicated server into VPS
`/etc/network/interfaces`, `ip route`, `ip addr` for both host and the VM

This how my host's `/etc/network/interfaces` look, and:
Ethernet port / network card is named: 
And there's a virtual bridge named: 
```

```

Host's `ip addr` is:

```

```

Host's `ip route` is: 
```

```


I just ran `xl create vps0` and created a VM. 

The VM's `/etc/network/interfaces` look like, and:
Ethernet port / network card is named:
```

```

VM's `ip addr` looks like:

```

```

VM's `ip route` looks like:

```

```

---

## acc UFW Open Ports

**(Separate Document from the mega document with multiple ACC sections)**

8443 PMA Php MyAdmin and CloudPanel
80
443
27017 MongoDB

---
## acc Web App Dependencies and URLs

**(Separate Document from the mega document with multiple ACC sections)**

..

---
## acc Exiting Protocol

**(Separate Document from the mega document with multiple ACC sections)**

List backup and cleanup procedures here if discontinuing service.