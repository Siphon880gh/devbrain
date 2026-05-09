You can modify what IP address a domain name points to on your own computer.

For example, you can tell your computer:

```text
When I type this domain name, send it to this IP address.
```

This can be useful on purpose. For example, you may want a convenient alias for an IP address on your network so it fits your mental model better:

```text
192.168.1.50    printer.local
192.168.1.80    devserver.local
127.0.0.1       myapp.local
```

Instead of remembering:

```text
http://192.168.1.80:3000
```

you can visit:

```text
http://devserver.local:3000
```

But this same technique can also be abused by hackers. Malware can modify the hosts file so that when you type a real website, your computer secretly sends you to the wrong IP address. That can be used for phishing, stealing login credentials, blocking antivirus updates, or hijacking browser traffic.

So this is a powerful local override.

You can **think of it as "local DNS"** if it makes it easier for you to learn this, but technically it is not DNS. The more accurate term is:

```text
hosts file mapping
```

Also commonly called:

```text
hosts file override
local hostname resolution
static host mapping
```

It’s using the hosts file (a local, static name-resolution mechanism) to bypass DNS for that name.

---

## What `/etc/hosts` Does

The hosts file is a local file on your computer that maps hostnames to IP addresses.

On macOS and Linux, it is usually here:

```bash
/etc/hosts
```

On Windows, it is usually here:

```text
C:\Windows\System32\drivers\etc\hosts
```

When you add a line like this:

```text
127.0.0.1       localhosta
```

you are telling your computer:

```text
localhosta points to 127.0.0.1
```

That means `localhosta` now behaves like another name for your own computer. In fact, this makes `http://localhosta` act the same as the `http://localhost`

---

## Editing `/etc/hosts`

On macOS or Linux, open the hosts file with:

```bash
sudo vi /etc/hosts
```

Example entries:

```text
127.0.0.1       localhosta
13.107.213.40   apple.com
13.107.213.40   apple.local
13.107.213.40   idontexist12349876.com
```

In this example:

```text
127.0.0.1       localhosta
```

makes `localhosta` point to your own computer.

These lines:

```text
13.107.213.40   apple.com
13.107.213.40   apple.local
13.107.213.40   idontexist12349876.com
```

make those domain names point to `13.107.213.40`.

That IP is from looking up something like `microsoft.com` on WhatsMyDNS, therefore you are actually pointing apple.com to microsoft.com. The test is to see whether unrelated domain names can be forced to resolve to a Microsoft/Azure-related IP.

Usually, you do **not** need to run any reset command after saving `/etc/hosts`. The change should work right away for new requests.

Visiting one of your defined domains: The web browser may show a Microsoft/Azure broken page, default server page, certificate warning, or “site not found” response because their server is not configured to send a specific page for those domains, nor did they have a default for everything else that looks like their homepage (technically, that error page is the default because it's a catch-all). Some companies may decide to send you to their homepage as a catch all.

---

## Testing a Local Hostname

Start a local app on a port.

Examples:

```text
Node.js / Next.js app: port 3000
Python Flask / Gunicorn app: port 5000
MAMP: port 8888, or whatever port MAMP shows
```

Then visit:

```text
http://localhost:3000
http://localhosta:3000
```

Or for Flask:

```text
http://localhost:5000
http://localhosta:5000
```

Or for MAMP:

```text
http://localhost:8888
http://localhosta:8888
```

Because you added:

```text
127.0.0.1       localhosta
```

your computer now treats `localhosta` as another name (like `localhost`) for `127.0.0.1`.

Important:

```text
The hosts file maps names to IP addresses.
It does not map ports.
```

So you still need to include the port number in the browser URL.

---

## Testing Public and Fake Domains

Now try visiting:

```text
http://apple.com
http://apple.local
http://idontexist12349876.com
```

Because of these entries:

```text
13.107.213.40   apple.com
13.107.213.40   apple.local
13.107.213.40   idontexist12349876.com
```

your computer sends those hostnames to `13.107.213.40`.

This proves the hosts file can override name resolution for:

```text
A real public domain:
apple.com

A local-looking hostname:
apple.local

A fake or nonexistent public domain:
idontexist12349876.com
```

They may all show a Microsoft/Azure broken page, default server page, certificate warning, or “site not found” response because their server is not configured to send a specific page for those domains, nor did they have a default for everything else that looks like their homepage (technically, that error page is the default because it's a catch-all). Some companies may decide to send you to their homepage as a catch all.

That does **not** mean the hosts file failed.

It means your computer successfully reached the IP address, but the web server at that IP was not configured to serve those hostnames.

In other words:

```text
The IP was reached,
but the server’s Nginx, Apache, IIS, or Azure vhost configuration did not recognize that domain name.
```

For clean testing, use `http://` first. If you use `https://`, the browser may show a certificate warning because the domain name and SSL certificate do not match.

---

## This Is Not a Redirect

People may casually say:

```text
I redirected apple.com to another IP.
```

But technically, that is not a web redirect.

A web redirect happens when a server tells the browser:

```text
Go to this other URL instead and change the URL in the address bar
```

A hosts file mapping happens earlier. It changes name resolution:

```text
domain name → IP address
```

So the more accurate wording is:

```text
The domain was resolved to a different IP address through the hosts file.
```

---

## Security Warning: Malware Can Abuse This

Malware often modifies the hosts file to hijack internet traffic.

For example:

```text
123.123.123.123   bankwebsite.com
```

If that line is added, your computer may bypass normal DNS and send `bankwebsite.com` to the attacker’s IP address.

That can be used to:

```text
Send you to a phishing page
Steal login credentials
Block antivirus websites
Block security updates
Hijack browser traffic
Prevent access to security tools
```

So if you ever see strange entries in your hosts file, investigate them.

The hosts file is useful for developers and sysadmins, but it is also a common place for malware to tamper with internet connectivity.

---

## Using a Custom Local Domain with a Remote Nginx Vhost

If you control a remote server, you can use your local hosts file to make a custom hostname point to that server.

For example, on your own computer, edit:

```bash
sudo vi /etc/hosts
```

Add:

```text
123.45.67.89   mywebsite.local
```

Replace `123.45.67.89` with your remote server’s public IP address.

Then on the remote server, configure the Nginx vhost:

```nginx
server {
    listen 80;
    listen [::]:80;

    server_name mywebsite.local;

    root /home/wengindustries/htdocs/wengindustries.com/test-message;
}
```

Put an `index.html` file in that folder:

```html
<h1>Hello from mywebsite.local</h1>
<p>This page is being served from my custom Nginx vhost.</p>
```

Then reload Nginx on the remote server:

```bash
nginx -s reload
```

Now visit from your own browser:

```text
http://mywebsite.local
```

If everything is configured correctly, this works because:

```text
Your local hosts file sends mywebsite.local to the remote server IP.
Your browser automatically sends Host: mywebsite.local.
Nginx reads that Host header and matches server_name mywebsite.local.
```

Side note:

```text
Nginx does not magically know what name you typed.
It looks at the hostname from the HTTP Host header.
Your browser sends that Host header automatically when you visit a URL.
```

So when you visit:

```text
http://mywebsite.local
```

your browser sends something like:

```http
Host: mywebsite.local
```

That is what allows Nginx to match:

```nginx
server_name mywebsite.local;
```

Important distinction:

```text
127.0.0.1   mywebsite.local
```

is for testing a web server running on your **own machine**.

```text
123.45.67.89   mywebsite.local
```

is for testing a vhost on a **remote server**.

You can also test from the command line without editing `/etc/hosts`:

```bash
curl -H "Host: mywebsite.local" http://123.45.67.89
```

For HTTPS testing, the hostname also affects TLS/SNI, so this is better:

```bash
curl --resolve mywebsite.local:443:123.45.67.89 https://mywebsite.local
```

For browser testing, editing `/etc/hosts` is usually the easiest way.

## Apache Equivalent: Using a Custom Local Domain with a Remote Apache VirtualHost

If you control a remote server running Apache, the same idea works.

On your own computer, edit your local hosts file:

```bash
sudo vi /etc/hosts
```

Add:

```text
123.45.67.89   mywebsite.local
```

Replace `123.45.67.89` with your remote server’s public IP address.

Then on the **remote server**, create or edit an Apache VirtualHost config.

On Debian/Ubuntu, Apache vhost files usually live here:

```text
/etc/apache2/sites-available/
```

Example:

```bash
sudo vi /etc/apache2/sites-available/mywebsite.local.conf
```

Then add:

```apache
<VirtualHost *:80>
    ServerName mywebsite.local

    DocumentRoot /home/wengindustries/htdocs/wengindustries.com/test-message

    <Directory /home/wengindustries/htdocs/wengindustries.com/test-message>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Enable the site:

```bash
sudo a2ensite mywebsite.local.conf
```

Then reload Apache:

```bash
sudo systemctl reload apache2
```

On AlmaLinux/Rocky/CentOS-style systems, Apache configs usually live here:

```text
/etc/httpd/conf.d/
```

Example:

```bash
sudo vi /etc/httpd/conf.d/mywebsite.local.conf
```

Use the same vhost config:

```apache
<VirtualHost *:80>
    ServerName mywebsite.local

    DocumentRoot /home/wengindustries/htdocs/wengindustries.com/test-message

    <Directory /home/wengindustries/htdocs/wengindustries.com/test-message>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Then reload Apache:

```bash
sudo systemctl reload httpd
```

Put an `index.html` file in the document root folder:

```html
<h1>Hello from mywebsite.local</h1>
<p>This page is being served from my custom Apache VirtualHost.</p>
```

Now visit from your own browser:

```text
http://mywebsite.local
```

If everything is configured correctly, this works because:

```text
Your local hosts file sends mywebsite.local to the remote server IP.
Your browser automatically sends Host: mywebsite.local.
Apache reads that Host header and matches ServerName mywebsite.local.
```

Side note:

```text
Apache, like Nginx, does not magically know what name you typed.
It reads the hostname from the HTTP Host header.
Your browser sends that Host header automatically when you visit a URL.
```

So when you visit:

```text
http://mywebsite.local
```

your browser sends something like:

```http
Host: mywebsite.local
```

That is what allows Apache to match:

```apache
ServerName mywebsite.local
```

Before reloading, you can test the Apache config:

Debian/Ubuntu:

```bash
sudo apache2ctl configtest
```

AlmaLinux/Rocky/CentOS:

```bash
sudo apachectl configtest
```

Important distinction:

```text
127.0.0.1   mywebsite.local
```

is for testing a web server running on your **own machine**.

```text
123.45.67.89   mywebsite.local
```

is for testing a vhost on a **remote server**.

---

## Summary

You can think of editing `/etc/hosts` as **“local DNS”** because it lets your own computer decide where a domain name should go.

But the real term is:

```text
hosts file mapping
```

or:

```text
hosts file override
```

It lets you locally map a hostname to a specific IP address before normal DNS is used. This is useful for local development, server testing, network aliases, migrations, and vhost debugging.

But the same technique can also be abused by malware to send users to phishing pages or block access to security websites.

By testing these various domain names here, this proves websites that exist on the internet, websites whose TLD dont exist on the internet (apple.local), and websites that dont exist with an internet TLD (idontexist12349876.com) all are properly overridden using hosts file. In other words, the domain name and the TLD (eg. .com or .local) you choose is not restricted by the internet nor does it need to exist on the internet.

