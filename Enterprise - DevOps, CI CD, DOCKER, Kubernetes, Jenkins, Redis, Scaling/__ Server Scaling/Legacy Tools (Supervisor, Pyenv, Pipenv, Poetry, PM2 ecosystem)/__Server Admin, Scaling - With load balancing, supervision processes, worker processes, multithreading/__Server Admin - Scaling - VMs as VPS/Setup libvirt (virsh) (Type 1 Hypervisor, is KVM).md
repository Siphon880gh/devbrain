Libvirt is a toolkit and API designed to manage and interact with virtualization technologies. It primarily manages Type 1 (bare-metal) and Type 2 (hosted) hypervisors, with a focus on KVM (Kernel-based Virtual Machine), which is a Type 1 hypervisor when used on a Linux system.  To review type 1 and type 2, refer to guide [[Splitting Dedicated Server into VPS (via VMs) - Fundamental Concepts]]
### Libvirt:
- **Libvirt and Hardware Virtualization**: Libvirt is often used with KVM, which leverages hardware virtualization extensions (such as Intel VT-x and AMD-V) to run virtual machines directly on the host's hardware.
- **Command Line Tool**: The primary command-line interface for interacting with libvirt-managed virtualization environments is `virsh`.

### Basic `virsh` Commands:
Here are some commonly used `virsh` commands:

- **List all running VMs**:
  ```sh
  virsh list
  ```

- **List all VMs (running and not running)**:
  ```sh
  virsh list --all
  ```

- **Start a VM**:
  ```sh
  virsh start <vm-name>
  ```

- **Shutdown a VM**:
  ```sh
  virsh shutdown <vm-name>
  ```

- **Destroy (force stop) a VM**:
  ```sh
  virsh destroy <vm-name>
  ```

- **Define a new VM from an XML file**:
  ```sh
  virsh define <vm.xml>
  ```

- **Undefine (remove) a VM**:
  ```sh
  virsh undefine <vm-name>
  ```

- **Get detailed information about a VM**:
  ```sh
  virsh dominfo <vm-name>
  ```

Libvirt, in combination with KVM, provides a robust and efficient way to manage virtual machines, offering both hardware virtualization and management of virtualized environments.

You can use GUI's. Refer to [[GUIs to manage hypervisors and VMs]] for the appropriate selection.

---

Mandatory - Here is another complete guide on Libvirt:
https://www.tecmint.com/create-kvm-virtual-machine-template/