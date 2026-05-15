## Floating IPs for VPS/Dedicated Servers: What They Are and Their Limitations

A **floating IP** is an extra public IP address that can be attached, detached, or moved between servers, depending on your hosting provider.

It is useful when you want a more flexible IP address for your website or application.

For example:

```
Original server IP:  1.2.3.4
Floating IP:         5.6.7.8
```

Your server can receive traffic from both IP addresses, but your website files still live on the same server.

---

## Does Adding a Floating IP Wipe the Server?

No.

Adding a floating IP does **not** wipe your VPS or dedicated server.

It does not:

```
Delete website files
Reinstall the operating system
Format the disk
Reset your database
Remove your Nginx/Apache config
Erase your SSL certificates
```

Think of it like this:

```
Your server files = the house
Original IP = the original address
Floating IP = an extra address sign pointing to the same house
DNS = the phone book telling visitors which address to use
```

The floating IP is a **networking change**, not a file/disk change.

---

## Why Use a Floating IP?

A floating IP is commonly used when you want the ability to move traffic between servers more easily.

For example, you may have:

```
Server A: current production server
Server B: backup or replacement server
Floating IP: public IP used by your website
```

Your DNS points to the floating IP:

```
example.com → 5.6.7.8
```

If Server A has problems, you can move the floating IP to Server B.

That way, your domain can continue pointing to the same floating IP, while the floating IP itself moves to another server.

---

## Can You Switch It Back Later?

Yes.

You can usually attach a floating IP, point DNS to it, and later switch DNS back to the original server IP.

Example:

```
Day 1:
example.com → 5.6.7.8

Day 2:
example.com → 1.2.3.4
```

This should not affect your website files.

The main thing to watch is **DNS caching**. Some visitors may still hit the old IP for a while depending on the DNS TTL.

---

## Useful Case: Temporarily Bypassing Cloudflare for One-Time Tasks

A floating IP can be useful when your website normally runs behind Cloudflare, but you need to temporarily bypass Cloudflare for an one-time large or long-running task, eg. Wordpress Migrations All-In-One

Cloudflare is great for protection, caching, and hiding your origin IP, but it also has proxy limits. For example, Cloudflare’s Free/Pro upload limit is **100 MB**, and long requests can hit timeout limits. Cloudflare’s current docs list a default **120-second Proxy Read Timeout.**

This matters for one-time tasks like:

```
WordPress All-in-One WP Migration imports
Large WordPress backup restores
Large database imports
Large media uploads
Long-running admin scripts
```

For these jobs, you may temporarily bypass Cloudflare by pointing a DNS-only record to the floating IP:

```
Normal setup:
example.com → Cloudflare proxy → server

Temporary migration setup:
migration.example.com → DNS-only → floating IP → same server
```

The reason to do this is simple:

```
Cloudflare is great for normal public traffic.
Direct DNS-only access is sometimes better for one-time large uploads or long-running migration tasks.
```

After the migration or upload is finished, you can remove the temporary DNS record or switch it back behind Cloudflare.

Important: when you bypass Cloudflare, your server is more directly exposed to the internet. So for a temporary migration subdomain, it is smart to restrict access to your own IP address using Nginx, Apache, UFW, or your provider firewall.

Example idea:

```
Allow your home/office IP
Block everyone else
```

That way, you temporarily bypass Cloudflare’s limits without leaving the migration endpoint open to everyone.

A floating IP can be useful when you normally protect your website behind Cloudflare, but you temporarily need to bypass Cloudflare for a special task.

For example:

```
Normal setup:
visitor → Cloudflare → your server

Temporary migration setup:
visitor/admin tool → floating IP → your server
```

This can help when you need to run long or large operations such as:

```
WordPress All-in-One WP Migration import/export
Large file uploads
Large database imports
Long admin-side scripts
Large backup restoration
Big media uploads
```

Cloudflare has limits that can affect these kinds of operations. Cloudflare currently documents a **120-second default Proxy Read Timeout** before Error 524 can happen when the origin takes too long to respond, and it recommends using a **DNS-only subdomain** for HTTP requests that regularly take over 120 seconds. ([Cloudflare Docs](https://developers.cloudflare.com/fundamentals/reference/connection-limits/ "Connection limits · Cloudflare Fundamentals docs"))

Cloudflare also documents upload-size limits by plan. As of the current Cloudflare docs, Free and Pro show **100 MB**, Business shows **200 MB**, and Enterprise shows **500+ MB**. Cloudflare’s own suggested options for larger uploads include chunking the request, changing the DNS record to **DNS-only**, or upgrading the plan. ([Cloudflare Docs](https://developers.cloudflare.com/support/troubleshooting/http-status-codes/4xx-client-error/error-413/ "Error 413 · Cloudflare Support docs"))

So a temporary floating IP can be helpful like this:

```
Normal public website:
example.com → Cloudflare proxy → origin server

Temporary migration/upload path:
migration.example.com → DNS-only → floating IP → same server
```

Then after the migration is done, you can remove or disable the temporary DNS record.

---

## Important Warning When Bypassing Cloudflare

When you bypass Cloudflare using a **DNS-only record** or direct IP access, your server becomes more exposed to the public internet.

Normally, Cloudflare sits in front of your server:

```
Visitor → Cloudflare → Your server
```

But when you bypass Cloudflare, traffic can reach your server more directly:

```
Visitor → Your server
```

This means automated scanners, bots, and hackers can still discover your server’s IP address.

When you need to bypass Cloudflare for a one-time task, such as a large WordPress migration, large upload, or long-running admin process, a safe approach is:

```
Bypass Cloudflare only when needed.
Restrict access to your own IP if possible.
Keep the bypass temporary.
Remove the DNS-only record or direct IP access when finished.
Move traffic back behind Cloudflare afterward.
```

This helps reduce risk, but it still exposes the IP you point DNS to.

For example, if you do this:

```
migration.example.com → original server IP
```

then your original server IP is now publicly exposed in DNS.

Automated scanners can still find it. Blocking access with `403 Forbidden` may reduce the chance that some systems save your IP as a useful target, but it does not guarantee that. Some scanners may still save and attack any exposed IP, even if it returns `403`.

Also, even blocked requests can still use CPU and server resources, because your server still has to receive the request, process it, and respond.

---

### Even Safer Approach: Use a Floating IP

An even safer approach is to use a **floating IP**, if your web host supports it.

Instead of exposing your original server IP, you expose the floating IP temporarily.

Example:

```
Original server IP:  1.2.3.4
Floating IP:         5.6.7.8
```

Instead of doing this:

```
migration.example.com → 1.2.3.4
```

do this:

```
migration.example.com → 5.6.7.8
```

Now the temporary DNS-only record exposes the floating IP, not your original server IP.

The better flow is:

```
Attach a floating IP to the server.
Point the temporary DNS-only migration subdomain to the floating IP.
Restrict access to your own IP if possible.
Run the migration, upload, or long task.
Remove the temporary DNS record when finished.
Move normal traffic back behind Cloudflare.
Detach or stop using the floating IP if needed.
```

This does not make you invisible. The floating IP is still exposed while you are using it.

But it helps keep your **original server IP** out of public DNS records, which is safer long-term.

---

## Important Limitation: The Original IP Usually Still Works

A floating IP usually does **not** replace or disable the original server IP.

It is usually an **additional public IP**.

So your server may be reachable from both:

```
http://1.2.3.4
http://5.6.7.8
https://example.com
```

This is very important.

If your goal is to hide the original server IP, a floating IP by itself usually does **not** do that.

Someone may still be able to access:

```
1.2.3.4
```

unless you block it.

So you just never expose the original IPs in the DNS records. You expose the floating IP.

---

## What You May Need to Adjust

Even though the files are safe, you may need to adjust your network and web server setup.

### 1. DNS Records

If you want the domain to use the floating IP, update your `A` records:

```
example.com      A      5.6.7.8
www.example.com  A      5.6.7.8
```

If you switch back later:

```
example.com      A      1.2.3.4
www.example.com  A      1.2.3.4
```

For temporary Cloudflare bypassing, you may use a separate DNS-only subdomain:

```
migration.example.com  A  5.6.7.8
```

Then set it to **DNS-only**, not proxied.

---

### 2. Firewall Rules

Make sure your firewall allows web traffic on:

```
80
443
```

Usually this is fine unless your firewall rules are tied to a specific destination IP.

If your goal is to block direct access to the original IP, then you need stronger firewall rules.

For a migration-only floating IP, you may only allow your own IP address.

---

### 3. Nginx or Apache Config

Most web servers listen on all IP addresses by default.

For Nginx, this is usually fine:

```
listen 80;
listen 443 ssl;
```

But if your config is bound to a specific IP, like this:

```
listen 1.2.3.4:443 ssl;
```

then the site may not work properly through the floating IP until you update the config.

Usually, this is better:

```
listen 443 ssl;
```

That means Nginx accepts HTTPS traffic on any IP assigned to the server.

---

## SSL Certificates

SSL certificates are usually tied to the **domain name**, not the IP address.

So if your domain stays the same:

```
example.com
```

your SSL certificate usually still works, even if DNS changes from:

```
1.2.3.4
```

to:

```
5.6.7.8
```

However, Let’s Encrypt renewal must still be able to reach the correct server through the domain’s current DNS.

So if you change IPs often, make sure:

```
example.com → correct active server
/.well-known/acme-challenge/ is reachable
Port 80 is open
Port 443 is open
```

For a temporary migration subdomain, you may need a separate certificate for:

```
migration.example.com
```

---

## Floating IPs Do Not Automatically Hide the Origin Server

This is the biggest limitation.

A floating IP does not automatically protect the original IP.

Bad assumption:

```
I added a floating IP, so nobody can access the original IP anymore.
```

Better understanding:

```
I added a floating IP, but the original IP may still be reachable unless I block it.
```

If someone knows your original IP, they may still try:

```
http://1.2.3.4
https://1.2.3.4
```

---

## How to Block Direct Access to the Original IP

You have a few options.

### Option 1: Block IP-Based Requests in Nginx

You can create a default Nginx server block that rejects requests that do not match your real domain.

Example:

```
server {
    listen 80 default_server;
    server_name _;

    return 444;
}
```

Your real site should be configured separately:

```
server {
    listen 80;
    listen 443 ssl;

    server_name example.com www.example.com;

    root /home/example/htdocs/example.com;
}
```

This helps prevent random visitors from opening the site directly by IP.

---

### Option 2: Use Cloudflare and Block Non-Cloudflare Traffic

If your domain uses Cloudflare proxy, the usual traffic flow is:

```
Visitor → Cloudflare → Your server
```

In that setup, you can configure the server firewall to only allow Cloudflare IP ranges on ports `80` and `443`.

Then this works:

```
Visitor → Cloudflare → Your server
```

But this gets blocked:

```
Visitor → Original IP directly
```

This is one of the better ways to hide and protect your origin server.

---

### Option 3: Provider Firewall

Some providers let you create firewall rules at the cloud/network level.

For example, you may allow:

```
80/443 from Cloudflare only
22 from your personal IP only
```

And block everything else.

This is often cleaner than only relying on the server’s internal firewall.

---

## Floating IPs Are Not the Same as Cloudflare Protection

A floating IP gives you IP flexibility.

Cloudflare proxy gives you origin protection, caching, DDoS shielding, and traffic filtering.

They solve different problems.

```
Floating IP:
Useful for moving traffic between servers or temporarily routing traffic around Cloudflare.

Cloudflare:
Useful for hiding/protecting the origin and filtering traffic.

Firewall:
Useful for deciding who can directly reach your server.
```

A floating IP by itself is not a security shield.

---

## Simple Summary

A floating IP is an extra movable public IP for your VPS or dedicated server.

It does **not** wipe your files.

It does **not** reinstall your server.

It does **not** automatically disable your original IP.

It does **not** automatically hide your origin server.

It is useful for flexible routing, failover, server migration, reducing DNS changes, and temporarily bypassing Cloudflare for large uploads or long-running migration tasks.

But if you want to prevent access to the original IP, you need firewall rules, Nginx/Apache restrictions, Cloudflare origin protection, or provider-level network rules.