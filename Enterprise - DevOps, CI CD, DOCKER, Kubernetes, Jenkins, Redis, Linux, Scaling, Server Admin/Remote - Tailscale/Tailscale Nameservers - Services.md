Requirement: You must have setup [[Tailscale Nameservers (Mac)]] so that the basic methods of setting up hostnames and base urls work

Here we will use Tailscale's services that allow you to host nodejs, python, databases etc among the tailscale network using identifiable url's (not IP with ports) much like subdomains or reverse proxies:

- app1.tailXXX.ts.net
- app2.tailXXX.ts.net
- db.tailXXX.ts.net
- etc

Setup the services to the desired port (for example a NodeJS app that's currently running at port 3000):
![[Pasted image 20260422002538.png]]

Copy URL. Try to visit in the web browser. It will fail (and hence Hosts will remain 0 because no Host able to connect to the service yet)
![[Pasted image 20260422002913.png]]

---


```
tailscale serve -service=svc:test -http=80 http://127.0.0.1:3000
```

![[Pasted image 20260422015607.png]]

Approval:
![[Pasted image 20260422020521.png]]

![[Pasted image 20260422020630.png]]

Success is:
![[Pasted image 20260422020455.png]]


### Troubleshooting
tailscale serve -service=svc:yourservice-https=443 http://127.0.0.1:3000
service hosts must be tagged nodes

![[Pasted image 20260422020436.png]]

![[Pasted image 20260422021104.png]]

![[Pasted image 20260422020729.png]]

But make sure exists in Access controls -> JSON editor (should've been auto populated from installing tailscale):
![[Pasted image 20260422020829.png]]