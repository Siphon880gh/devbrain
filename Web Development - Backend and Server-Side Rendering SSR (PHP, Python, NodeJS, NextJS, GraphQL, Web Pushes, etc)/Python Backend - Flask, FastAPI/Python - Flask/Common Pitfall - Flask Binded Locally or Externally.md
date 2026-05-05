
If your Flask app isn’t reachable from outside your server, check how you’re starting it:

Corrected:
```python
if __name__ == "__main__":
	# app.run(debug=True)
    app.run(host="0.0.0.0", port=5000, debug=True)
```

- `host="0.0.0.0"` is required to accept external connections
- Without it, Flask binds to `127.0.0.1` (localhost only), so it won’t be accessible from the internet
    

**Quick test:**
- If `domain.tld:5000` doesn’t work, try:
    - `http://X.XX.XX.XX:5000`
- If IP works but domain doesn’t → likely DNS / Cloudflare / proxy issue
- If neither works → likely firewall or binding issue


**Cloudflare Tunnel:**

If using Cloudflare Tunnel which is similar to reverse proxy, making your custom port accessible at a subdomain (without needing additional subdomain in your SSL or needing a CNAME subdomain record):

It expects you to bind locally (so don't bind to 0.0.0.0). Of course this is only an issue for stacks that have control over internet vs local binding, which Flask has control.