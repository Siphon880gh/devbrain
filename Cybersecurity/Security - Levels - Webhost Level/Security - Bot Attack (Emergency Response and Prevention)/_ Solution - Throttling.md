**Note**: This is not the full solution to bot attacks. This is one of the many interventions needed. Refer to [[_ Best Practice - Prevent or Stop Bot Attacks (Linux, Cloudflare, PHP)]] for the other interventions

---

If your app is PHP, you may want to throttle based on the same IP making multiple requests in a short time frame. 

The scraper gets served a 429 status code which means too many requests. If it's an actual user clicking too much on the web browser (still bad for our network / cpu), we degrade to friendlier message:

![[throttle.png]]

**Continue reading at**:
[[PHP - Throttle same IP over short time period]]