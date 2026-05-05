State of affair in 2024 when it comes to GUI's that manage VMS is, and it's bad if your hardware supports hardware virtualization but not KVM type hardware virtualization, and really bad if you have to rely on Xen hardware virtualization (Otherwise you rely on even slower OS type virtualizations)

Many Gui's have dropped Xen support in favor for the faster KVM even though not all server hardware support KVM. Proxmox well known for ease of use has dropped support for Xen. Cockpit does not support Xen (supports KVM)

Virt-manager requires desktop gui.

Ubuntu and Debian have moved away from /etc/network/interfaces, so many GUI tools that are outdated will have problems autoconfiguring network interface so internet becomes available to VM

Xen Orchestra requires another level - Xen-NG and XenServer - above having Xen. However Xen-NG is a full ISO that you have to run typically off a USB bootable thumbdrive. And XenServer is no longer free. XenServer was rebranded to Citrix Hypervisor, then rebranded back to XenServer. If you have access to the server physically or have a budget, then you're fine.

Webmin's module Cloudmin which uses Xen to create VMs have been outdated and do not work for many modern Linux distros. For example with Ubuntu 22, creating VMs will have networking problems. In Debian 12, you'll have Cloudmin installation problems.

---

Results: Because my server supports hardware virtualization but not KVM hardware virtualizations, because the dedicated servers are already virtualizations at the data center and they haven't enabled nested virtualization: I had to forego GUI for command lines (combination of xen-create-image and xl).