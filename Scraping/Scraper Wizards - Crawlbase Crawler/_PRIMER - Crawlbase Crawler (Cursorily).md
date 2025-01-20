
Status: Cursorily. I just used mostly the Crawlbase API instead because of my own use case. Will update this tutorial to be more complete when I have a more appropriate use case. To read about Crawlbase API: [[_PRIMER - Crawlbase API]]

Note Crawlbase Crawler is not a complete wizarad (UI) solution. It is as wizardly as you decide to. The most wizard is setting up the crawler AND using the crawler storage to see your scrapped results (rather than using a custom webhook). Crawlbase Crawler is more for asynchronous set and forget (goes to webhook or crawl storage), whereas Crawlbase API you can see the results when you push the request (though technically, you could cronjob it and it would be and set and forget as well).

Although there could be captcha errors from Google Search every so often, the Crawler (unlike the Crawler API which requires further handling) will automatically retry each request, including those that encounter captchas, to ensure optimal data retrieval, and can send to your custom webhook or save to Crawlbase Storage. For a better success rate with Google Search scraping, it's recommended to use the JS Crawler at the Crawler.

Note that proxy and ip rotation is already included in their crawling, as in when you use their product to scrape, you dont have to worry about an IP being blocked. The Smart Proxy is a separate product that lets you use their proxy for whatever reason (may not necessarily be for scraping).

---

About: All-In-One data crawling and scraping platform for business developers.

Key links:
- API and tokens - [https://crawlbase.com/dashboard/account/docs](https://crawlbase.com/dashboard/account/docs)
- Credits (Crawler API): [https://crawlbase.com/dashboard/api](https://crawlbase.com/dashboard/api)

To see your credits, Crawling API -> Dashboard
![](https://i.imgur.com/GilJbZM.png)



Their offers
- Free trial
- Sales people offer it for 2000 credits
- Limited time, 1000 free credits, then 9000 free credits for enabling billing (if you haven't used any initial credits yet) - 1/2025

---

Crawlbase Crawler (https://crawlbase.com/dashboard/crawler/crawlers) is the wizard that lets you setup crawling through their web interface. However, on success, the information gets sent to your custom webhook UNLESS you choose to use crawlbase storage which can be visted at https://crawlbase.com/dashboard/storage
- Crawlbase storagelimits:  maximum of 10,000 documents are stored for a maximum of 14 days.
- By choosing crawlbase storage, it's a more complete wizard where you can see the scraped data on their interface.

At the Crawlbase Crawler product page, go to the tab "Crawlers":
![](https://i.imgur.com/Y2GsInh.png)

Note real browser requests (Javascript) is required if your data is dynamically loaded in at the start of the webpage. Note Google SERP needs Javascript request for better scraping.

A Callback, you type a custom webhook to retrieve information on information being scraped. This means that you have to implement a webpage that takes in the response, and saves it to a file or your database. This could be in the form of a php file, most simply, or it could be a python flask server endpoint or nodejs express server endpoint. If you do not have the time budget for this, then have it stored in crawlbase by clicking "click here to do so" where it mentions "If you prefer to use Crawlbase Storage". Notice if you choose crawlbase storage, it fills the Callback field with their own crawlbase url. That url updates your Crawlbase Storage page at https://crawlbase.com/dashboard/storage
![](https://i.imgur.com/uqwrCOX.png)

You can have additional parameters in the api push endpoint. Refer to [[_PRIMER - Crawlbase API]] or https://crawlbase.com/docs/crawling-api/parameters/. After all, the Crawlbase Crawler is just a wrapper on top of the Crawlbase API.

If you had chosen to use your own webhook, refer to this documentation on how to interpret the response sent to your endpoint or php file:
https://crawlbase.com/docs/storage-api/response/

At the Crawlers tab, since you have crawlers now, where it lists your crawlers, it tells you the API endpoint to push a request:
![](https://i.imgur.com/eJEBtQ3.png)

Besides custom webhook which is a choice, the API endpoint is the only part that is not wizardly. Maybe in a future version, they will create a form for you to customize the api push and make the api push on the same page.

