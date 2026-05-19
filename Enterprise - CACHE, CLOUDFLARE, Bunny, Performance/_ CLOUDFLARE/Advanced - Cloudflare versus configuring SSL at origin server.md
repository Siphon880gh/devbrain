
Let's say your website is behind Cloudflare, and you want to renew Let’s Encrypt on your origin server. 

If Cloudflare is set to **Flexible SSL**, renewing Let’s Encrypt on the server is not required for visitors to see HTTPS, because Cloudflare terminates HTTPS at the edge and then connects to your origin server over plain HTTP. However, this is only partially secure because the Cloudflare-to-origin connection is unencrypted, so it can be exposed to interception or tampering between Cloudflare and your VPS. 

> [!note] Interception or tampering between Cloudflare and your VPS
> For a normal random hacker, this is not easy — they usually cannot just “sniff” your Cloudflare-to-server traffic from home. They would need control over part of the network path between Cloudflare and your VPS, such as a compromised router, access inside a provider or ISP network, or a rare internet routing attack where traffic is redirected through the attacker’s network (**BGP hijacking** or **route leak**). In other cases, they would need your origin network setup to be compromised so traffic gets redirected before reaching your real server.

Cloudflare recommends using **Full** or **Full (strict)** instead of **Flexible** whenever possible.

- **Full** means Cloudflare connects to your server over HTTPS, but it does **not strictly verify** whether the origin certificate is fully valid. This can work with a self-signed certificate, an expired certificate, or a certificate that may not perfectly match the hostname. It encrypts the Cloudflare-to-server connection, but it is less secure than Full (strict).
- **Full (strict)** means Cloudflare connects to your server over HTTPS **and verifies** that the origin certificate is valid, not expired, and matches the requested hostname. The certificate can come from a public certificate authority like **Let’s Encrypt**, or from **Cloudflare Origin CA**.

Cloudflare Origin CA certificates are useful when your domain stays behind the Cloudflare proxy, because Cloudflare trusts those certificates. However, normal browsers do **not** trust Cloudflare Origin CA certificates directly. So if you pause Cloudflare or switch the DNS record to **DNS-only**, visitors may see a certificate warning.

Having multiple domains like `domain.com`, `domain2.com`, and `domain3.com` point to the same web root is not a problem by itself. SSL certificates do not care that the websites share the same folder on the server. They care whether the certificate matches the domain name being requested. So your server needs to present a certificate that covers each domain, either by using one certificate with multiple domain names, wildcard certificates, or separate certificates for each domain through separate virtual hosts.