
**Why check**: Ask your provider if the dedicated server is a physical server or itself a virtualization/hypervisor, because if it's a virtualization, and you want to create VMs, that's considered nested virtualizations. That capability must be present.

---


To check if nested virtualization is enabled in your BIOS or UEFI, you will need to access your system's BIOS/UEFI settings during the boot process. The exact steps to do this can vary depending on your motherboard or system manufacturer, but the general process is as follows:

1. **Restart your computer.**
2. **Enter BIOS/UEFI setup:** During the initial boot sequence, press the key required to enter the BIOS/UEFI setup. Common keys include `F2`, `F10`, `Del`, or `Esc`. The exact key is usually displayed briefly on the screen during startup or can be found in your system's manual.
3. **Navigate to the CPU or Advanced settings:** Once in the BIOS/UEFI setup, look for a section related to CPU configuration or advanced settings. This section might be labeled as `Advanced`, `CPU Configuration`, `Processor Settings`, or something similar.
4. **Find nested virtualization settings:** Within the CPU or advanced settings, look for options related to virtualization. The setting might be labeled as `VT-x`, `Intel Virtualization Technology`, `AMD-V`, or `SVM`. If there is a setting for nested virtualization, it might be labeled as `Nested Virtualization`, `Nested Paging`, `VT-d`, or similar.
5. **Enable nested virtualization:** If you find a setting for nested virtualization and it is disabled, enable it. Save your changes and exit the BIOS/UEFI setup.

If you need instructions on accessing BIOS/UEFI through IPMI (remote service for you to access recovery console, BIOS, etc of your rented dedicated server), they are in  [[Check BIOS if enabled - nested virtualization, hardware virtualization, kvm, paravirtualization, etc]]

If you cannot find an option for nested virtualization in your BIOS/UEFI settings, it is possible that your CPU or motherboard does not support this feature, or it might be enabled by default with no option to change it.

Additionally, you can check if nested virtualization is enabled on your current system from within your operating system:

### For Intel CPUs:

1. **Check VT-x and VT-d support:**
   ```bash
   egrep -o 'vmx|svm' /proc/cpuinfo
   ```
   If you see `vmx` listed, VT-x is supported and enabled.

2. **Check nested virtualization support:**
   ```bash
   cat /sys/module/kvm_intel/parameters/nested
   ```
   If it returns `Y`, nested virtualization is enabled.

### For AMD CPUs:

1. **Check AMD-V support:**
   ```bash
   egrep -o 'vmx|svm' /proc/cpuinfo
   ```
   If you see `svm` listed, AMD-V is supported and enabled.

2. **Check nested virtualization support:**
   ```bash
   cat /sys/module/kvm_amd/parameters/nested
   ```
   If it returns `1`, nested virtualization is enabled.

By following these steps, you can determine whether nested virtualization is enabled both in your BIOS/UEFI and on your current system configuration.