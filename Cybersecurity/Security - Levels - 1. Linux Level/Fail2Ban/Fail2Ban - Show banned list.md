
## Show Banned IPs List
Run:
```
fail2ban-client banned
```

You won't have to be far to see banned IPs


## Test the Banning of IPs Actually Work (After failed login attempts)

In my case, within one hour of installing Fail2Ban, it had already banned several IP addresses:
![[Pasted image 20260429034741.png]]

You can forcefully test the banning by hopping onto a VPN (which changes your IP address), and then fail at ssh authentication several times (up to maxtimes in the conf). See [[Fail2Ban - Test banning multiple attempts work]]
