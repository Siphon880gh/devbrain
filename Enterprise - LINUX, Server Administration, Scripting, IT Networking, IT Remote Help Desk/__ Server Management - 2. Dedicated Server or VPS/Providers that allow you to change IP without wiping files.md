## Providers that allows you to request IP change

You want to be able to rotate public IPv4 on demand in case you get bot attacks and Cloudflare can’t block it (because they’re attacking your public IP instead of through the domain name).

There are budget VPS providers that give you **more flexibility than Hostinger**, but the exact kind of flexibility varies:

- some let you **attach an extra public IPv4** to the same VM,
- some let you **move a reserved/floating IP** between VMs,
- some let you **replace the primary IPv4** only in certain conditions,
- and some handle IP swaps only by **support ticket / paid renumbering**. ([Vultr Documentation](https://docs.vultr.com/how-to-configure-multiple-public-ipv4-addresses-on-a-vultr-compute-instance?utm_source=chatgpt.com "Configure Multiple Public IPv4 Addresses on Vultr Compute"))

For your use case, the most practical low-cost options I found are:

**Hetzner Cloud**  
Hetzner supports **Floating IPs**, which can be assigned and reassigned among servers, and it also says a server’s **Primary IP can be added, removed, or replaced while the server is powered off**. That gives you a cleaner migration path than “reinstall or new instance only.” ([Hetzner Docs](https://docs.hetzner.com/cloud/floating-ips/getting-started/adding-a-floating-ip/?utm_source=chatgpt.com "Adding a Floating IP"))

**Vultr**  
Vultr documents adding **multiple public IPv4 addresses** to a compute instance, and it also offers **Reserved IPs**. That means you can keep your original VM and attach another public IP, or design around a movable IP instead of treating the VM’s first address as permanent. ([Vultr Documentation](https://docs.vultr.com/how-to-configure-multiple-public-ipv4-addresses-on-a-vultr-compute-instance?utm_source=chatgpt.com "Configure Multiple Public IPv4 Addresses on Vultr Compute"))

**DigitalOcean**  
DigitalOcean offers **Reserved IPs** that can be assigned and reassigned to Droplets within the same datacenter. That is useful for migration and failover, though it is not the same thing as casually “changing the Droplet’s built-in primary IP on demand.” ([DigitalOcean Docs](https://docs.digitalocean.com/products/networking/reserved-ips/?utm_source=chatgpt.com "Reserved IPs | DigitalOcean Documentation"))

**Linode / Akamai Cloud**  
Linode documents that IP addresses can be **viewed, added, removed, transferred, or shared**, and its newer interface docs say adding additional IPv4 addresses may require **support approval/justification**. So it is flexible, but less “instant self-service” than Hetzner or Vultr in practice. ([Akamai TechDocs](https://techdocs.akamai.com/cloud-computing/docs/managing-ip-addresses-on-a-compute-instance?utm_source=chatgpt.com "Manage IP addresses on a Linode"))

**OVHcloud**  
OVHcloud supports **Additional IPs** on Public Cloud and broader **Additional IP** products. This is useful if you want a separate mail IP or a migration path without rebuilding everything around a single immutable address. ([OVHcloud Help](https://help.ovhcloud.com/csm/en-public-cloud-network-configure-additional-ip?id=kb_article_view&sysparm_article=KB0050248&utm_source=chatgpt.com "Configuring an Additional IP"))

**RackNerd**  
RackNerd is one of the few I found with a clearly stated **IP replacement policy**: free within the first 72 hours, then **$3 per IP change** afterward. That is close to exactly what you asked for, although it is based on their published policy and not a generic self-service “change IP anytime” feature. ([RackNerd Blog](https://blog.racknerd.com/changing-your-vps-primary-ipv4-address-with-racknerd/?utm_source=chatgpt.com "Changing Your VPS Primary IPv4 Address with RackNerd"))

For your situation, I would rank them like this:

1. **Hetzner** if you want the cleanest IP-management model at low cost. Floating IPs plus replaceable primary IPs are a strong combo. ([Hetzner Docs](https://docs.hetzner.com/cloud/floating-ips/getting-started/adding-a-floating-ip/?utm_source=chatgpt.com "Adding a Floating IP"))
2. **Vultr** if you want straightforward extra IPv4 options and reserved IPs. ([Vultr Documentation](https://docs.vultr.com/how-to-configure-multiple-public-ipv4-addresses-on-a-vultr-compute-instance?utm_source=chatgpt.com "Configure Multiple Public IPv4 Addresses on Vultr Compute"))
3. **DigitalOcean** if you value simplicity and are okay thinking in terms of Reserved IPs rather than “swap the main IP.” ([DigitalOcean Docs](https://docs.digitalocean.com/products/networking/reserved-ips/?utm_source=chatgpt.com "Reserved IPs | DigitalOcean Documentation"))
4. **OVHcloud** if separate/additional IPs matter a lot and you are comfortable with a slightly more infra-heavy setup. ([OVHcloud Help](https://help.ovhcloud.com/csm/en-public-cloud-network-configure-additional-ip?id=kb_article_view&sysparm_article=KB0050248&utm_source=chatgpt.com "Configuring an Additional IP"))
5. **RackNerd** if your main requirement is literally “I want a cheap provider that may let me pay to change IPs.” ([RackNerd Blog](https://blog.racknerd.com/changing-your-vps-primary-ipv4-address-with-racknerd/?utm_source=chatgpt.com "Changing Your VPS Primary IPv4 Address with RackNerd"))

A key design point: you may not actually need a provider that lets you constantly “change the main VPS IP.” A better pattern is often:

- put the website behind **Cloudflare**,
- use a provider that supports **reserved/floating/additional IPs**,
- keep **mail on a separate DNS-only IP/server**,
- and firewall the web origin so only Cloudflare can reach 80/443.

That way, if a web origin IP gets burned, you can migrate more cleanly without mixing your site and mail exposure together. This follows from the IP products these providers document and Cloudflare’s origin-protection model discussed earlier. ([Vultr Documentation](https://docs.vultr.com/how-to-configure-multiple-public-ipv4-addresses-on-a-vultr-compute-instance?utm_source=chatgpt.com "Configure Multiple Public IPv4 Addresses on Vultr Compute"))

One caution: because of IPv4 scarcity, many providers now require justification, charge extra, or restrict how casually public IPv4s can be reassigned. So the market trend is more “**attach or reserve another IP**” than “press button to get a random fresh primary IP whenever you want.” ([Akamai TechDocs](https://techdocs.akamai.com/cloud-computing/docs/managing-linode-interfaces?utm_source=chatgpt.com "Manage Linode interfaces (BETA)"))

My practical recommendation for you:

- **Best budget/value:** Hetzner Cloud
- **Best easy US-friendly alternative:** Vultr
- **Most explicitly close to your request:** RackNerd’s paid IP replacement policy ([Hetzner Docs](https://docs.hetzner.com/cloud/servers/primary-ips/overview/?utm_source=chatgpt.com "Overview"))