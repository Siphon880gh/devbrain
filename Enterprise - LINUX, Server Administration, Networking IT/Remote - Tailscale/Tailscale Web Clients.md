## Remote Web Client

You usually access your settings on the remote user dashboard at tailscale.com, eg. https://login.tailscale.com/admin/machines

## Local Web Client

But you can access a limited dashboard locally by running
```
tailscale set --webclient
```

You'll see message:
```
Web interface now running at 100.80.255.2:5252
```

Visit that url `100.80.255.2:5252`
![[Pasted image 20260421233242.png]]

You might also see the local dashboard at:
http://100.100.100.100/