
```
nproc

lscpu

grep MemTotal /proc/meminfo
```


1. **nproc**: 
   - This command prints the number of processing units available to the current process, which is essentially the number of CPU cores.

2. **lscpu**: 
   - This command displays detailed information about the CPU architecture, including the number of CPUs, threads, cores, sockets, and other hardware characteristics.

3. **grep MemTotal /proc/meminfo**: 
   - This command extracts the total amount of physical memory available on the system. It reads the file `/proc/meminfo`, which contains information about the system's memory usage, and filters the line that starts with "MemTotal", which shows the total memory in kilobytes.


---

**Reworded**



Number of processors:
```
nproc --all
```

Processors more details:
```
lscpu
```


OS Distro:
```
lsb_release -a
```


Memory in KB:
```
grep MemTotal /proc/meminfo
```


Total storage space:
```
sudo fdisk -l
```


Or:
```
lsblk
```

