
You might commonly access or modify in:
* **`/var`** stores variable data, meaning files that change frequently, such as ever-growing log files.
* **`/etc`** stores configuration files, especially system and service configs that should remain separate from the core operating system files.
	* Eg. `/etc/nginx` which is where nginx web server software is at. It's not exactly included in Linux distros, and is usually something you install afterwards, so it's not part of the core Linux.

The core operating system files are generally spread across directories like:
- **`/bin`** – essential user command binaries
- **`/sbin`** – essential system/admin binaries
- **`/lib`** and **`/lib64`** – essential shared libraries needed by binaries in `/bin` and `/sbin`
- **`/usr/bin`**, **`/usr/sbin`**, **`/usr/lib`** – most of the rest of the operating system programs and libraries
- **`/boot`** – files needed to boot the system, such as the kernel and bootloader files

You might see:
* **`/dev`** and **`/proc`** are virtual directories that expose device interfaces and process/kernel information, not regular files on disk.