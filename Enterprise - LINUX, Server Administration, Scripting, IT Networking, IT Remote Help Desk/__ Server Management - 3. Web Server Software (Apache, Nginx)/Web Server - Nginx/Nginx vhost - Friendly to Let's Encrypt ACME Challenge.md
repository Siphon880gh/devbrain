Before HTTPS can work, Let’s Encrypt first needs a way to confirm that your server actually controls the domain. The usual method is to let it check a temporary verification file over plain HTTP on port 80.

Add this inside your **port 80 server block**:
- Make sure it's before any redirects
```nginx
location ^~ /.well-known/acme-challenge/ {
    root /home/wengindustries/htdocs/wengindustries.com/;
    allow all;
    auth_basic off;
}
```

This allows Let’s Encrypt to verify your domain over **HTTP on port 80** before HTTPS is set up.

When you request the certificate, Let’s Encrypt checks a file inside the `/.well-known/acme-challenge/` path. Your server must be able to serve that file publicly over the internet. If Let’s Encrypt can reach it, that proves you control the domain, and it can then issue the SSL certificate for your HTTPS site.

Without this, your vhost setup may force you to temporarily disable or comment out any HTTP-to-HTTPS redirects in the port 80 server block each time you renew or reissue the certificate, just so the ACME challenge file can be reached.

A slightly tighter final sentence would be:

> Without this, some vhost setups will require you to temporarily disable HTTP-to-HTTPS redirects in the port 80 server block whenever you issue or renew the certificate, so the ACME challenge file remains reachable.