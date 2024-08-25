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

## Create the image

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

#### Decide computer resource allocations

> [!note] Figure out computer resource allocations during image creation
> 
> To allocate resources for a single VPS on your dedicated server while leaving enough overhead for managing the host, you can follow these general guidelines. Keep in mind that depending on your tool, your allocations could be in different units. For example, xl uses Gigabytes in their allocation options. There is a difference between GiB and GB.
> 
> These calculations are based off you wanting to split a dedicated server into one VPS. If you're aiming for multiple VMs or VPS, you have to split them evenly or vertically scale up by adding more hardware (RAM, hard drives, etc)
> 
> 1. **Memory Allocation**:  
>    - **VPS**: Allocate **85-90%** of the total memory to the VPS.
>    - **Host Overhead**: Leave **10-15%** for the host to handle SSH, Webmin/Cloudpanel/etc, and other essential services.
> Chosen 90% for Gb
> `27`
> 
> 2. **Swap File Size**:  
>    - Old Allocation Strategy
> 	   - **VPS**: Allocate a swap file size equivalent to **100%** of the VPS's memory allocation, but this can vary depending on your use case (e.g., 2GB RAM = 2GB swap).
> 	   - **Host**: Allocate swap based on what remains after the VPS allocation, typically another **100%** of the host’s memory overhead.
>    - Newer Allocation Strategy:
> 	   - Find out how much space does the host machine use for swap memory by running `swapon -s`. For example, `15624188` is approx 15GB
>    - Chosen newer allocation strategy, VM's swap size strategy in GB should be:
> `15`
> 
> 
> 3. **Disk Space Allocation**:  
>    - **VPS**: Choose **90-95%** of the disk space to the VPS for both the VM and its swap file. Subtract the swap size from the previous allocation. For the remaining 90-95% disk space after subtracting swap size, subtract an additional 1GB. 
> 	   - Explanation: LVM requires a small amount of overhead for its metadata, which might prevent it from allocating 100% of the VG space. In some environments, reserving a small amount of space can prevent issues related to disk full errors, which could affect system stability.
> 	   - If you want to use max disk space: For 50gb, you can subtract 0.5gb (for that VM's overhead). For 100gb, you subtract 1gb. For 150gb, you subtract 1.5gb. For 200gb, you subtract 2gb.
> 	   - **Host Overhead**: We are leaving **5-10%** for the host, including for space for logs, backups, and other essential files. It's assumed you won't be using the dedicated server for public websites or apps.
> Ran `df -h` to determine that the main hard drive:
> E.g. Main harddrive has `128` GB available. Will assume won't be adding anymore significant file sizes of packages or files to the dedicated server besides to the VPS.  90% of that is `115` GB rounded down. Subtracted from swap size `15` GB is `100`GB. However at 100gb, I should subtract 1gb otherwise Xen will complain with a vague error (because it predicted there won't be room for LVM metadata).
> So harddrive allocation: `99`GB
> 
> You might be left with much less space for the dedicated server than for the VM, and that's ok.
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
- Response back to you: Your numbers for all the partitions might not be exact, so the support team might leave some unallocated sectors for you to allocate the final partition. Otherwise there might be some GB's remaining if they perform all the partitions exactly as told. Or they might allocate more GBs to the biggest partition. This depends on the technician. If they left you unallocated sectors for you to partition, instructions on how to partition the rest of the unallocated sectors are at:
  [[Partition unallocated sectors on a disk in Linux]]

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

If you have problems or want to review, you can view all physical volumes with `sudo pvdisplay` and all volume groups with `sudo vgdisplay`, OR `sudo pvs` and `sudo vgs` which are different display formats
### Create the image while allocating resources

Create VM without network options (dhcp option required, lets say yes to dhcp we wanting automatic IP for now)
```
sudo xen-create-image --force --verbose --hostname=vps0 --dhcp --lvm=vg0 --size=99G --memory=24G --swap=15G --debootstrap --dist=bookworm --arch=amd64 --mirror=http://deb.debian.org/debian/ --debootstrap-cmd='/usr/sbin/debootstrap'
```

- `--force`: Proceed with creating the image even if there are warnings or non-critical errors.
- `--hostname=vps1`: Sets the hostname of the new VM to `vps1`.
- `--lvm=vg0`: Specifies that the root filesystem for the VM should be created as a logical volume within the volume group `vg0`.
- `--size=99G`: Indicates that the root logical volume will have a size of 99 GB.
- `--memory=24G`: Allocates 24 GB of RAM to the VM.
- `--swap=15G`: Allocates 15 GB of swap space to the VM.
- `--debootstrap`: standalone command-line tool if outside the context of `xen-create-image`. It's used primarily for creating a minimal Debian or Ubuntu system within a specified directory or partition (aka VM).
- `--dist=jammy`: Specifies that the distribution to be installed is Ubuntu 22.04 (Jammy Jellyfish).
- `--arch=amd64`: Specifies the architecture of the VM as 64-bit (AMD64).
- `--dhcp`: Configures the VM to use DHCP for network configuration.
- Keep in mind the size and swap should roughly equal and be less than the total file size of that partition for max use of storage space
	- If you have 115 GB group volume, you may feel tempted to split the logical volumes into 100 GB VM and 15 GB swap in the xen-create-image command, however reality is there is some space you cannot use. So it's more like 99GB and 15GB

If fails to install, refer to Appendix X - Xen Create Image Errors

Copy your Installation Summary to your webhost details document under a VPS VM section. Copy especially the password that's in the Installation summary because that's the root password you need to console into the VM as a quick test (before making it accessible to the internet for SSH root login)

Your installation summary looks like:
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

## Start a VM from the Image
#### Before starting the VM, adjust console settings

You will be consoling into the VM after starting it. However at the moment, a setting needs to be fixed to prevent the console from hanging. For the setting to apply, it's applied when you start the VM. So let's edit the setting now.

Edit your config file in /etc/xen/vps0.cfg and add the line:
```
extra = 'console=hvc0 xencons=tty'
```

Eg.
```
kernel      = '/boot/vmlinuz-2.6.32-5-xen-amd64'  
ramdisk     = '/boot/initrd.img-2.6.32-5-xen-amd64'  
extra       = 'console=hvc0 xencons=tty'
vcpus       = '1'  
memory      = '2048'
```


This must be done before starting VMs with `sudo xl create...`, so if you had previous VMs running from `sudo xl list` and you want to apply this setting fix to them as well, you have to `xl destroy vps0` and `xl create /etc/xen/vps0.cfg`. Next section if starting the VM.

Thanks to for the fix: https://www.chrisnewland.com/solved-xen-domu-console-hangs-302

After this fix, it might still hang but lets you press Enter to exit out of the hang (versus if you didn't have the setting applied, it would hang for a much worse problem - not having the VM terminal to flow to the current terminal). If it hangs, it's because root user is automatically accepted but the shell doesn't know it's time to start receiving user inputs. You have to press Enter (if that fails, press CTRL+C; if that fails, press CTRL+], depending on your OS), then you you can start typing into the console. Then if you want assurance that you've been authenticated automatically, you can confirm you're still in the VPS by looking at the prompt being similar to `root@vps0:~#`, or running `ls -la`, or running `pwd`.

#### Before starting the VM, create the virtual bridge
Some networking knowledge (FYI's) you need to know: Refer to [[_Networking - Concept Primer of creating VPS]]

To add the bridge, follow the guide at [[_Networking - Create virtual bridge to make guest VM accessible by host machine at dedicated server]]

#### Start the VM

Required vocabulary: In Xen Project's `xl`, creating a VM is the same thing as starting a VM.

Start the VM by running the `xl create` which creates an entry in `xl list`. It's Xen's vocabulary that domains mean VMs. We run off a config file that's named based off the hostname option from xen-create-image:
```
sudo xl create /etc/xen/vps0.cfg
```

Coincidentally by starting the VM, we are also testing that the virtual bridge works. Because if it doesn't work, then the host machine can't create the VM and connect to all available VMs in `xl list` -  Xen will cancel starting the VM because it'll know it won't go into `xl list`. Furthermore, you cannot even console into the VM because the network bridge must be done for the SSH shell to even connect to other computers (VM) on the same network. 

**IF** it complains about bridging like this below then you need to check if you did anything wrong setting up the virtual bridge. After all that's done, you re-attempt the `xl create` command:
```
root@debian:~# sudo xl create /etc/xen/vps0.cfg Parsing config from /etc/xen/vps0.cfg libxl: error: libxl_exec.c:117:libxl_report_child_exitstatus: /etc/xen/scripts/vif-bridge online [24802] exited with error status 1 libxl: error: libxl_device.c:1319:device_hotplug_child_death_cb: script: Could not find bridge device xenbr0 libxl: error: libxl_create.c:1921:domcreate_attach_devices: Domain 1:unable to add vif devices libxl: error: libxl_exec.c:117:libxl_report_child_exitstatus: /etc/xen/scripts/vif-bridge offline [24849] exited with error status 1 libxl: error: libxl_device.c:1319:device_hotplug_child_death_cb: script: Could not find bridge device xenbr0 libxl: error: libxl_domain.c:1183:libxl__destroy_domid: Domain 1:Non-existant domain libxl: error: libxl_domain.c:1137:domain_destroy_callback: Domain 1:Unable to destroy guest libxl: error: libxl_domain.c:1064:domain_destroy_cb: Domain 1:Destruction of domain failed
```

**IF** you have to wait for a slight while with `Parsing config from /etc/xen/vps0.cfg` and no other messages appear, likely it's a success. To be sure, list all VMs to see if the new VM is listed:
```
xl list
```
	
If you see any domains besides Domain-0 then those are your VM(s). FYI Xen concepts: The Dom0 is the privileged domain aka Dom0 running on the hypervisor. All other VMs you create are unprivileged domains aka guest VMs aka DomU

Might look like:
```
Name                                        ID   Mem VCPUs	State	Time(s)
Domain-0                                     0  7593     8     r-----     129.7
vps0                                         1 24576     1     -b----       2.9
```

If you only see Domain-0, then it failed!

Lets console into the successfully created VM. We should be able to console into the VM's console because of the virtual bridge.

#### Console into the VM

We quickly test if we can see the VM from the host SSH shell and whether we can interact with it
	
Run	
```
xl console <vm-name>
```
eg. `xl console vps0`

It will ask for your username. Use root.
Then it will ask for your password which was in the installation summary

For your future reference: You can leave the VM shell back into the host shell by pressing `CTRL + ]`

#### Check the computer allocation resources went thru

Xen Xl is tricky and they change their syntax enough times that you need to double check your allocations went through.

- Disk space.
	- Run `lsblk` on host machine to check the storage spaces allocated to the VM and to its swap.
- Memory:
	- Run `xl list` which has a "Mem" column.
- CPU count:
	- Run `xl list` which has a VCPUs" column.

If memory and CPU allocations need to be changed on an already running VM, refer to [[Xen - Adjust Xen VM allocations after already started]]

#### Is Linux Administration Ready?
- Some distros are a bare bones OS version. This means some commands you expect to help with Linux administration like sudo might be missing! Package installer might be missing sources to search packages from. 
- This is especially true for Debian 12, etc. although it's performant because it's bare minimum. In that case, refer to the folder to finish setting up the OS so you can admin the server properly: [[Debian breaking into new shoes]]
- Why make Linux Administration Ready now? Your dedicated server can see and connect (by the way of consoling) into your VM, but in order for your VM to be seen by the internet as having websites, you must make your operating system be able to run sudo and being able to edit with vi editor. Some distros lack that and requires a bit of breaking in (more setups). Your VM can successfully connect to the internet for downloading files because of the virtual bridge which allows your VM to connect to the router/gateway that accesses the internet, and a lot of the tools to continue setting up is through you package installer (eg. apt-get, etc).

---

## Convert the VM into a VPS that can show webpages on the internet

#### Can skip reading: Why you want a VPS
- Let's assume you have a dedicated server that can host a website on the internet if you wanted to.
	(Background what's a dedicated server: Your computer is not shared with other businesses, therefore your computer is your dedicated server.)
- But instead you want to carve out a VPS in this dedicated server so if the public facing website breaks, because the website is on the VPS, you can manage the VPS from your dedicated server's console (think restore from a backup). You dont want to wait for support of your rented colocation to reinstall or restart the dedicated server (which could downtime your website for half a day)
- You have to create a VM which requires you to create an image from a desired OS installation file. Why a virtual computer? A computer can act as a web server when its ports are opened to listen for internet requests with the ability to deliver back webpages or other files. It can open other ports to perform other data transmissions like SSH or act as a gaming server. 
- Originally your physical network (all the devices and computer connected) consists of your computer connected to a network interface's ethernet port (one of many ports) which connects to gateway aka router, which then connects to the rest of the internet network. The gateway/router assigns IP addresses to devices on the network and routes traffic between the local network and the internet. Yes the gateway/router has a "DHCP server" or service inside.
- Now you will add VPS to your physical network. This is another computer whether it's a physical computer or a virtual one (aka VM, aka guest OS). Your VM has to go through your computer / dedicated server to receive or send information to the internet. The internet is blind to your VM. So what you do is create a "virtual bridge" and this is because you're not using a physical device for bridging the computers. Your virtual bridge will connect your guest OS / VMs to the internet too, hence when you assign a static public IP or the gateway/router's DHCP service assigns a public IP from a pool of public IPs, it can be connected to by other users on the internet. Btw, the host and available public IPs were assigned by the ISP and then your provider/webhost gave it to you during onboarding.

#### Make your VM discoverable on the internet, becoming a VPS

Although your VM can connect to the internet when you install packages (`apt install ..`), for example. It can because it's connected to the router. However to make the VM discoverable so it can be requested for webpages (in other words, internet users can visit a webpage on your VM), several setups will be done in this section:
- Assign a static IP address to your VM 
	- Explanation: You need a static IP which is a public IP address that never changes. Dynamic IP addresses changes based on a first come first server basis (if you have multiple VMs and some start crashing, now the IP addresses could get changed)
	- You will assign your purchased domain name to a specific IP address.
- Install a web server so that ports 80 (http) and 443 (https) are open to listening to internet requests using a daemon / background process. Those internet requests are delivered to the VM through the gateway/router. Then your VM delivers a webpage or other files back to the internet. This is synonymous with receiving and sending packets. 

Follow the instructions sat [[_Networking - Assign VM a public IP and listen to ports 22, 80, 443 for SSH and websites]]


---

### OPTIONAL: Modify the VPS to not hog the dedicated server's bandwidth

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

### OPTIONAL: Modify the VPS to not hog the dedicated server's CPU compute resources

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

## Appendix X (Xen-Create-Image Errors)


### Log files

Named after your hostname option passed to xen-create-image:
```
cat /var/log/xen-tools/vps0.log
```
### Common go-to fixes

**Consistent OS the best**
Firstly, try to avoid creating different OS than your host OS. Even keep the version the same if possible. If you can't then you need advanced configuring at `/etc/xen-tools/xen-tools.conf`

**Try a smaller size than you allocated for the VM, by 1 GB**
```
--size=99G
```
If you have 115 GB group volume, you may feel tempted to split the logical volumes into 100 GB VM and 15 GB swap in the xen-create-image command, however reality is there is some space you cannot use. So it's more like 99GB and 15GB


**Try reinstall debootstrap:**
```
sudo apt-get update
sudo apt-get upgrade
sudo apt-get install --reinstall debootstrap
```


**Check `/etc/xen-tools/xen-tools.conf` making sure the install method is debootstrap and that the cli tool path exists (more on this later):**
```
install-method = debootstrap
debootstrap-cmd = /usr/sbin/debootstrap
```


**Check `/etc/xen-tools/xen-tools.conf` making sure the mirror url works and that the dist is spelled correctly (eg. bookworm represents Debian 12):**
```
dist = bookworm
mirror = http://deb.debian.org/debian/
```

**Try having xen-create-image automatically detect debootstrap-cmd**

You do this by commenting it out in `/etc/xen-tools/xen-tools.con`

**Check cli tool debootstrap**

Run `which debootstrap` to see if the first most entry is the same as the debootstrap-cmd path. If not, you may need to add the folder to your PATH and may have to persist it in ~/.bash_profile or equivalent.

Check if execution permissions are in. For instance, this is good:
	-rwxr-xr-x 1 root root 25122 Aug 30 2023 /usr/sbin/debootstrap


**Check for Disk Space and Permissions:**

Ensure that there is sufficient disk space available and that the `/tmp` directory has the correct permissions:

```
df -h /tmp
ls -ld /tmp
```

If `/tmp` is running out of space or has incorrect permissions, that could cause issues. Ensure that `/tmp` has plenty of free space and the permissions are set to `drwxrwxrwt`.

**Make sure future xen-create-image has VERBOSE mode on**
You add the flag `--verbose`.

**Determine if it's xen-create-image or debootstrap probelm**

- Verify if `debootstrap` works directly from the command line using the correct syntax.
- You can test it with:
```
`sudo debootstrap --arch=amd64 bookworm /tmp/debootstrap-test http://deb.debian.org/debian/
```
    
- If this command fails, it will help diagnose any underlying issues with `debootstrap` itself. Otherwise it is an error within xen-create-image, either the command you run or its config file is misconfigured.
- Cleanup: Run `rm -rf /tmp/debootstrap-test`. The test command does not mount to partitions.
### Error right after executing just flags

See this error output seems to be missing a cli command. It's only flags and options that was executed:
```
Executing : --dist=bookworm --verbose --arch amd64 bookworm /tmp/9Ow8dqc0vw http://deb.debian.org/debian/ Starting command '--dist=bookworm --verbose --arch amd64 bookworm /tmp/9Ow8dqc0vw http://deb.debian.org/debian/ 2>&1' failed: No such file or directory Starting command '--dist=bookworm --verbose --arch amd64 bookworm /tmp/9Ow8dqc0vw http://deb.debian.org/debian/ 2>&1' failed: No such file or directory Aborting
```

So likely later down the road there are more folders and files that don't exist. This is because the command should be `debootstrap --dist=bookworm --verbose...`, NOT `--dist=bookworm --verbose...`. You could follow the common go-to fixes in the previous section (Edit `/etc/xen-tools/xen-tools.conf` and make sure the path to the cmd is correct, and making sure `which` sees where the cli executable is per PATH). Or, better yet, override the path toe debootstrap in the command xen-create-image with the command option roughly similar to: `debootstrap-cmd = /usr/sbin/debootstrap`

### Purge out old bugged images

If you created image with `xen-create-image`, and it's a bugged image (there were significant errors during xen-create-image, and/or the files are not completely generated).

1. Unmount then remove where the failed image is at. Adjust this:
```
sudo umount /tmp/9Ow8dqc0vw
sudo rm -rf /tmp/debootstrap-test
```

2. Check what the logical volumes are (the host and/or swap that xen-create-image created). Depending on the extend of the errors disrupting the xen-create-image process, there is either one or two logical volumes

- Get a quick glance with `lsblk`
- Then get their logical volume paths with `sudo lvdisplay`
- Then remove the logical volume(s). Your commands will vary:
```
sudo lvremove vg0/...-host
sudo lvremove vg0/...-swap
```

Note that xen-create-image with the --force option does not do the above steps when you create an image onto the same volume group.

