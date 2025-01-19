
Situation: you make a request to Crawlbase Crawler push endpoint. Scraping is successful so sends the scrapped information to your custom webhook (you didn’t setup Crawlbase Storage as where you store scrapped results synchronously).

### Format HTML

This will come when you call the API with the `&format=html`.
```
Headers:  
  "Content-Type" => "text/plain"  
  "Content-Encoding" => "gzip"  
  "Original-Status" => 200  
  "PC-Status" => 200  
  "rid" => "The RID you received in the push call"  
  "url" => "The URL which was crawled"  
  
Body:  
  The HTML of the page
```

## Format JSON
This will come when you call the API with the `&format=json`.
```
Headers:  
  "Content-Type" => "gzip/json"  
  "Content-Encoding" => "gzip"  
  
Body:  
{  
  pc_status: 200,  
  original_status: 200,  
  rid: "The RID you received in the push call",  
  url: "The URL which was crawled",  
  body: "The HTML of the page"  
}
```

Please note that `pc_status` and `original_status` must be checked.