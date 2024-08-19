Here's how to adjust CPU and/or memory on a VM that's already running:
```
xl vcpu-set vps0 8
xl mem-set vps0 27648
```

^Note that memory is in megabytes. Eg. Converted 27 GB (gigabytes) to MB (megabytes): 1 GB = 1024 MB. So, 27 GB = 27 × 1024 MB = 27,648 MB.

---

CPU adjustment error:
```
libxl: error: libxl_domain.c:1869:libxl_set_vcpuonline: Domain 7:Requested 8 VCPUs, however maxcpus is 1!: Function not implemented

libxl_set_vcpuonline failed domid=7 max_vcpus=8, rc: -3
```

You'll need to first fix the maxvcpus setting in that VM's config file:
vi `/etc/xen/vps0.cfg`:
```
vcpus = 8
maxvcpus = 8
```

Then restart your VM in this way:
```
xl shutdown vps0
xl create /etc/xen/vps0.cfg
```
^ The xl create command with its existing configuration file will NOT wipe the data as long as the storage is persistent (e.g., LVM, file-based disk images).

Confirm the adjustments applied by running:
```
xl list
```
^ There are columns for Mem and VCPUs.

---

Appendix:

vi `/etc/xen/vps0.cfg`:
```
vcpus = 8  
maxvcpus = 8  
memory      = '27648'
```