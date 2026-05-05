The names eth0, eno0, and ens0 refer to network interfaces on Linux systems. These naming conventions are determined by the Predictable Network Interface Names (introduced in systemd/udev), which replaced the traditional naming scheme (like eth0, eth1, etc.) with persistent and predictable names.

Here’s a quick breakdown:

1. eth0 (Old-style naming):
   Used in older systems (pre-systemd).
   Interfaces were named in sequence (eth0, eth1, etc.).
   Lack of predictability: If hardware changes occurred, the name assignments could shift.

2. eno0 (Predictable naming: onboard devices):
   eno stands for "Ethernet onboard."
   Used for onboard network interfaces.
   Numbers (like 0, 1, etc.) indicate the sequence of onboard interfaces.

3. ens0 (Predictable naming: hotplug devices):
   ens stands for "Ethernet slot."
   Used for interfaces on hotplug PCI-Express slots (e.g., server adapters in expansion slots).

Why Predictable Naming?
Predictable naming provides consistent interface names across reboots and hardware changes, avoiding interface renaming issues common in the traditional ethX format.