
You can run commands on the host machine to see the devices connected to it in that network at some data center.


1. Run this command to see your loopback, virtual card port, host's IP address, and broadcast IP (We have not installed a virtual bridge):

```
ip addr
```
^ Can also be `ip a`

Output could be

```
1: lo: <LOOPBACK,UP,LOWER_UP> mtu 65536 qdisc noqueue state UNKNOWN group default qlen 1000  
    link/loopback 00:00:00:00:00:00 brd 00:00:00:00:00:00  
    inet 127.0.0.1/8 scope host lo  
       valid_lft forever preferred_lft forever  
2: ens33: <BROADCAST,MULTICAST,UP,LOWER_UP> mtu 1500 qdisc fq_codel state UP group default qlen 1000  
    link/ether 00:0c:29:3e:8e:1d brd ff:ff:ff:ff:ff:ff  
    inet 192.168.1.100/24 brd 192.168.1.255 scope global dynamic ens33  
       valid_lft 86023sec preferred_lft 86023sec  
```
  

- **`lo`:** This is the loopback interface, used internally by the system. It’s not used for external network connections. The IP address `127.0.0.1` (commonly referred to as "localhost") is used for self-connections, allowing the computer to communicate with itself. As a developer, let's say a webpage requests API service at port 5001, then the API service requests a video is generated at video generator microservice at port 5002. So port 5001 connects to 127.0.0.1 and the website never connected to the video generator script directly.

- **`ens33` (or similar):** This is likely your primary network interface if it has an IP address assigned (`inet 192.168.1.100/24` in the example). This is the IP address of the computer where you ran the command.
  
- The broadcast address follows `brd` so in this case it's: 192.168.1.255. The broadcast address is also the very last possible IP in the network’s IP range (from 192.168.1.100/24)
	- What is broadcast? If you send packets to the broadcast IP address, that information will be sent to all your devices. The gateway/router will not send that information to the rest of the internet though
	- Why? Here are some reasons:
		- Some services, like printers or media servers, broadcast messages to announce their presence on the network or to find other devices offering specific services. So it allows devices to discover each other without prior knowledge of specific IP addresses.
		- When a device knows the IP address of another device on the local network but needs to find its MAC address (the unique identifier for network interfaces), it sends an Address Resolution Protocol (ARP) request as a broadcast. The device with the matching IP address responds directly to the sender with its MAC address. The device doesn’t know which specific device owns the IP address, so it broadcasts the request to all devices on the network.
		- Dynamic Host Configuration Protocol (DHCP): This is usually not used in a dedicated server or VPS because you'd rather have predictable static ip addresses that you can assign domains to at a domain registration service (eg. Namecheap, Porkbun, Dan). When a device connects to a network and needs an IP address, it sends a broadcast message requesting IP configuration. The device doesn’t know the IP address of the DHCP server, so it uses broadcast to ensure the message reaches the server.
		- Network Service Announcements
	  
- inet stands for internet

2. Run this command to see your host's IP address, gateway aka router's IP address, and all possible IP addresses available. We haven't created a virtual bridge for VM to be discoverable on the internet. (Sorry not from the same computer as step 1 so the network interface name is different)
```
ip route
```

Output could be:
```
default via 208.76.249.73 dev enX0 onlink 
172.17.0.0/16 dev docker0 proto kernel scope link src 172.17.0.1 linkdown 
208.76.249.72/29 dev ens33 proto kernel scope link src 208.76.249.75
```

Default line
- The default line is the gateway aka router's IP address and also where the packet gets sent if the IP address destination doesn't match any devices. Think of the gateway/router is the home router where your wireless connections go and come from the internet. That's exactly the job of the gateway/router.

Docker (Only shows up if you've installed Docker for creating VM for VPS instances)
- **172.17.0.0/16**: This is a route to the 172.17.0.0/16 subnet, commonly used by Docker for creating virtual networks for containers.
- **dev docker0**: The packets destined for this subnet will be routed through the `docker0` network interface, which is typically a bridge interface created by Docker.
- **proto kernel**: This indicates that the route was added by the kernel (operating system) itself, likely as a result of Docker setting up its networking.
- **scope link**: This means that the route is only valid for directly connected devices, i.e., devices that are on the same physical or virtual network link.
- **src 172.17.0.1**: This indicates that the source IP address for packets sent out this interface should be 172.17.0.1, which is the IP address assigned to the `docker0` interface.
- **linkdown**: This suggests that the `docker0` interface is currently down or inactive, meaning no traffic can be routed through it at this moment.

`208.76.249.72/29 dev enX0 proto kernel scope link src 208.76.249.75`
- **208.76.249.72/29**: This is a route for the 208.76.249.72/29 subnet. More formally, is known as the **network address of the subnet**. The `/29` subnet mask indicates that this subnet has 8 IP addresses (from 208.76.249.72 to 208.76.249.79).
	- So it's all IP addresses available and that can deliver packets to the 208.76.249.75 which is the network interface
- **dev enX0**: The route uses the `enX0` network interface.
- **proto kernel**: The route was added automatically by the kernel.
- **scope link**: This route is for devices that are on the same link as the network interface `enX0`.
- **src 208.76.249.75**: When sending packets through this route, the source IP address will be 208.76.249.75, which is the IP address assigned to the `enX0` interface.

3. Let's say we have created a virtual bridge for VM to be discoverable on the internet. And we uninstalled docker. Running the `ip route` on the hots machine could give this output:
```
default via 208.76.249.73 dev xenbr0 onlink 
208.76.249.72/29 dev xenbr0 proto kernel scope link src 208.76.249.74
```

Instead of enX0 or any of the possible network interface naming, it's xenbr0 which means Xen bridge 0. This is a virtual bridge acting as the network interface. Hence 208.76.249.74 is the IP address to the virtual bridge.

The virtual bridge shares the same ip address as the host machine (which you can run `hostname -i` to confirm). The host machine is configured to use `xenbr0` as its main interface for network communication, meaning all network traffic, including that associated with the hostname, is routed through this bridge.

---

So in a network, various devices and components have their own IP addresses to enable communication. Here’s how the IP addresses apply to each device you mentioned:

1. **Host Machine**:
    
    - The host machine itself (e.g., a physical server, computer, or virtual machine) has an IP address assigned to one or more of its network interfaces. This IP address is used for communication between the host and other devices on the network.
      
2. **Network Card (NIC)**:
    
    - The Network Interface Controller (NIC) on the host machine has an IP address assigned to it. This IP address is associated with the network card and is used for communication over the network that the NIC is connected to. For example, the `ens33` interface in your earlier example has an IP address of `192.168.1.100`.
    
1. **Bridge** (includes virtual bridge):
    
    - A network bridge, which is often used in virtualized environments (e.g., Docker, Xen, or KVM setups), can also have an IP address. The bridge connects different network interfaces and allows traffic to pass between them as if they were on the same physical network. For example, the `docker0` bridge interface might have an IP address like `172.17.0.1`.
      
4. **Gateway**:
    
    - The gateway, often a router, also has an IP address. This IP address is the default gateway for devices on the network, meaning it is the address that devices use to send traffic destined for external networks (e.g., the internet). For example, in your routing table, the gateway has an IP address of `208.76.249.73`.


---

You can see how your network is connected and how it's configured virtually by running:
```
cat /etc/network/interfaces.d
```


---

## xenbr0 vs br0

Please refer to [[Networking Basics - Virtual Bridge - br0, xenbr0]]