Its free tier is very generous: it can help block bot attacks, challenge visitors to verify they are human, hide your origin server’s IP to reduce targeted direct-to-IP attacks, improve performance with caching even on the free plan, and provide free SSL. It also includes free visitor insights, including basic traffic and audience geography data.

Anyone making a website with a directory of information needs it (high chance of bot targetting you with 10k-100k scraping an hour). Anyone who will scale up will need it (caching to reduce hit to CPU/performance). Anyone who uses their website for business should have it (insights). It's free!

Note on bot attacks:
- Bots (thousands) can attack for scraping, DDOS, or sniping a business competition, or helping train an AI for some government (Not gonna say more than that)
- Cloudflare DNS' proxy mode means bots stop at their server before ever affecting your server's CPU. Note however if the bots are attacking at your VPS or dedicated server's IP, then Cloudflare wont stop it - you'd have to rotate your IP address if your hosting provider allows that.