
Normal requests:
```
curl -x "http://{NORMAL_TOKEN}@smartproxy.crawlbase.com:8000" -k "URL"  
```

JS aka headless:
```
curl -x "http://{JS_TOKEN}@smartproxy.crawlbase.com:8000" -k "URL"
```

^/^^ You can test the above with URL http://httpbin.org/ip

For more information, read their help document (which will generate the token for you in the help document too)
[https://crawlbase.com/docs/crawling-api/proxy-api-mode/#how-it-works](https://crawlbase.com/docs/crawling-api/proxy-api-mode/#how-it-works)

Reminder: Your tokens are located at
[https://crawlbase.com/dashboard/account/docs](https://crawlbase.com/dashboard/account/docs)