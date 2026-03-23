Bots can either attack by your domain name / subdomain OR the server IP. Let's say it's attacking your server IP.

A server IP can end up publicly known to botnets for several ordinary reasons:

**1. The IP was always public by design**  
Any VPS with a public IPv4 address is reachable from the internet. Bots do not need a secret list at first. They can just scan huge ranges of IP addresses and find live servers.

**2. DNS exposed it**  
If the domain ever pointed directly to the VPS before Cloudflare or another proxy was enabled, the IP could have been collected by:

- DNS history services
    
- passive DNS databases
    
- search engine crawlers
    
- third-party scanners
    
- browser/security tools
    

Once recorded, that IP can stay in datasets for a long time.

**3. Email records exposed it**  
If the same server handled mail, records like **MX**, plus mail headers, SMTP banners, or reverse DNS could reveal the IP. Cloudflare does not hide mail routing the way it hides proxied web traffic.

**4. The IP was leaked in logs, headers, or app config**  
A site can accidentally expose its origin IP through:

- direct links to the server IP
    
- redirects
    
- absolute URLs
    
- email headers
    
- API responses
    
- security misconfiguration
    
- a bypass subdomain such as `origin.example.com` or `direct.example.com`
    

**5. The IP belonged to another customer before you**  
VPS providers often reuse IP addresses. If a prior tenant exposed it, got attacked, or ended up on scanning lists, that same IP may keep getting hit after reassignment.

**6. Public scans and threat feeds share findings**  
Security researchers, scanners, attackers, and bot operators all collect lists of responsive IPs. Once your server answers on ports like 80, 443, 22, or 25, it can get added to internal lists for later probing.

**7. Backlinks, datasets, archives, or code leaks revealed it**  
The IP may appear in:

- old DNS zone files
    
- GitHub or config files
    
- cached pages
    
- archived snapshots
    
- analytics/referrer logs
    
- public documentation
    

Even one exposure can be enough.

**8. Direct-IP requests already succeeded once**  
If bots tested the IP and got a valid HTTP response, login page, or recognizable server fingerprint, they may keep revisiting it automatically.

A cleaner way to say it in your article:

> A server IP can become publicly known because it was directly exposed through DNS, email routing, past configuration, reused VPS allocation, or broad internet scanning. Once discovered, the IP may be stored in scanner databases, proxy networks, or attacker lists and continue receiving automated traffic even after protections like Cloudflare are added.

The important idea is that the IP usually does **not** need to be manually “published” by you. Simply being online and reachable is often enough for it to be discovered, recorded, and reused by automated systems. 

If Cloudflare is in place before the server IP is exposed, it can help hide the origin IP as long as the usual origin leaks are not present. If Cloudflare is added only after the IP has already been exposed, the protection may come too late because bots or attackers may continue hitting the server directly. In that situation, you may need to rotate the server’s public IP. Some hosting providers support IP changes or reassignment, but others only issue a new IP when you reprovision the VPS (aka reinstall the operating system wiping your files and database).