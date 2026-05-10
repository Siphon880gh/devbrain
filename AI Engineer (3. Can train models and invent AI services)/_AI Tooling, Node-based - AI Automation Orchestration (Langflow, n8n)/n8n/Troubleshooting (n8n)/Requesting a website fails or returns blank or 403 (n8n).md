
You have a part of n8n go fetch the website content in order to perform logic on or it’s just a scraper

But n8n’s HTTP Request node failed to scrape or read the webpage, and even the AI Agent node could not process it. The AI Agent returns blank information from the website it’s supposed to go get more information from.

HTTP Request Node:
![[Pasted image 20260509225445.png]]

HTTP Request as an AI Agent's Tool:
![[Pasted image 20260509225318.png]]

On closer look at the Executions log, you may see a 403 depending on what the bot fighting mechanism does (Cloudflare Fight Mode would respond with status code 403):
![[Pasted image 20260509224807.png]]

Do you have bot blocking or cloudflare with enhanced settings? If you do NOT control the website, you’ll have to use a third party scraping service whose focus is on circumventing bot blocking and cloudflare with enhanced settings (and you may have to purchase additional IPs for it to rotate, depending on their pricing structure).

You are scanning on the behalf of a client who owns the website? Ask their developer to whitelabel your bot name, eg. “WengScanner”


---

## You control the website source and have FREE Cloudflare?
Normal default Cloudflare doesn’t block n8n as of May 2026 but if you had enabled Bot Fight Mode then it does

If you don’t want to take away Bot Fight Mode, just replace it with WAF that turns on managed challenge if no specific header found. Adjust WAF at Security -> Security Rules. Your n8n fetch node or fetch tool can send that secret header. The secret header would be for example, “Weng Scanner”

Configure your http request node or http request tool node (attached to AI Agent) to send over the secret scanner bot name:
![[Pasted image 20260509224916.png]]

And you setup the WAF to allow the bot to pass through:
![[Pasted image 20260509224930.png]]

Make sure you've turned off Bot Fight Mode since the new WAF rule replaces it (and is better because you can add exceptions such as our scanner):
![[Pasted image 20260509225221.png]]

---

## You control the website source and have PAID Cloudflare?
Normal default Cloudflare doesn’t block n8n as of May 2026 but if you had enabled Bot Fight Mode then it does. 

Because you're on the paid cloudflare, they made it a bit easier to run Bot Fight Mode for all requests except your scanners. You can keep Bot Fight Mode on, but at WAF Rules (Security -> Security Rules), you have expanded actions. Use the same condition as described in the previous section with the FREE Cloudflare. For the action, simply choose "Skip -> Super Bot Fight Mode".

Btw in the paid Cloudflare, Bot Fight Mode is superseded by the Super Bot Fight Mode. It's super because it allows you to customize it further and turn it on/off with WAF rules.

---

## Want to keep Cloudflare settings alone (Not recommended because now you have to touch vhost)

You have Bot Fight Mode on and dont want to touch it. This is the least recommended way because you're editing your vhost and also scanning the IP of your VPS/dedicated server directly.

Example header at HTTP Request:

```
User-Agent: WengScanner/1.0 n8n-heroku
```

You can make n8n scan the origin directly instead of going through Cloudflare.

Examples:

```
https://origin-scan.example.com
```

Set that DNS record to **DNS only**, not proxied through Cloudflare.

But lock it down hard:

```
location / {
    if ($http_user_agent != "WengScanner/1.0 n8n-heroku") {
        return 403;
    }

    proxy_pass http://127.0.0.1:3000;
}
```
^ Syntax: Header names become lowercase and hyphens become underscore lines, and we prefix with $http
^ Let's say the website you're scanning is a NodeJS or NextJS app delivering webpages that you normally reverse proxied.

Even better, also restrict by IP if your n8n instance has a stable outbound IP. This is easier if n8n is self-hosted. If you use n8n Cloud, the outbound IP may not be stable unless your plan or setup provides that.