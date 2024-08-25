

Get the IP address of your dedicated server that your SSH session is on:
```
hostname -I
```


*Result could be:*
```
222.22.222.24
```

---

Get information about your server's network and its connection to the internet network:
```
echo "Current IP Address (default interface):" && ip -4 addr show $(ip route | grep default | awk '{print $5}') | grep -oP '(?<=inet\s)\d+(\.\d+){3}'  
echo ''  
echo -e "\nAll Available IP Addresses:" && ip -4 addr show | grep -oP '(?<=inet\s)\d+(\.\d+){3}/\d+'
echo ''
echo -e "\nNetmask (for default interface):" && ip -4 addr show $(ip route | grep default | awk '{print $5}') | grep -oP '(?<=inet\s)\d+(\.\d+){3}/\d+' | cut -d '/' -f 2  
echo ''  
echo -e "\nGateway:" && ip route | grep default | awk '{print $3}'  
echo ''  
echo -e "\nDNS Servers:" && cat /etc/resolv.conf | grep 'nameserver' | awk '{print $2}'    
echo -e "\nNetwork Speed/Bandwidth:" && ethtool $(ip route | grep default | awk '{print $5}') | grep -i "speed"  
echo ''  
echo -e "\nip a:" && ip a
```


*Result could be:*
```
Current IP Address (default interface):
222.22.222.24


All Available IP Addresses:
127.0.0.1/8
222.22.222.24/29


Netmask (for default interface):
29


Gateway:
222.22.222.23


DNS Servers:
8.8.8.8

Network Speed/Bandwidth:
	Speed: 1000Mb/s


ip a:
1: lo: <LOOPBACK,UP,LOWER_UP> mtu 65536 qdisc noqueue state UNKNOWN group default qlen 1000
    link/loopback 00:00:00:00:00:00 brd 00:00:00:00:00:00
    inet 127.0.0.1/8 scope host lo
       valid_lft forever preferred_lft forever
    inet6 ::1/128 scope host noprefixroute 
       valid_lft forever preferred_lft forever
2: eno1: <BROADCAST,MULTICAST,UP,LOWER_UP> mtu 1500 qdisc mq state UP group default qlen 1000
    link/ether 34:17:eb:ee:2a:87 brd ff:ff:ff:ff:ff:ff
    altname enp4s0f0
    inet 222.22.222.22/29 brd 222.22.222.22 scope global eno1
       valid_lft forever preferred_lft forever
    inet6 fe80::3617:ebff:feee:2a87/64 scope link 
       valid_lft forever preferred_lft forever
3: eno2: <BROADCAST,MULTICAST> mtu 1500 qdisc noop state DOWN group default qlen 1000
    link/ether 34:17:eb:ee:2a:88 brd ff:ff:ff:ff:ff:ff
    altname enp4s0f1
```
