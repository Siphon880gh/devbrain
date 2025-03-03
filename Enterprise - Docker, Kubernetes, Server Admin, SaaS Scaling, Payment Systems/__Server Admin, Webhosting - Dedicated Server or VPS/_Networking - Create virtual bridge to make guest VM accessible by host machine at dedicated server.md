#### Setup virtual bridge inside the dedicated server's private network

To set up your VM, you'll need to allow your computer to even see the new computer. This means creating a virtual bridge that will allow your host computer to see the other guest computers (VM). This virtual bridge will also connect your VM to your physical network's router aka gateway, so that the internet can start seeing your VM as another server that can have websites.

##### Step 1: Configure the Bridge in `/etc/network/interfaces`

You'll need to modify your `/etc/network/interfaces` file to create a network bridge.  

Checkpoint: Deja vu? If you feel like you had already done this step, did you add the bridge on the pre-xen OS? Remember you booted into XEN now. The `/etc/network/interfaces` in your XEN bootup is different from the one in your non-XEN bootup. You had done extra work that didn't count. We have to edit the settings inside the Xen that's booted.

Before making any changes, it’s always a good idea to back up your current network configuration:
```
sudo cp /etc/network/interfaces /etc/network/interfaces.bak
```


Assuming this is the original:
```
# This file describes the network interfaces available on your system
# and how to activate them. For more information, see interfaces(5).

source /etc/network/interfaces.d/*

# The loopback network interface
auto lo
iface lo inet loopback

# The primary network interface
allow-hotplug eno1
iface eno1 inet static
		address 192.0.2.2/29
		gateway 192.0.2.1
        # dns-* options are implemented by the resolvconf package, if installed
		dns-nameservers 198.51.100.2 198.51.100.3 8.8.8.8
		dns-search example.rdns.provider.com
```

Here's how you can edit it:
REPLACE adderss, gateway, dns-nameservers, and dns-serach with your original values
xenbr0 is the default bridge name from xen tools. If you had set the virtual bridge name when running `xen-create-image`, then you'd have to use that virtual bridge name instead.
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
auto xenbr0
iface xenbr0 inet static
		address 192.0.2.2/29
		gateway 192.0.2.1
        bridge_ports eno1
        bridge_stp off
        bridge_fd 0
        bridge_maxwait 0
		dns-nameservers 198.51.100.2 198.51.100.3 8.8.8.8
		dns-search example.rdns.provider.com
```

Key options:
- **eno1** is now set to `manual` to prevent it from being assigned an IP address directly.
- **xenbr0** is the new bridge interface that takes over the IP address and gateway configuration.
- **bridge_ports eno1** connects your physical interface `eno1` to the bridge `br0`.
- **bridge_stp off** disables Spanning Tree Protocol, as it's not needed in this scenario.
- **bridge_fd 0** and **bridge_maxwait 0** are settings to reduce the delay during bridge setup.

Explanation: Why the config changes are like this is beyond the scope of this tutorial. Refer to [[_Networking - Concept Primer of creating VPS]]'s FAQ section, specifically at "At `auto xenbr0` and `iface xenbr0 inet static`, coding wise - br0 is just another interface, but concept wise (when we draw on diagram or communicate about networking) - it's a virtual bridge"
##### Step 2: Apply the Configuration

After modifying the `/etc/network/interfaces` file, you should restart the networking service to apply the changes:

```bash
sudo systemctl restart networking && sudo systemctl restart sshd
```

Or:
```
systemctl restart networking && systemctl restart sshd
```

Restarting the networking service will kick you off SSH. This command logs you back into SSH as soon as the networking service is back on. Could take up to 1-2 minutes.

If you can't log back into SSH, then the bridge is not functioning correctly or you have messed up. You have to reach out to support and let them know about the backup file so they can restore your network settings (or last resort, they reformat).

##### Step 3: Test Network settings with the virtual bridge are correct

1. **Check the Bridge Status:**
   Once you are back in, you can verify that the bridge is up and running by checking the network interfaces:

   ```bash
   ip addr
   ```
^ A shortcut is running `ip a`

   You should see `xenbr0` listed with the correct IP address and configuration. Here's an example. For this example, the public IP address of the dedicated server host machine is (192.0.2.2/29 and 192.0.2.2). It does NOT show your gateway aka router. That's the next command:
```
Host's ip addr is:
1: lo: <LOOPBACK,UP,LOWER_UP> mtu 65536 qdisc noqueue state UNKNOWN group default qlen 1000
    link/loopback 00:00:00:00:00:00 brd 00:00:00:00:00:00
    inet 127.0.0.1/8 scope host lo
       valid_lft forever preferred_lft forever
    inet6 ::1/128 scope host noprefixroute 
       valid_lft forever preferred_lft forever
2: eno1: <BROADCAST,MULTICAST,UP,LOWER_UP> mtu 1500 qdisc mq master xenbr0 state UP group default qlen 1000
    link/ether xx:xx:xx:xx:xx:xx brd ff:ff:ff:ff:ff:ff
    altname enp4s0f0
3: eno2: <BROADCAST,MULTICAST> mtu 1500 qdisc noop state DOWN group default qlen 1000
    link/ether xx:xx:xx:xx:xx:xx brd ff:ff:ff:ff:ff:ff
    altname enp4s0f1
4: xenbr0: <BROADCAST,MULTICAST,UP,LOWER_UP> mtu 1500 qdisc noqueue state UP group default qlen 1000
    link/ether xx:xx:xx:xx:xx:xx brd ff:ff:ff:ff:ff:ff
    inet 999.99.999.99/29 brd999.99.999.99 scope global xenbr0
       valid_lft forever preferred_lft forever
    inet6 xxxx::xxxx:xxxx:xxxx:xxxx/64 scope link 
       valid_lft forever preferred_lft forever
8: vif4.0: <BROADCAST,MULTICAST,UP,LOWER_UP> mtu 1500 qdisc mq master xenbr0 state UP group default qlen 1000
    link/ether xx:xx:xx:xx:xx:xx brd ff:ff:ff:ff:ff:ff
    inet6 xxxx::xxxx:xxxx:xxxx:xxxx/64 scope link 
       valid_lft forever preferred_lft forever

```

See if the IP of your gateway aka router. 
^ Background knowledge: Remember, certain devices in your physical network including host machine, virtual machines, and gateway aka router needs an IP address, whether it's private IP only to the network, or public IP that can be seen by the internet. Without an IP address, you won't be able to connect to that device

Run `ip route`. You may see (For this example, 192.0.2.1 is the gateway/router ip, 192.0.2.100 is the private IP of your host machine aka source ip which is different numeric value than its public IP that the internet sees):
```
default via 192.0.2.1 dev eth0 proto dhcp src 192.0.2.100 metric 100 
192.0.2.1/29 dev eth0 proto kernel scope link src 192.0.2.100
```


Recall that your `/etc/network/interfaces` file actually had assigned some devices' IP addresses, and they will match the above outputs (Source ip aka private source ip is auto assigned though):
```
		address 192.0.2.2/29
		gateway 192.0.2.1
```

2. **Test Local Network Connectivity by pinging the Gateway:**
   To ensure the bridge is correctly routing traffic, you can ping the gateway:

Adjust to your gateway's ip and ping it to demonstrate your host machine is connected to your gateway aka router:
   ```bash
   ping -c 4 999.99.999.98
   ```


^ Required: Your gateway IP. This is also called the router IP. 
^ Background knowledge: Certain devices in your physical network require IP addresses to be connected to, whether it's a private IP only to your network or a public IP that internet network is privy to.

You can run `ip route | grep default` to get the IP that corresponds to the gateway aka router
**Why the command works**:  The "default" route refers to the route that packets should take when their destination address doesn't match any other route in the routing table. This "default" route is usually configured to send packets to the network's gateway, which is the device that routes traffic from your local network to other networks, including the internet.
**Options**: `-c 4` is the Count of pings sent


   This should return successful pings if the bridge is set up correctly. The result could be:
```
ING 208.76.249.73 (208.76.249.73) 56(84) bytes of data.

64 bytes from 208.76.249.73: icmp_seq=1 ttl=255 time=0.253 ms

64 bytes from 208.76.249.73: icmp_seq=2 ttl=255 time=0.315 ms

64 bytes from 208.76.249.73: icmp_seq=3 ttl=255 time=0.263 ms

64 bytes from 208.76.249.73: icmp_seq=4 ttl=255 time=0.281 ms
```

3. **Test Internet Connectivity and DNS Resolution by pinging a public IP:**
   You can also try pinging a public DNS server, like Google’s:

   ```bash
   ping -c 4 8.8.8.8
   ```

   Next ping a domain name with alphabets, like Google’s public web server:
	```
	ping -c 4 google.com
	```

   Successful responses indicate that the bridge is functioning as expected and has not broken your network settings.


---

### **Checkpoint**
Now that you have a virtual bridge, the question is whether you have VMs. With a virtual bridge, VMs can be started without virtual bridge errors (For example, Xen's `xl create` automatically checks the requirement of a virtual bridge). If you do not have a VM yet, and you're using Xen, go to [[Xen - Setup XEN VMs (Type 1 Hypervisor, no KMV) - Part 2]]

Proceeding means your VM has started and you want the VM to be discoverable on the internet.

---

### Proceed to making VM discoverable on the internet (Refer to)

Proceed to making the VM discoverable on the internet. Follow instructions at [[_Networking - Assign VM a public IP and listen to ports 22, 80, 443 for SSH and websites]]