Sure! Here’s a **beginner-friendly primer on shell scripting in Linux**, with key tips, gotchas (“captchas”), and the most commonly used commands you’ll likely use in scripting and automation.

---

# 🐧 Shell Scripting Primer for Linux

## 🧠 What Is a Shell Script?

A **shell script** is a text file containing a series of commands that the Linux shell can execute. It's used to **automate repetitive tasks**, set up environments, or glue together utilities.

### 🔹 Basic Structure

```bash
#!/bin/bash  # Shebang - tells system to use bash
echo "Hello, world!"
```

Save as `myscript.sh`, make it executable:

```bash
chmod +x myscript.sh
./myscript.sh
```

---

## ⚠️ Captchas (Common Gotchas by OS / Environment)

|Category|Gotcha|Notes|
|---|---|---|
|**Shebang**|`#!/bin/bash` vs `#!/bin/sh`|Use `bash` for scripting unless targeting POSIX-only systems. `sh` may behave differently across distros.|
|**Package Managers**|Use correct one for your OS|`apt` (Debian/Ubuntu), `dnf`/`yum` (Fedora/CentOS/RHEL), `zypper` (openSUSE), `apk` (Alpine), `pacman` (Arch).|
|**Permissions**|Scripts must be executable|Use `chmod +x script.sh`.|
|**Line Endings**|Don't write scripts in Windows editors|Use `LF` line endings. Windows `CRLF` can break shell scripts.|
|**Environment**|Scripts may run with limited `$PATH`|Use full paths or set up environment inside script.|
|**Root Access**|Some commands need `sudo`|Add checks or `sudo` where necessary.|
|**Interactive Commands**|Don't use commands needing user input|Use flags like `-y`, or check for interactive prompts and disable them.|

---

## 🛠️ Most Common Commands in Shell Scripting

Here are essential commands that are building blocks in automation:

### 📁 File & Directory

|Command|Usage|Example|
|---|---|---|
|`ls`|List files|`ls -lh`|
|`cd`|Change directory|`cd /var/log`|
|`mkdir`|Make directory|`mkdir newdir`|
|`rm`|Remove files/dirs|`rm -rf /tmp/oldstuff`|
|`cp`|Copy|`cp file1.txt backup/`|
|`mv`|Move/rename|`mv a.txt b.txt`|

### 🔍 Search & Filter

|Command|Usage|Example|
|---|---|---|
|`grep`|Pattern matching|`grep "ERROR" logfile.txt`|
|`find`|Locate files|`find /etc -name "*.conf"`|
|`awk`|Text processing|`awk '{print $1}' file.txt`|
|`sed`|Stream edit|`sed 's/foo/bar/g' file.txt`|
|`cut`|Extract fields|`cut -d':' -f1 /etc/passwd`|

### 🛑 Permissions & Ownership

|Command|Usage|Example|
|---|---|---|
|`chmod`|Change permissions|`chmod +x script.sh`|
|`chown`|Change ownership|`chown user:group file`|

### ⚙️ System & Process

|Command|Usage|Example|
|---|---|---|
|`ps`|List processes|`ps aux|
|`kill`|Kill process|`kill -9 1234`|
|`top` / `htop`|Monitor|`top`|
|`df` / `du`|Disk usage|`df -h` or `du -sh *`|

### 📦 Package Management (OS-specific)

|OS|Command|Example|
|---|---|---|
|Debian/Ubuntu|`apt`|`sudo apt update && sudo apt install curl`|
|RHEL/Fedora|`dnf` / `yum`|`sudo dnf install git`|
|Arch|`pacman`|`sudo pacman -S vim`|
|Alpine|`apk`|`apk add bash`|
|openSUSE|`zypper`|`zypper install htop`|

### 🔁 Flow Control

|Command|Usage|
|---|---|
|`if`, `elif`, `else`|Conditional logic|
|`for`, `while`, `until`|Loops|
|`case`|Switch-style conditions|
|`&&`, `||
|`set -e`|Exit on error|
|`exit 1`|Return exit code|

Example:

```bash
#!/bin/bash
if [ -f /etc/passwd ]; then
  echo "File exists"
else
  echo "File not found"
fi
```

---

## 🧪 Debugging & Best Practices

|Practice|Why|
|---|---|
|`set -e`|Exit on error (fail fast)|
|`set -x`|Print commands as they run (debugging)|
|Use quotes (`"$var"`)|Avoid word-splitting bugs|
|Use `[[ ]]` for conditions|Safer than `[ ]` in Bash|
|Comment your code|Future you will thank you|

---

## ✅ Example: Script to Backup a Directory

```bash
#!/bin/bash
set -e

SRC="/home/user/data"
DEST="/backup/data_$(date +%F)"
mkdir -p "$DEST"
cp -r "$SRC"/* "$DEST"

echo "Backup complete: $DEST"
```

---

## 📚 Recommended Next Steps

- Learn `man <command>` to explore manual pages.
- Practice small scripts (file rename, auto-updates, etc).
- Explore tools like `cron` (for scheduling) and `systemd` services (for startup tasks).
- Learn about input/output redirection: `>`, `>>`, `2>&1`, and pipes `|`.