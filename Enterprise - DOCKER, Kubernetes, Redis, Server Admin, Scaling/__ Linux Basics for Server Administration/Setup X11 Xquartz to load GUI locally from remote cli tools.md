On Linux distros, there are cli tools that open a GUI but since you’re in a SSH shell, there’s no GUI on the server’s side, so the server instead connects to your GUI loading app (XQuartz) on your local compute. This loads a GUI on your local computer to interact with the remote app. 

This guide will make sure this will work. In order to follow the guide, understand that X11 forwarding is the technology to make it possible. Understand that those Linux cli commands that can perform this are called X11 apps. The remote server DOES NOT need to be a desktop distro - a server distro is just fine.

1. Locally make sure Xquarts is on your Mac (CMD+F)

2. Locally setup XQuarts settings (You may have to CMD+Tab into it) for the top menu strip → Settings
	- For input, enable all
	- For security, enable “Authenticate connections” and “Allow connections from network clients”

3. Locally, make sure ssh can X11 forward:

`sudo vi /etc/ssh/sshd_config` into:
```
X11Forwarding yes  
X11DisplayOffset 10  
X11UseLocalhost yes  
```

Then restart: `sudo launchctl stop com.openssh.sshd`  and `sudo launchctl start com.openssh.sshd`   

3. Remotely, make sure ssh can X11 forward:

`sudo vi /etc/ssh/sshd_config` into:
```
X11Forwarding yes  
X11DisplayOffset 10  
X11UseLocalhost yes  
```

Then restart, similar to: `sudo systemctl restart sshd` 

4. Remotely, make sure server is X11 capable

Install X11 Libraries on the Server (if not already installed. Or, you should attempt to reinstall anyways):

- For Debian/Ubuntu-based distributions:
```
sudo apt-get install xauth xorg  
```

- For RHEL/CentOS-based distributions:
```
sudo yum install xorg-x11-xauth xorg-x11-apps  
```

5. Back at the local computer:

- To make sure it works, open `xquartz`  before connecting on SSH
- At SSH connect with the -Y option:
```
ssh -Y user@remote-server 
``` 


If using sshpass (which allows you to login into SSH with password on the same command):
```
sshpass -p 'your_password' ssh -Y user@remote-server  
```


---

### To test if Xquartz work:

  

1. **On remote server, make sure you have the sample X11 applications** like `xclock` or `xeyes`:
```
sudo apt-get install x11-apps  
```

2. After installing, try running `xclock` or `xeyes` to verify that X11 forwarding is working. 
	- Let’s test by running `xeyes`   
    

3. Right click XQuarts from taskbar to see if it created a window named after your app:
![](ALep1rV.png)

4. Test that the actual GUI works. Try to open XQuarts xeyes. You should see this:

![](FmbWvag.png)
^ The GUI is eyes follow your mouse cursor

If it fails and your computer has a firewall, make sure it’s allowing XQuarts to receive incoming connections (because it’s loading GUI from your remote cli X11 apps)  

If it fails, try to make sure you dont have multiple monitors connected and see if that fixes the problem.

If it still fails, you may need to update Xquarts. If that fails, look up Xquarts website to download and reinstall it. 


If still fails, you can try -X instead of -Y:
```
ssh -Y user@remote-server  
```

or
```
sshpass -p 'your_password' ssh -Y user@remote-server  
```
^FYI -X is normal X11 forwarding. -Y is trusted X11 forwarding


Last resort:  Use an Alternative X Server:As a last resort, you might consider using a different X server for macOS, like X2Go or VcXsrv, which might be more compatible with your needs. This is outside the scope of this guide.

---

### User flow with Xquarts

To get into XQuarts you may have to CMD+tab to select Xquartz. If window doesnt show, it may be out of window’s visibility so try CMD+SHIFT+Left/Top arrow to bring it to the screen. If that fails, go to XQuartz menu at the top and turn on full screen; you’ll still have a shell called Xterm; recommend you have multiple monitors if doing this way.

To get out of Xquarts full screen, you can perform Mission Control F3 because your ALT+TAB might be taken over by the XQuarts