By Weng

[![GitHub](https://img.shields.io/badge/GitHub--blue?style=social&logo=GitHub)](https://github.com/Siphon880gh) [![LinkedIn](https://img.shields.io/badge/LinkedIn-blue?style=flat&logo=linkedin&labelColor=blue)](https://www.linkedin.com/in/weng-fung/) [![YouTube](https://img.shields.io/badge/Youtube-red?style=flat&logo=youtube&labelColor=red)](https://www.youtube.com/user/Siphon880yt/) [![Donate](https://img.shields.io/badge/buy%20me%20a%20coffee-donate-yellow.svg)](https://www.paypal.com/donate?business=T42BK25TYPZSA&item_name=Buy+me+coffee+%28I+develop+free+apps%29&currency_code=USD)


**How to use this guide:** Open a table of contents that persist on your screen. There are optional steps and appendix to cover concepts at the end of the guide. 

This is PART 2 after finding out that your hardware supports Hardware Virtualization, but not KVM type Hardware Virtualization.

WIth this guide, you've chosen to use xl command line to create and manage VMs. You could not use any of the tools that have GUI either because your server does not have the requirements (usually requiring you to boot into recovery mode, etc) or it's out of your budget.

---

**Objectives / Knowledge Requirements:**

We will create a VM on the dedicated server. The VM will act like its own computer.

Then we convert the VM into VPS by setting up the Networking so that data can flow between the VM and the internet. 

This also means you need to have some background knowledge on networking, partitioning, computer computing and storage resources, and VMs. Had you used GUI, that would be abstracted away.

---

## Check installed

Confirm that xl and xen-create-image comes included with xen. confirm they work:
```
xl --version
xen-create-image --version
```

## Image creation

### Overview on resource allocation
Prepare for the xl command that creates the image. Typically we include network bridge names etc but we will keep networking options to a minimum so we can test the computer resource options work right away. We will also decide on an OS and version, which the xl command will download the image and install. It'll work when we successfully create a VM we can console into. Then we can modify the networking options after the image is created. This strategy will assure we can even create an image.

### Prepare to allocate computing and storage resources

Run this to get your current computer resources so you can figure out allocations:
```
echo "Memory (RAM):" && free -h  
echo ''  
echo -e "\nDisk Space:" && df -h  
echo ''  
echo -e "\nCPU Information:" && lscpu | grep "Model name\|CPU(s):\|MHz"
```

Keep in mind for the tool we chose (xl) what resource allocations we can set when creating the image and what allocations can only be set after image creation (cpu use percentage), and what allocations should be preferred to be set after image creation (networking)

> [!note] Figure out computer resource allocations during image creation
> 
> To allocate resources for a single VPS on your dedicated server while leaving enough overhead for managing the host, you can follow these general guidelines. Keep in mind that depending on your tool, your allocations could be in different units. For example, xl uses Gigabytes in their allocation options. There is a difference between GiB and GB.
> 
> These calculations are based off you wanting to split a dedicated server into one VPS. If you're aiming for multiple VMs or VPS, you have to split them evenly or vertically scale up by adding more hardware (RAM, hard drives, etc)
> 
> 1. **Memory Allocation**:  
>    - **VPS**: Allocate **85-90%** of the total memory to the VPS.
>    - **Host Overhead**: Leave **10-15%** for the host to handle SSH, Webmin, and other essential services.
> Chosen 90% for Gb
> `27`
> 
> 
> 2. **Swap File Size**:  
>    - **VPS**: Allocate a swap file size equivalent to **100%** of the VPS's memory allocation, but this can vary depending on your use case (e.g., 2GB RAM = 2GB swap).
>    - **Host**: Allocate swap based on what remains after the VPS allocation, typically another **100%** of the host’s memory overhead.
> Chosen to follow the swap size strategy that the local machine used in GB:
> `15`
> 
> There’s no swap file option, however you should theoretically be able to create a swap file inside commandline once VM is created
> 
> 3. **Disk Space Allocation**:  
>    - **VPS**: Choose **90-95%** of the disk space to the VPS. Subtract the swap size you've chosen in the previous guideline. This is because you will partition off from an existing hard drive.
>    - **Host Overhead**: Leave **5-10%** for the host, including space for logs, backups, and other essential files.
> Ran `df -h` to determine that the main hard drive:
> E.g. Main harddrive has `205` GB available. Will assume won't be adding anymore significant file sizes of packages or files to the dedicated server besides to the VPS.  90% of that is 184.5GB, but rounded down to be safe is `180` GB. Subtracted from swap size is `165`GB
> So: `165`
> 
> You might be left with like 25gb for the dedicated server and that's ok
> 
> These percentages ensure that your dedicated server remains responsive and manageable while maximizing the resources available to your single VPS.

#### Overview you will create two partitions out of a non-root partition

You will instruct xen-create-image to create two partitions out of an existing partition. The two partitions are storage and swap for the VM.

Original before partitioning
```
NAME   MAJ:MIN RM  SIZE RO TYPE MOUNTPOINT
sda      8:0    0  500G  0 disk
└─sda1   8:1    0  500G  0 part /
sdb      8:16   0  1.8T  0 disk
└─sdb1   8:17   0  1.8T  0 part
```

Let's assume you've used `/dev/sdb1` to create `vg0` and then created a VM with a 155G root filesystem and a 15G swap partition. Here's what `lsblk` might look like:
```
NAME        MAJ:MIN RM   SIZE RO TYPE MOUNTPOINT
sda           8:0    0  500G  0 disk
└─sda1        8:1    0  500G  0 part /
sdb           8:16   0  1.8T  0 disk
└─sdb1        8:17   0  1.8T  0 part
  └─vg0-vps1  254:0  0   155G  0 lvm
  └─vg0-swap  254:1  0    15G  0 lvm
sr0          11:0    1  1024M  0 rom
```

Notice we did not touch sda1 because that's mounted to root which houses your SSH access root credentials and critical system files

##### Do you have a non-root partition?

- Good if you do have a non-root partition. You can assign a VM to this partition while your main partition where your SSH session is residing in can remain intact.
- Damned if there's only one partition because it's mounted to your root filesystem where your SSH session is currently residing
	- If you rended the dedicated server, reach out to support to help break off into two partitions
	- If you own the dedicated server and have physical access to it, boot from CD while unmounting the root partition, splitting and resizing it, etc

**Let's find out if you have this problem**

Run `fdisk -l` to see if you have the single root filesystem problem:

We have one partition that has significant size. The other two partitions are less than 1GB and insignificant
```
Device     Boot     Start       End   Sectors  Size Id Type
/dev/sda1  *         2048 465663999 465661952  222G 83 Linux
/dev/sda2       465666046 467662847   1996802  975M  5 Extended
/dev/sda5       465666048 467662847   1996800  975M 82 Linux swap / Solaris
```

fdisk doesn't show mount points but running `lsblk -f` will. 

```
NAME   FSTYPE FSVER LABEL UUID          FSAVAIL FSUSE% MOUNTPOINTS
sda                                                                           
├─sda1 ext4   1.0         55ea7608-...  204.2G     1% /
├─sda2                                                                        
└─sda5 swap   1           5209b3bf-...                [SWAP]
```


Run `df -hT` to see all your mount points, you can see that your sda1 is more spelled out as /dev/sda1 and is mounted to root /. You see its type ext4 which is a harddrive. The other types here are memory-based filesystems which  are not significant
```
Filesystem     Type      Size  Used Avail Use% Mounted on
udev           devtmpfs   16G     0   16G   0% /dev
tmpfs          tmpfs     3.1G  652K  3.1G   1% /run
/dev/sda1      ext4      218G  2.3G  205G   2% /
tmpfs          tmpfs      16G     0   16G   0% /dev/shm
tmpfs          tmpfs     5.0M     0  5.0M   0% /run/lock
tmpfs          tmpfs     3.1G     0  3.1G   0% /run/user/0
```

Run: `df -hT | grep -Ev "devtmpfs|tmpfs"` showing only the block-device filesystems
```
Filesystem     Type      Size  Used Avail Use% Mounted on
/dev/sda1      ext4      218G  2.3G  205G   2% /
```


In that case, you HAVE A PROBLEM. Your entire disk is allocated to a single partition (`/dev/sda1`), which is mounted as your root filesystem. This partition holds your operating system, SSH service, and all critical files. Therefore, **unmounting** or modifying this partition while the system is running is not feasible without risking the loss of SSH access and potentially crashing the system. **But you have to** create partition that houses your image and swap.

**Do not unmount the root filesystem (`/dev/sda1`)** while the system is running, especially if you are connected via SSH. If this is your only partition, your options are:

###### No, I dont have a non-root partition and I dont have physical access to the server
- You could use file-based images for your VMs instead of LVM but that's slow.
- Ask support of your rented dedicated server if they can create two partitions. Request that:
	- Hi Support, 
	- Situation: I am creating a VM inside the dedicated server and having that VM act as a VPS. 
	- Request: I wish to split the partition of the dedicated server so that one partition is used for the root filesystem (where the operating system and essential files reside) and the other partition I will allocate to a VM that acts as a VPS, and another partition to have backups.
	- Why ask for help: My problem is that we only have one main partition and that partition is mounted as the root filesystem, so I cannot mess with it without losing SSH access and getting locked out.
	- I see there's a /dev/sda1 that has 205G available. I'd like to create two partitions out of this. One partition could have around 30-50GB or 40GB and will act as the root file system. The other partition must have 165GB. The bigger partition will NOT be root. The two partitions can be formatted into ext4 types. Again the smaller partition will be the root filesystem.
	- If you're curious I'll use the second bigger partition to create logical volumes for swap and VM.
	- I hope we do not need to reformat my files. But if you have to, I have things backed up and the preferred OS is Debian 12
- For practical purposes, you want to be able to backup the VPS for quick restoring when needed. You may need a third partition for storing backup and it may not have to be the same size as the VPS partition if you are willing to be strategic about what to backup and what to invest in (for example, cron-scripting user files to upload to another file storage server). Or you could have another partition of the same size and may want to purchase an extra hard drive through your dedicated server web host / provider (or if you own the server physically, acquire and install the hard drive yourself). In that case, your support request script can change to:
	```
	Dear Support, 
	
	Background: I am creating a VM inside the dedicated server and having that VM act as a VPS. I do not want to run websites directly on the dedicated server. This gives me the ability to restart or restore my own web servers.
	
	Request: I wish to split the partition of the dedicated server so that one partition is used for the root filesystem (where the root user and essential files reside) and the other partition I will mount a VM, and another partition I will have backups.
	
	- The main partition could have around 40-50GB. This will be the root file system.
	- A second partition must have 115GB. It will remain unmounted. If you're curious: I will use this partition for VM and add a virtual bridge so it can be discoverable on the internet as a VPS.
	- A third partition with 50 GB. It can remain unmounted. If you're curious: This lets me backup files from the VPS.
	- We can keep all the partitions as ext4 filesystems.
	
	Why ask for help: My problem is that we only have one main partition and that partition is mounted as the root filesystem, so I cannot mess with it without losing SSH access and getting locked out. I figured since you're on-premise, you can unmount without that problem.
	
	Helpful information: I see there's a /dev/sda1 that has 205 G available. I'd like to create the three partitions out of this.
	
	I hope we do not need to reformat my files. But if we must, I have things backed up already and the preferred OS is Debian 12.
	```
- Response back to you: Your numbers for all the partitions might not be exact, so the support team might leave some unallocated sectors for you to allocate the final partition. Otherwise there might be some GB's remaining if they perform all the partitions exactly as told. Or they might allocate more GBs to the biggest partition. This depends on the technician. If they left you unallocated sectors for you to partition, instructions on how to partition the rest of the unallocated sectors are at [[Partition unallocated sectors on a disk in Linux]]

#### Overview you will create logicals from the non-root partition

The `xen-create-image` works with logical volumes which is not the same as partitions. You will assign a partition to different types of entities in order to work with the logical volume management (LVM) philosophy.
- You will select a non-root partition that is pretty much the size of your desired VPS file storage plus the desired swap size. Let's say 165 GB
- You will create a physical volume out of that non-root partition
- Then you will assign a volume-group to that physical volume
- You will call xen-create-image passing it the volume group name and also passing in the hostname you would name the VPS after
- The `xen-create-image` will create two logical volumes, one for the VPS, and one for the swap file (automatically naming it for `lsblk` as VOLUME_GROUP+"swap" or "VOLUME_GROUP"+HOST_NAME)
	- FYI only. Behind the scenes, `xen-create-image` runs commands like `lvcreate --yes vg0 -L 15G -n vps1-swap` and `lvcreate --yes vg0 -L 150G -n vps1-<hostname>` which will automatically allocate space from the available free space in the specified volume group (`vg0`) and create two logical volumes that can be mounted, formatted, and used just like regular "disk partitions". They are "logically" partitions in practice. `xen-create-image` assign names to these logical volumes based on the volume group's name and whether it's the VPS host or the swap; you passed the hostname in the command.
	- In this example, this is the result of `lsblk`:
	```
	NAME        MAJ:MIN RM   SIZE RO TYPE MOUNTPOINT
	sda           8:0    0  500G  0 disk
	└─sda1        8:1    0  500G  0 part /
	sdb           8:16   0  1.8T  0 disk
	└─sdb1        8:17   0  1.8T  0 part
	  └─vg0-vps1  254:0  0   155G  0 lvm
	  └─vg0-swap  254:1  0    15G  0 lvm
	sr0          11:0    1  1024M  0 rom
	```


To summarize those concepts:
- **Physical Volume (PV)**: The base layer of LVM, representing the actual storage devices or partitions.
- **Volume Group (VG)**: A pool of storage that combines physical volumes.
- **Logical Volume (LV)**: The flexible partitions created from a volume group, which can be mounted, formatted, and used just like regular "disk partition".


#### Convert the non-root partition into the LVM framework

Requirement: Your root filesystem is in one partition. You have another partition that's the size of the VPS plus its swap. We will use xen-create-image which creates two sub-partitions (VPS and swap)

First make sure LVM framework is installed which installs the cli tools pvcreate and vgcreate and lvcreate (xen-create-image uses lvcreate behind the scene to create two logical volumes)
```
sudo apt install lvm2
```

Lets assign the non-root partition into the LVM (logical volume management) framework that `xen-create-image` uses.

First make sure you've unmounted /dev/sdaX otherwise pvcreate and vgcreate will complain it's still mounted. Make sure your fstab has been set up to permanently mount /dev/sdaX because after these steps are done, we will restart mountings based on fstab

You have to unmount based on the mount point (directory path a partition is loaded into). Run `lsblk` to get the mount point of sdaX

Could've been
```
sudo umount /mnt/vps0
```

Make sure to adjust for X (run `lsblk` to see which partition is appropriate):
```
sudo pvcreate /dev/sdaX
sudo vgcreate vg0 /dev/sdaX
```
^If asking if ok to wipe anything while creating physical volume (`pv...`), say yes.

FYI: Note if your /dev/sdaX is a logical partition, this will still work. pvcreate creates a "physical volume", then vgcreate creates a "volume group" from the "physical volume", then xen-create-image will create "logical volumes" VPS and swap. Logical volume is not the same as logical partition, so we are good to go

That's it. You have the partition under the volume group 0. You will pass this volume group name `vg0` into the `xen-create-image` and it will create two logical volumes automatically (for the VM/VPS and for the swap)

#### Create the VM

Create VM without network options (dhcp option required, lets say yes to dhcp we wanting automatic IP for now)
```
sudo xen-create-image --hostname=vps0 --lvm=vg0 --size=100G --memory=24G --swap=15G --debootstrap --dist=jammy --arch=amd64 --dhcp
```

- `--hostname=vps1`: Sets the hostname of the new VM to `vps1`.
- `--lvm=vg0`: Specifies that the root filesystem for the VM should be created as a logical volume within the volume group `vg0`.
- `--size=100G`: Indicates that the root logical volume will have a size of 100 GB.
- `--memory=24G`: Allocates 24 GB of RAM to the VM.
- `--swap=15G`: Allocates 15 GB of swap space to the VM.
- `--debootstrap`: standalone command-line tool if outside the context of `xen-create-image`. It's used primarily for creating a minimal Debian or Ubuntu system within a specified directory or partition (aka VM).
- `--dist=jammy`: Specifies that the distribution to be installed is Ubuntu 22.04 (Jammy Jellyfish).
- `--arch=amd64`: Specifies the architecture of the VM as 64-bit (AMD64).
- `--dhcp`: Configures the VM to use DHCP for network configuration.
- Keep in mind the size and swap should equal the total file size of that partition for max use of storage space

Let's test if successful:
1. List all VMs to see if the VM is listed:
	```
	xl list
	```
2. Console into the VM:
	```
	xl console <vm-name>
	```
3. Before you install either nginx or apache or cloudpanel (which installs nginx), let's leave the VM because we have to configure its networking. Exit out of the VM with Ctrl + ]


----

### Modify VM to act as VPS

Requires networking knowledge.

#### Overview of Network Settings to allow VPS
- Let's assume you have a dedicated server that can host a website on the internet if you wanted to.
- But instead you want to carve out a VPS in this dedicated server so if the public facing website breaks, because the website is on the VPS, you can manage the VPS from your dedicated server's console (think restore from a backup). You dont want to wait for support of your rented colocation to reinstall or restart the dedicated server (which could downtime your website for half a day)
- A computer can act as a web server when its ports are opened to listen for internet requests with the ability to deliver back webpages or other files. It can open other ports to perform other data transmissions like SSH or act as a gaming server. Your computer is not shared with other businesses, therefore your computer is your dedicated server.
- Originally your physical network (all the devices and computer connected) consists of your computer connected to a network interface's ethernet port (one of many ports) which connects to gateway aka router, which then connects to the rest of the internet network. The gateway/router assigns IP addresses to devices on the network and routes traffic between the local network and the internet. Yes the gateway/router has a "DHCP server" or service inside.
- Now you will add VPS to your physical network. This is another computer whether it's a physical computer or a virtual one (aka VM, aka guest OS). Your VM has to go through your computer / dedicated server to receive or send information to the internet. The internet is blind to your VM. So what you do is create a "virtual bridge" and this is because you're not using a physical device for bridging the computers. Your virtual bridge will connect your guest OS / VMs to the internet too, hence when you assign a static public IP or the gateway/router's DHCP service assigns a public IP from a pool of public IPs, it can be connected to by other users on the internet. Btw, the host and available public IPs were assigned by the ISP and then your provider/webhost gave it to you during onboarding.

#### Prepare to setup networking inside the dedicated server

1. Get the IP address of your dedicated server that your SSH session is on:
```
hostname -I
```


*Result could be:*
```
208.76.249.74
```

2. Get information about your server's network and its connection to the internet network:
```
echo "Current IP Address (default interface):" && ip -4 addr show $(ip route | grep default | awk '{print $5}') | grep -oP '(?<=inet\s)\d+(\.\d+){3}'  
echo ''  
echo -e "\nAll Available IP Addresses:" && ip -4 addr show | grep -oP '(?<=inet\s)\d+(\.\d+){3}/\d+'
echo ''
echo -e "\nNetmask (for default interface):" && ip -4 addr show $(ip route | grep default | awk '{print $5}') | grep -oP '(?<=inet\s)\d+(\.\d+){3}/\d+' | cut -d '/' -f 2  
echo ''  
echo -e "\nGateway:" && ip route | grep default | awk '{print $3}'  
echo ''  
echo -e "\nDNS Servers:" && cat /etc/resolv.conf | grep 'nameserver' | awk '{print $2}'    
echo -e "\nNetwork Speed/Bandwidth:" && ethtool $(ip route | grep default | awk '{print $5}') | grep -i "speed"  
echo ''  
echo -e "\nip a:" && ip a
```


*Result could be:*
```
Current IP Address (default interface):
208.76.249.74


All Available IP Addresses:
127.0.0.1/8
208.76.249.74/29


Netmask (for default interface):
29


Gateway:
208.76.249.73


DNS Servers:
204.13.153.34
64.69.34.82
8.8.8.8

Network Speed/Bandwidth:
	Speed: 1000Mb/s


ip a:
1: lo: <LOOPBACK,UP,LOWER_UP> mtu 65536 qdisc noqueue state UNKNOWN group default qlen 1000
    link/loopback 00:00:00:00:00:00 brd 00:00:00:00:00:00
    inet 127.0.0.1/8 scope host lo
       valid_lft forever preferred_lft forever
    inet6 ::1/128 scope host noprefixroute 
       valid_lft forever preferred_lft forever
2: eno1: <BROADCAST,MULTICAST,UP,LOWER_UP> mtu 1500 qdisc mq state UP group default qlen 1000
    link/ether 34:17:eb:ee:2a:87 brd ff:ff:ff:ff:ff:ff
    altname enp4s0f0
    inet 208.76.249.74/29 brd 208.76.249.79 scope global eno1
       valid_lft forever preferred_lft forever
    inet6 fe80::3617:ebff:feee:2a87/64 scope link 
       valid_lft forever preferred_lft forever
3: eno2: <BROADCAST,MULTICAST> mtu 1500 qdisc noop state DOWN group default qlen 1000
    link/ether 34:17:eb:ee:2a:88 brd ff:ff:ff:ff:ff:ff
    altname enp4s0f1
```


3. Run `cat /etc/network/interfaces`:
*Result could be:*
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
        address 208.76.249.74/29
        gateway 208.76.249.73
        # dns-* options are implemented by the resolvconf package, if installed
        dns-nameservers 204.13.153.34 64.69.34.82 8.8.8.8
        dns-search 76.249.74.rdns.ColocationAmerica.com
```

5. Get next IP address you want to assign

For example, the output from above is in CIDR format:
```
All Available IP Addresses:
208.76.249.74/29
```


Ask chat for the available IPs or calculate yourself (ipcalc and other scripts are not reliable as of 2024 to my knowledge):
```
For the IP address block `208.76.249.74/29`, there are a total of 8 IP addresses available. Here's the breakdown:

- **Network Address:** 208.76.249.72 (This address cannot be assigned to devices, as it identifies the network itself.)
- **Usable IP Addresses:** 208.76.249.73 to 208.76.249.78 (These are the IP addresses that can be assigned to devices.)
- **Broadcast Address:** 208.76.249.79 (This address is used for broadcasting to all devices on the network and cannot be assigned to individual devices.)

So, the **usable IP addresses** are:

- 208.76.249.73
- 208.76.249.74
- 208.76.249.75
- 208.76.249.76
- 208.76.249.77
- 208.76.249.78
```


#### Setup networking inside the dedicated server

To set up your VM to act as a VPS with a public-facing website, you'll need to modify your network configuration to include a bridge. This bridge will allow the VM to communicate with the external network.

##### Step 1: Configure the Bridge in `/etc/network/interfaces`

You'll need to modify your `/etc/network/interfaces` file to create a network bridge.  

Before making any changes, it’s always a good idea to back up your current network configuration:
```
sudo cp /etc/network/interfaces /etc/network/interfaces.bak
```


Assuming this is the original:
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
		address 192.0.2.2/29
		gateway 192.0.2.1
        # dns-* options are implemented by the resolvconf package, if installed
		dns-nameservers 198.51.100.2 198.51.100.3 8.8.8.8
		dns-search example.rdns.provider.com
```

Here's how you can edit it:

```bash
# This file describes the network interfaces available on your system
# and how to activate them. For more information, see interfaces(5).

source /etc/network/interfaces.d/*

# The loopback network interface
auto lo
iface lo inet loopback

# The primary network interface
allow-hotplug eno1
iface eno1 inet manual

# Bridge setup
auto br0
iface br0 inet static
		address 192.0.2.2/29
		gateway 192.0.2.1
        bridge_ports eno1
        bridge_stp off
        bridge_fd 0
        bridge_maxwait 0
		dns-nameservers 198.51.100.2 198.51.100.3 8.8.8.8
		dns-search example.rdns.provider.com
```

Explanation:
- **eno1** is now set to `manual` to prevent it from being assigned an IP address directly.
- **br0** is the new bridge interface that takes over the IP address and gateway configuration.
- **bridge_ports eno1** connects your physical interface `eno1` to the bridge `br0`.
- **bridge_stp off** disables Spanning Tree Protocol, as it's not needed in this scenario.
- **bridge_fd 0** and **bridge_maxwait 0** are settings to reduce the delay during bridge setup.

##### Step 2: Apply the Configuration

After modifying the `/etc/network/interfaces` file, you should restart the networking service to apply the changes:

```bash
sudo systemctl restart networking && sudo systemctl restart sshd
```


Restarting the networking service will kick you off SSH. This command logs you back into SSH as soon as the networking service is back on. Could take up to 1-2 minutes.

If you can't log back into SSH, then the bridge is not functioning correctly or you have messed up. You have to reach out to support and let them know about the backup file so they can restore your network settings (or last resort, they reformat).



   ```bash
   # This file describes the network interfaces available on your system
   # and how to activate them. For more information, see interfaces(5).

   source /etc/network/interfaces.d/*

   # The loopback network interface
   auto lo
   iface lo inet loopback

   # The primary network interface
   allow-hotplug eno1
   iface eno1 inet manual

   # Bridge setup
   auto br0
   iface br0 inet static
           address 208.76.249.74/29
           gateway 208.76.249.73
           bridge_ports eno1
           bridge_stp off
           bridge_fd 0
           bridge_maxwait 0
           dns-nameservers 204.13.153.34 64.69.34.82 8.8.8.8
           dns-search 76.249.74.rdns.ColocationAmerica.com
   ```



##### Step 3: Test Network settings at dedicated server so far

1. **Check the Bridge Status:**
   Once you are back in, you can verify that the bridge is up and running by checking the network interfaces:

   ```bash
   ip a
   ```

   You should see `br0` listed with the correct IP address and configuration.

2. **Test Network Connectivity by pinging the Gateway:**
   To ensure the bridge is correctly routing traffic, you can ping the gateway:

   ```bash
   ping -c 4 208.76.249.73
   ```

   This should return successful pings if the bridge is set up correctly.

3. **Check Internet Connectivity:**
   You can also try pinging a public DNS server, like Google’s:

   ```bash
   ping -c 4 8.8.8.8
   ```

   Successful responses indicate that the bridge is functioning as expected.


Once you have verified that the bridge is working and that you can maintain SSH access, you can proceed to modify the VM’s network settings to use the bridge (`vif = ['bridge=br0']`) and restart the VM.

##### Step 4: Modify the VM’s Network Configuration

Since you left out the networking configuration during the creation of the VM, you'll need to modify the VM's configuration file (likely located at `/etc/xen/vps1.cfg`) to use the bridge you just created. 

Note for the anxious: When you restarted the networking service, it should let you back on unless you made a mistake - the VM settings did not have to be applied for you to SSH back into dedicated server.

Modify the `vif` line to connect the VM to the bridge:

```bash
vif = ['bridge=br0']
```

##### Step 5: Restart the VM to apply bridge to the VM

Once you've made these changes, restart your VM:

```bash
sudo xl shutdown vps1
sudo xl create /etc/xen/vps1.cfg
```

This setup should allow your VM to communicate externally, enabling it to host a website that can be accessed publicly.

You'll have to test entering the public IP of the VM into your web browser and whether it delivers a webpage, but you would've to setup nginx or apache or cloudpanel (which installs nginx). That can be for a future time. Let's move onto the optionals steps where you allocate networking resources and/or CPU resources so you don't hog the dedicated server.


If you want to review the concepts, refer to the appendexes

---


### OPTIONAL: Modify the VPS to not overhog the dedicated server's bandwidth

#### Prepare to allocate networking resources (bandwidth) inside the VM
> [!note] Allocation network resources after image creation
> 
> To allocate resources for a single VPS on your dedicated server while leaving enough overhead for managing the host, you can follow these general guidelines. Keep in mind that depending on your total, your allocations could be in different units
> 
> xl uses Gigabytes in their allocation options
> 
> These calculations are based off you wanting to split a dedicated server into one VPS. If you're aiming for multiple VMs or VPS, you have to split them evenly or vertically scale up by adding more hardware (RAM, hard drives, etc)
> 
>
> 1. **Maximum Network Speed**:  
>    - **VPS**: Limit the network speed to **80-90%** of the maximum available bandwidth.
>    - **Host Overhead**: Reserve **10-20%** for the host to ensure it can handle SSH, updates, and management traffic smoothly.
> If your network interface speed is 1 Gbps (or 1000Mbps)...
> Mbs/s (from echo) → kilobits/s (for setting at cloudmin)
> 900000
> or 900Mb/s 
> 
> These percentages ensure that your dedicated server remains responsive and manageable while maximizing the resources available to your single VPS.

#### Allocate networking resources (bandwidth) inside the VM

Here's how you can do it:

1. **Edit the VM's configuration file**:
   Open the configuration file of the specific VM (`/etc/xen/server.cfg`) using `vi`:

   ```bash
   sudo vi /etc/xen/server.cfg
   ```

2. **Modify the `vif` line**:
   Find the line that starts with `vif` and modify it to include a `rate` parameter. For example:

   ```bash
   vif = ['mac=00:16:3e:xx:xx:xx, bridge=xenbr0, rate=900MB']
   ```

   - `rate=900MB` limits the bandwidth to 900 Megabytes per second. You can adjust this value to whatever limit you prefer. This is a good bandwidth for a dedicated server that is containing one VPS and the dedicated server reported a bandwidth of 1000MB (Guideline is to use 90%).
   - This bandwidth limit set is the maximum cumulative bandwidth that all users combined can utilize at any given time. It is not per individual user on your website

3. **Save and Exit**:
   After editing, save the changes and exit the text editor.

4. **Restart the VM**:
   For the changes to take effect, you'll need to restart the VM:

   ```bash
   sudo xl shutdown <vm_name>
   sudo xl create /etc/xen/server.cfg
   ```

This configuration should effectively limit the bandwidth usage for your VM, preventing it from consuming all available bandwidth on your dedicated server.


----

### OPTIONAL: Modify the VPS to not overhog the dedicated server's CPU compute resources

This is optional. You can modify the VPS (really, you're modifying the VM) so it uses up to specific CPU criteria.


> [!note] Follow guidelines to decide on CPU allocation (CPU use percentage)
> ### **GUIDELINE: Maximum CPU Usage**:  
>    - **VPS**: Set the VPS to use up to **80-90%** of the CPU resources.
>    - **Host Overhead**: Reserve **10-20%** of CPU resources for the host.
>  Eg. `90`%. We set this after the image is done being created.
> When allocating vCPUs and CPU cap for a VM on a dedicated server, especially if you're only running one VM on that server, you can follow these general guidelines:
> 
> ### Number of vCPUs:
> - **Equal to Physical CPU Cores**: If you're dedicating the entire server to a single VM, you can allocate the same number of vCPUs as there are physical CPU cores. This maximizes the VM's processing power.
> - **vCPUs > Physical Cores (Overcommit)**: If you want to allow for potential higher processing capability, you can allocate more vCPUs than physical cores. However, this can lead to contention if the workload is CPU-intensive.
> 
> ### CPU Cap:
> - **100% Cap**: By setting the CPU cap to 100%, you're allowing the VM to use the full processing power of the allocated vCPUs when needed. This is generally recommended for a single VM on a dedicated server.
> - **Less than 100%**: You might lower the cap if you want to reserve some processing power for the host system or other background processes. For instance, setting the CPU cap to 90% would allow the VM to use up to 90% of the CPU resources, leaving 10% for the host.
> 
> ### Example Scenarios:
> 1. **Performance-Oriented Configuration**:
>    - **vCPUs**: Equal to the number of physical cores (e.g., 8 cores, 8 vCPUs).
>    - **CPU Cap**: 100% (full access to CPU resources).
> 
> 2. **Balanced Configuration (Reserving Host Resources)**:
>    - **vCPUs**: Slightly fewer than physical cores (e.g., 8 cores, 6-7 vCPUs).
>    - **CPU Cap**: 90-95% to leave some CPU headroom for the host.
> 
> If you're uncertain about the workload, starting with a 1:1 vCPU to physical core ratio and a 100% CPU cap is a safe choice, and you can adjust based on performance observations.




> [!note] Allocate CPU allocation (CPU use percentage) after image creation
> Set the CPU usage for a Xen virtual machine by specifying the `cpus` and `vcpus` parameters in the Xen configuration file. As of 2024, the `xen-create-image` command that created the image didn't directly provide an option to set CPU usage as a percentage. 
> 
> **Locate the VM configuration file:**
> 
> 1. After image creation, the VM's configuration file will be located in `/etc/xen/`. The file is usually named after the hostname, so in this case, it should be `/etc/xen/vps1.cfg`.
> 
> 2. **Edit the VM configuration file to limit CPU usage:**
> 
> Use your preferred text editor (vi as per your preference) to edit the configuration file:
> ```
> sudo vi /etc/xen/vps1.cfg
> ```
> 
> 3. **Add or modify the CPU parameters:**
> 
> - `vcpus`: Specifies the number of virtual CPUs the VM can use.
> - `cpu_cap`: Limits the maximum percentage of CPU the VM can use. This value is a percentage, where 100 represents 100% of a single physical CPU core. For example, cpu_cap = 50 would limit the VM to using a maximum of 50% of a single core.
> 
> Here is an example:
> ```
> vcpus = 4
> cpu_cap = 100
> ```
> 
> In this example, the VM can use up to 4 vCPUs, and each vCPU can use up to 200% of a physical CPU core (which means up to 2 full cores if available).
> 
> 4. **Save the configuration and start the VM:**
> 
> After editing and saving the configuration file, start the VM:
> 
> ```
> sudo xl create /etc/xen/vps1.cfg
> ```
> 
> 5. **Verify CPU settings:**
> 
> You can verify the CPU settings using xl commands:
> ```
> sudo xl vcpu-list
> sudo xl sched-credit
> ```
> 
> This will show the current CPU allocation and usage for your VMs.


---

## APPENDIX

### Networking Bridge mode to allow dedicated server and VPS:

#### **Conceptually this means I virtually bridged my VMs to the gateway/router so it's seenable by the internet?**

Yes, conceptually, creating a bridge on your host system (dedicated server) and connecting your VMs to that bridge means you are effectively linking your VMs to the same network as your host's physical interface. This setup allows the VMs to be directly accessible on the network, just like any other device connected to the router or gateway.

**Here’s how it works:**

1. **Bridge Interface (br0):**
   - The bridge interface (`br0`) acts like a virtual network switch that connects multiple network interfaces, including your physical network interface (`eno1`) and the virtual interfaces of your VMs.
   - By assigning your host’s IP address and gateway to the bridge, you’re ensuring that the bridge manages the network traffic for both the host and any VMs connected to it.

2. **VM Connection:**
   - When you configure your VM to use the bridge (`vif = ['bridge=br0']`), the VM’s virtual network interface is connected to this bridge.
   - This allows the VM to appear on the same network as your host, with its own IP address (either assigned by DHCP or statically set).
   - The VM can now send and receive network traffic through the bridge, just like the host.

3. **Public Accessibility:**
   - Because the VM is connected to the same network as your host, it can be assigned an IP address in the same range as the host.
   - This makes the VM accessible from outside the host, as if it were a separate machine on the network.
   - If the VM is assigned a public IP address, it will be reachable over the internet, allowing it to host services like a website that people can visit.

**Visualization:**

- **Before Bridging:** Your VM’s network is isolated from the external network unless explicitly routed. It may only be accessible via NAT or port forwarding from the host.

- **After Bridging:** Your VM is virtually "bridged" to the same network as the host's physical interface. It can directly communicate with the gateway/router and be accessed from the internet.

This setup is common in scenarios where you want your VMs to be treated as first-class citizens on the network, with their own IP addresses and full network visibility.

#### Does this mean my dedicated server is also bridged virtually on the same br0?

Yes, that’s correct! When you create a bridge interface (`br0`) on your dedicated server and assign the server’s IP address and gateway to that bridge, both your dedicated server and any VMs connected to the bridge are effectively sharing the same virtual network.

**Here’s how it works:**

1. **Shared Bridge Interface (`br0`):**
   - The bridge (`br0`) acts as a virtual switch that connects your dedicated server's physical network interface (`eno1`) and the virtual network interfaces of your VMs.
   - By assigning the IP address and gateway directly to the bridge (`br0`), you're moving the network management from the physical interface (`eno1`) to the bridge.

2. **Dedicated Server’s Role:**
   - The dedicated server is also connected to this bridge through its physical interface (`eno1`), which now participates in the bridge instead of having a separate network configuration.
   - This means that both the server and the VMs are on the same network, and traffic from the server and the VMs is routed through the bridge.

3. **Networking Implications:**
   - **Virtual Switch:** The bridge functions like a virtual switch inside your server. It forwards network packets between the server, the VMs, and the external network (through `eno1`).
   - **Same Network Visibility:** Both the dedicated server and the VMs appear as separate devices on the same network, each potentially with its own IP address.
   - **Public Accessibility:** If your server has a public IP, the VMs connected to `br0` can also have public IPs (if available), making them accessible from the internet.

**Conceptual Visualization:**

- **Without a Bridge:** The dedicated server is directly connected to the network via `eno1`, and any VMs would need separate routing, NAT, or port forwarding to communicate externally.

- **With a Bridge (`br0`):** The dedicated server's physical interface (`eno1`) and the VMs are all connected to the same virtual network through `br0`. The server and the VMs can communicate as if they were on the same physical switch, sharing the same network segment.

**Summary:**
- Your dedicated server and the VMs are "virtually bridged" through `br0`, meaning they are on the same network and can communicate with each other and with external networks via the same gateway/router.
- This setup allows for seamless network integration between the server and VMs, with each able to have its own IP and be independently accessible.


#### So even though the gateway (and hence the internet network) connects to the physical NIC (Network interface controller), the internet sees the virtual switch which bridges the host and the guest OS?

Yes, exactly! The bridge interface (`br0`) you created on your dedicated server essentially acts as a virtual switch. Here's how it works:

**How the Bridge (`br0`) Works:**

1. **Physical NIC (Network Interface Controller):**
   - Your dedicated server's physical NIC (`eno1`) is the actual hardware that connects to your network, including the gateway and the wider internet.
   - It physically connects your server to your network infrastructure (e.g., router, gateway) using the network cable or other physical connections.

2. **Virtual Bridge (`br0`):**
   - The bridge interface (`br0`) is a software construct that acts like a virtual network switch inside your server.
   - You connect the physical NIC (`eno1`) to this bridge, so now the bridge manages the network traffic instead of `eno1` directly.

3. **Host (Dedicated Server) and Guest OS (VMs):**
   - Both the host (dedicated server) and any VMs connected to the bridge are treated as if they are all plugged into the same physical switch.
   - They can communicate with each other directly through the bridge, just like devices connected to the same physical switch would.

4. **Gateway and Internet Connectivity:**
   - The bridge forwards network traffic between your host, VMs, and the external network through the physical NIC (`eno1`).
   - From the perspective of the external network (including the gateway and the internet), all devices connected to the bridge (host and VMs) appear to be on the same network.

5. **Public IP Addresses:**
   - If your server or VM has a public IP address, the bridge allows it to be directly accessible over the internet. The network sees each device connected to the bridge (host or VM) as having its own IP address and treats them as separate entities.

**Visualizing the Concept:**

- **Physical Layer:** The physical NIC (`eno1`) connects to the gateway/router, providing the physical link to the internet.
- **Virtual Layer (Bridge `br0`):** The bridge (`br0`) connects the physical NIC and the virtual network interfaces of the VMs, effectively placing them on the same network.
- **Network Perspective:** The external network (including the internet) sees the bridge and all connected devices (host and VMs) as if they are separate devices on the same network segment.

**Summary:**
- The internet and your local network interact with the virtual switch (bridge `br0`), which bridges your physical NIC and the virtual network interfaces of the VMs.
- This setup allows your host (dedicated server) and guest OS (VMs) to share the same network environment and be independently accessible from the internet, each with its own IP address.


#### Next clarification questions are based off this network interface settings file:

```
# This file describes the network interfaces available on your system
# and how to activate them. For more information, see interfaces(5).

source /etc/network/interfaces.d/*

# The loopback network interface
auto lo
iface lo inet loopback

# The primary network interface
allow-hotplug eno1
iface eno1 inet manual

# Bridge setup
auto br0
iface br0 inet static
        address 192.0.2.2/29
        gateway 192.0.2.1
        bridge_ports eno1
        bridge_stp off
        bridge_fd 0
        bridge_maxwait 0
        dns-nameservers 198.51.100.2 198.51.100.3 8.8.8.8
        dns-search example.rdns.provider.com

```


#### At `auto br0` and `iface br0 inet static`, coding wise - br0 is just another interface, but concept wise (when we draw on diagram or communicate about networking) - it's a virtual bridge

You're absolutely right. In code, `br0` is treated like any other network interface, but conceptually, it acts as a virtual bridge that connects the physical network interface (e.g., `eno1`) with the virtual network interfaces on your VPS.

This distinction is important when diagramming or discussing the network architecture, as the virtual bridge (br0) represents the link that allows communication between the physical network and virtual machines, creating a seamless network environment.

#### At `bridge_ports eno1`, is that saying that although the gateway/router is connected to the eno1 physical network interface's ethernet port, the gateway/router sees the virtual network interface that bridges the VM and the physical computer host?

Yes, that's correct.

When you configure `bridge_ports eno1`, you are essentially telling the bridge (`br0`) to include the physical network interface `eno1` as part of the bridge. This means that any traffic coming into or going out of the `eno1` interface is now part of the `br0` bridge network.

Here’s how it works conceptually:

- **Physical Setup:** The physical network interface `eno1` is connected to your network, likely to a switch or directly to a gateway/router.

- **Bridge Behavior:** The bridge `br0` acts as an intermediary between the physical interface (`eno1`) and the virtual interfaces connected to your virtual machines (VMs). 

- **Traffic Flow:** 
  - When the gateway/router sends traffic to your server, it arrives at `eno1`.
  - The bridge (`br0`) then allows this traffic to be passed to the virtual interfaces (e.g., `vif0.0`) that connect to the VMs.
  - Conversely, traffic originating from the VMs can pass through the bridge and out via `eno1` to the gateway/router.

- **Gateway/Router Perspective:** The gateway/router sees the bridge as if it were a single entity, even though it might be routing traffic to multiple virtual interfaces behind it. The bridge abstracts the complexity of having multiple interfaces on different VMs, presenting them as if they were part of a single, unified network segment.

So in summary, while `eno1` is the physical connection point, the bridge (`br0`) allows the gateway/router to interact seamlessly with the virtual interfaces of the VMs, as though they were all on the same physical network.