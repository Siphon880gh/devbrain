You should have all http:// urls redirect to https:// when you already have a SSL

You place this into the :80 and :443 server block:
```
  if ($scheme != "https") {
    rewrite ^ https://$host$uri permanent;
  }
```

But a caveat: While self-signing a SSL, make sure to comment out those lines so that the challenge file that Let's Encrypt creates at the http:// url can be fetched.