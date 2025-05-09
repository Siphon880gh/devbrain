
This guide assumes dedicated server or VPS. For AWS, there are additional tools for security.

---


At the server level, you want to block out ports. iptables / firewalld / ufw etc

Harden at the server/linux level with:
[https://cisofy.com/](https://cisofy.com/)
![[Pasted image 20250508191728.png]]

---

At a web server level you dont want wordpress and web app to be on the same server (go different partitions, for example).

So that being hacked into the app doesn't endanger Wordpress and being hacked into Wordpress doesn't endanger the app (or it's secrets in dot env)

---

At a proxy level - consider Cloudflare

Cloudflare to work on the proxy level (you just change your DNS Zone settings). It’ll help in addition to caching, prevents DDos and block common IPs used for bots to scan for website vulnerabilities:
[https://www.fastly.com/](https://www.fastly.com/)  

Cloudflare just for $20/mo (per domain and subdomains are included free) gives you a proxy you can put in. So it’s just a layer, but it helps you handle DDOS, limit connections, has WAF (web application firewall). Yes does have caching too.
[https://www.cloudflare.com/plans/](https://www.cloudflare.com/plans/)

---



At the code level, you want to prevent xss attacks (cross-site scripting) and file upload bypass vulnerabilities. Easy to remember but not exhaustive:
- Someone cross posting script block so that your public page renders and executes the script block (eg. comments public can see). Usually done through a form
- Can cause a rendering of script block that accesses user’s `document.cookie` and then fetch to a remote url like “[https://evil.com/steal](https://evil.com/steal)”, the intention that even though multiple users would have rendered it, it’s hoping the user’s logged in. Then the token can be used to imitate the user, allowing “staying logged in” on an unauthorized machine. Then they could go access credit card information under billing or hopefully it’s an admin’s session token, and the interface can show more privileged settings

List of web app vulnerabilities (along with their compliance code)
- [https://www.invicti.com/learn/vulnerabilities/](https://www.invicti.com/learn/vulnerabilities/)  
- [https://www.invicti.com/web-vulnerability-scanner/vulnerabilities/](https://www.invicti.com/web-vulnerability-scanner/vulnerabilities/)  

It’s recommended you go through their list carefully and check your code for those vulnerabilities. They have a done for you service. Easier to just get a code scanner.

Scan code level with (untested):
- Sonarsource [https://www.sonarsource.com/products/sonarqube/](https://www.sonarsource.com/products/sonarqube/)  
- Free version here: [https://www.sonarsource.com/open-source-editions/sonarqube-community-edition/](https://www.sonarsource.com/open-source-editions/sonarqube-community-edition/)

---

At a services level, say you have a copy of the code at Github, be careful of committing secrets and .env

FAQ:
If my api key is only on older commits on GitHub, and newer commits don't have it, can hackers still find them? Yes! Hackers have bots on rotating IP addresses that traverse old commits.