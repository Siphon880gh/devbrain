
Crawlbase API is the API endpoints you call to help you scrape. They take care of IP rotation.
https://crawlbase.com/dashboard/crawler

Crawlbase Crawler (https://crawlbase.com/dashboard/crawler/crawlers) is the wizard that lets you setup crawling through their web interface. However, on success, the information gets sent to your custom webhook UNLESS you choose to use crawlbase storage which can be visted at https://crawlbase.com/dashboard/storage
- Crawlbase storagelimits:  maximum of 10,000 documents are stored for a maximum of 14 days.
- By choosing crawlbase storage, it's a more complete wizard where you can see the scraped data on their interface.
- For information on how to configure the crawler, refer to [[_PRIMER - Crawlbase Crawler (Cursorily)]]

Note Crawlbase Crawler is not a complete wizarad (UI) solution. It is as wizardly as you decide to. The most wizard is setting up the crawler AND using the crawler storage to see your scrapped results (rather than using a custom webhook). Crawlbase Crawler is more for asynchronous set and forget (goes to webhook or crawl storage), whereas Crawlbase API you can see the results when you push the request (though technically, you could cronjob it and it would be and set and forget as well).