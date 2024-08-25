
Can lock you out of SSH
- enabling ufw but not allowing port 22 before disconnecting. Remedy: Allow port 22 or reformat
- modifying grub_default to boot into another os or device and you boot into the wrong one. Remedy: Modify /etc/default/grub
- modifying `/etc/network/interfaces`  to configure the network, especially adding virtual bridges for VM, however modified incorrectly. Remedy: Modify /etc/network/interfaces
- modifying fstab to have permanent mountings but the mounting is glitched. Remedy: Modify fstab

  

Can make your system dirty and prone to bugs so you have to reformat:
- Corrupted Cloudpanel installation, especially installing on top of nginx (there should be no web server because Cloudpanel recommends installing on an empty system)
- Installing Webmin’s Cloudmin which has been very outdated. It will really make your system dirty if you try to create VMs on Cloudmin.

You’ll need to boot into recovery with a CD rom / thumb drive if you have physical access to the server. If your server is rented, you can ask support for IMPI or KVM over IP (Lantronix Spider KVM) or ask them to reprovision/reformat