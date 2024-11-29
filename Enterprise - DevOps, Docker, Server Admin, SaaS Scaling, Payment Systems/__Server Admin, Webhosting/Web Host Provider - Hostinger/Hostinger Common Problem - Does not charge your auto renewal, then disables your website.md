Applies to: VPS

When you see this:
![](https://i.imgur.com/L03HFur.png)

And it's passed that even though you have auto renewal turned on, SOMETIMES Hostinger forgets to charge from your auto renewal as of 11/2024. 

---

This causes your VPS / website to brick at multiple points.
- FTP denying access to your /home user folder. Here's Filezilla logs:
  ![](https://i.imgur.com/haJrsCT.png)
- 404 when visiting many of your webpages
- When you log into the SSH terminal as root, then you switch to site user, it can't access its own folder:
	1. Cd into the site's folder as root. You should have no problem accessing with `ls` command
	2. In the same folder, switch to that site's user:
```
su wengindustries
```
That errors: `ls: cannot access '/home/wengindustries/.bashrc': Permission denied`

---

**SOLUTION**

Simply pay the bill and you'll see that the VPS limitations are removed (the message popped up and went away too quickly for me to screenshot, so I mocked it at the top right):
![](https://i.imgur.com/8pNpvll.png)


This doesn't solve your problems entirely yet.

You have to REBOOT the server.
On Debian 12, you run `reboot`