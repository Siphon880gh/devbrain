
### Nested Virtualization, if applicable

Ask your provider if the dedicated server is a physical server or itself a virtualization/hypervisor, because if it's a virtualization, and you want to create VMs, that's considered nested virtualizations. That capability must be present.

It should be enabled in the BIOS. If you dont have access to BIOS because it's a rented dedicated server, ask if they have IPMI service provided to you, which allows you remote into recovery console, BIOS, etc. Otherwise, you have to ask their support team to help check and/or setup nested virtualization.

In addition to the BIOS, Nested Virtualization would also need to be capable from your CPU. 

Refer to guide [[Check if nested virtualization is available]]


## Hardware or OS Virtualization

Hardware Virtualization is better because it's faster. You'll have to check if hardware virtualization is allowable by your CPU and if it's enabled in BIOS. If it is not, then you have to rely on OS virtualization and figure out if the performance hit is worth it.

You'd have to install and then boot into the software that leverages the hardware virtualization or OS virtualization. You also have to make it a permanent part of the booting process that hands over control to the kernel, etc.

Can it support hardware virtualization?
```
egrep '(vmx|svm)' /proc/cpuinfo
```


To check if your CPU is virtualization compatible, check for the vmx or svm tag in this command output:
```
egrep -c '(vmx|svm)' /proc/cpuinfo
```

^ Easier if you pipe into a.txt, then scan a.txt with `vi`

If **0** it means that your CPU doesn't support hardware virtualization.

If **1** or more it does - but you still need to make sure that virtualization is enabled in the BIOS.


Refer to BIOS guide [[Check BIOS if enabled - nested virtualization, hardware virtualization, paravirtualization, etc

## If Hardware Virtualization, can we do KVM

Kernel virtual machines (KVM) is much faster. There are many types of hardware virtualization, and depending on the type you can do (depends on your hardware), you install different software. These softwares are called type 1 hypervisors. The concepts are covered in [[Splitting Dedicated Server into VPS (via VMs) - Fundamental Concepts]]


Find out if KVM type hardware virtualization is supported from the guide [[Check if hardware supports KVM hardware virtualization]]

It should be enabled in the BIOS. If you dont have access to BIOS because it's a rented dedicated server, ask if they have IPMI service provided to you, which allows you remote into recovery console, BIOS, etc. Otherwise, you have to ask their support team to help check and/or setup nested virtualization.

Refer to BIOS guide [[Check BIOS if enabled - nested virtualization, hardware virtualization, kvm, paravirtualization, etc]]


---



