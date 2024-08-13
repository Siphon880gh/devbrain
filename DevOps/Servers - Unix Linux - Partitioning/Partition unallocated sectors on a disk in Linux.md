
## Required knowledge:
Disk vs its partitions
What are sectors (start and end sector makes up a partition)
What’s mounting (associating a partition of the disk to a directory path and its descendants, eg. /)
What’s a mount point (directory path as an entry point and makes storage accessible!)

## Step 1: Determine if there is Unallocated Space

`fdisk -l`  to see all partitions. Could be:
```
Device     Boot     Start       End  Sectors  Size Id Type
/dev/sda1            2048  31250431 31248384 14.9G 82 Linux swap / Solaris
/dev/sda2  *     31250432 128907263 97656832 46.6G 83 Linux
/dev/sda3       128907264 226564095 97656832 46.6G 83 Linux
```

`lsblk`  to show the devices along with their partitions. Could be:
```
NAME   MAJ:MIN RM  SIZE RO TYPE MOUNTPOINTS
sda      8:0    0  223G  0 disk 
├─sda1   8:1    0 14.9G  0 part [SWAP]
├─sda2   8:2    0 46.6G  0 part /
└─sda3   8:3    0 46.6G  0 part /backup
sr0     11:0    1 1024M  0 rom 
```

You know that disc (sda) doesn’t total up to 14.9+ 46.9 +46.9 total file size, so you suspect there is unallocated space and you may need to allocated space into a new partition. Keep in mind depending on the system, it might only be able to do up to 4 partitions (Master Boot Record partitions can go up to 4 primary partitions. GPT or GUID Partition Table can go up to 128 partitions). Run sudo fdisk -l /dev/sda  to check the total disk space vs allocated among the partitions. You could see:
```
Disk /dev/sda: 223 GiB, 239444426752 bytes, 467664896 sectors
Disk model: PERC H330 Adp   
Units: sectors of 1 * 512 = 512 bytes
Sector size (logical/physical): 512 bytes / 512 bytes
I/O size (minimum/optimal): 512 bytes / 512 bytes
Disklabel type: dos
Disk identifier: 0x1dee65ee

Device     Boot     Start       End  Sectors  Size Id Type
/dev/sda1            2048  31250431 31248384 14.9G 82 Linux swap / Solaris
/dev/sda2  *     31250432 128907263 97656832 46.6G 83 Linux
/dev/sda3       128907264 226564095 97656832 46.6G 83 Linux
```


Notice first line tells you the total storage size of your disk. Look at the column sizes. Therefore there is 114.3 GB of hard disk space that’s not allocated to partitions and partitions can be mounted as user accessible folder paths - what waste! Let’s allocate!

## Step 2: Create a Partition in the Unallocated Space
Once you have determined the start and end sectors of the unallocated space, you can create a new partition using fdisk:
1. Open `fdisk` for your disk:
	```
	sudo fdisk /dev/sda
	```

You could see:
```
Welcome to fdisk (util-linux 2.38.1).
Changes will remain in memory only, until you decide to write them.
Be careful before using the write command.

This disk is currently in use - repartitioning is probably a bad idea.
It's recommended to umount all file systems, and swapoff all swap
partitions on this disk.
```

2. Create a New Partition:
	- Press n to create a new partition.
	- When prompted for the first sector, enter the starting sector you found (e.g., 226563072).*
	- When prompted for the last sector, enter the ending sector you found (e.g., 468862127) or accept the default if it matches.*

3. Write the Partition Table:
	- After creating the partition, press w to write the changes to the disk.

The tail end of the terminal session should look like:
```
Using default response e.
Selected partition 4
First sector (226564096-467664895, default 226564096): 226564096
Last sector, +/-sectors or +/-size{K,M,G,T,P} (226564096-467664895, default 467664895): 467664895

Created a new partition 4 of type 'Extended' and of size 115 GiB.

Command (m for help): w
The partition table has been altered.
Syncing disks.
```

CTRL+D to exit. Might ask you to type y / yes to confirm

Skip to the next section that’s not help a Help checkpoint

---

(\*) Help checkpoint: If can’t figure out the first and last sector. Here’s a case study

Ran `sudo fdisk -l /dev/sda`:
```
Disk /dev/sda: 223 GiB, 239444426752 bytes, 467664896 sectors
Disk model: PERC H330 Adp   
Units: sectors of 1 * 512 = 512 bytes
Sector size (logical/physical): 512 bytes / 512 bytes
I/O size (minimum/optimal): 512 bytes / 512 bytes
Disklabel type: dos
Disk identifier: 0x1dee65ee

Device     Boot     Start       End  Sectors  Size Id Type
/dev/sda1            2048  31250431 31248384 14.9G 82 Linux swap / Solaris
/dev/sda2  *     31250432 128907263 97656832 46.6G 83 Linux
/dev/sda3       128907264 226564095 97656832 46.6G 83 Linux
```


Based on the `fdisk -l` output you provided, here’s how to determine the start and end points of the unallocated space on your disk:

### Disk Information:
- **Total Disk Size**: 223 GiB
- **Total Sectors**: 467,664,896

### Partition Information:
- **Partition 1 (/dev/sda1)**:
  - **Start**: 2048
  - **End**: 31,250,431
  - **Size**: 14.9 GiB

- **Partition 2 (/dev/sda2)**:
  - **Start**: 31,250,432
  - **End**: 128,907,263
  - **Size**: 46.6 GiB

- **Partition 3 (/dev/sda3)**:
  - **Start**: 128,907,264
  - **End**: 226,564,095
  - **Size**: 46.6 GiB

### Calculating Unallocated Space:

1. **Starting Point of Unallocated Space**:
   - The unallocated space begins immediately after the last sector of `/dev/sda3`.
   - **Start Sector**: 226564096

2. **Ending Point of Unallocated Space**:
   - The unallocated space extends to the last sector of the disk.
   - **End Sector**: 467664895

### Summary:
- **Start Sector of Unallocated Space**: 226564096
- **End Sector of Unallocated Space**: 467664895

So far the terminal session should be:
```
Welcome to fdisk (util-linux 2.38.1).
Changes will remain in memory only, until you decide to write them.
Be careful before using the write command.

This disk is currently in use - repartitioning is probably a bad idea.
It's recommended to umount all file systems, and swapoff all swap
partitions on this disk.


Command (m for help): n
Partition type
   p   primary (3 primary, 0 extended, 1 free)
   e   extended (container for logical partitions)
Select (default e): 

Using default response e.
Selected partition 4
First sector (226564096-467664895, default 226564096): 226564096
Last sector, +/-sectors or +/-size{K,M,G,T,P} (226564096-467664895, default 467664895): 467664895

Created a new partition 4 of type 'Extended' and of size 115 GiB.
```

Resume from where you left off when you needed help figuring out the first and last sectors

---

Mind that you created an extended partition that is NOT mountable yet:
After creation, running `fdisk -l` gives me this:
```
Device     Boot     Start       End   Sectors  Size Id Type
/dev/sda1            2048  31250431  31248384 14.9G 82 Linux swap / Solaris
/dev/sda2  *     31250432 128907263  97656832 46.6G 83 Linux
/dev/sda3       128907264 226564095  97656832 46.6G 83 Linux
/dev/sda4       226564096 467664895 241100800  115G  5 Extended
```

But running `lsblk` gives me this:
```
NAME   MAJ:MIN RM  SIZE RO TYPE MOUNTPOINTS
sda      8:0    0  223G  0 disk 
├─sda1   8:1    0 14.9G  0 part [SWAP]
├─sda2   8:2    0 46.6G  0 part /
├─sda3   8:3    0 46.6G  0 part /backup
└─sda4   8:4    0    1K  0 part 
sr0     11:0    1 1024M  0 rom
```

`lsblk` is not showing that the new partition takes up 115G?

The issue you're seeing arises because the newly created partition `/dev/sda4` is an "Extended" partition. An extended partition itself is not directly usable for storage; it's a container that can hold multiple logical partitions.

An extended partition, like `/dev/sda4`, is a special type of partition designed to bypass the limit of four primary partitions on a disk using MBR (Master Boot Record). Unlike primary partitions, an extended partition doesn't hold data directly; instead, it acts as a container for logical partitions where the actual data storage occurs. This is why `lsblk` shows `/dev/sda4` as having a size of only 1K—it's not a mountable partition itself but is waiting for logical partitions to be created within it to utilize the available space.

^TLDR: The new partition (aka extended partition, mnemonic: extender partition) requires another step to make it a partition you can mount (aka logical partition), however it’s aware of the file size despite `lsblk` not showing it (because `fdisk -l` did show the filesize).

You might ask - could I have allocated a mountable partition directly instead of adding this extra step of an Extended partition? Yes but by adding an extended partition, you can now make more than four primary partitions on a MBR (Master Boot Record) disk. Using extended partitions can also assure broad compatibility with various operating systems and tools.

 **Next Steps**

1. **Create Logical Partitions**:
   - You need to create one or more logical partitions inside the extended partition `/dev/sda4`.

   Here’s how to do it:

   - Run `sudo fdisk /dev/sda`.
   - Select `n` to create a new partition.
   - Choose `l` for a logical partition if prompted (it might not even prompt you - it might go directly to saying "Adding logical partition 5”).
   - Set the start and end sectors for the new logical partition. The default values should cover the entire unallocated space within the extended partition because those default values were from prior steps when you created the extended partition.
   - **Write the changes with `w`.**

CTRL+D to exit. Might ask you to type y / yes to confirm

2. Verify the new logical partition:
Run `fdisk -l` and you may see duplicate partitions, but one is Extended and the other is Linux, which is correct. Just know how to read it in the future:
```
/dev/sda1            2048  31250431  31248384 14.9G 82 Linux swap / Solaris
/dev/sda2  *     31250432 128907263  97656832 46.6G 83 Linux
/dev/sda3       128907264 226564095  97656832 46.6G 83 Linux
/dev/sda4       226564096 467664895 241100800  115G  5 Extended
/dev/sda5       226566144 467664895 241098752  115G 83 Linux
```

Running `lsblk` wil show the extended partition broken down under the device as 1K, then the mountable logical partition with the true file size
```
NAME   MAJ:MIN RM  SIZE RO TYPE MOUNTPOINTS
sda      8:0    0  223G  0 disk 
├─sda1   8:1    0 14.9G  0 part [SWAP]
├─sda2   8:2    0 46.6G  0 part /
├─sda3   8:3    0 46.6G  0 part /backup
├─sda4   8:4    0    1K  0 part 
└─sda5   8:5    0  115G  0 part 
sr0     11:0    1 1024M  0 rom  
```


3. **Format the New Logical Partition**:
   - Once the logical partition is created, format it with a filesystem. You can see what filesystem types your normally used partitions are by running lsblk -f  which could show:
```
NAME   FSTYPE FSVER LABEL UUID                                 FSAVAIL FSUSE% MOUNTPOINTS
sda                                                                           
├─sda1 swap   1           13d60847-1c39-4c70-b62c-1a6cd24a5fdd                [SWAP]
├─sda2 ext4   1.0         3fd30eef-cd38-4162-835a-50f13347772b     41G     5% /
├─sda3 ext4   1.0         0119ed17-6c48-49dc-a7a3-b6311dd9cc88   43.2G     0% /backup
├─sda4                                                                        
└─sda5                                                                        
sr0  
```

Therefore we will convert the new logical partition into ext4 type file system

Replace sdaX with the new logical partition name (likely /dev/sda5)
```
sudo mkfs.ext4 /dev/sdaX
```

---

4. Decide: Mount Logical Partition or Leave Unmounted

I’d you’re using this partition to store files, then you want to mount to a path. 

If you are using the partition to mount a VM, DO NOT mount. This guide finishes here. Your xen-create-image will split the partition into smaller logical volumes (not logical partitions) for the VM at / and for the swap. The VM’s / is separate from the host’s /, and you console into and out of the VM.

FYI explanation why you doubt mount when you intend to use partition as Xen VM: When you use xen-create-image to create a VM with logical volumes (LVM), the tool automatically creates the necessary mount point for the root (/) in the VM (and creates a swap). If concerned about the path: The VM’s root (/) is contained within the logical volume and is solated from your host system’s root (/), and you enter and exit out of the VM via the console.

5. **If Mounting, Mount the Logical Partition**:
   - Create a mount point:
	
	- a. Create the folder at the desired directory path (-p flag creates the upstream folder if it doesn’t exist):
		```
		sudo mkdir -p /mnt/newpartition
		```
		or eg. `sudo mkdir -p /mnt/vps0`

	- b. Mount the new logical partition (Replace sdaX with the new logical partition name):
	  
	  Mounting? The instructions below are LOW CONFIDENCE. Weng has not attempted, only read about then wrote this
		
		```
		sudo mount /dev/sdaX /mnt/newpartition 
		```
		or eg. `sudo mount /dev/sda5 /mnt/vps0

	- c. Verify mount successful by running lsblk . Your output could be:
		```
		NAME   MAJ:MIN RM  SIZE RO TYPE MOUNTPOINTS
		sda      8:0    0  223G  0 disk 
		├─sda1   8:1    0 14.9G  0 part [SWAP]
		├─sda2   8:2    0 46.6G  0 part /
		├─sda3   8:3    0 46.6G  0 part /backup
		├─sda4   8:4    0    1K  0 part 
		└─sda5   8:5    0  115G  0 part /mnt/vps0
		sr0     11:0    1 1024M  0 rom  
		```
		^ Notice the mount point at sda5 is what was assigned from examples, thus successful.


6. If mounted, make mount permanent - LAST STEP!

By default, partitions mounted using the mount command are only mounted temporarily. If you reboot your system, the partition will no longer be mounted. To make the mount permanent (persistent across reboots), you add an entry to the /etc/fstab config file (stands for File System Table) which is a configuration file in Linux that contains information about disk drives and partitions and how they should be mounted at boot time

- a. Find the UUID of the Partition
	- It's recommended to use the UUID (Universally Unique Identifier) of the partition rather than the device name (`/dev/sdaX`), because device names can change. To find the UUID, run:
		```
		sudo blkid /dev/sda5
		```
	
	- This will give you output like:
	```
	/dev/sda5: UUID="a2511db9-49e9-4373-8ba9-2375cd5bceb0" BLOCK_SIZE="4096" TYPE="ext4" PARTUUID="1dee65ee-05"
	```

- b. Edit `/etc/fstab`. Run:
```
vi /etc/fstab
```

Notice that lines starting with #  are comments. Add a new line for your partition. It should look something like this:
```
UUID=a2511db9-49e9-4373-8ba9-2375cd5bceb0 /mnt/vps0 ext4 defaults 0 2
^0 2: These numbers control backup and filesystem checking. 0 2 means the filesystem will be checked last on boot (for non-root filesystems).
```
   
You may want to add a comment on a line above it that describe what this mounting is for.
eg.
```
# /dev/sda5 logical partition for VM mounting that acts as VPS 0
UUID=a2511db9-49e9-4373-8ba9-2375cd5bceb0 /mnt/vps0 ext4 defaults 0 2
```

- c. Reload
	Tell system to reload important setting files including fstab
	```
	systemctl daemon-reload
	```


- d. **Test the Entry**:
   - To test if the entry works, you can unmount the partition and remount it using the `mount -a` command, which reads `/etc/fstab` and mounts everything listed there:

Adjust:
```
sudo umount /mnt/newpartition
sudo mount -a
```
^ If says is busy, then make sure you aren’t cd into that path
^ If there are no errors, the partition should now be mounted, and it will automatically mount at `/mnt/newpartition` on every boot.

OR, perform `sudo reboot`  and wait ~5 minutes depending on your server’s usual reboot time

REGARDLESS which testing method you chose, run `lsblk`  to test partition still there

Keep in mind, having a partition listed in `/etc/fstab` that cannot be mounted successfully can cause SSH login to fail, especially if the partition is critical to the system's boot process or if the system hangs while trying to mount it.
