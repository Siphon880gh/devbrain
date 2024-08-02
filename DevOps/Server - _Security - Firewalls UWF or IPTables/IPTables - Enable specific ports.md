
Check if iptables is managing firewall by running `sudo service iptables status`. 

If it's enabled, you should open the Mongo port by running `sudo iptables -A INPUT -p tcp --dport 27017 -j ACCEPT` . 

Check ports allowed by running `sudo iptables -L -n`