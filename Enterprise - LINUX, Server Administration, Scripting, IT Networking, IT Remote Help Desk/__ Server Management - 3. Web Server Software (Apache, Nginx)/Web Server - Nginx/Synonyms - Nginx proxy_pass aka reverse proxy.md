Regardless Nginx or Apache, there is a setup called **reverse proxy**.

But inside an Nginx vhost config, the key directive starts with `proxy_pass`

For example:
```
location /v1/api/ {  
	proxy_pass http://127.0.0.1:3000;  
}
```

Therefore, reverse proxy is aka as proxy_pass