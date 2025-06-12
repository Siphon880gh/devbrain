
In response to your crawler push, the API will send back a JSON representation with a unique request identifier RID. This RID is unique and will help you identify the request at any point in the future.

Example of push response:
```
{ "rid": "1e92e8bff32c31c2728714d4" }
```

By default, you can push up to 30 urls each second to the Crawler.
