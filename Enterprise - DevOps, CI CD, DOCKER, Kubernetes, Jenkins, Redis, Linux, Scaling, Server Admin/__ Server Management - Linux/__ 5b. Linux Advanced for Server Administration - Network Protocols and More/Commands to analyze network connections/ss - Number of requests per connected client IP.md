## Snapshot the client IPs hitting port 443

To see whether traffic is coming from a few sources or many distributed addresses, inspect connected client IPs.
```
sudo ss -Htan state established sport = :443 | awk '{
  for (i=1;i<=NF;i++) {
    if ($i ~ /^[0-9a-fA-F.:]+:[0-9]+$/ || $i ~ /^\[[0-9a-fA-F:]+\]:[0-9]+$/) {
      if ($i !~ /:443$/) print $i
    }
  }
}' | sed -E 's/^\[([^]]+)\]:[0-9]+$/\1/; s/^([0-9.]+):[0-9]+$/\1/' | sort | uniq -c | sort -rn | head -20
```

How to interpret it:
- It's a tab separated values on multiple lines outputted to the terminal. The first column is the number of hits from the ip. The right column is the ip.
- A few IPs with very high counts may indicate a **small number of abusive clients**.
- Many different IPs with low counts each can indicate **distributed bot/scanner traffic**.
	- But at a high volume traffic with instant 75-100% CPU usage, then your server’s IP address is likely listed on a public scanning botnet for scraping or is experiencing a targeted DDoS (Distributed Denial of Service) attack. 
- Simply being online and reachable is often enough for it to be discovered, recorded, and reused by automated systems.
- A wide spread of apparently real public IPs is more consistent with **broad internet scanning or distributed HTTPS load** than with one broken browser or one friendly crawler.

Example output. Here’s me being attacked by a botnet:
![[Pasted image 20260321055221.png]]

Discussion:
Based on the sustained volume and repeated requests, it may be consistent with one or more of the following: aggressive scraping of a high-information website, denial-of-service style abuse, malicious competitor activity, or automated data collection/training activity by unknown third parties. 

Looking at the shape, a high volume of many different IPs with 12-22 requests each is likely your domain or IP is now listed on a public scanning botnet for scraping or you are experiencing a targeted DDoS (Distributed Denial of Service) attack. Looking at the ramp up from 12 to 13 to 14... to 22, it's clear this is a sophisticated attack where an automated system pushes the limits to see if it can continue attacking or scraping without crashing your server, and when your server does crash, it will likely wait then restart the scraping effort, knowing the limit of requests. 

Regardless of motive, the effect has been the same: sustained resource exhaustion, service instability, and loss of access to critical systems.