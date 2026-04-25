## What should've been done at Linux level before Cloudflare

You should put your website behind Cloudflare from the start.

If a site has already been online for a while **without** Cloudflare, first check whether it is already being hit by bots or abusive traffic. If bot traffic is already driving CPU usage up, the better order is usually:
1. **Rotate the server IP**
2. **Then place the site behind Cloudflare**

That matters because if the original IP has already been exposed and picked up by bots, simply adding Cloudflare later may not fully solve the problem. Attackers can keep hitting the old origin IP directly.

There is one major limitation: some hosting providers do **not** let you change the public IP without reprovisioning or rebuilding the VPS, which can wipe the server if you are not careful.

If that is the case, you usually have two choices:
- accept that CPU usage may keep rising over time as bots continue sharing or targeting the exposed server IP
- plan a migration to a fresh server or new host

A safer migration approach is to clone the website, database, and server setup onto a new server that is **not yet public**. Once everything is tested and ready, move the domain to that new server and put it behind Cloudflare before exposing it publicly.

Cloudflare should not be your only layer of protection. You should also restrict inbound traffic so the server only accepts what it actually needs, such as:
- **SSH**
- **Cloudflare proxy traffic**
	- You'll need the list of IPv4 and IPv6 Cloudflare addresses to allow in. Refer to [[Cloudflare IPv4 and IPv6 Addresses to Allow Through Firewall]]

However, where you place those firewall rules matters.

If the server is **already under attack**, applying filtering only at the Linux level using tools like **UFW**, **iptables**, or even **nftables** may still leave your kernel handling a large volume of unwanted traffic. That can still consume significant CPU just from filtering the requests.

Because of that, if your hosting provider offers firewall controls in its own infrastructure panel, it is often better to block traffic there instead of relying only on firewall rules inside the VPS itself (At cpanel/cloudpanel or Linux shell). For example, on a host like Hostinger, set those rules in the provider’s hpanel.

---

## Additional Checks at Cloudflare

- Make sure you didn't turn off the default blocking AI training bots (at Overview), or the Bot flight mode (At Security -> Settings), any DDoS protections (same page)
- Make sure you have your DNS records proxied

---

## Additional Hardening at Cloudflare


- Have Cloudflare block outside US traffic, referring to [[Countries - Restrict, block all other countries]]
- Set Cloudpanel to only accept Cloudflare traffic under the Traffic tab (Setting is at the very bottom). Refer to [[CloudPanel with Cloudflare - Only allow Cloudflare Traffic IP]]
- If you can see bot traffic still gets through Cloudflare, add **non-interactive Cloudflare challenge** on the app URL. If not good enough, you can add an **interactive Cloudflaer challenge**

---

## Appendix: Also harden Nginx itself

Cloudflare and upstream firewall rules help a lot, but it is also worth tightening **core Nginx connection handling** at the origin.

A useful control is `limit_conn`, usually keyed by `$binary_remote_addr`, which limits how many concurrent connections one client IP can hold open. This helps when a single IP tries to open hundreds of connections at once. For example, it is useful against one IP holding open 500 connections. It is **less effective** against highly distributed traffic, such as 1 connection each from 3,000 different IPs. Nginx documents `limit_conn` specifically as a way to limit the number of connections per defined key, commonly per client IP, and notes that in HTTP/2 and HTTP/3 each concurrent request is counted separately for this module. ([Nginx](https://nginx.org/en/docs/http/ngx_http_limit_conn_module.html?utm_source=chatgpt.com "Module ngx_http_limit_conn_module"))

A basic example looks like this:

```nginx
http {
    limit_conn_zone $binary_remote_addr zone=perip:10m;

    server {
        limit_conn perip 20;
    }
}
```

That does **not** replace Cloudflare. It is an extra guardrail at the Nginx layer.

### Make sure Nginx sees the real visitor IP

If your site is behind Cloudflare, Nginx will otherwise see **Cloudflare’s proxy IPs** unless you explicitly restore the original client IP. Cloudflare says the original visitor IP is passed to the origin in the `CF-Connecting-IP` header, and recommends using that header or `True-Client-IP` rather than relying on `X-Forwarded-For`, because those Cloudflare headers contain a single, consistent client IP. ([Cloudflare Docs](https://developers.cloudflare.com/support/troubleshooting/restoring-visitor-ips/restoring-original-visitor-ips/?utm_source=chatgpt.com "Restoring original visitor IPs · Cloudflare Support docs"))

On the Nginx side, this is handled by the `ngx_http_realip_module`, which replaces the client address with the value from a trusted header. The trusted proxy sources are defined with `set_real_ip_from`, and the header to trust is set with `real_ip_header`. ([Nginx](https://nginx.org/en/docs/http/ngx_http_realip_module.html?utm_source=chatgpt.com "Module ngx_http_realip_module"))

A common Cloudflare setup looks like this:

```nginx
http {
    # Trust only Cloudflare proxy IP ranges
    set_real_ip_from 173.245.48.0/20;
    set_real_ip_from 103.21.244.0/22;
    set_real_ip_from 103.22.200.0/22;
    set_real_ip_from 103.31.4.0/22;
    set_real_ip_from 141.101.64.0/18;
    set_real_ip_from 108.162.192.0/18;
    set_real_ip_from 190.93.240.0/20;
    set_real_ip_from 188.114.96.0/20;
    set_real_ip_from 197.234.240.0/22;
    set_real_ip_from 198.41.128.0/17;
    set_real_ip_from 162.158.0.0/15;
    set_real_ip_from 104.16.0.0/13;
    set_real_ip_from 104.24.0.0/14;
    set_real_ip_from 172.64.0.0/13;
    set_real_ip_from 131.0.72.0/22;

    real_ip_header CF-Connecting-IP;
    real_ip_recursive on;
}
```

That way, access logs, rate limits, allow/deny rules, and security decisions can work against the **actual visitor IP** instead of only seeing Cloudflare’s edge IPs. Cloudflare’s docs say the origin otherwise logs a Cloudflare IP by default, while the original client IP is available in `CF-Connecting-IP`. ([Cloudflare Docs](https://developers.cloudflare.com/support/troubleshooting/restoring-visitor-ips/restoring-original-visitor-ips/?utm_source=chatgpt.com "Restoring original visitor IPs · Cloudflare Support docs"))

### Important warning

Do **not** trust arbitrary forwarded-IP headers from the open internet. Only trust headers from known proxy ranges. In practice, that means `set_real_ip_from` should be limited to Cloudflare’s published IP ranges, not to the whole internet. Otherwise the client IP can be spoofed. This follows directly from how Nginx realip works: it only replaces the client address using the specified header when the source is in a trusted range. ([Nginx](https://nginx.org/en/docs/http/ngx_http_realip_module.html?utm_source=chatgpt.com "Module ngx_http_realip_module"))

### Where to place this config

The path is **not always** `/etc/nginx/nginx.conf`.

Common locations are:

- `/etc/nginx/nginx.conf`
- `/etc/nginx/conf.d/*.conf`
- `/etc/nginx/sites-enabled/*`

The exact place depends on the distro, package layout, and hosting panel. The important part is that:

- `limit_conn_zone`, `set_real_ip_from`, `real_ip_header`, and `real_ip_recursive` usually belong in the `http` block
- `limit_conn` is commonly placed in `server` or `location`

Nginx’s docs list `limit_conn_zone` in the `http` context, while `limit_conn` may be placed in `http`, `server`, or `location`. The real IP directives are also valid in `http`, `server`, or `location`, though putting them in `http` is the usual way to apply them broadly. ([Nginx](https://nginx.org/en/docs/http/ngx_http_limit_conn_module.html?utm_source=chatgpt.com "Module ngx_http_limit_conn_module"))

---

If your app is PHP, you may want to throttle based on the same IP making multiple requests in a short time frame. 

The scraper gets served a 429 status code which means too many requests. If it's an actual user clicking too much on the web browser (still bad for our network / cpu), we degrade to friendlier message:

![[throttle.png]]