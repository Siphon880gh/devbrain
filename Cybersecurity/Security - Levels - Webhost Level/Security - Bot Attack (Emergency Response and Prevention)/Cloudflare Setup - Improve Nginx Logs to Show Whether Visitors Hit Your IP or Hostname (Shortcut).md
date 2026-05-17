By default, Nginx access logs usually show the visitor IP, request path, status code, referrer, and user agent. That is useful, but sometimes it is not enough.

You may be attacked/scraped/DDoS and you wonder if it's because they have your VPS / dedicated server's IP. In that case, hiding behind Cloudflare Proxy records won't be enough because your IP is already exposed. You'd have to change the IP (on some webhosts that means wiping your files)

Setup enhanced logs at:
[[Cloudflare Setup - Improve Nginx Logs to Show Whether Visitors Hit Your IP or Hostname]]
