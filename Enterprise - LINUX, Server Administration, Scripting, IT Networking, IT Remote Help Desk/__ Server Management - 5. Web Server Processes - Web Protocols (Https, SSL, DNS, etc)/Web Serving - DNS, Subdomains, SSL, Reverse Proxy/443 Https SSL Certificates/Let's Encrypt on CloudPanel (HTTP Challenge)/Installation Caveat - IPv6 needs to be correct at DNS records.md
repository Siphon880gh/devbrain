When setting up SSL with Cloudflare (or any provider), make sure your **IPv6 is correct**, since Let’s Encrypt will often prioritize IPv6 over IPv4 during validation.

To check your server’s IPv6 address, run:

```
curl -6 ipconfig.co
```

If the IPv6 configured in DNS is incorrect, Let’s Encrypt may connect to the wrong endpoint and fail validation—typically returning a **404 error** even though your IPv4 setup is correct.

So double check your DNS AAAA Records

In CloudPanel, this usually appears as a failed SSL issuance with a validation/HTTP challenge error, but note the highlighted IPv6 address:
![[Pasted image 20260415054651.png]]