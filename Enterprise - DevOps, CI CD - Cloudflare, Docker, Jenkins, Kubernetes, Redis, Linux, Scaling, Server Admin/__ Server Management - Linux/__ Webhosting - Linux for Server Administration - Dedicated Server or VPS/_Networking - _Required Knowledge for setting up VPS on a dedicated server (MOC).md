You want to setup a VPS on a dedicated server. In other words, you are carving a piece of the dedicated server as the VPS that the internet can access. The rest of your dedicated server is untouched.

When setting up VPS environments within a dedicated server—a common and practical approach for better security and control. Here’s why:
- **Crash Recovery During Development**: If a public-facing server crashes due to buggy code (e.g. during early development before a stable release), isolating it in a VM means you won’t have to rely on IT support—especially during off-hours or when dealing with slow ticket queues. Some dedicated server providers don’t grant full reboot access, or only allow it temporarily through a web interface that's enabled at the IT team's discretion.
- **Security Containment**: If the public-facing server is ever compromised, the damage is limited to the VM acting as the VPS. You can simply reflash the VM, patch any vulnerabilities, and restore from a backup—minimizing downtime, risk, and cost.

The rest of the sibling notes will help with this endeavor.

But first make sure you have mastered some **basic required knowledge**:
- How to partition [[Partition unallocated sectors on a disk in Linux]]
	- In fact, you should have a partition readily available to act as the VM or VPS.
- Having a partition by default is just a storage area for files. That's not enough. You will virtualize another Linux OS into that partition. Therefore, you need to know [[_CATE - VMs as VPS]]
- Know the main network interfaces such as virtual bridges. The reason why is that you will be creating a VM out of that partition, then exposing that to the public internet as a VPS. To expose it to the internet, you need to virtually setup network interfaces (You dont have to physically be at the data center). Understand the notes in this folder: [[_CATE - Network Interfaces]]