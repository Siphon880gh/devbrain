Debian 12 left a lot of things unset that doesnt make sense to be lacking or oddly configured. The upside is that installation is quicker because it’s bare bones. Like wearing new shoes, think of Debian 12 requiring you to step into the shoes to break them in.

**Sudo will likely not be installed. But apt can’t even install sudo because it has no sources other than cd rom. In order to edit the apt source lists, you need vim which does come included, but that vim is not properly setup to work with backspaces and arrows. So finish installing Debian in this way, performing these error solutions in order pretending the errors will occur anyways:**

> [!note] Debian breaking in - vi text editor in command line, pressing up/down/left/right caused letters A, B, C, D
>When using Vim, pressing the arrow keys can sometimes cause characters like A, B, C, or D to appear instead of moving the cursor. This behavior usually occurs when Vim is operating in a mode that doesn't recognize the arrow keys properly, such as when Vim is running in compatibility mode or when the terminal is not configured correctly.
>
>Add the following to ~/.vimrc (if file does not exist, add file):
>set nocompatible


> [!note] Debian breaking in - vi text editor in command line, pressing backspace causes error beep and doesn’t work
>Add the following to ~/.vimrc  (if file does not exist, add file):
>set backspace=indent,eol,start


> [!note] Debian breaking in - apt error asking for DVD or cd-rom
>
>Error when try to install anything via apt :
>```
>Media change: please insert the disc labeled
> 'Debian GNU/Linux 12.6.0 _Bookworm_ - Official amd64 DVD Binary-1 with firmware 20240629-10:19'
>in the drive '/media/cdrom/' and press [Enter]
>
>Media change: please insert the disc labeled
> 'Debian GNU/Linux 12.6.0 _Bookworm_ - Official amd64 DVD Binary-1 with firmware 20240629-10:19'
>in the drive '/media/cdrom/' and press [Enter]
>```
>
>2. **Update Your APT Sources List**:
>    -  Edit the `/etc/apt/sources.list` file to comment out or remove the line that refers to the CD-ROM/DVD. You can do this by running:
>    ```
>    vi /etc/apt/sources.list
>    ```
>
>    - If you see only one line and it’s the deb cdrom , you can just press d twice to delete.
>    - If multiple lines, look for lines starting with `deb cdrom:` and comment them out by adding a `#` at the beginning of those lines.
>
>    - After editing the file, run:
>    ```
>    apt update
>    ```
>
>    - This will refresh the package list from the online repositories instead of the DVD.
>



> [!note] Debian breaking in - apt package is missing
>If every package says package not found, then check if there are online sources at:
>vi /etc/apt/sources.list
>
>If missing, choose a commonly used package source and add them in. Look for something like “Below is an example of a sources.list for Debian 12/Bookworm (stable) released 10th June 2023.”
>```
>https://wiki.debian.org/SourcesList
>
>deb http://deb.debian.org/debian bookworm main non-free-firmware
>deb-src http://deb.debian.org/debian bookworm main non-free-firmware
>
>deb http://deb.debian.org/debian-security/ bookworm-security main non-free-firmware
>deb-src http://deb.debian.org/debian-security/ bookworm-security main non-free-firmware
>
>deb http://deb.debian.org/debian bookworm-updates main non-free-firmware
>deb-src http://deb.debian.org/debian bookworm-updates main non-free-firmware
>```
>
>To apply, run sudo apt update  or apt update 



> [!note] Debian breaking in - apt package missing SUDO (sudo)
>Try `apt install sudo `
>
>Then add the current root user to sudo group:
>```
>sudo usermod -aG sudo root
>```
>
>To apply, restart shell (logout, log back into shell)
>
>If sudo package is missing, you may have to add in sources for apt because Debian is bare bones. In that case, refer to above's "Debian breaking in - apt package is missing"


> [!note] Debian breaking in - git with vi/vim (Later)
>For when you install git, git might use nano (You can test with `git rebase -i HEAD~3` on some git repo on the server). You can set vi/vim with: `git config --global core.editor "vi"`
