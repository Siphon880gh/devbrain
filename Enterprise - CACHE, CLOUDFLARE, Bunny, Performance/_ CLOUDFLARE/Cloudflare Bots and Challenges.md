## Cloudflare Bot Protection Options: Bot Fight Mode, WAF Rules, Challenges, Super Bot Fight Mode, Under Attack Mode, and AI Crawler Controls

In your own experience browsing the web, you have probably seen a Cloudflare “Human Verification” or “Checking your browser” page:

![[Pasted image 20250513051753.png]]

That is Cloudflare challenging the request before letting the visitor reach the website. Cloudflare challenges are security checks used to verify whether a visitor is likely a real human/browser or an automated bot/script. A challenge may run browser checks in the background, or it may ask the visitor to take a small action such as clicking a button or completing a verification step. ([Cloudflare Docs](https://developers.cloudflare.com/cloudflare-challenges/?utm_source=chatgpt.com "Cloudflare challenges docs"))

Some challenges are visible and interactive. 

Others are visible but doesn't require user interaction:

![[Pasted image 20260424205459.png]]  
->  
![[Pasted image 20260424205444.png]]

And others are more seamless and can pass in the background without much user interaction. Cloudflare could send a javascript challenge that only a real web browser can pass.

Cloudflare’s bot protection is not just one feature. It includes several layers: **Bot Fight Mode**, **WAF custom rules**, **Managed Challenges**, **Super Bot Fight Mode**, **Bot Management**, **Under Attack Mode**, **Rate Limiting**, **Turnstile**, **Managed Rules**, and crawler controls for **AI bots / AI training bots**.

---

## Why Bot Protection Matters

Bots can operate at scale. Thousands of automated requests can hit your website for purposes such as:

- Scraping content
    
- Brute-forcing login pages
    
- Looking for vulnerable plugins or outdated software
    
- Spamming forms
    
- Abusing APIs
    
- Launching DDoS attacks
    
- Gathering competitive business intelligence
    
- Crawling content for AI training or answer engines
    

When your DNS record is proxied through Cloudflare, visitors receive Cloudflare IP addresses instead of your origin server’s real IP address. This lets Cloudflare sit in front of your server and filter, cache, optimize, challenge, or block traffic before forwarding clean traffic to your origin. Cloudflare recommends proxying HTTP traffic records so DNS lookups return Cloudflare IPs instead of your origin IP. ([Cloudflare Docs](https://developers.cloudflare.com/dns/manage-dns-records/troubleshooting/exposed-ip-address/?utm_source=chatgpt.com "Exposed IP addresses - DNS records"))

That matters because bad traffic stopped at Cloudflare’s edge does not consume your VPS or dedicated server’s CPU, memory, bandwidth, PHP workers, Node workers, or database connections.

---

# 1. Bot Fight Mode

**Bot Fight Mode** is Cloudflare’s simple bot-protection option. It is designed to detect and mitigate bot-like traffic across your domain. Cloudflare describes Bot Fight Mode as a feature that identifies traffic matching known bot patterns and issues computationally expensive challenges to increase the cost of automated bot traffic. ([Cloudflare Docs](https://developers.cloudflare.com/bots/get-started/bot-fight-mode/?utm_source=chatgpt.com "Get started with Bot Fight Mode"))

This is the easiest bot setting to understand:

> Turn it on, and Cloudflare starts fighting bot-like traffic across the domain.

The tradeoff is that regular Bot Fight Mode is broad. It protects the domain, but it is not very customizable. Cloudflare specifically says you cannot bypass or skip Bot Fight Mode using WAF custom rules or Page Rules because Bot Fight Mode does not run on the Ruleset Engine. ([Cloudflare Docs](https://developers.cloudflare.com/bots/get-started/bot-fight-mode/?utm_source=chatgpt.com "Get started with Bot Fight Mode"))

That means Bot Fight Mode can be useful for a simple website, but it may become a problem if your site has legitimate automated traffic, such as:

- API clients
    
- Payment processor callbacks
    
- Webhooks
    
- Monitoring tools
    
- Mobile app traffic
    
- Automation scripts
    
- Cloudflare Tunnel traffic
    
- Third-party integrations
    

If you need exceptions, regular Bot Fight Mode may be too blunt.

---

# 2. WAF Custom Rules

Cloudflare’s **WAF custom rules** give you more targeted control. Instead of applying one broad bot setting to the whole domain, you can create rules that match specific request patterns and then choose what Cloudflare should do with them. Cloudflare says custom rules let you filter incoming traffic and perform actions such as **Block**, **Managed Challenge**, or **Skip**. ([Cloudflare Docs](https://developers.cloudflare.com/waf/custom-rules/?utm_source=chatgpt.com "Custom rules · Cloudflare Web Application Firewall (WAF) ..."))

For example, you can create WAF rules based on things like:

- IP address
    
- Country
    
- ASN
    
- URL path
    
- Request method
    
- User agent
    
- Headers
    
- Query strings
    
- Known bad patterns
    
- Login or admin paths
    
- API routes
    

This is helpful when you do not want to challenge the whole website.

For example, instead of challenging every visitor, you might only challenge traffic hitting sensitive paths:

```txt
/wp-login.php
/xmlrpc.php
/admin
/login
/api/search
/api/submit
```

You might also block or challenge requests with suspicious traits:

```txt
Empty User-Agent
Fake browser User-Agent
Missing expected custom header
Bad IP range
Known abusive country or ASN
Too many POST requests to login endpoints
```

For most WAF challenge rules, **Managed Challenge** is usually the better default action. Cloudflare recommends Managed Challenges for most WAF rules because Cloudflare can decide the appropriate challenge type instead of forcing every visitor through the same experience. ([Cloudflare Docs](https://developers.cloudflare.com/cloudflare-challenges/challenge-types/challenge-pages/?utm_source=chatgpt.com "Interstitial Challenge Pages"))

A simple way to think about WAF actions:

|Action|Best For|
|---|---|
|**Allow**|Trusted traffic|
|**Managed Challenge**|Suspicious traffic that might still include real users|
|**Block**|Clearly unwanted traffic|
|**Skip**|Trusted traffic that should bypass certain Cloudflare security features|

---

# 3. Interactive vs. Non-Interactive Challenges

Not all Cloudflare challenges feel the same to the visitor.

Some challenges are mostly invisible. The browser performs checks in the background, and the visitor may only see a brief “checking your browser” page.

Other challenges are interactive. The visitor may need to click, wait, or complete a visible verification step.

Cloudflare says most human visitors are automatically verified, but visitors with non-human browser attributes may be required to interact with the challenge. ([Cloudflare Docs](https://developers.cloudflare.com/cloudflare-challenges/challenge-types/challenge-pages/?utm_source=chatgpt.com "Interstitial Challenge Pages"))

In practical terms:

- **Non-interactive or automatic checks** are better for normal visitors because they create less friction.
    
- **Interactive challenges** are stronger but can annoy real users if used too aggressively.
    
- **Managed Challenge** is often the best default because Cloudflare chooses the least disruptive check that still protects the site.
    
- **Block** should be reserved for traffic you are confident is unwanted.
    

---

# 4. Super Bot Fight Mode

**Super Bot Fight Mode** is the more configurable bot-protection option available on paid Cloudflare plans. Cloudflare describes Super Bot Fight Mode as adding configurable actions per bot category and supporting WAF custom rule exceptions. ([Cloudflare Docs](https://developers.cloudflare.com/bots/?utm_source=chatgpt.com "Overview · Cloudflare bot solutions docs"))

This is the important practical difference:

> Regular Bot Fight Mode is broad and cannot be skipped with WAF rules. Super Bot Fight Mode can be skipped in specific cases using WAF custom rules.

Cloudflare says that in parts of your site where you want bot traffic, you can use the **Skip** action in WAF custom rules to specify where Super Bot Fight Mode should not run. ([Cloudflare Docs](https://developers.cloudflare.com/bots/get-started/super-bot-fight-mode/?utm_source=chatgpt.com "Get started with Super Bot Fight Mode"))

That means you can do things like:

- Enable stronger bot protection for most of the website.
    
- Skip Super Bot Fight Mode for trusted API routes.
    
- Skip it for payment processors.
    
- Skip it for uptime monitors.
    
- Skip it for webhooks.
    
- Skip it for known business integrations.
    
- Skip it for requests with a trusted secret header.
    

This makes Super Bot Fight Mode more practical for websites that have both normal visitors and legitimate machine-to-machine traffic.

Cloudflare also warns that if your organization uses Cloudflare Tunnel, you should keep “Definitely Automated” set to Allow, otherwise Super Bot Fight Mode may block tunnel connections and cause failures. ([Cloudflare Docs](https://developers.cloudflare.com/bots/get-started/super-bot-fight-mode/?utm_source=chatgpt.com "Get started with Super Bot Fight Mode"))

---

# 5. Bot Management

For larger organizations, Cloudflare also has **Bot Management**. This is more advanced than Bot Fight Mode and Super Bot Fight Mode.

Cloudflare says Bot Fight Mode and Super Bot Fight Mode do not provide the same granular per-request scoring as Bot Management. Cloudflare also notes that bot score is available to Enterprise customers with Bot Management. ([Cloudflare Docs](https://developers.cloudflare.com/waf/get-started/?utm_source=chatgpt.com "Get started · Cloudflare Web Application Firewall (WAF) docs"))

In simpler terms:

> Bot Management is for businesses that want precise control over bot traffic instead of a basic on/off bot filter.

With Bot Management, you can build more detailed logic, such as:

```txt
If bot score is very low, block.
If bot score is suspicious and path is /login, challenge.
If bot score is suspicious and request is for static assets, allow.
If verified bot is Googlebot, allow.
If unknown bot is scraping too aggressively, rate limit or block.
```

For small sites, Bot Fight Mode or WAF rules may be enough. For bigger sites with APIs, logins, search pages, paid content, user accounts, and business-critical traffic, Bot Management gives more control.

---

# 6. Under Attack Mode

**Under Attack Mode** is the emergency option.

Cloudflare says Under Attack Mode performs additional security checks to help mitigate layer 7 DDoS attacks. It is designed as a last-resort option when a zone is under attack, and it may temporarily pause access to your site and affect analytics. ([Cloudflare Docs](https://developers.cloudflare.com/fundamentals/reference/under-attack-mode/?utm_source=chatgpt.com "Under Attack mode - Cloudflare Fundamentals"))

When Under Attack Mode is enabled, visitors receive an interstitial challenge page before they can access the website. ([Cloudflare Docs](https://developers.cloudflare.com/fundamentals/reference/under-attack-mode/?utm_source=chatgpt.com "Under Attack mode - Cloudflare Fundamentals"))

Use it when your site is actively being overwhelmed.

Do not treat it as your normal everyday setting unless you are okay with more visitor friction. It can interfere with:

- Normal browsing
    
- Third-party analytics
    
- API traffic
    
- Webhooks
    
- Automated integrations
    
- Some non-browser clients
    

A better everyday setup is usually:

1. Use WAF rules for suspicious paths.
    
2. Use rate limiting for repeated abuse.
    
3. Use Bot Fight Mode or Super Bot Fight Mode for broad bot filtering.
    
4. Save Under Attack Mode for active attack situations.
    

---

# 7. Rate Limiting Rules

Bot protection looks at whether traffic appears automated. **Rate limiting** looks at how often requests happen.

Cloudflare rate limiting rules let you define limits for matching requests and choose what happens when those limits are reached. Cloudflare gives examples such as protecting login endpoints from brute-force attacks and limiting API calls. ([Cloudflare Docs](https://developers.cloudflare.com/waf/get-started/?utm_source=chatgpt.com "Get started · Cloudflare Web Application Firewall (WAF) docs"))

This is important because some abusive traffic may look technically valid request-by-request, but the volume gives it away.

For example:

```txt
One login attempt = normal.
500 login attempts in 2 minutes = suspicious.
```

Good places to use rate limiting include:

- `/login`
    
- `/wp-login.php`
    
- `/xmlrpc.php`
    
- `/admin`
    
- `/api`
    
- `/search`
    
- Contact forms
    
- Checkout forms
    
- Signup forms
    
- Password reset pages
    

Rate limiting is especially useful against:

- Brute-force attacks
    
- Credential stuffing
    
- Form spam
    
- API abuse
    
- Scraping bursts
    
- Search endpoint abuse
    

---

# 8. Turnstile

**Cloudflare Turnstile** is different from a full-page Cloudflare challenge.

Instead of challenging the entire website, Turnstile can be embedded into specific forms or actions. Cloudflare describes Turnstile as a way to run challenges anywhere on your site in a less intrusive way, without requiring the use of Cloudflare’s CDN. ([Cloudflare Docs](https://developers.cloudflare.com/turnstile/?utm_source=chatgpt.com "Overview · Cloudflare Turnstile docs"))

This is useful for protecting specific high-risk actions, such as:

- Contact forms
    
- Login forms
    
- Signup forms
    
- Checkout pages
    
- Comment forms
    
- Lead generation forms
    
- Password reset forms
    

A good way to think about it:

> WAF rules protect traffic at the Cloudflare edge. Turnstile protects specific user actions inside your website or app.

For example, you might not want every visitor to be challenged just for reading a blog post. But you may want stronger verification before someone submits a contact form, creates an account, or attempts login.

---

# 9. WAF Managed Rules

Custom WAF rules are rules you write yourself. **Managed Rules** are prebuilt Cloudflare rulesets.

Cloudflare says Managed Rules are pre-configured rulesets that protect against web application exploits, including zero-day vulnerabilities, top attack techniques, stolen or leaked credentials, and sensitive data extraction. ([Cloudflare Docs](https://developers.cloudflare.com/waf/get-started/?utm_source=chatgpt.com "Get started · Cloudflare Web Application Firewall (WAF) docs"))

This is useful because many bots are not just scraping. They are scanning for known weaknesses, such as:

- WordPress vulnerabilities
    
- Plugin vulnerabilities
    
- Admin panel paths
    
- PHP exploits
    
- SQL injection attempts
    
- XSS attempts
    
- Credential leaks
    
- Known CVEs
    

If your website uses WordPress, PHP apps, Node apps, APIs, or common CMS software, WAF Managed Rules can help catch exploit traffic before it reaches your server.

---

# 10. Crawler and AI Training Bot Controls

Cloudflare also has specific controls for crawlers, especially AI crawlers and AI training bots.

This is different from blocking hacking bots. A crawler might not be trying to hack your site, but it can still scrape your content, consume bandwidth, copy your articles, index pages you did not intend to promote, or use your content for AI training and answer generation.

Cloudflare describes AI bots as bots related to uses such as training language models or generating search answers. Cloudflare says site owners can opt into a managed rule that blocks known AI crawlers categorized as AI Bots. ([Cloudflare Docs](https://developers.cloudflare.com/bots/concepts/bot/?utm_source=chatgpt.com "Bots · Cloudflare bot solutions docs"))

This matters if you are worried about:

- AI crawlers scraping your content
    
- Answer engines using your content
    
- Training-data extraction
    
- Large-scale content harvesting
    
- Bots ignoring `robots.txt`
    
- Crawlers consuming bandwidth without sending useful traffic back
    

---

## Block AI Bots

Cloudflare has a **Block AI Bots** setting. When activated, Cloudflare says it blocks verified bots classified as AI crawlers, along with some unverified bots that behave similarly. ([Cloudflare Docs](https://developers.cloudflare.com/bots/additional-configurations/block-ai-bots/?utm_source=chatgpt.com "Block AI Bots"))

Use this when you want a broad setting to reduce AI crawler access to your site.

This is useful against crawlers that may use your content for:

- AI training
    
- AI search answers
    
- Dataset building
    
- Content extraction
    
- Large-scale scraping
    

A simple way to explain it:

> Bot Fight Mode is for general bot traffic. Block AI Bots is specifically for AI-related crawlers and AI training-style traffic.

---

## AI Crawl Control

For more granular control, Cloudflare has **AI Crawl Control**. Cloudflare says AI Crawl Control lets you manage AI crawlers, analyze AI traffic, track `robots.txt`, identify crawlers that violate your directives, and use Pay Per Crawl. ([Cloudflare Docs](https://developers.cloudflare.com/ai-crawl-control/?utm_source=chatgpt.com "AI Crawl Control"))

This is important because you may not want to block every crawler.

For example, you may want to:

- Allow Googlebot for SEO.
    
- Allow Bingbot for search visibility.
    
- Allow certain AI search crawlers if they send referral traffic.
    
- Block AI training crawlers that provide no benefit.
    
- Block unknown or aggressive crawlers.
    
- Block crawlers hitting too many pages too quickly.
    

So instead of thinking only in terms of “block all bots,” a better approach is:

> Allow crawlers that help your business. Block crawlers that scrape, abuse, or extract value without benefit.

---

## Managed robots.txt

Cloudflare also has a managed `robots.txt` setting for AI bot traffic. Cloudflare says this setting generates and maintains a `robots.txt` file that instructs known AI crawlers to stay away from your content. ([Cloudflare Docs](https://developers.cloudflare.com/bots/additional-configurations/managed-robots-txt/?utm_source=chatgpt.com "robots.txt setting · Cloudflare bot solutions docs"))

However, `robots.txt` is not true security. It is a directive. Good crawlers may follow it, but bad crawlers can ignore it.

So think of it this way:

|Tool|Purpose|
|---|---|
|`robots.txt`|Tells crawlers what you prefer|
|Block AI Bots|Broadly blocks AI-related crawlers|
|AI Crawl Control|Lets you monitor and manage AI crawler activity|
|WAF rules|Lets you create custom crawler restrictions|
|Rate limiting|Slows down aggressive crawlers|
|Origin lockdown|Prevents direct-to-server bypass|

---

## AI Labyrinth

Cloudflare also has **AI Labyrinth**, which is designed for AI crawlers that do not follow recommended guidance.

Cloudflare says AI Labyrinth adds invisible links with `nofollow` tags to block AI crawlers that crawl without permission. Crawlers that scrape without permission can get stuck in a maze of never-ending links, and their details are recorded and used by Cloudflare customers who choose to block AI bots. ([Cloudflare Docs](https://developers.cloudflare.com/bots/additional-configurations/ai-labyrinth/?utm_source=chatgpt.com "AI Labyrinth - Bots"))

This is useful against crawlers that ignore normal rules and keep scraping anyway.

---

## Be Careful Not to Block Good Crawlers

One important warning: do not blindly block every crawler unless you understand the tradeoff.

Some crawlers are useful, such as:

- Googlebot
    
- Bingbot
    
- Search engine crawlers
    
- SEO audit tools you intentionally use
    
- Uptime monitors
    
- Partner integrations
    
- Payment/webhook services
    
- Your own automation tools
    

For SEO-sensitive websites, the better strategy is usually:

> Block unwanted AI training bots and aggressive scrapers, but allow legitimate search crawlers that help people find your website.

---

# 11. The Most Important Limitation: Origin IP Exposure

Cloudflare protects traffic that goes through Cloudflare.

If attackers discover your real VPS or dedicated server IP and send traffic directly to that IP, they can bypass Cloudflare. Cloudflare warns that if a DNS-only record points to the same origin server as a proxied record, DNS queries can reveal the origin IP and make it easier for attackers to target the server directly. ([Cloudflare Docs](https://developers.cloudflare.com/dns/manage-dns-records/troubleshooting/exposed-ip-address/?utm_source=chatgpt.com "Exposed IP addresses - DNS records"))

That means Cloudflare bot protection works best when:

1. Your DNS records are proxied through Cloudflare.
    
2. Your real origin IP is not publicly exposed.
    
3. Your server firewall blocks direct web traffic that does not come from Cloudflare IP ranges.
    
4. You avoid exposing the origin IP through DNS-only records, mail records, old DNS history, or server misconfiguration.
    

Cloudflare recommends allowing Cloudflare IP addresses at the origin web server and reviewing DNS-only records to avoid leaking origin IP information. ([Cloudflare Docs](https://developers.cloudflare.com/fundamentals/concepts/cloudflare-ip-addresses/?utm_source=chatgpt.com "Allow Cloudflare IP addresses"))

This is especially important for VPS and dedicated servers. If your server IP gets added to a botnet’s scrape or attack list, hiding the IP later may not fully solve the problem. You may need to rotate the IP, use a floating IP if your host supports it, or firewall the origin so only Cloudflare can reach ports 80 and 443.

Also watch out for mail records. Cloudflare warns that if your mail server is on the same IP as your web server, your MX record can expose the origin IP because mail traffic is not hidden behind the Cloudflare proxy. ([Cloudflare Docs](https://developers.cloudflare.com/dns/manage-dns-records/troubleshooting/unexpected-dns-records/?utm_source=chatgpt.com "Unexpected DNS records"))

---

# Recommended Layered Setup

A strong everyday Cloudflare setup could look like this:

## 1. Proxy your website DNS records

Use Cloudflare proxied DNS records for your website so visitors connect to Cloudflare first instead of directly to your origin server. Cloudflare recommends proxying HTTP traffic records so DNS lookups return Cloudflare IPs instead of your origin IP. ([Cloudflare Docs](https://developers.cloudflare.com/dns/manage-dns-records/troubleshooting/exposed-ip-address/?utm_source=chatgpt.com "Exposed IP addresses - DNS records"))

## 2. Use bot protection

Enable Bot Fight Mode if you want simple protection and do not need exceptions.

Use Super Bot Fight Mode if you need stronger bot controls and the ability to create WAF Skip rules for trusted traffic.

Use Bot Management if you need granular bot scoring and endpoint-specific bot logic.

## 3. Create WAF rules for suspicious traffic

Create WAF custom rules for suspicious paths and request patterns. Cloudflare custom rules can filter traffic and apply actions such as Block, Managed Challenge, or Skip. ([Cloudflare Docs](https://developers.cloudflare.com/waf/custom-rules/?utm_source=chatgpt.com "Custom rules · Cloudflare Web Application Firewall (WAF) ..."))

Good targets include:

```txt
/wp-login.php
/xmlrpc.php
/admin
/login
/api
/search
```

## 4. Add rate limiting

Add rate limits to login pages, API endpoints, forms, and search pages. Rate limiting helps when traffic is technically valid but excessive in volume.

## 5. Use Turnstile on forms

Use Turnstile on forms where bots are likely to submit data, such as contact forms, signups, logins, comments, and checkout pages. Turnstile is designed to run challenges in a less intrusive way than full-page challenge pages. ([Cloudflare Docs](https://developers.cloudflare.com/turnstile/?utm_source=chatgpt.com "Overview · Cloudflare Turnstile docs"))

## 6. Enable Managed Rules

Enable relevant WAF Managed Rules, especially if you run WordPress, PHP apps, or common CMS/software stacks. Managed Rules are prebuilt protections against common web application attacks and exploit attempts. ([Cloudflare Docs](https://developers.cloudflare.com/waf/get-started/?utm_source=chatgpt.com "Get started · Cloudflare Web Application Firewall (WAF) docs"))

## 7. Control AI crawlers and AI training bots

Use Cloudflare’s AI crawler controls if you want to block or manage AI training bots, answer-engine crawlers, and aggressive scrapers.

Depending on your Cloudflare setup, this may include:

- Block AI Bots
    
- AI Crawl Control
    
- Managed `robots.txt`
    
- AI Labyrinth
    
- WAF rules for specific crawler behavior
    
- Rate limiting for aggressive crawlers
    

## 8. Save Under Attack Mode for emergencies

Save Under Attack Mode for emergencies when your site is actively under heavy layer 7 attack. Cloudflare describes it as a last-resort mode that performs additional checks and shows visitors an interstitial page. ([Cloudflare Docs](https://developers.cloudflare.com/fundamentals/reference/under-attack-mode/?utm_source=chatgpt.com "Under Attack mode - Cloudflare Fundamentals"))

## 9. Lock down your origin server

Lock down the origin server so ports 80 and 443 only accept traffic from Cloudflare IP ranges and any trusted partners or services. Otherwise, attackers who discover your real server IP may bypass Cloudflare and hit your server directly.

---

# Simple Summary

Cloudflare gives you multiple bot-protection layers:

|Feature|Best For|
|---|---|
|**Bot Fight Mode**|Simple free bot protection across the domain|
|**WAF Custom Rules**|Targeted blocking/challenging by path, IP, header, country, method, etc.|
|**Managed Challenge**|Letting Cloudflare decide the least disruptive challenge|
|**Super Bot Fight Mode**|Paid bot protection with better control and WAF Skip exceptions|
|**Bot Management**|Enterprise-level bot scoring and granular control|
|**Under Attack Mode**|Emergency layer 7 attack mitigation|
|**Rate Limiting**|Stopping repeated abuse, brute force, scraping bursts, and API abuse|
|**Turnstile**|Protecting forms and specific user actions|
|**Managed Rules**|Prebuilt protection against common web exploits|
|**Block AI Bots**|Blocking known AI crawlers and AI-training-related bots|
|**AI Crawl Control**|Monitoring and managing AI crawler activity|
|**Managed robots.txt**|Telling known AI crawlers not to crawl your content|
|**AI Labyrinth**|Trapping AI crawlers that ignore rules and scrape without permission|
|**Origin Lockdown**|Preventing attackers from bypassing Cloudflare directly|

The strongest setup is not just one toggle. It is a layered approach: proxy your DNS through Cloudflare, use WAF rules and rate limiting for targeted abuse, use bot protection for automated traffic, add Turnstile to forms, enable managed rules for exploit attempts, control AI crawlers and training bots, and lock down the origin server so attackers cannot bypass Cloudflare.