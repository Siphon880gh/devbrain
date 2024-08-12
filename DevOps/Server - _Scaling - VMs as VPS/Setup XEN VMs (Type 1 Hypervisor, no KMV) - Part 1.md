If you chose Xen as your hypervisor, it is a type 1 hypervisor that does hardware virtualization without KVM hardware virtualization. In addition to Xen being booted, you have to check that other parts are working with Xen to allow virtualization. This tutorial will go over Xen installation, check if hardware virtualization is allowed from Xen's perspective, and check/enable hardware virtualization from BIOS. 

You can check if hardware virtualization is supported and enabled in the BIOS after booting into Xen (using `xl`). However if your computer does not have Xen installed, refer to XEN Installation section first.

## XEN Installation


To boot into a Xen kernel, you need to ensure you have both the Xen hypervisor and the appropriate kernel installed. Here’s a step-by-step guide to help you boot into a Xen kernel:

1. **Install Xen and the Xen kernel**: Ensure you have the Xen hypervisor and the Xen-enabled kernel installed on your system. You can install these packages using your distribution's package manager.
    
    For Debian/Ubuntu:
   ```bash
   sudo apt-get update
   sudo apt-get install xen-hypervisor-amd64 xen-tools

   ```

Note if errors that the package doesn't exist, it may be: `sudo apt-get install xen-hypervisor-4.16-amd64`

The `amd64` designation refers to the 64-bit architecture, which applies to both AMD and Intel processors.

   For CentOS/RHEL:
   ```bash
   sudo yum install xen
   sudo yum install kernel-xen
   ```

2. **Update GRUB configuration**:
   After installing Xen and the Xen kernel, you need to update your GRUB configuration to include the Xen hypervisor. This process might vary slightly depending on your Linux distribution.

   For Debian/Ubuntu:
   ```bash
   sudo update-grub
   ```

   For CentOS/RHEL:
   ```bash
   sudo grub2-mkconfig -o /boot/grub2/grub.cfg
   ```

3. **Edit GRUB configuration (if necessary)**:
   Sometimes, you may need to manually edit the GRUB configuration file to ensure the Xen hypervisor is set as the default boot option.

   Open the GRUB configuration file:
   ```bash
   sudo vi /etc/default/grub
   ```

   Set the default boot entry by modifying the `GRUB_DEFAULT` parameter.

You could've set it to the second entry in the GRUB menu setting it to`1` (GRUB menu entries are zero-indexed) like `GRUB_DEFAULT=1` IF you did not perform partitions and it's either your one device partition only or the Xen Hypervisor. But if you have multiple partitions or to be safer, look into the menuentries of grub (either by booting by holding SHIFT after the BIOS/UEFI screen, or if you don't have physical access to the server:
- Run to get all bootup menu items:
	```
	grep -E "menuentry " /boot/grub/grub.cfg
	```
- Look for the one that looks like Xen:
  Eg. `menuentry 'Xen 4.14.1 with Linux 5.4.0-42-generic' --class xen --class gnu-linux --class gnu --class os {
  Make sure it's not the (recovery mode one)
- Now you can edit the GRUB_DEFAULT. Could be:
```
GRUB_DEFAULT="Xen 4.14.1 with Linux 5.4.0-42-generic"
```

   Update GRUB again after making changes:
   ```bash
   sudo update-grub
   ```

4. **Reboot your system**:
   Reboot your system to boot into the Xen kernel:
   ```bash
   sudo reboot
   ```

5. **Verify Xen is running**:
   After rebooting, verify that the Xen hypervisor is running. You can check this by running:
   ```bash
   xl info
   ```

This command 0  should display information about the Xen hypervisor if it is running correctly. Refer to XEN Info Interpretation

---

## Verify XEN Hypervisor Running with Proper Virtualization Support by Interpreting Xen  Info

What Xen log will not do:
Xen does not specifically show KVM capabilities because KVM (Kernel-based Virtual Machine) is a different hypervisor technology that is part of the Linux kernel. Xen and KVM are separate virtualization technologies and do not typically interact directly with each other. To check if your hardware supports KVM type hardware virtualization, refer to [[Check if hardware supports KVM hardware virtualization]]. If your hardware does support KVM, it's better to forego XEN for KVM because it's faster By following these steps, you can verify whether hardware virtualization is supported and enabled on your system. If you encounter any issues or need further assistance, feel free to ask!


1. **Using `xl info`**: Since you're using Xen, you can check the virtualization capabilities using the `xl` tool.
	```
	xl info | grep caps
	```
    
    This command will display the capabilities of the hypervisor, and you should see the virtualization extensions listed if they are supported and enabled. 
    
    To see more insights:
	```
	xl info
	```
    
    From the output of the `xl info` command, to check if Xen hypervisor is running correctly on your system, the key lines to look at are:
    
    - `virt_caps`: This shows the virtualization capabilities supported by the Xen hypervisor on your system, including `pv` (paravirtualization), `hvm` (hardware-assisted virtualization), `hvm_directio`, `pv_directio`, etc.
    - `xen_version`: This indicates the version of the Xen hypervisor running, which is `4.16.0`.
    - `xen_caps`: This shows the capabilities of the Xen hypervisor, including support for various virtualization modes.
    
    The presence of the `hvm` capability in `virt_caps` and `xen_caps` indicates that hardware-assisted virtualization is supported and enabled.
    
    Other useful `xl info` details could include:  
    
    - nr_cpus: 8 (indicating 8 CPU cores available to Xen)
    - virt_caps: Includes `hvm` (hardware-assisted virtualization), `hvm_directio`, `pv`, etc.
    - xen_version: 4.16.0 (indicating the version of the Xen hypervisor)
      
2. **Check BIOS/UEFI Settings - If have access to BIOS** access

	If you own your dedicated server, you have BIOS access. If you are renting a colocation, you have to ask the support team to help with this (if they're willing). If they provide IPMI which is a remote service for you to access recovery console and BIOS even if you are renting the dedicated space, then you have BIOS access as well.

	Finally, it's important to ensure that hardware virtualization is enabled in your system's BIOS/UEFI settings.
	
	- **Reboot your system**.
		- **Enter the BIOS/UEFI setup** by pressing the appropriate key during the boot process (common keys are `F2`, `F10`, `Del`, or `Esc`).
		- **Navigate to the CPU Configuration or Advanced Settings** section.
		- Look for an option named **Intel VT-x**, **AMD-V**, **Virtualization Technology**, or similar.
		- Ensure this option is **enabled**.
		- Save the changes and exit the BIOS/UEFI setup.

### Steps to Further Verify Hardware Virtualization Support

To ensure that hardware virtualization is fully supported and utilized, you can check a few more things:

1. Check for Virtualization Extensions: Ensure that the virtualization extensions (Intel VT-x or AMD-V) are enabled in your BIOS/UEFI settings. This can usually be done by rebooting your system, entering the BIOS/UEFI setup, and ensuring that options like "Intel VT-x", "Intel Virtualization Technology", or "AMD-V" are enabled.
    
2. Check CPU Flags: Verify that the CPU flags `vmx` (for Intel) or `svm` (for AMD) are present.
    
	```
	grep -E 'vmx|svm' /proc/cpuinfo
	```
    
    If you see these flags, it means that hardware virtualization support is present.
    
3. Using `dmesg` Logs: Look at the kernel messages to ensure that hardware virtualization is being used.

	```
	`dmesg | grep -iE 'vmx|svm'
	```

4. Check Xen Logs: Check the Xen logs to see if there are any messages related to hardware virtualization.

	```
	`sudo cat /var/log/xen/xen-hotplug.log`
	```
    
5. Capabilities page

The file `/sys/hypervisor/properties/capabilities` can provide additional information about the capabilities of the hypervisor. You can check this file to verify the capabilities supported by your Xen hypervisor.

To view the contents of this file, you can use the `cat` command:

```bash
cat /sys/hypervisor/properties/capabilities
```

This file should contain information about the supported virtualization features. Here's an example of what you might see:

```plaintext
xen-3.0-x86_64 hvm-3.0-x86_32 hvm-3.0-x86_32p hvm-3.0-x86_64
```

In this example, the presence of `hvm-3.0-x86_64` indicates that hardware-assisted virtualization (HVM) is supported for 64-bit x86 architectures.

### Explanation of the Capabilities

- **xen-3.0-x86_64**: Indicates support for the Xen 3.0 hypervisor on 64-bit x86 architectures.
- **hvm-3.0-x86_32**: Indicates support for hardware-assisted virtualization for 32-bit x86 architectures.
- **hvm-3.0-x86_32p**: Indicates support for hardware-assisted virtualization for 32-bit PAE (Physical Address Extension) x86 architectures.
- **hvm-3.0-x86_64**: Indicates support for hardware-assisted virtualization for 64-bit x86 architectures.

The presence of these entries confirms that your system supports various virtualization modes, including hardware-assisted virtualization (HVM).

### Summary

By checking `/sys/hypervisor/properties/capabilities`, you can verify that your Xen hypervisor supports the necessary virtualization features. If the file contains entries like `hvm-3.0-x86_64`, it confirms that hardware-assisted virtualization is enabled and supported on your system.

If you have any further questions or need additional assistance, feel free to ask!


---

## Continuing, Decide on the next Xen tools

Xen hypervisor is now booted into. You will have to install other tools to leverage the Xen hypervisor in order to create and manage VMs. 

As of 2024, if you want a GUI to manage Xen VMs, these are no longer your options for Xen
- Proxmox dropped support for Xen

For Xen GUI management depending on your situation:
- Xen Orchestra (Xen-NG requires physical access to server hardware, or XenServer requires budget)
- Virt-Manager (Requires Desktop version of the Linux, or unless you're willing to setup tunneling from your own personal Desktop)

If GUI is not an option, then you will have to use only command lines to create and manage Xen VMs. You'll also have to use command lines to allow traffic through to the VMs to act as VPS. This means you need to have some background knowledge on networking, partitioning, computer computing and storage resources, and VMs. With GUI, that was abstracted away.
- As of 2024, toolstack's xe command discontinued in 2018. XenProject's xm command discontinued. 
- In 2024 OS releases, use XenProject's xl. Still active development [https://github.com/xen-project/xen/tags](https://github.com/xen-project/xen/tags)
	- xl comes with Xen