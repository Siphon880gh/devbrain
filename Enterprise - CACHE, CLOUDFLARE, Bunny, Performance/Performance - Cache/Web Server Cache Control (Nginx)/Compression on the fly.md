You can configure your Nginx vhost so certain file types are compressed and saved on the server. The file only gets recompressed when a newer version exists. This can happen on the first request after the file changes.

Common compression options include:
* `gzip`
* `brotli`

You can also set the compression level. For example:

```nginx
gzip_comp_level 2;
```

A compression level of `2` is reasonable for a VPS with:

```text
2 vCPU
8 GB RAM
```

This is usually configured in the main Nginx config file:

```text
/etc/nginx/nginx.conf
```

Be careful with higher compression levels. They can make the first request slower because the server has to work harder to compress the file.

The benefit is that compressed files are smaller, so they are delivered faster to the browser. The browser automatically decompresses them.

Your code still looks like normal files, such as:

```text
.html
.json
.css
.js
```

You do not need to change your file names or mention the compression type in your code.
