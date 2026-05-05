Recall that every machine on the tailscale network is assigned an IP. You can change the IP here:

You should see this page at
https://login.tailscale.com/admin/machines
Then go Edit machine IP
![[Pasted image 20260421220449.png]]
Let's say you have port 3000 running on the local machine at local host to an Express endpoint, which means tailscale IP will automatically have access to that port.

Increment your IP, like change 100.80.255.1 to 100.80.255.2. See if the same port is opened
![[Screenshot 2026-04-21 at 10.44.01 PM.png]]
