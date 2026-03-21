
**Use case for creating VPS**: You own a dedicated server which allows you to create virtual private servers (that you can lend out to customers or allows you to isolate your website or gaming server so that you can restart or scale them from the dedicated server)

## Concepts

These are levels from basic to more involved and complex to make it possible for a dedicated server to spawn out VPS (virtual private servers) with their own IP addresses:

- 1st level: Your physical network is comprised of the computer that houses your dedicated server listening to different ports and receiving and sending back packets. This computer is sitting somewhere in a data center or if you have it built yourself, it's in front of you. The computer has a network card with ports in the back that that can connect ethernet cables to. The network card then connects to a router (aka gateway ). All these are physical devices that are connected, hence your "physical network".
- 1st level: The gateway/router connects to the internet network.
- 2nd level: We are adding a new computer to the network, except that computer isn't physical. It's a virtual machine. Other names for it are VM and guest OS (as opposed to host OS which is the physical computer). In order for the VM to be accessible by your host or dedicated server (so you can console it in), you need to create a virtual bridge (as opposed to a physical bridge device) that connects the VM to the rest of your physical network.
- 2nd level: This virtual bridge will also connect to the router as though it were a physical device. This would allow your VM (guest os) and server (host os) to be discoverable by the internet
- 2nd level: You do not need to physical rearrange any cables at the server. You can modify your server's network settings (`/etc/network/interfaces` file at the host machine) to apply the virtual bridge. However you are required to know the IP addresses of certain devices like computer machines and gateway aka router. Certain devices in your physical network require IP addresses to be connected to, whether it's a private IP only to your network or a public IP that internet network is privy to.
- 3rd level: However, the VM is not listening to different ports and receiving and sending back packets yet. Just like your host machine has a public IP that domains can resolve to, you have to assign a static public IP to your VM. Then you have to install nginx/apache/cloudpanel so that the internet ports are opened up and there is a background process / daemon that receives and sends packets (aka data). 

---


## FAQS

### Networking Bridge mode to allow dedicated server and VPS:

#### **Conceptually this means I virtually bridged my VMs to the gateway/router so it's seenable by the internet?**

Yes, conceptually, creating a bridge on your host system (dedicated server) and connecting your VMs to that bridge means you are effectively linking your VMs to the same network as your host's physical interface. This setup allows the VMs to be directly accessible on the network, just like any other device connected to the router or gateway.

**Here’s how it works:**

1. **Bridge Interface (br0):**
   - The bridge interface (`br0`) acts like a virtual network switch that connects multiple network interfaces, including your physical network interface (`eno1`) and the virtual interfaces of your VMs.
   - By assigning your host’s IP address and gateway to the bridge, you’re ensuring that the bridge manages the network traffic for both the host and any VMs connected to it.

2. **VM Connection:**
   - When you configure your VM to use the bridge (`vif = ['bridge=br0']`), the VM’s virtual network interface is connected to this bridge.
   - This allows the VM to appear on the same network as your host, with its own IP address (either assigned by DHCP or statically set).
   - The VM can now send and receive network traffic through the bridge, just like the host.

3. **Public Accessibility:**
   - Because the VM is connected to the same network as your host, it can be assigned an IP address in the same range as the host.
   - This makes the VM accessible from outside the host, as if it were a separate machine on the network.
   - If the VM is assigned a public IP address, it will be reachable over the internet, allowing it to host services like a website that people can visit.

**Visualization:**

- **Before Bridging:** Your VM’s network is isolated from the external network unless explicitly routed. It may only be accessible via NAT or port forwarding from the host.

- **After Bridging:** Your VM is virtually "bridged" to the same network as the host's physical interface. It can directly communicate with the gateway/router and be accessed from the internet.

This setup is common in scenarios where you want your VMs to be treated as first-class citizens on the network, with their own IP addresses and full network visibility.

#### Does this mean my dedicated server is also bridged virtually on the same br0?

Yes, that’s correct! When you create a bridge interface (`br0`) on your dedicated server and assign the server’s IP address and gateway to that bridge, both your dedicated server and any VMs connected to the bridge are effectively sharing the same virtual network.

**Here’s how it works:**

1. **Shared Bridge Interface (`br0`):**
   - The bridge (`br0`) acts as a virtual switch that connects your dedicated server's physical network interface (`eno1`) and the virtual network interfaces of your VMs.
   - By assigning the IP address and gateway directly to the bridge (`br0`), you're moving the network management from the physical interface (`eno1`) to the bridge.

2. **Dedicated Server’s Role:**
   - The dedicated server is also connected to this bridge through its physical interface (`eno1`), which now participates in the bridge instead of having a separate network configuration.
   - This means that both the server and the VMs are on the same network, and traffic from the server and the VMs is routed through the bridge.

3. **Networking Implications:**
   - **Virtual Switch:** The bridge functions like a virtual switch inside your server. It forwards network packets between the server, the VMs, and the external network (through `eno1`).
   - **Same Network Visibility:** Both the dedicated server and the VMs appear as separate devices on the same network, each potentially with its own IP address.
   - **Public Accessibility:** If your server has a public IP, the VMs connected to `br0` can also have public IPs (if available), making them accessible from the internet.

**Conceptual Visualization:**

- **Without a Bridge:** The dedicated server is directly connected to the network via `eno1`, and any VMs would need separate routing, NAT, or port forwarding to communicate externally.

- **With a Bridge (`br0`):** The dedicated server's physical interface (`eno1`) and the VMs are all connected to the same virtual network through `br0`. The server and the VMs can communicate as if they were on the same physical switch, sharing the same network segment.

**Summary:**
- Your dedicated server and the VMs are "virtually bridged" through `br0`, meaning they are on the same network and can communicate with each other and with external networks via the same gateway/router.
- This setup allows for seamless network integration between the server and VMs, with each able to have its own IP and be independently accessible.


#### So even though the gateway (and hence the internet network) connects to the physical NIC (Network interface controller), the internet sees the virtual switch which bridges the host and the guest OS?

Yes, exactly! The bridge interface (`br0`) you created on your dedicated server essentially acts as a virtual switch. Here's how it works:

**How the Bridge (`br0`) Works:**

1. **Physical NIC (Network Interface Controller):**
   - Your dedicated server's physical NIC (`eno1`) is the actual hardware that connects to your network, including the gateway and the wider internet.
   - It physically connects your server to your network infrastructure (e.g., router, gateway) using the network cable or other physical connections.

2. **Virtual Bridge (`br0`):**
   - The bridge interface (`br0`) is a software construct that acts like a virtual network switch inside your server.
   - You connect the physical NIC (`eno1`) to this bridge, so now the bridge manages the network traffic instead of `eno1` directly.

3. **Host (Dedicated Server) and Guest OS (VMs):**
   - Both the host (dedicated server) and any VMs connected to the bridge are treated as if they are all plugged into the same physical switch.
   - They can communicate with each other directly through the bridge, just like devices connected to the same physical switch would.

4. **Gateway and Internet Connectivity:**
   - The bridge forwards network traffic between your host, VMs, and the external network through the physical NIC (`eno1`).
   - From the perspective of the external network (including the gateway and the internet), all devices connected to the bridge (host and VMs) appear to be on the same network.

5. **Public IP Addresses:**
   - If your server or VM has a public IP address, the bridge allows it to be directly accessible over the internet. The network sees each device connected to the bridge (host or VM) as having its own IP address and treats them as separate entities.

**Visualizing the Concept:**

- **Physical Layer:** The physical NIC (`eno1`) connects to the gateway/router, providing the physical link to the internet.
- **Virtual Layer (Bridge `br0`):** The bridge (`br0`) connects the physical NIC and the virtual network interfaces of the VMs, effectively placing them on the same network.
- **Network Perspective:** The external network (including the internet) sees the bridge and all connected devices (host and VMs) as if they are separate devices on the same network segment.

**Summary:**
- The internet and your local network interact with the virtual switch (bridge `br0`), which bridges your physical NIC and the virtual network interfaces of the VMs.
- This setup allows your host (dedicated server) and guest OS (VMs) to share the same network environment and be independently accessible from the internet, each with its own IP address.


#### Next clarification questions are based off this network interface settings file:

```
# This file describes the network interfaces available on your system
# and how to activate them. For more information, see interfaces(5).

source /etc/network/interfaces.d/*

# The loopback network interface
auto lo
iface lo inet loopback

# The primary network interface
allow-hotplug eno1
iface eno1 inet manual

# Bridge setup
auto br0
iface br0 inet static
        address 192.0.2.2/29
        gateway 192.0.2.1
        bridge_ports eno1
        bridge_stp off
        bridge_fd 0
        bridge_maxwait 0
        dns-nameservers 198.51.100.2 198.51.100.3 8.8.8.8
        dns-search example.rdns.provider.com

```


#### At `auto xenbr0` and `iface xenbr0 inet static`, coding wise - br0 is just another interface, but concept wise (when we draw on diagram or communicate about networking) - it's a virtual bridge

You're absolutely right. In code, `br0` is treated like any other network interface, but conceptually, it acts as a virtual bridge that connects the physical network interface (e.g., `eno1`) with the virtual network interfaces on your VPS.

This distinction is important when diagramming or discussing the network architecture, as the virtual bridge (br0) represents the link that allows communication between the physical network and virtual machines, creating a seamless network environment.

#### At `bridge_ports eno1`, is that saying that although the gateway/router is connected to the eno1 physical network interface's ethernet port, the gateway/router sees the virtual network interface that bridges the VM and the physical computer host?

Yes, that's correct.

When you configure `bridge_ports eno1`, you are essentially telling the bridge (`br0`) to include the physical network interface `eno1` as part of the bridge. This means that any traffic coming into or going out of the `eno1` interface is now part of the `br0` bridge network.

Here’s how it works conceptually:

- **Physical Setup:** The physical network interface `eno1` is connected to your network, likely to a switch or directly to a gateway/router.

- **Bridge Behavior:** The bridge `br0` acts as an intermediary between the physical interface (`eno1`) and the virtual interfaces connected to your virtual machines (VMs). 

- **Traffic Flow:** 
  - When the gateway/router sends traffic to your server, it arrives at `eno1`.
  - The bridge (`br0`) then allows this traffic to be passed to the virtual interfaces (e.g., `vif0.0`) that connect to the VMs.
  - Conversely, traffic originating from the VMs can pass through the bridge and out via `eno1` to the gateway/router.

- **Gateway/Router Perspective:** The gateway/router sees the bridge as if it were a single entity, even though it might be routing traffic to multiple virtual interfaces behind it. The bridge abstracts the complexity of having multiple interfaces on different VMs, presenting them as if they were part of a single, unified network segment.

So in summary, while `eno1` is the physical connection point, the bridge (`br0`) allows the gateway/router to interact seamlessly with the virtual interfaces of the VMs, as though they were all on the same physical network.
