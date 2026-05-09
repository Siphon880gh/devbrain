Nginx chooses which `server {}` block to use mainly by comparing the request’s **Host header** against the configured `server_name`.

Important distinction:

```text
server_name does not match the TCP destination IP.
server_name matches the HTTP Host header.
```

So this can work:

```nginx
server_name 203.0.113.10;
```

But only when the client sends:

```text
Host: 203.0.113.10
```

That usually happens when someone visits:

```text
http://203.0.113.10/
```

because most browsers will set the `Host` header to the IP address.

## How Nginx Routes the Request

If multiple virtual hosts listen on the same address and port, Nginx picks the matching server block based on the `Host` header.

For example:

```text
Host: example.com
```

will match:

```nginx
server_name example.com;
```

And:

```text
Host: 203.0.113.10
```

can match:

```nginx
server_name 203.0.113.10;
```

### Key Takeaway

Use this mental model:

```text
Nginx first looks at the listen IP/port.
Then it checks the Host header.
If Host matches a server_name, it uses that server block.
```

The big correction is:

```text
Putting an IP in server_name does not mean
“match traffic sent to this destination IP.”

It means:
“match requests where the Host header is this IP.”
```

---

## cURL Nuances

Yes — **curl sends a `Host` header automatically** based on the URL you give it.

Example:

```bash
curl -v http://203.0.113.10/
```

Curl will send something like:

```http
GET / HTTP/1.1
Host: 203.0.113.10
```

So this can match an Nginx block like:

```nginx
server {
    listen 80;
    server_name 203.0.113.10;
}
```

### cURL - When you need to manually send the Host header

You need to send a custom `Host` header when you are connecting to one IP address but want Nginx to route the request as if you visited a domain.

Example:

```bash
curl -v -H "Host: example.com" http://203.0.113.10/
```

That means:

```text
TCP destination: 203.0.113.10
HTTP Host header: example.com
```

So Nginx can match:

```nginx
server {
    listen 80;
    server_name example.com;
}
```

### cURL - Definitely mention the Host for https using resolve flag

For HTTPS, do not rely only on `-H "Host: example.com"`.

Use `--resolve` instead:

```bash
curl -v --resolve example.com:443:203.0.113.10 https://example.com/
```

This tells curl:

```text
Use example.com in the URL
But connect to 203.0.113.10
```

That helps with both:

```text
HTTP Host header: example.com
TLS SNI: example.com
```

That matters because HTTPS chooses the certificate before the HTTP `Host` header is even processed.

### cURL - Quick mental model

For plain HTTP:

```bash
curl http://203.0.113.10/
```

sends:

```text
Host: 203.0.113.10
```

And:

```bash
curl -H "Host: example.com" http://203.0.113.10/
```

sends:

```text
Host: example.com
```

For HTTPS virtual host testing, prefer:

```bash
curl --resolve example.com:443:203.0.113.10 https://example.com/
```