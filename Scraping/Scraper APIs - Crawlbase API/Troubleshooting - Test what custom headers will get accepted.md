
You can test what customer headers can get accepted with Crawler API

Why important: Some webpages that you scrape could expect certain headers so it can present the correct information to your "web browser"

You test like this - note the request_headers:
```
curl "https://api.crawlbase.com/?token=USER_TOKEN&request_headers=accept-language%3Aen-GB%7Caccept-encoding%3Agzip&url=https%3A%2F%2Fpostman-echo.com%2Fheaders"
```

Known request_headers that are not accepted as of 1/2025:
- Accept which lets you override what content (html, png, etc) is expected - that's not supported. Running such endpoint will return a response with the default accept header.

For more information, refer to:
https://crawlbase.com/docs/crawling-api/parameters/#request-headers