If your website ever gets hacked, there is a good chance it will not begin with a person manually targeting you. More often, it starts with an automated bot scanning the internet for vulnerable websites.

To attackers, a vulnerable website is an opportunity. They may be looking for credit card data, passwords, customer records, admin access, private files, or anything else that can be reused or sold. Even if the passwords on your website are not valuable by themselves, attackers may test the same email-and-password combinations against PayPal, banks, email accounts, marketplaces, and other services. This is called **credential stuffing**, and it works because many people reuse passwords across multiple websites.

There are strong financial incentives behind this. Some attackers specialize in breaking into websites. Others specialize in scraping data, collecting leaked credentials, building target lists, and selling that information on dark web marketplaces or private criminal forums.

For larger brands, the risk can go beyond ordinary cybercrime. If a company is connected to infrastructure, finance, healthcare, government, defense, research, energy, logistics, or valuable technology, it may attract more advanced attackers, including nation-state groups or organized cybercriminals. These attackers may be looking for trade secrets, intellectual property, sensitive data, disruption opportunities, or economic leverage.

The risk also extends to companies you are connected with. If your app integrates with another company through an API, shared login system, payment processor, data pipeline, or backend connection, then a breach in your system could put their systems and data at risk too.

That is why security and compliance become more important as your company grows. Banks, investors, government agencies, enterprise clients, and larger business partners may ask for proof that your app is secure before they trust you with access, data, funding, or contracts. This can include security reviews, **compliance documentation**, penetration testing results, SOC 2 reports, HIPAA-related safeguards, PCI compliance, or other certifications depending on your industry.

At a smaller but still real level, businesses can also be targeted by competitors, angry former employees, extortion groups, or people hired to cause damage. Sometimes the goal is not even to steal data. It may be to take the site offline, damage trust, scrape business leads, spam forms, abuse resources, or create enough trouble that the business loses money.

That is why website security should not be treated as an afterthought. The internet is constantly being scanned. The question is not whether bots will find your website. The question is what they will find when they get there.

## How Automated Scanners Find and Attack Websites

When you put a website, VPS, or dedicated server online, you are not only dealing with human visitors. You are also dealing with automated scanners.

These scanners constantly search the internet for domains, IP addresses, open ports, exposed services, login pages, vulnerable applications, and leaked origin servers. Some scanning is done by legitimate security researchers and monitoring services, but a lot of it is also done by bots, malware networks, scrapers, and attackers.

CISA’s own cyber hygiene service describes vulnerability scanning as continuous monitoring of internet-accessible IPv4 assets to check exposed hosts, risky services, and known vulnerabilities. That gives you a good idea of what both defensive and offensive scanners are looking for: public-facing systems with something interesting exposed. ([CISA](https://www.cisa.gov/cyber-hygiene-services?utm_source=chatgpt.com "Cyber Hygiene Services"))

## Scanners Do Not Need You to Share the Domain Publicly

A common mistake is thinking:

> “Nobody knows this domain yet, so I’m safe.”

That helps, but it is not a guarantee.

Automated scanners can discover targets through many sources, including:

- Wordlists
- Common business names
- Predictable domain patterns
- Newly registered domain feeds
- DNS datasets
- Search engine indexes
- Certificate Transparency logs
- Previously leaked DNS history
- Public subdomain records
- Internet-wide port scanning

Certificate Transparency logs are especially important. They are public logs of issued TLS certificates. A research paper on Certificate Transparency found that CT log data can be used to identify new targets for scanning campaigns within minutes after certificate issuance. ([arXiv](https://arxiv.org/abs/1809.08325?utm_source=chatgpt.com "The Rise of Certificate Transparency and Its Implications on the Internet Ecosystem"))

So even if you never posted your domain anywhere, your domain or subdomain may still become visible once you issue an SSL certificate for it.

## Guessable Domains Are Easier Targets

Some domains are easier for scanners to guess because they use common words, business terms, or predictable naming patterns.

For example:

```txt
mycoolstartup.com
bestairductcleaning.com
aiplumbingtools.com
```

These are more guessable because they use common English words and business phrases.

Compare that with something more obscure:

```txt
zaflorim-8421.com
nuvexa-test-lab.com
```

These are less obvious to a simple dictionary-based guessing system, although they can still be discovered through DNS records, CT logs, search indexes, registrar data, or other public datasets.

This does not mean obscure domains are “secure.” It only means they are less likely to be found by basic wordlist guessing.

## Dictionary-Based Domain Generation Is a Real Technique

Malware and botnet systems sometimes use Domain Generation Algorithms, also called DGAs. These algorithms generate large numbers of domain-like names that infected machines can try to contact for command-and-control instructions. Some DGA systems generate random-looking domains, while others combine dictionary words to create domains that look more legitimate. Research on wordlist-based DGAs specifically discusses malware families that generate domains by pseudo-randomly combining dictionary words. ([arXiv](https://arxiv.org/abs/1811.08705?utm_source=chatgpt.com "Inline Detection of Domain Generation Algorithms with Context-Sensitive Word Embeddings"))

That does **not** mean every attacker is using DGA-style logic to find your website. DGA is more commonly discussed in the context of malware command-and-control infrastructure. But it does confirm the bigger point: using dictionaries, wordlists, and common-word combinations to generate domain names is a real technique.

## The Big Risk: Finding Your Origin IP

If you use Cloudflare proxying, the goal is usually to hide your real server IP behind Cloudflare.

That protection only works well if the origin IP has not already leaked.

Attackers and scrapers may try to find the real IP behind your domain so they can bypass Cloudflare and hit your VPS or dedicated server directly. Once they know the origin IP, turning on Cloudflare later may not fully solve the problem because the attacker can keep sending traffic directly to the server IP.

Common ways an origin IP can leak include:

- Old DNS records
    
- DNS history databases
    
- Direct `A` records before Cloudflare was enabled
    
- Unproxied subdomains
    
- Email server records on the same machine
    
- Exposed staging/test domains
    
- SSL certificate logs revealing subdomains
    
- Apps that return the server IP in headers, errors, or callbacks
    
- Services running on other ports outside Cloudflare
    

This is why it is better to put Cloudflare or another proxy layer in front **before** a domain becomes public or indexed.

## Scanners Also Look for Open Ports

Scanners do not only look at your website. They also scan IP addresses for open ports.

For example, they may check for:

```txt
22    SSH
80    HTTP
443   HTTPS
3306  MySQL
5432  PostgreSQL
6379  Redis
27017 MongoDB
8080  Alternate web app
8443  Admin panel / control panel
```

Once a scanner finds an open port, it can guess what service is running there. Then it can compare that service against known vulnerability lists.

For example:

```txt
Port 22 open  -> try SSH brute force or SSH vulnerability checks
Port 3306 open -> check for exposed MySQL
Port 6379 open -> check for exposed Redis
Port 27017 open -> check for exposed MongoDB
Port 8443 open -> check for exposed admin panels
```

This is why firewall rules matter. If a service is only needed locally, bind it to:

```txt
127.0.0.1
```

instead of:

```txt
0.0.0.0
```

And if a service does not need to be publicly accessible, do not expose it to the internet.

## Scanners Also Check Website Paths

Bots also probe common paths to identify what app you are running.

For example, they may request paths like:

```txt
/wp-admin/
/wp-login.php
/xmlrpc.php
/.env
/.git/config
/admin/
/phpmyadmin/
/server-status
/vendor/
/api/docs
```

These requests help them fingerprint the website.

If they find WordPress paths, they may try WordPress-specific attacks.

If they find Laravel-style files, they may look for exposed `.env` files.

If they find phpMyAdmin, they may try known phpMyAdmin exploits or password attacks.

If they find `/api/docs`, Swagger, or OpenAPI endpoints, they may inspect your API structure.

The scanner’s logic is basically:

```txt
Find technology -> identify version or behavior -> try known attack list
```

## SSH Gets Hit Constantly

SSH is one of the most commonly attacked services on public servers.

Bots often try usernames like:

```txt
root
admin
user
ubuntu
debian
test
deploy
```

They may also try names found from the website itself. For example, if your WordPress site exposes author names, bots may try those author names as SSH usernames too.

So if your WordPress author is:

```txt
weng
```

a bot may eventually try:

```txt
ssh weng@your-server-ip
```

They may also try the same username against:

```txt
/wp-login.php
/wp-admin/
```

That is why it is a bad idea to expose unnecessary usernames publicly.

SANS has long recommended defensive SSH measures such as disabling remote root login, using key-based authentication, disabling password authentication, limiting IP ranges that can connect to SSH, and using brute-force prevention tools. ([SANS Internet Storm Center](https://isc.sans.edu/diary/9031?utm_source=chatgpt.com "Distributed SSH Brute Force Attempts on the rise again"))

## Attackers Rotate IP Addresses

Many brute-force and scanning systems do not hammer you from one IP address.

Instead, they rotate through many IPs.

For example, one IP might only try:

```txt
4 login attempts
```

Then another IP tries 4 more.

Then another IP tries 4 more.

This makes simple IP-based blocking less effective, because no single IP crosses your rate-limit threshold quickly.

This is why you may see logs that look like:

```txt
IP 1: 4 failed SSH attempts
IP 2: 4 failed SSH attempts
IP 3: 4 failed SSH attempts
IP 4: 4 failed SSH attempts
```

Individually, each IP looks minor. Together, it is a distributed brute-force attack.

## Why Cloudflare Helps, But Does Not Fix Everything

Cloudflare can help protect your website by hiding your origin IP, filtering traffic, challenging bots, caching content, and absorbing some malicious requests.

But Cloudflare mainly protects traffic that goes through Cloudflare.

If the attacker knows your real server IP, they may bypass Cloudflare entirely:

```txt
Visitor -> Cloudflare -> Your server
Attacker -> Your server IP directly
```

That is why your origin server should still be locked down.

Good practice includes:

```txt
Only allow HTTP/HTTPS traffic from Cloudflare IP ranges
Keep SSH restricted to your own IP or VPN
Close unused ports
Bind internal services to 127.0.0.1
Disable password SSH login
Disable root SSH login
Use firewall rules
Use fail2ban or similar tooling
Hide or protect admin panels
Avoid exposing staging/test subdomains publicly
Avoid leaking origin IP through old DNS records
```

However some scanners and bots aren't programmed to be efficient with their bandwidth. Even if hit with 403, they may keep hitting you. While your Linux firewall focuses on processing and blocking IPs, a sheer volume of incoming traffic to process will still overwhelm your CPU. That can crash your website and online business, and it can also place you on a potential deletion list with your web host. Usually with root access, the web hots will say that all server management is your responsibility, and they may not have the team with the skills to help you, so their easier policy is to delete or ban you.

If you never place your real IP on DNS records that aren't proxy, you will be 100% be safe. Even safer, if you use floating IPs for your DNS records (but keep in mind floating IPs don't deactivate original IPs, and floating IPs cost a few bucks a month). But if you always had your DNS record pointing to your IP behind a Cloudflare proxy, you will be fine. If Cloudflare service is interrupted on their end, you are still protected because traffic just stops with them.

## Scanners Also Attack Upload Buttons and Input Fields

Bots do not only scan ports and paths. They also interact with website features that accept user input.

They may test:

```txt
File upload buttons
Comment forms
Contact forms
Search boxes
Login forms
Newsletter signup forms
Review forms
Profile update forms
Checkout forms
API fields
```

The reason is simple: any place where a user can submit data is a possible attack surface.

For example, upload forms may be tested for:

```txt
Malicious PHP files
Fake image files with embedded code
Oversized files
File extension bypasses
MIME type bypasses
Path traversal attempts
Malware uploads
Stored cross-site scripting payloads
```

A bot may try to upload something like:

```txt
shell.php
image.php.jpg
invoice.pdf.php
../../malicious-file.php
```

If the website stores the file in a public folder and the server executes it, the attacker may gain control of the site.

This is why upload handling needs strong protection:

```txt
Limit allowed file types
Verify MIME type and file content
Rename uploaded files
Store uploads outside executable directories when possible
Disable script execution in upload folders
Limit file size
Scan uploads when practical
Require authentication for sensitive uploads
```

## Scanners Also Test Text Fields and Database-Connected Forms

Text fields are another major target because many of them eventually touch a database.

Examples include:

```txt
Blog comments
Product reviews
Search bars
Contact forms
Support tickets
User profiles
Checkout notes
Forum posts
Chat boxes
Admin fields
```

Bots may submit attack strings to test for:

```txt
SQL injection
Cross-site scripting
Stored XSS
Command injection
Template injection
NoSQL injection
HTML injection
Spam link injection
Mass form submission
```

For example, a comment form may receive payloads designed to test whether the website improperly stores and displays user-submitted content.

A search box may receive payloads designed to test whether the backend directly inserts the input into a database query.

A contact form may receive spam content, phishing links, or script payloads.

The scanner’s logic is:

```txt
Find input field
Submit test payload
Watch the response
If the response leaks an error or reflects the payload, try stronger attacks
```

This is why form security matters even on simple websites.

Good protection includes:

```txt
Validate input
Sanitize output
Use prepared statements for database queries
Escape user-generated content before displaying it
Add CSRF protection where needed
Rate-limit form submissions
Use CAPTCHA or turnstile challenges on abused forms
Block dangerous file types
Log suspicious submissions
```

## Scanners Harvest Emails, Phone Numbers, and Contact Information

Some bots are not trying to break into the server directly. They are trying to collect information.

They may crawl your website looking for:

```txt
Email addresses
Phone numbers
Staff names
Author names
Physical addresses
Social media profiles
Login usernames
Contact form URLs
Business hours
Technology clues
```

This information can be used for spam, phishing, credential attacks, social engineering, or future scraping campaigns.

For example, if your website publicly lists:

```txt
weng@example.com
(555) 123-4567
Author: weng
```

a bot may use that information to try:

```txt
Email spam
Phishing emails
Password reset abuse
WordPress login attempts
SSH username guessing
Credential stuffing
Fake customer inquiries
```

This is why public contact information should be intentional.

That does not mean you should hide all contact information. Many businesses need visible phone numbers and emails. But you should understand that anything publicly listed can be scraped.

Safer options include:

```txt
Use contact forms instead of exposing direct emails
Use role-based emails like support@example.com instead of personal emails
Protect forms with rate limits and spam filtering
Avoid exposing admin usernames as public author names
Avoid publishing unnecessary staff login names
Monitor form submissions for spam patterns
```

## Other Things Scanners May Look For

You can also add that scanners often look for:

```txt
Exposed .env files
Exposed .git folders
Backup files like backup.zip or site.sql
Old admin panels
Default credentials
Outdated WordPress plugins
Outdated themes
Exposed API documentation
Misconfigured cloud storage
Public database ports
Directory listing
Debug error messages
Server headers revealing versions
```

They are not always looking for one big weakness. Often, they collect many small clues.

A scanner may combine:

```txt
WordPress detected
Author username found
/wp-login.php exists
XML-RPC enabled
Old plugin path found
Email address scraped
Server IP exposed
SSH port open
```

Then it decides which attack path to try next.

## Updated Mental Model

The scanner is not only asking:

```txt
What ports are open?
What software is running?
What vulnerabilities match this server?
```

It is also asking:

```txt
Where can I submit data?
Where can I upload files?
Where can I inject code?
Where can I spam links?
What emails and usernames can I harvest?
What phone numbers can I scrape?
What public information helps me attack later?
```

So the real security mindset is:

```txt
Reduce what scanners can discover.
Reduce what they can reach.
Reduce what they can submit.
Reduce what they can harvest.
Reduce what they can reuse later.
```

That makes the website harder to fingerprint, harder to exploit, harder to scrape, and harder to attack directly.