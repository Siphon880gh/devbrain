If you look into Grub (which is Linux' boot loader):


Generating grub configuration file ...
Found linux image: /boot/vmlinuz-6.1.0-22-amd64
Found initrd image: /boot/initrd.img-6.1.0-22-amd64
Found linux image: /boot/vmlinuz-6.1.0-22-amd64
Found initrd image: /boot/initrd.img-6.1.0-22-amd64
Found linux image: /boot/vmlinuz-6.1.0-22-amd64
Found initrd image: /boot/initrd.img-6.1.0-22-amd64
Warning: os-prober will not be executed to detect other bootable partitions.
Systems on them will not be added to the GRUB boot configuration.
Check GRUB_DISABLE_OS_PROBER documentation entry.


vmlinuz and initrd
- vmlinuz, as a compressed kernel image, reduces the initial load time and memory usage, 
- initrd provides a temporary root filesystem to facilitate the kernel in loading necessary modules to access the actual root filesystem.