## Requirement: Setup port 3000

We're setting up port 3000 to say "Express works" for testing purposes

For example if you have an express server.js running on the server side like:
(Initiate a NodeJS app with: `npm init -y` -> `npm install express`)
(Then run with `node server.js`)
File `server.js`:
```
const express = require('express');
const app = express();
const PORT = 3000;

// Root route
app.get('/', (req, res) => {
  res.send('Express works');
});

// Start server
app.listen(PORT, () => {
  console.log(`Server running on http://localhost:${PORT}`);
});
```

As a quick test, I run it in foreground at a ssh
![[Pasted image 20260420064652.png]]

When I created the tunnel, I used address `http://localhost:3000`

Then going to `http://100.80.255.1:3000` would have shown:
![[Screenshot 2026-04-21 at 10.44.38 PM.png]]
## Nameservers

Instead I want some alphanumerical URL to open the port 3000 webpage

### Setup Mac for nameservers

These settings apply to Mac

1. ...
![[Pasted image 20260422001704.png]]

2. ...
![[Pasted image 20260422001739.png]]
3. ...
Settings -> Network -> Wi-Fi -> Details
![[Pasted image 20260422001847.png]]
![[Pasted image 20260422010015.png]]

> [!note] Becareful of glitch where old DNS servers disappear
> Note copy or screenshot the old DNS servers because some Macs have a glitch that removes old DNS servers when you add a new one! Then re-add the old DNS servers along the 100.100.100.100
> This would be bad - Notice there's just the new DNS server we entered:
> ![[Pasted image 20260422002034.png]]
>

Finally, add the same to "Search Domains":
![[Pasted image 20260422012137.png]]

### Reset tailscale to the new dns


Flush local DNS service on Mac:
```
sudo dscacheutil -flushcache; sudo killall -HUP mDNSResponder
```

Forceful reset tailscale and accept dns:
```
tailscale down && tailscale up --reset --accept-dns
```

### Try the following hosting name methods

**Works**
`tailscale serve 3000`
![[Pasted image 20260422002457.png]]
https://wengs-macbook-pro-new.tail844572.ts.net/

Note if it's your first time serving, you may get a message like:
```
Serve is not enabled on your tailnet.
To enable, visit:

         https://login.tailscale.com/f/serve?node=XXXXX

```

Visiting that page on the browser (copy and pasted):
![[Pasted image 20260422021607.png]]

**Works**
`tailscale serve --set-path=/test 127.0.0.1:3000`
![[Pasted image 20260422002457.png]]
https://wengs-macbook-pro-new.tail844572.ts.net/test

Note yes with set path, it's an even longer because you have to be type out the entire address


**Works**
Go to local web client per [[Tailscale Web Clients]]

![[Pasted image 20260421233242.png]]

Then copy the hostname:
![[Pasted image 20260422003509.png]]

**Visit with the port number:**
http://wengs-macbook-pro-new.tail844572.ts.net:3000/

If you dislike the machine name that precedes the tail*.ts.net, you can change the machine name at https://login.tailscale.com/admin/machines and that will change the URL:
![[Pasted image 20260422015434.png]]

### Troubleshooting

Diagnose (make sure there's Nameservers.. you can send this output to ChatGPT and ask why tailscale ts.net domains not working on your Mac machine):
```
tailscale dns status --all
```
Or
```
nslookup wengs-macbook-pro-new.tail844572.ts.net
```

**Again, to reset tailscale to the new dns:**

Flush local DNS service on Mac:
```
sudo dscacheutil -flushcache; sudo killall -HUP mDNSResponder
```

Forceful reset tailscale and accept dns:
```
tailscale down && tailscale up --reset --accept-dns
```
