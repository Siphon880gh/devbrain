## Why

Some of your logic might not work as intended because can't traverse folder if your script does that or can't execute scripts if you have a web app that does it on the server's behalf. And some webpages simply won't load at all with a 403 error.

![[Pasted image 20260514235856.png]]

## When can happen

Wrong ownership and permissions can happen when you upload files via FTP/SFTP. Wrong ownership can especially if you used the root account to get in instead of the site user. No website will have permission to display if its underlying html or php file is owned by root and only root can view it.

## Applies to:

Wordpress, PHP websites, html websites, any website, actually

---

## Instructions

After uploading files to a new server or from local machine to server, make sure they have proper ownerships and permissions
- Ownership: If Cloudflare, the site username and site group are the same.

1. Make sure of ownership recursively:
```
sudo chown -R USER:GROUP DIR
```

2. For permissions, you run:
```
sudo find DIR -type d -exec chmod 755 {} \;
sudo find DIR -type f -exec chmod 644 {} \;
```

## Explanation (Can Skip)

These commands are standard because they give the web server enough permission to **read and enter website folders**, but they do **not** make files unnecessarily writable or executable.

```bash
sudo find DIR -type d -exec chmod 755 {} \;
sudo find DIR -type f -exec chmod 644 {} \;
```

### Directory permission: `755`

```bash
chmod 755 folder
```

Means:

```txt
owner: read + write + execute
group: read + execute
others: read + execute
```

Written out:

```txt
rwxr-xr-x
```

For directories, **execute** means “can enter/traverse the folder.”

So `755` allows:

```txt
Owner can:
- read folder contents
- enter folder
- create/edit/delete inside folder

Group and others can:
- read folder contents
- enter folder
- but not write/change files inside it
```

This is important for websites because the web server needs to enter folders like:

```txt
/public
/assets
/images
/css
/js
```

Without execute permission on directories, the web server may get:

```txt
403 Forbidden
Permission denied
```

Even if the files themselves are readable.

### File permission: `644`

```bash
chmod 644 file
```

Means:

```txt
owner: read + write
group: read
others: read
```

Written out:

```txt
rw-r--r--
```

So `644` allows:

```txt
Owner can:
- read the file
- edit the file

Group and others can:
- read the file
- but not edit it
- and not execute it
```

This is standard for website files like:

```txt
index.html
style.css
script.js
image.png
config examples
```

The web server usually only needs to **read** these files so it can serve them to visitors.

### Why files are not `755`

You usually do **not** want normal website files to be executable.

Bad example:

```bash
chmod 755 index.php
chmod 755 style.css
chmod 755 script.js
```

That gives execute permission to files that do not need it.

For most web files, execution is handled by the web server or PHP-FPM process, not by Linux directly running the file as a program.

So this is safer:

```txt
folders: 755
files:   644
```

### What the commands do

### Directories

```bash
sudo find DIR -type d -exec chmod 755 {} \;
```

Find every directory under `DIR` and set it to `755`.

### Files

```bash
sudo find DIR -type f -exec chmod 644 {} \;
```

Find every normal file under `DIR` and set it to `644`.

Example:

```bash
sudo find /home/site/htdocs/example.com -type d -exec chmod 755 {} \;
sudo find /home/site/htdocs/example.com -type f -exec chmod 644 {} \;
```

### Important note

These commands fix **permissions**, but not **ownership**.

If the wrong user owns the files, you may still have problems. For example, on many server setups you also need something like:

```bash
sudo chown -R websiteuser:websiteuser DIR
```

Common safe default:

```txt
directories: 755
files:       644
owner:       the website/Linux user that manages the site
```

For upload/cache folders, some apps may need writable permissions, but you should only make those specific folders writable instead of making the whole website `777`.
