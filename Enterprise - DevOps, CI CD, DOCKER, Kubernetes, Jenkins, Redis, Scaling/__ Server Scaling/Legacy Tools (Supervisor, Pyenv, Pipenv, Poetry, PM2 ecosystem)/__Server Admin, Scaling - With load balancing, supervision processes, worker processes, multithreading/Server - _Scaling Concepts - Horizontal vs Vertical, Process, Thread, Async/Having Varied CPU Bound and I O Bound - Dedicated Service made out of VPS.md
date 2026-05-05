
Scenario: Website that people visit where they upload pictures and wait for video to finish generating (I/O high on concurrent users). Where it generates the video using MoviePy/Ffpmeg, that's high in CPU use.

As a response to my scenario:
For an app that has parts that use CPU more and parts that use I/O more: If you'd run with the VM approach here, you could easily dedicate different resources to both parts, keeping the front end snappy, and the backend may just take longer under heavy load. Then if you need to scale up again, you could always get another server at that time and move the one image over. Personally I'd virtualize both environments, as it'd let you control performance, and give you snapshots that you could easily restore yourself rather than needing to ask your friend to reprovision your entire dedicated server.

Using Dockers and Kubernetes is one approach. Personally I'd think proxmox would be simpler.

Proxmox VE is an open-source server virtualization management platform that integrates the KVM hypervisor to enable full virtualization (KVM is a type 1 hypervisor that turns the Linux kernel into a bare-metal hypervisor. It allows you to run multiple virtual machines (VMs) on a Linux host.). It provides a web-based interface to create, manage, and monitor VMs, leveraging KVM's capabilities for high performance and scalability. Proxmox supports clustering for managing multiple nodes, offers advanced resource management, and features high availability and live migration. This integration allows users to benefit from KVM's robust virtualization while enjoying the ease of use and comprehensive management tools provided by Proxmox, making it an efficient solution for both small and large-scale virtual environments.
- **Hypervisor**: A hypervisor is **a software that you can use to run multiple virtual machines on a single physical machine**. Every virtual machine has its own operating system and applications. The hypervisor allocates the underlying physical computing resources such as CPU and memory to individual virtual machines as required.
- **Bare-metal, type 1 hypervisor, type 2 hypervisor:** Bare-metal refers to a physical computer hardware system, such as a server or workstation, that operates without any operating system or software layer between the hardware and the applications. In the context of virtualization, a bare-metal hypervisor (also known as a type 1 hypervisor) runs directly on the physical hardware and manages the hardware resources, enabling the creation and management of virtual machines (VMs). This approach contrasts with a type 2 hypervisor, which runs on top of a conventional operating system. Bare-metal hypervisors, such as KVM, VMware ESXi, and Microsoft Hyper-V, typically offer better performance, efficiency, and resource utilization compared to hosted hypervisors.

Since it sounds like you don't really have a colocation and are actually leasing a dedicated server, ask the customer support team to install proxmox or a basic Debian 12 server install.

ubuntu 22 wont work with this? > No. You can't convert Ubuntu 22 to proxmox. You can convert Debian 12 to proxmox

As for proxmox different IP for each VM/VPS:
It depends on how network access is handed off to you. If you have a block of IPs, it will be easy to assign a public IP to each VM

I only use 1 public IP, so I needed a router to do port forwarding and it gave me an easy site-to-site VPN to make off-site backups a breeze.

---

And yes. VMs and VPSs are almost the same.

Hostinger probably uses some implementation of openstack instead of a cluster of esxi servers

