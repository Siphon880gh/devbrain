
If you want to split your dedicated server into VPS instances with their own public IPs and have the ability to restart these servers without relying on the support team of the rented colocation (which could take hours), you'll need to create virtual machines (VMs). To do this, you must decide on the type of hypervisor to use, and the company provisioning your dedicated server gives you a CIDR or a block of available public IPs in addition to the primary IP.

A hypervisor, also known as a virtual machine monitor (VMM), is software or firmware that creates and runs virtual machines. It allows multiple operating systems to share a single hardware host, with each operating system appearing to have the host's processor, memory, and other resources all to itself. This lets you manage VPS or rent out VPS. 

For virtualization, it's not enough that the software (called hypervisor) is booted in before the kernel, and that the CPU supports it, but also the BIOS have it enabled. The how-to guides will cover those steps.

There are two types of hypervisors:

1. **Type 1 Hypervisor** (bare-metal hypervisor): 
   - Can be thought of as "hardware virtualization"
   - Runs directly on the host's hardware to control the hardware and manage guest operating systems.
   - Much faster than Type 2 Hypervisor.
   - Requires your CPU to support hardware virtualization (Hardware-assisted Virtualization (HVM)). You can check for the HVM flag in your CPU.
   - The most performant type of hardware virtualization is KVM. You can find out if you're using KVM or other types of hardware virtualization by running commands when you're booted into the Type 1 Hypervisor.
   - Examples include Xen and VMware ESXi.

2. **Type 2 Hypervisor** (hosted hypervisor):
   - Can be thought of as "OS virtualization"
   - Relies on the host operating system to provide virtualization services.
   - Much slower than Type 1 Hypervisor.
   - Examples include VMware Workstation and Oracle VirtualBox.

To initiate the hypervisor on your dedicated server, you need to modify GRUB (GRand Unified Bootloader). GRUB is a bootloader package that comes with Linux and is designed to manage the boot process of various operating systems on a computer, allowing system administrators to choose which OS to boot into from the GRUB settings file. GRUB also loads the kernel and the initial RAM disk (initrd), which contains necessary drivers and initial setup scripts needed by the kernel to boot the operating system. For virtualization, GRUB loads the hypervisor (e.g., Xen) before loading the kernel of the guest operating system*.

\*A guest operating system (guest OS) is an operating system that runs on a virtual machine created and managed by a hypervisor. It is called "guest" because it is not directly installed on the physical hardware of the computer (which is where the "host" operating system resides), but rather on a virtual environment provided by the hypervisor. This allows multiple guest operating systems to run on the same physical hardware simultaneously, each within its own isolated virtual machine.


