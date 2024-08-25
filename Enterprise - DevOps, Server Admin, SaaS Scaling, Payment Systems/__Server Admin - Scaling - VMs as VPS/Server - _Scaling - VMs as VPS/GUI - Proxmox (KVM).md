
To get started with Proxmox and create a VM (KVM), follow these steps:

1. **Install Proxmox VE**:
   - Download the Proxmox VE ISO from the official website.
   - Create a bootable USB drive or burn the ISO to a CD.
   - Boot your machine from the USB/CD and follow the installation instructions.

2. **Access the Proxmox Web Interface**:
   - After installation, access the Proxmox web interface by entering the IP address of your Proxmox server in a web browser.
   - Login with the root user and the password you set during installation.

3. **Create a New VM**:
   - Click on "Create VM" in the top-right corner of the web interface.
   - Follow the wizard to configure your VM:

4. **Assign Basic Settings**:
   - **Node**: Select the Proxmox node where you want to create the VM.
   - **VM ID**: A unique identifier for the VM.
   - **Name**: Give your VM a name.

5. **Assign OS Settings**:
   - **ISO Image**: Select the installation media for the operating system. You need to have uploaded the ISO image to the Proxmox storage.
   - **OS Type**: Select the operating system type and version.

6. **Assign System Settings**:
   - **BIOS**: Default is fine for most cases.
   - **Machine Type**: Default (q35) is fine for most cases.
   - **SCSI Controller**: Default (LSI 53C895A) is fine for most cases.

7. **Assign Disk Settings**:
   - **Bus/Device**: Default (VirtIO) is recommended.
   - **Storage**: Select the storage location.
   - **Disk Size**: Specify the disk size for your VM.

8. **Assign CPU Settings**:
   - **Sockets**: Number of CPU sockets.
   - **Cores**: Number of cores per socket.
   - **Type**: Default (kvm64) is fine for most cases.

9. **Assign Memory Settings**:
   - **Memory (MiB)**: Specify the amount of RAM.

10. **Assign Network Settings**:
    - **Bridge**: Select the network bridge.
    - **Model**: Default (VirtIO) is recommended.
    - **VLAN Tag**: Optional, for VLAN configuration.

11. **Confirm and Start the VM**:
    - Review your settings and click "Finish" to create the VM.
    - The VM will appear in the list of VMs. You can start it by selecting it and clicking "Start".

12. **Assign IP Address**:
    - If you need to assign a static IP address, you will need to configure this within the operating system of the VM after it has been installed.

13. **Bandwidth Settings**:
    - Bandwidth throttling can be configured using firewall rules or traffic shaping, which can be set up later.

These steps cover the basic process of setting up a VM in Proxmox. If you need more advanced configurations or additional features like high availability, clustering, or backups, Proxmox has extensive documentation and a helpful community for more detailed guidance.

---

## Background: Number of CPU Sockets

The number of CPU sockets refers to how many physical CPU sockets your virtual machine will appear to have. This is part of how you allocate the host's CPU resources to the VM. Here's a more detailed explanation:

- **CPU Sockets**: This represents the number of physical CPU sockets your VM will emulate. For most standard virtual machines, you can set this to 1.
- **Cores per Socket**: This represents the number of CPU cores per socket. For example, if you set 2 CPU sockets and 4 cores per socket, your VM will have a total of 8 cores.

In the Proxmox VM creation wizard, you will typically see a section where you can set the number of CPU sockets and cores per socket. Adjust these based on the performance needs of your VM and the available resources on your Proxmox host.

### Assigning a Static IP Address

To assign a static IP address to your VM, you typically do this within the operating system running on the VM after it has been installed. Here’s how you can do it for common operating systems:

#### For Linux (e.g., Ubuntu)

1. **Login to your VM**.
2. **Edit the network configuration file**. Depending on your distribution, this could be different files.

   For Ubuntu 20.04 and later using Netplan:
   ```bash
   sudo nano /etc/netplan/01-netcfg.yaml
   ```

   Add or modify the configuration to include the static IP settings:
   ```yaml
   network:
     version: 2
     ethernets:
       ens18:
         dhcp4: no
         addresses:
           - 192.168.1.100/24
         gateway4: 192.168.1.1
         nameservers:
           addresses:
             - 8.8.8.8
             - 8.8.4.4
   ```

3. **Apply the Netplan configuration**:
   ```bash
   sudo netplan apply
   ```

#### For Windows

1. **Login to your VM**.
2. **Open Network and Sharing Center**:
   - Go to Control Panel > Network and Internet > Network and Sharing Center.
3. **Change Adapter Settings**:
   - Click on "Change adapter settings" on the left side.
4. **Configure the Network Adapter**:
   - Right-click on your network adapter and select "Properties".
   - Select "Internet Protocol Version 4 (TCP/IPv4)" and click on "Properties".
   - Select "Use the following IP address" and enter your static IP address, subnet mask, and default gateway.
   - Enter your preferred DNS server addresses.
5. **Save and Close**.


### Summary so far

- **CPU Sockets**: This is the number of physical CPU sockets your VM will emulate. Set this based on your performance needs.
- **Static IP Address**: Configure this within the operating system of your VM after installation by editing the network configuration settings, depending on whether you are using Linux or Windows.

### Math to calculate sockets and cores per socket

When determining the configuration for CPU sockets and cores per socket for a virtual machine, you should consider the total number of CPU cores you want to allocate to the VM. Here’s the math and considerations involved:

### Calculating Sockets and Cores per Socket

1. **Determine Total CPU Cores Needed**:
   Decide how many total CPU cores you want to allocate to your VM. Let’s denote this as \( \text{Total\_Cores} \).

2. **Define Sockets and Cores per Socket**:
   You need to choose values for \( \text{Sockets} \) and \( \text{Cores\_per\_Socket} \) such that:
   \[
   \text{Total\_Cores} = \text{Sockets} \times \text{Cores\_per\_Socket}
   \]

### Example Calculations

#### Example 1:
You want to allocate a total of 8 CPU cores to your VM.

- **Option 1**:
  - Sockets: 1
  - Cores per Socket: 8
  - Calculation: \( 1 \times 8 = 8 \)

- **Option 2**:
  - Sockets: 2
  - Cores per Socket: 4
  - Calculation: \( 2 \times 4 = 8 \)

- **Option 3**:
  - Sockets: 4
  - Cores per Socket: 2
  - Calculation: \( 4 \times 2 = 8 \)

#### Example 2:
You want to allocate a total of 16 CPU cores to your VM.

- **Option 1**:
  - Sockets: 1
  - Cores per Socket: 16
  - Calculation: \( 1 \times 16 = 16 \)

- **Option 2**:
  - Sockets: 2
  - Cores per Socket: 8
  - Calculation: \( 2 \times 8 = 16 \)

- **Option 3**:
  - Sockets: 4
  - Cores per Socket: 4
  - Calculation: \( 4 \times 4 = 16 \)

### Considerations

1. **Hardware and Performance**:
   - The underlying physical hardware and the CPU topology might influence your decision. Some applications perform better with a particular CPU topology.
   - Hyper-threading should also be taken into account if your physical CPUs support it.

2. **Licensing**:
   - Some software licensing models are based on the number of CPU sockets. Be aware of the licensing implications of your chosen configuration.

3. **Operating System and Application Compatibility**:
   - Ensure that the operating system and applications you plan to run on the VM are compatible with the chosen CPU configuration.

### Conclusion

To configure the CPU settings for your VM:

1. Decide the total number of CPU cores you need.
2. Use the formula \( \text{Total\_Cores} = \text{Sockets} \times \text{Cores\_per\_Socket} \) to find suitable combinations.
3. Consider hardware, performance, licensing, and compatibility before finalizing the configuration.


----

## Background: Reasoning for CPU Sockets and Cores Configuration

**CPU Sockets** and **Cores per Socket** configuration can impact the performance and resource allocation of a virtual machine (VM) in several ways. Here are some key considerations:

1. **NUMA Nodes**:
   - Non-Uniform Memory Access (NUMA) is a memory architecture where the memory access time depends on the memory location relative to a processor. Virtual machines can benefit from being configured to match the underlying NUMA topology of the host.
   - If your physical host has multiple NUMA nodes, configuring VMs with multiple sockets can align with these nodes, potentially improving memory access speeds and overall performance.

2. **Licensing**:
   - Some software licenses are based on the number of CPU sockets rather than the number of cores. Configuring fewer sockets with more cores per socket can reduce licensing costs.

3. **Hypervisor Optimization**:
   - Certain hypervisors (like Proxmox) may have optimizations based on the CPU socket configuration. Understanding these optimizations can help in configuring VMs for better performance.

### CPU-bound vs. I/O-bound Workloads

**CPU-bound** workloads are those where the performance is primarily limited by the processing power of the CPU. **I/O-bound** workloads are those where the performance is primarily limited by input/output operations, such as disk access or network communication.

#### Optimizing for CPU-bound Workloads

1. **More Cores**:
   - Allocate more CPU cores to the VM to increase parallel processing capabilities.
   - Distribute the cores across multiple sockets if the underlying hardware and NUMA configuration benefit from it.

2. **Higher CPU Frequency**:
   - Ensure that the physical CPUs have a high clock speed, as CPU-bound tasks benefit from faster processing times per core.

3. **Hyper-threading**:
   - Enable hyper-threading if supported by the host CPUs, as it can provide additional virtual CPU cores to handle more threads concurrently.

#### Optimizing for I/O-bound Workloads

1. **Fast Storage**:
   - Use fast storage solutions like SSDs or NVMe drives to reduce latency and increase throughput for disk I/O operations.
   - Consider storage configurations such as RAID for redundancy and performance.

2. **Network Optimization**:
   - Use high-speed network interfaces and configure network settings to optimize data transfer rates.
   - For network-intensive applications, consider dedicated network interfaces or virtual network devices optimized for high throughput.

3. **I/O Scheduler**:
   - Tune the I/O scheduler settings within the VM to match the workload requirements. Different schedulers (e.g., `noop`, `deadline`, `cfq`) can have significant impacts on performance depending on the nature of the I/O operations.

4. **Disk Caching**:
   - Enable or adjust disk caching settings to improve read/write performance. Be cautious with write caching as it can impact data integrity in case of power failure.

### Practical Configuration Example

Suppose you have a physical host with the following specifications:
- 2 NUMA nodes
- Each NUMA node has 1 CPU socket with 8 cores

For a CPU-bound VM requiring 16 cores, you might configure:
- **Sockets**: 2
- **Cores per Socket**: 8

This configuration aligns with the underlying \*NUMA nodes (refer to section on Numa nodes), potentially improving performance by optimizing memory access patterns.

For an I/O-bound VM, ensure:
- The VM is allocated sufficient CPU cores to handle the processing overhead of I/O operations.
- The VM storage is backed by fast disks.
- Network settings are optimized for the specific I/O workload.

By understanding these factors and configurations, you can better tailor your Proxmox VM settings to match the specific needs of your workload, whether it is CPU-bound or I/O-bound.

---

## Background: Understanding NUMA Nodes

**NUMA (Non-Uniform Memory Access)** is a computer memory design used in multiprocessing where the memory access time depends on the memory location relative to the processor. A NUMA system has multiple memory controllers and processors, where each processor has its own local memory. Access to local memory is faster than access to remote memory.

### Finding Out the Number of NUMA Nodes

The method to find the number of NUMA nodes depends on your operating system. Here’s how you can do it on Linux and Windows.

#### On Linux

1. **Using `lscpu` Command**:
   - Open a terminal and run:
     ```bash
     lscpu | grep "NUMA node(s)"
     ```
   - This will display the number of NUMA nodes.

2. **Using `numactl` Command**:
   - If `numactl` is installed, you can get detailed NUMA information:
     ```bash
     numactl --hardware
     ```
   - This command provides a detailed breakdown of the NUMA nodes and their associated CPUs and memory.

3. **Reading from `/sys`**:
   - You can directly read the information from the sysfs filesystem:
     ```bash
     ls /sys/devices/system/node/
     ```
   - This will list directories like `node0`, `node1`, etc., representing each NUMA node.

#### On Windows

1. **Using `systeminfo` Command**:
   - Open Command Prompt and run:
     ```cmd
     systeminfo | find "NUMA"
     ```
   - This will display information about the NUMA nodes.

2. **Using PowerShell**:
   - Open PowerShell and run:
     ```powershell
     Get-WmiObject Win32_ComputerSystem | Select-Object -Property Name,NumberOfLogicalProcessors,NumberOfProcessors
     ```
   - This command provides information about the processors, which can help infer the NUMA nodes.

3. **Using Task Manager**:
   - Open Task Manager (Ctrl+Shift+Esc).
   - Go to the "Performance" tab.
   - Click on "CPU" and you might see the NUMA nodes listed, especially in systems with multiple CPUs.

#### On Proxmox

Proxmox itself does not directly provide NUMA node information, but you can use the underlying Linux methods to find this information. 

1. **Access Proxmox Host via SSH**:
   - Connect to your Proxmox host using SSH.
   - Run the Linux commands mentioned above (`lscpu`, `numactl`, etc.) to get the NUMA node information.

### Practical Example on Linux

If you run the `lscpu` command:
```bash
lscpu | grep "NUMA node(s)"
```
You might get an output like:
```
NUMA node(s):          2
```
This indicates there are 2 NUMA nodes on your system.

Using `numactl --hardware`:
```bash
numactl --hardware
```
Output might be:
```
available: 2 nodes (0-1)
node 0 cpus: 0 1 2 3 4 5 6 7
node 0 size: 16384 MB
node 0 free: 12345 MB
node 1 cpus: 8 9 10 11 12 13 14 15
node 1 size: 16384 MB
node 1 free: 12345 MB
```
This gives a detailed breakdown of the CPUs and memory associated with each NUMA node.

By understanding your NUMA configuration, you can optimize your VM settings in Proxmox to better align with the physical hardware, enhancing performance for CPU and memory-intensive applications.