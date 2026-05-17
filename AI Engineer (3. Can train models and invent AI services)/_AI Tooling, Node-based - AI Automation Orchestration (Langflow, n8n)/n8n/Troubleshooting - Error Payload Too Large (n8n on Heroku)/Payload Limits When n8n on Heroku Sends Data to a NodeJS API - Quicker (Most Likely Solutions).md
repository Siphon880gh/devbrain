
## How it looks

Looking back at Execution logs:
![[Pasted image 20260517062506.png]]

Drilling in:
![[Pasted image 20260517062522.png]]

---

## Underlying Reason


In n8n when a http request node complains payload too large (with a method set to "POST" and a "Send Body" option on so you're sending JSON information over)... it's the receiving api endpoint it sent payload to.

If there's Cloudflare protecting the api endpoint, then you also have to consider Cloudflare's limits:
- Free is 120seconds / 100mb

The HTTP Request is equivalent to a POST with request body:

Payload's Send Body option, and the fields that followed it refers to values:
![[Pasted image 20260517063258.png]]

Scrolling up shows the method is "POST":
![[Pasted image 20260517063900.png]]

---
## Approach 1

If it's an API endpoint, you can:
- Highest effort
- API will receive multiples until done signal
- How to find out what’s the actual payload limit? 
	- Isolate test with a small circuit of random text with known character length to an api endpoint on the server (will have to setup an api endpoint to respond with “hi” but receives the request payload)
	- You can use an API tester like Postman instead of n8n to test directly.

Even if you have Cloudflare protecting the endpoint, by splitting the requests, you're unlikely to hit that 120 seconds / 100 mb limit anyways.

---
## Approach 2

If the API endpoint is NodeJS, change the limit on express server:
- Lowest effort
- Adjust limits at the express server.js:

```
// Middleware

app.use(cors());
app.use(express.json({ limit: "10mb" }));
app.use(express.urlencoded({ limit: "10mb", extended: true }));
```

### Approach 2 + Cloudflare?

You would still have to go through Cloudflare’s limits. 

Will your n8n's HTTP Request performing a POST to send data take longer than 120 seconds or exceed 100mb of data? If not, you can skip these Cloudflare steps.

Cloudflare steps:

One option is to add a rule that bypasses Cloudflare proxying when the request comes from n8n’s server to your API endpoint. In theory, if the n8n server is never exposed publicly, and even if it is exposed, there is no direct public URL that triggers this POST request from n8n to the api endpoint, then your API endpoint’s IP should not be exposed if you are worried about it being added to a botnet. Check whether the API endpoint is on the same domain as a public website. If it is, create a separate subdomain and set that subdomain to **DNS Only** in Cloudflare. That leaves you vulnerable to having the VPS or dedicated server's IP being saved to botnet (and then you'll be hit with 100k scrapers/bots a day).

In theory, no one would know about that subdomain to scan for the IP, but technically, once you issue an SSL certificate for it, the subdomain can still become visible through public certificate logs, and then it can be scanned for its IP. To reduce the chance of it being discovered and saved by a botnet, immediately return a **403** on unwanted subdomain requests especially to the front page url `/`, and make sure the API endpoint path is not obvious. For example, instead of using something like `domain.com/api/...`, use a harder-to-guess path like `domain.com/abc123/api`, where the URL includes a very unique string. But if you want to harden it further, make those api endpoints protected (requiring a special authorization token) because n8n is perfectly capable of sending header with authorization token.




