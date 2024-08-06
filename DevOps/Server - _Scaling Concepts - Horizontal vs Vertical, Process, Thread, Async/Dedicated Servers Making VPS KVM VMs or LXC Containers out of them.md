
For an app that has parts that use CPU more and parts that use I/O more: If you'd run with the VM approach here, you could easily dedicate different resources to both parts, keeping the front end snappy, and the backend may just take longer under heavy load. Then if you need to scale up again, you could always get another server at that time and move the one image over. Personally I'd virtualize both environments, as it'd let you control performance, and give you snapshots that you could easily restore yourself rather than needing to ask your friend to reprovision your entire dedicated server.

---


Proxmox can make both kvm based VMs and shared kernel LXC containers. The VMs are like the VPSs that you know already, but since you have a dedicated server, you can keep track of your server load and make sure that you don't over-commit your servers resources. Your setup essentially becomes like a dedicated VPS offering. LXC containers are nice, and makes sense if you're building an entire app and you're separating parts of the app into VMs. KVM based allows you to create entire VPS with devoted IPs and devoted OS (different Linux distributions even)

When deciding between KVM-based VMs and shared-kernel LXC containers, it's important to understand the key differences, use cases, and advantages of each technology. Here's a comparison to help guide your decision:

### KVM-based VMs
**KVM (Kernel-based Virtual Machine)** is a full virtualization solution for Linux on x86 hardware containing virtualization extensions (Intel VT or AMD-V).

#### Advantages:
1. **Isolation:** Each VM has its own isolated OS instance, making it highly secure and isolated from other VMs.
2. **Compatibility:** VMs can run any OS that is compatible with the underlying hardware, including different Linux distributions, Windows, and BSD variants.
3. **Resource Allocation:** VMs have dedicated resources (CPU, memory, disk space), providing predictable performance.
4. **Stability:** Because VMs are fully isolated, a crash in one VM does not affect others.
5. **Live Migration:** VMs can be moved from one host to another without downtime, which is useful for maintenance and load balancing.

#### Use Cases:
- Running different operating systems.
- High-security environments requiring strong isolation.
- Legacy applications that require a specific OS version or configuration.
- Environments where stability and resource predictability are critical.

### LXC Containers
**LXC (Linux Containers)** is an OS-level virtualization method for running multiple isolated Linux systems (containers) on a single Linux host.

#### Advantages:
1. **Performance:** Containers share the host kernel, leading to minimal overhead and better performance compared to VMs.
	1. Compared to KVM: LXC Containers is like all the VMs are using the same shared kernel which makes them more performant. You do lose some performance in a VM in KVM, but it's not that much. 5-10%
2. **Resource Efficiency:** Containers are lightweight, using fewer resources than VMs, which allows for higher density of applications on a single host.
3. **Speed:** Containers can be started and stopped quickly, facilitating rapid development and deployment.
4. **Portability:** Containers can be easily moved across different environments, ensuring consistency from development to production.
5. **Scalability:** Ideal for microservices and applications requiring rapid scaling.

**Huge disadvantage**
1. LXC containers have their own trade-offs. You don't really get root access. Some system calls don't quite work. CPU and RAM reporting inside the container don't work right. IT require more tinkering and tuning
	1. You get root in the container, but because it's actually mapped to uid=10000 in the hypervisor, it doesn't mess up the hypervisor
	2. 1. The other downside of an lxc container or any other container is that if for some reason it locks up the CPU and causes a kernel panic, it locks up the hypervisor.

#### Use Cases:
- Microservices architectures and cloud-native applications.
- Development environments where rapid iteration and deployment are essential.
- Applications that require high density and efficient resource utilization.
- Environments where fast startup times are beneficial.

### Key Differences:

1. **Isolation and Security:**
   - **KVM:** Provides strong isolation with separate kernels, making it suitable for high-security applications.
   - **LXC:** Shares the host kernel, offering less isolation but sufficient for many applications.

2. **Resource Overhead:**
   - **KVM:** Higher overhead due to full virtualization of hardware.
   - **LXC:** Lower overhead with efficient resource usage due to shared kernel.

3. **Flexibility:**
   - **KVM:** Can run different operating systems, offering greater flexibility.
   - **LXC:** Limited to Linux distributions but more efficient for similar environments.

4. **Performance:**
   - **KVM:** Slightly slower due to virtualization overhead.
   - **LXC:** Faster performance due to direct use of host kernel.

5. **Management and Operations:**
   - **KVM:** More complex management and higher resource usage per instance.
   - **LXC:** Easier management with faster provisioning and scaling.

### Conclusion
- **Use KVM-based VMs** if you need strong isolation, compatibility with various operating systems, and stable, predictable resource allocation.
- **Use LXC containers** if you need high performance, efficient resource usage, rapid scaling, and are working within a Linux ecosystem.

Each technology has its strengths and is suited to different scenarios. The choice depends on your specific requirements regarding security, performance, resource allocation, and the nature of the applications you intend to run.


---

KVMs: Have their own virtual kernels at each VM
LXCs: Shares same kernel

---

## Another major advantage - rollback ability:

Yeah. Since it sounds like you don't really have a colocation and are actually leasing a dedicated server, ask the customer support team to install proxmox or a basic Debian 12 server install.

sounds like I have to get into proxmox / debian 12 server so I can create a frontend so I can manage multiple VPS

Sounds like a plan. At least you'll be able to quickly snapshot something and roll back any "oopsies"