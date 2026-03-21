# Why a VPS sees bot traffic

## It is not always a personal attack

A bot attack can happen for several reasons, and it does not always mean someone is personally targeting your business.

## Public IPs are constantly discovered

One common reason is that a VPS has a public IP address exposed to the internet. Public-facing servers are constantly discovered and probed by automated systems that scan large ranges of IP addresses looking for websites, open ports, login pages, admin panels, outdated software, or known vulnerabilities. In that situation, the traffic may not even be about your domain name. The bots may simply be hitting the server because they found the IP.

## When the direct IP bypasses domain-level protection

Another possibility is that the VPS IP was exposed before protections like Cloudflare were added, or the IP may have been indexed, logged, cached, shared, or reused from a previous tenant. Once a direct server IP becomes known, bots can continue sending requests straight to the machine instead of going through the domain. That means domain-level protection can be bypassed unless ports such as 80 and 443 are restricted so only Cloudflare’s IP ranges can reach them.

## Internet-wide scanning is normal noise on public servers

A large share of suspicious traffic comes from broad internet-wide scanning. This is common on public servers. Attackers and automated systems continuously probe the internet for anything reachable, often checking for common files, CMS paths, exposed services, weak authentication points, and software weaknesses. In many cases, the server is not being singled out at all. It is simply one of many systems being tested by opportunistic reconnaissance.

## Distributed traffic: many IPs, few requests each

In other situations, the pattern is more distributed. Instead of one IP making thousands of requests, many IPs each make a small number of requests. That often points to scanner networks, botnets, proxy networks, or distributed abusive traffic. This is why many different IPs with low counts each can still be serious. The goal is to spread requests across many sources so that simple IP-based blocking becomes less effective while the total combined traffic still overwhelms the server.

## Scraping, proxies, and commercial automation

Some abusive traffic is tied to scraping or data collection. There are services and networks that make money by gathering website data, running automated requests, or renting proxy access that helps hide the origin of traffic. Some operators use residential or datacenter proxy networks for scraping, ad verification, automation, or mass collection. However, scraping is only one possibility. Not all abusive traffic is commercial scraping, and not every scraper is trying to take a server down.

### How to read the symptoms: scraping versus flood-style abuse

The difference is usually in the effect. Ordinary scraping is often focused on extracting content or data from pages. A denial-of-service style attack is focused on exhausting CPU, sockets, bandwidth, worker processes, or connection tables. When the visible symptom is that the website stops loading, Nginx workers spike, and CPU jumps to 100 percent almost immediately, that pattern is more consistent with abusive flood traffic, application-layer attack traffic, or heavy hostile scanning than with routine scraping alone.

## You appearing as a known IPs, lists, and reuse keep hits coming

A bot attack may also happen because the server IP ended up on a list used by public scanner networks or hostile infrastructure. Once that happens, repeated hits can continue even if the site itself is small or not well known. Some background noise is normal on nearly every public VPS, but if the request volume becomes high enough, even low-count distributed traffic can create real outages.

## Motives are mixed and the pattern alone may not reveal them

This kind of traffic can come from different motives. Some actors are scanning for vulnerable servers. Some are scraping high-information pages. Some are attempting credential attacks or exploit attempts. Some are simply trying to overload a target, disrupt service, or consume resources. In some cases the behavior may be opportunistic, while in others it may be targeted. The pattern alone does not always reveal the motive, but the infrastructure behind it is often distributed by design.

## Why CPU can spike to 100 percent

A sudden spike to 100 percent CPU usage usually means the server is spending its resources trying to process too many malicious or abusive requests at once. Even simple requests can cause major instability if there are enough of them. The load may hit Nginx, PHP, Node.js, Python apps, the kernel networking stack, or all of them together. That is why the website may time out, become unreachable, or even make admin panels fail before the application itself can be properly inspected.

## Bottom line

In short, a bot attack may happen because the server is publicly reachable, the direct VPS IP was exposed, the IP was previously known or reused, automated internet-wide scanners discovered it, or the machine is being hit by a distributed flood of abusive requests. Some of that traffic may be related to scraping or proxy networks, while some may be tied to reconnaissance or denial-of-service activity. The visible result is often the same: too many automated requests exhausting server resources and causing the website or services to become unstable or unavailable.
