## Fundamentals of A and AAAA Records

DNS is the phonebook layer of the internet. When someone types a domain like:

```txt
example.com
www.example.com
app.example.com
```

their browser first needs to know:

```txt
What server IP address should this hostname point to?
```

That is where **A** and **AAAA** records come in.

---

### What Is an A Record?

An **A record** points a hostname to an **IPv4 address**.

Example:

```txt
Type: A
Name: @
Value: 203.0.113.10
```

This means:

```txt
example.com → 203.0.113.10
```

Another example:

```txt
Type: A
Name: app
Value: 203.0.113.10
```

This means:

```txt
app.example.com → 203.0.113.10
```

IPv4 addresses look like this:

```txt
192.0.2.10
203.0.113.25
198.51.100.50
```

An A record is still the most common record used to point a website or app to a VPS, dedicated server, load balancer, or hosting provider.

---

### What Is an AAAA Record?

An **AAAA record** points a hostname to an **IPv6 address**.

Example:

```txt
Type: AAAA
Name: @
Value: 2001:db8::10
```

This means:

```txt
example.com → 2001:db8::10
```

IPv6 addresses look longer and use colons:

```txt
2001:db8::1
2606:4700:4700::1111
```

The simple difference is:

```txt
A record    = points to IPv4
AAAA record = points to IPv6
```

If your server has both IPv4 and IPv6, you can have both A and AAAA records for the same hostname. Some visitors may connect over IPv4, while others may connect over IPv6.

---

### Common DNS Names: `@`, `www`, Subdomains, and Wildcards

In many DNS dashboards:

```txt
@ = root domain
```

So this:

```txt
Type: A
Name: @
Value: 203.0.113.10
```

means:

```txt
example.com → 203.0.113.10
```

This:

```txt
Type: A
Name: www
Value: 203.0.113.10
```

means:

```txt
www.example.com → 203.0.113.10
```

This:

```txt
Type: A
Name: app
Value: 203.0.113.10
```

means:

```txt
app.example.com → 203.0.113.10
```

A wildcard record looks like this:

```txt
Type: A
Name: *
Value: 203.0.113.10
```

That can catch many undefined subdomains, such as:

```txt
anything.example.com
test.example.com
client1.example.com
```

Cloudflare also supports wildcard DNS records, including proxied wildcard records, and shows examples using placeholder IPs like `192.0.2.1` for wildcard records. ([Cloudflare Docs](https://developers.cloudflare.com/dns/manage-dns-records/reference/wildcard-dns-records/?utm_source=chatgpt.com "Wildcard DNS records"))

---

### What TTL Means

**TTL** means **Time To Live**.

It tells DNS resolvers how long they should cache a DNS answer before checking again.

Example:

```txt
TTL: 300 seconds
```

That means DNS resolvers may cache the record for about 5 minutes.

A shorter TTL helps changes spread faster. A longer TTL reduces repeated DNS lookups but can make migrations slower.

For Cloudflare proxied records, the TTL is normally set to **Auto**, and Cloudflare says proxied records use a short automatic TTL of 300 seconds. ([Cloudflare Docs](https://developers.cloudflare.com/dns/proxy-status/?utm_source=chatgpt.com "Proxy status - DNS"))

---

## DNS-Only vs Cloudflare Proxied Records

If you use Cloudflare, an A or AAAA record can usually be set to either:

```txt
DNS only
```

or:

```txt
Proxied
```

This matters a lot.

---

### DNS-Only Records

A **DNS-only** record means Cloudflare simply answers DNS queries with the real IP address you entered.

Example:

```txt
Type: A
Name: app
Value: 203.0.113.10
Proxy: DNS only
```

When someone looks up:

```txt
app.example.com
```

they get:

```txt
203.0.113.10
```

That means your real VPS or dedicated server IP is visible.

Cloudflare’s own documentation says that when a record is DNS-only, Cloudflare responds with the actual origin IP address and does not route HTTP/HTTPS traffic through Cloudflare’s network. ([Cloudflare Docs](https://developers.cloudflare.com/dns/proxy-status/?utm_source=chatgpt.com "Proxy status - DNS"))

---

### Proxied Records

A **proxied** record means Cloudflare hides the real origin IP from normal DNS lookups.

Example:

```txt
Type: A
Name: app
Value: 203.0.113.10
Proxy: Proxied
```

Visitors do not normally see:

```txt
203.0.113.10
```

Instead, DNS returns Cloudflare IP addresses. The visitor connects to Cloudflare first, and Cloudflare connects to your origin server behind the scenes.

Cloudflare states that proxied DNS records hide the origin server IP because requests resolve to Cloudflare anycast IP addresses instead. ([Cloudflare Docs](https://developers.cloudflare.com/learning-paths/prevent-ddos-attacks/baseline/proxy-dns-records/?utm_source=chatgpt.com "Proxy DNS records · Cloudflare Learning Paths"))

This is the key reason many people use Cloudflare in front of a VPS or dedicated server.

---

## Dummy IPs: When You Do Not Want to Hook Up the Real IP Yet

Sometimes you want to create a DNS record before you are ready to point it to the real server.

Common reasons include:

```txt
You are preparing the domain before launch.
You are creating a redirect rule.
You are setting up a parked domain.
You are using Cloudflare Workers or rules.
You want the hostname to exist, but you do not want to expose the real server IP yet.
```

In that case, you may use a **dummy IP** or **placeholder IP**.

But you should not use a random IP address.

Do **not** invent something like:

```txt
1.2.3.4
8.8.8.8
123.123.123.123
```

Those may belong to real companies or real infrastructure.

Instead, use reserved documentation IP ranges.

For IPv4 examples, RFC 5737 reserves these blocks for documentation and examples:

```txt
192.0.2.0/24
198.51.100.0/24
203.0.113.0/24
```

([IETF Datatracker](https://datatracker.ietf.org/doc/html/rfc5737?utm_source=chatgpt.com "RFC 5737 - IPv4 Address Blocks Reserved for ..."))

A common placeholder A record is:

```txt
Type: A
Name: @
Value: 192.0.2.1
Proxy: Proxied
```

For IPv6 examples, RFC 3849 reserves:

```txt
2001:db8::/32
```

for documentation and examples. ([RFC Editor](https://www.rfc-editor.org/rfc/rfc3849?utm_source=chatgpt.com "RFC 3849: IPv6 Address Prefix Reserved for Documentation"))

A placeholder AAAA record could be:

```txt
Type: AAAA
Name: @
Value: 2001:db8::1
Proxy: Proxied
```

Cloudflare also recommends using reserved IP addresses or reserved domain names for placeholder records so you do not accidentally route traffic to infrastructure you do not own. ([Cloudflare Docs](https://developers.cloudflare.com/rules/page-rules/?utm_source=chatgpt.com "Page Rules"))

---

### Important Warning About Dummy IPs

A dummy IP is not a real website backend.

If the record is **DNS-only**, visitors may resolve your domain to the dummy IP and the website probably will not load.

Dummy IPs are most useful when:

```txt
Cloudflare proxy is enabled
and
Cloudflare itself is handling the redirect, Worker, rule, or other edge behavior
```

A common pattern is:

```txt
Type: A
Name: @
Value: 192.0.2.1
Proxy: Proxied
```

Then Cloudflare can match the hostname and apply redirect rules or other Cloudflare-side behavior without exposing your real server IP.

---

## Hiding Your VPS or Dedicated Server IP

If you are running a VPS or dedicated server, your origin IP is valuable information.

Once bots or attackers know the IP, they can bypass your domain name and try to hit the server directly.

For example, instead of visiting:

```txt
https://example.com
```

they may try:

```txt
http://203.0.113.10
https://203.0.113.10
```

Or they may scan that IP for open ports:

```txt
22    SSH
80    HTTP
443   HTTPS
3306  MySQL
8080  custom app
8443  control panel
```

This is why you generally want to avoid exposing the origin IP in the first place.

Cloudflare recommends proxying records when possible to hide origin IPs and provide DDoS protection, and also recommends reviewing DNS-only records to make sure they do not contain origin IP information. ([Cloudflare Docs](https://developers.cloudflare.com/fundamentals/security/protect-your-origin-server/?utm_source=chatgpt.com "Protect your origin server - Cloudflare Fundamentals"))

---

### Why Hiding the IP Later May Be Too Late

If your real server IP has already been exposed, hiding it later does not erase it from the internet.

The IP may already be in:

```txt
botnet target lists
scanner databases
old DNS history
logs
third-party tools
security scans
misconfigured DNS records
old A records
email headers
GitHub repos
public config files
```

Once an attacker has the origin IP, changing your DNS to Cloudflare proxied mode helps new visitors resolve to Cloudflare, but it does not stop someone who already knows the old IP from connecting directly.

That is why the best time to hide the origin IP is **before** launching the website publicly.

---

### Firewalls Help, But They Are Not Magic

You can block traffic at the Linux firewall level using tools like:

```txt
ufw
iptables
nftables
firewalld
```

That helps prevent unwanted traffic from reaching your web app.

But if the attack volume is high enough, your server may still be overwhelmed before the request ever reaches your application.

The server still has to deal with network packets. The CPU, network stack, bandwidth, connection tracking, and firewall rules may still be stressed.

So even if your firewall returns nothing or blocks the request, enough traffic can still cause:

```txt
high CPU
high bandwidth
slow website performance
server instability
crashes
hosting abuse flags
possible suspension
```

This is especially painful on unmanaged VPS or dedicated hosting. Many web hosts consider VPS and dedicated servers to be customer-managed. If your server is overloaded or receiving abuse complaints, they may not help you troubleshoot deeply. Some hosts may simply warn, suspend, or terminate service.

That is why upstream protection matters. Cloudflare, provider-level DDoS protection, floating IP strategies, and strict origin firewall rules are better than relying only on the Linux firewall after the server is already exposed.

---

## Changing the Server IP Is Not Always Easy

If your origin IP gets exposed, one option is to change the server IP.

But whether you can do that depends on your web host.

Some providers make it easy. Others do not.

In some hosting environments, changing the primary IP may require rebuilding, migrating, or wiping the VPS. For example, some hosts may require creating a new VPS or resetting the existing one instead of simply swapping the primary IP.

So you should not assume:

```txt
If my IP gets attacked, I can just change it instantly.
```

Sometimes that is true. Sometimes it is not.

Before launching a serious business site, check whether your host supports:

```txt
primary IP replacement
floating IPs
additional IPv4 addresses
DDoS-protected IPs
snapshots
fast VPS rebuilds
server migration
```

---

## Floating IPs

A **floating IP** is an extra IP address that can be attached to a server.

You usually pay a few extra dollars per month for it, depending on the provider.

The advantage is that you can point DNS to the floating IP instead of the server’s original primary IP.

Example:

```txt
Original server IP: 203.0.113.10
Floating IP:        198.51.100.25
```

You would point your DNS to:

```txt
198.51.100.25
```

not:

```txt
203.0.113.10
```

That way, if the floating IP gets burned, attacked, or exposed, you may be able to detach it and attach a different floating IP, depending on your provider.

But there is an important catch:

```txt
A floating IP does not automatically deactivate or hide the original server IP.
```

Your server still has its primary IP. If the original IP is reachable from the internet, attackers may still be able to hit it directly.

So if you use a floating IP, you should also make sure the original server IP is not accidentally exposed through:

```txt
DNS records
old A records
AAAA records
control panel records
mail records
web server redirects
app config files
API callbacks
GitHub commits
hardcoded URLs
```

You should also configure the server firewall so that public web traffic is only accepted in the way you intend.

Their bots may constantly find your new floating IP so you may be swapping floating IPs every time you notice your CPU gets consistently spiked.

---

## Best Practice: Cloudflare Proxy in Front of Your Server

For most VPS and dedicated server websites, the safer pattern is:

```txt
Visitor → Cloudflare → Origin server
```

Not:

```txt
Visitor → Origin server directly
```

In DNS, that means your website records should usually be proxied:

```txt
Type: A
Name: @
Value: your-origin-ip
Proxy: Proxied
```

```txt
Type: A
Name: www
Value: your-origin-ip
Proxy: Proxied
```

Or:

```txt
Type: AAAA
Name: @
Value: your-origin-ipv6
Proxy: Proxied
```

Cloudflare says proxied records return Cloudflare anycast IPs instead of the origin IP, while DNS-only records return the actual origin IP. ([Cloudflare Docs](https://developers.cloudflare.com/dns/proxy-status/?utm_source=chatgpt.com "Proxy status - DNS"))

That is the main difference:

```txt
DNS-only = exposes origin IP
Proxied  = hides origin IP from normal DNS lookups
```

---

### Does Cloudflare Going Down Expose Your Origin IP?

Normally, no.

If your record is proxied, DNS is supposed to return Cloudflare IPs, not your origin IP. If Cloudflare has an outage or interruption, your site may become unreachable or degraded, but that does not mean Cloudflare suddenly reveals your hidden VPS IP through DNS.

The usual failure mode is:

```txt
Cloudflare has a problem
visitors cannot reach your site correctly
but the DNS answer still does not intentionally expose your origin IP
```

The bigger risk is not “Cloudflare goes down and leaks my IP.”

The bigger risks are:

```txt
You left some records as DNS-only.
You exposed the origin IP before using Cloudflare.
Your server sends headers or redirects revealing the origin.
Your app uses direct-origin URLs.
Your mail records point to the same server IP.
Old DNS history already captured the IP.
The server accepts direct requests from the internet.
```

Cloudflare itself warns that DNS-only records may expose your origin IP and that proxying is required for most security and performance features. ([Cloudflare Docs](https://developers.cloudflare.com/dns/manage-dns-records/troubleshooting/exposed-ip-address/?utm_source=chatgpt.com "Exposed IP addresses - DNS records"))

---

## Recommended Setup for a New VPS Website

A strong setup looks like this:

```txt
1. Create the VPS or dedicated server.
2. Do not publicly share the raw server IP.
3. Add the domain to Cloudflare.
4. Create proxied A/AAAA records.
5. Avoid DNS-only A/AAAA records pointing to the origin.
6. Use dummy placeholder IPs for records that are only needed for redirects or Cloudflare rules.
7. Configure the origin firewall to only allow web traffic from Cloudflare IP ranges where practical.
8. Keep SSH restricted by IP, VPN, Tailscale, or key-based login.
9. Avoid exposing admin panels like 8443, phpMyAdmin, database ports, or app debug ports.
10. Check DNS history and records before launch.
```

Cloudflare recommends allowing Cloudflare IP addresses at the origin server and configuring the firewall to avoid accidentally blocking proxied traffic. ([Cloudflare Docs](https://developers.cloudflare.com/fundamentals/concepts/cloudflare-ip-addresses/?utm_source=chatgpt.com "Allow Cloudflare IP addresses"))

For stricter protection, you can go further and block direct HTTP/HTTPS traffic unless it comes from Cloudflare’s IP ranges.

---

## Simple Mental Model

Use this rule:

```txt
A record    = hostname to IPv4
AAAA record = hostname to IPv6
DNS-only    = reveals the IP you entered
Proxied     = routes through Cloudflare and hides the origin IP
Dummy IP    = placeholder when you do not want to connect the real server yet
Floating IP = movable extra IP, but does not remove the original server IP
```

The safest habit is:

```txt
Do not expose your real VPS or dedicated server IP unless you truly need to.
```

Once the IP is scraped, scanned, indexed, or placed on a bot list, hiding it later may not fully protect you. Cloudflare proxying is best used from the beginning, before the origin IP becomes public.