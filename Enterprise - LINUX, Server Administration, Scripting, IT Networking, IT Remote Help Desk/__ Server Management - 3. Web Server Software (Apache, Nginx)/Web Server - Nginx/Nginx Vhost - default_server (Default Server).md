If the `Host` value does **not** match any `server_name`, or if the request has **no Host header**, then Nginx sends the request to the **default server** for that `listen` port.

For more information on `Host` value, refer to [[Nginx Vhost - Server_name and the Host Header]]

## Default Server Behavior

If you do not explicitly define a default server, Nginx uses the **first server block** for that port as the default.

Example:

```nginx
server {
    listen 80;
    server_name example.org www.example.org;
}

server {
    listen 80;
    server_name example.net www.example.net;
}

server {
    listen 80;
    server_name example.com www.example.com;
}
```

If none of the `server_name` values match, Nginx routes the request to the first one.

## Explicit `default_server`

You can explicitly choose the default server by adding `default_server` to the `listen` directive:

```nginx
server {
    listen 80 default_server;
    server_name example.net www.example.net;
}
```

Important:

```text
default_server belongs to the listen address/port,
not to the server_name.
```

So the default server is tied to something like:

```text
0.0.0.0:80
example.com:80
[::]:80
```

not just the domain name.

## Multiple Vhosts on Same Port

If multiple virtual hosts listen on the same address and port, Nginx picks the server block based on the `Host` header.

If nothing matches, it uses the default server for that `listen`.

## “Requests by IP Go Here” Setup

If you want requests by IP address, unknown hostnames, or unmatched `Host` headers to go to a specific place, use a default server block:

```nginx
server {
    listen 80 default_server;
    server_name _;
    root /var/www/ip-default;
}
```

This means:

```text
Anything that does not match another server block on port 80
falls into this server block.
```

## Key Takeaway

Use this mental model:

```text
Nginx first looks at the listen IP/port.
Then it checks the Host header.
If Host matches a server_name, it uses that server block.
If Host does not match anything, it uses the default_server for that listen.
```