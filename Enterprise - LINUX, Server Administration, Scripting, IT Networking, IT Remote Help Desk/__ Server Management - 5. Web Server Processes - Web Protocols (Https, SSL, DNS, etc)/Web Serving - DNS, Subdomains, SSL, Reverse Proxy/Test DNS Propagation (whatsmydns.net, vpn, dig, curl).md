You can test propagation with whatsmydns.net

If other states or countries appear to have updated faster, you can jump the line to test your website as if you're over there if your VPN software allows you to choose location

---

This command lets you test A record quickly:
```
dig DOMAIN.com +short
```

---

This lets you test A and AAAA records quickly:

A record (IPv4):
```
curl -4 -I https://domain.com
```

AAAA record (IPv6):
```
curl -6 -I https://domain.com
```