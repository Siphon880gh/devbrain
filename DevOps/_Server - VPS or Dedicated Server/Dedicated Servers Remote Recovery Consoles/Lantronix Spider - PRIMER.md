### Lantronix Spider
The Lantronix Spider is a compact, remote KVM (Keyboard, Video, Mouse) over IP device. It allows administrators to control a server as if they were physically present, even during BIOS-level operations. The Spider connects to the server's video output, USB ports, and/or PS/2 ports, enabling remote access to the server's console. Unlike IPMI, which may require a separate dedicated port, the Lantronix Spider is a stand-alone device that can be used with any server, offering flexibility in remote management. Refer to [[Latronix Spider - PRIMER]]

---

## Suggested Script

You can ask your Support Team for access to a KVM over IP (aka IP KVM) when you're locked out of the SSH but you don't want to perform a reinstall (you can mention you didn't have backup the most recent data or because it's barebones like Debian 12 that you didn't want to have to do the leg work of reinstalling sudo, fixing vim, etc). I'm unsure if their tech SOP requires you give an extenuating reason for remote access to a recovery console.

They will give you the ip address, username, and password.

Let them know you're done so they can reclaim the KVM as soon as possible for security reasons: "Hi Support - You can reclaim the KVM and close the ticket. I finished with KVM over IP and regained SSH access. Thanks"


---


## Instructions

Just visit directly the url on the page. If no port number, then dont add port number (http://XXX...) If port number, then you add it (http://XXX....:##)

FY: No point ssh into it even though you can. there wont be vi, nano, sudo, cat, etc

![](https://i.imgur.com/utq2ajo.png)


![](https://i.imgur.com/cL3vlux.png)


-- Click KVM Console --

In this example, the console is in not a normal situation - you couldn't SSH into the server because the server couldn't boot. The partition has problems mounting. So it went into emergency mode that can still accept commands. A more normal terminal would've a prompt with minimal or no errors. Regardless, both situations will ask for your root password

![](https://i.imgur.com/xePUA0o.png)


 It asks for your root password (note copy and paste might say incorrect password because it could insert other characters instead). Type in manually. If it’s still incorrect password, use caps lock instead of holding shift to enter uppercase characters. Enter password and you're in:
 
 ![](https://i.imgur.com/ZTz8zKX.png)


Perform your command tasks in Emergency Mode terminal or boot into a separate OS, whichever is applicable.

If booting, you can run `reboot`, press the reboot button on the left sidebar, or click CTRL+ALT+DEL:
![](https://i.imgur.com/vFCvDPA.png)


Briefly you might see the terminal close reviewing it's a desktop behind the terminal:
![](https://i.imgur.com/Fv3CWbV.png)

Btw you can optimize the screen:
- Make sure Chrome is 100% zoom only
- Make your browser full screen mode (optional)
- Click Full Screen on the left sidebar:
![](https://i.imgur.com/4gzgpvL.png)

If closing the terminal does not automatically restart, click Shutdown/Reboot on the left sidebar:
![](https://i.imgur.com/1Lx9oEm.png)

If booting into another OS, hold SHIFT while it's booting:
![](https://i.imgur.com/rhf4alr.png)

  

At the menu choose the desired OS
![](https://i.imgur.com/f2s7uY0.png)


When it boots into the terminal over the desktop and it's loading, and lets say you still have the partition problem. You didn't see how long it took because when you logged into KVM over IP, it was already booted for you by the support team:
![](https://i.imgur.com/EcnIGRw.png)

For that problem, it will seem to hang. It'll eventually time out then let you enter root password in Emergency Mode (rather than a normal terminal because it's a partition problem that prevents a proper OS to load) (if you didn't have such critical booting problems, it would have went to just asking for root password in a more normal mode instead of erroring into Emergency Mode)

![](https://i.imgur.com/xePUA0o.png)

Fix whatever config file that locked you out of ssh. You will likely edit config files with either vi or nano. Make sure to optimize the view so that the command text editor does not get cut off (Chrome full screen, 100% zoom only, clicked full screen button on the left sidebar)

In our case, let's say our SSH into the remote server failed because of both GRUB booting into a broken OS AND a bad partition. For that case, here is the fix:

In this example, it was editing grub to be on the wrong bootup device (I have to make sure to edit this NOT in the Xen version but the original OS)

Example:

- Run to get all bootup menu items:
```
 grep -E "menuentry " /boot/grub/grub.cfg  
```


- Look for the one that looks like Xen:

  Eg. `menuentry 'Xen 4.14.1 with Linux 5.4.0-42-generic' --class xen --class gnu-linux --class gnu --class os {` 

  Make sure to not focus on the recovery mode one, if it exists, eg. NOT `Xen 4.14.1 with Linux 5.4.0-42-generic (Recovery Mode)` 

- Now you can edit the GRUB_DEFAULT by editing with `sudo vi /etc/default/grub` . Could be:

```
GRUB_DEFAULT="Xen 4.14.1 with Linux 5.4.0-42-generic"  
```

Check if escape works (Escape → “:wq”) in the vi editor. If not, you can send escape like this, which then allows you to type ":wq":
![](https://i.imgur.com/4KQiyuV.png)



Update GRUB again after making changes:
   ```bash
   sudo update-grub
   ```


(FYI Concept: If you edit the `GRUB_DEFAULT` value in `/etc/default/grub` but forget to run `sudo update-grub`, your changes will not be applied. The `update-grub` command is necessary to regenerate the GRUB configuration file, typically located at `/boot/grub/grub.cfg`, which is what GRUB actually reads during boot.)

Remove the bugged unmountable partition line(s) from `/etc/fstab` config file (stands for File System Table) which is a configuration file in Linux that contains information about disk drives and partitions and how they should be mounted at boot time.

Then perform these steps for safety reasons:

1. **Attempt to unmount the Partition** In case it's still mounted even if it's bugged

	```
	sudo umount /path/to/mount/point
	```
	
	Replace `/path/to/mount/point` with the actual mount point of the partition.
    
2. **Test the `/etc/fstab` File:** Before rebooting, it's a good practice to test if the `/etc/fstab` file has any errors:
	```
	sudo mount -a
	```
	    
	This command attempts to mount all filesystems listed in `/etc/fstab`, except the ones with the `noauto` option. **If there are any issues with the file, they will be reported here.**
	
	This error case study done. Proceed to next section.


---

Once done editing whatever config file needed. Reboot the system with `sudo reboot` . 

If the system is completely done rebooting on the KVM over IP without going into Recovery Mode on the terminal over Desktop, it's a successful fix. Then test if you can successfully SSH on your local computer's terminal.

For cleanup, remove the IVKVP IP address from ~/.ssh/known_hosts