When creating **Public API Endpoints or Webhooks**:
- A **public API endpoint** is an endpoint that you intentionally allow other IP numbers, domains, or third-party services to connect to.
- A **webhook** is an endpoint that automation tools, SaaS platforms, or external services need to hit so you can track, trigger, or coordinate something on a server you own.

There are major considerations:
- You may need to add **more permissive CORS rules**, either opening the endpoint to the public, allowing `*`, or only allowing specific whitelisted domains/origins.
	- Proceed to [[Permissible CORS (Open up to the world)]]
- **Behind Cloudflare?** You may need to add a bypass rule for that specific API or webhook URL.
    - Proceed to [[Bypass Cloudflare for public API endpoint or webhook]]