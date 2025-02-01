
This attempt at scraping imgur with a proxy that does ip rotation (Crawlbase Proxy API) will **FAIL**:
```
curl -x "http://{JS_TOKEN}@smartproxy.crawlbase.com:8000" -k -o downloaded/8T3CVPq.png "https://i.imgur.com/8T3CVPq.png"
```

This is because of Crawlbase Proxies' limitations:
- None of Crawlbase's products support image scraping as of 1/2025. Even if you add  request_header url parameter to a scraper api endpoint (normally returning html) in order to change accept header to image, it does not support overriding the accept header as tested with crawlbase api’s header testing endpoint
- even their proxies tunneling does not support images and will fail with a vague 500 status code