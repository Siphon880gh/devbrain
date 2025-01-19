Aka Get Started

About: All-In-One data crawling and scraping platform for business developers.

---

**Glossary of needed knowledge / commonly referenced**

Key links:
- API and tokens - [https://crawlbase.com/dashboard/account/docs](https://crawlbase.com/dashboard/account/docs)
- Credits (Crawler API): [https://crawlbase.com/dashboard/api](https://crawlbase.com/dashboard/api)

Menu of products:
![](https://i.imgur.com/Kldeygd.png)
- Note that proxy and ip rotation is already included in their Crawling API and Crawler products, as in when you use their product to scrape, you dont have to worry about an IP being blocked. The Smart Proxy is a separate product that lets you use their proxy for whatever reason (may not necessarily be for scraping).
- For Crawler API vs Crawler, refer to [[Crawlbase API vs Crawlbase Crawler]]

Token types
- Use the JavaScript token when the content you need to crawl is generated via JavaScript, either because it's a JavaScript built page (React, Angular, etc.) or because the content is dynamically generated on the browser.
- Otherwise use the Normal request token which is more performant.

To see your credits, Crawling API -> Dashboard
![](https://i.imgur.com/GilJbZM.png)


Their offers
- Free trial
- Sales people offer it for 2000 credits
- Limited time, 1000 free credits, then 9000 free credits for enabling billing (if you haven't used any initial credits yet) - 1/2025

---

**Commonly Needed**


API endpoint at its most basic is (Returns HTML):
```
const url = encodeURIComponent('https://www.somewebsite.com');
const options = {
  hostname: 'api.crawlbase.com',
  path: '/?token=JS_TOKEN&scraper=google-serp&screenshot=true&url=' + url,
};
```

API endpoint for Google Search Results only one page
Returns formatted json because of the scraper preset google-serp, and saves screenshot of the scraped page to Crawlbase Storage page
```
const url = encodeURIComponent('https://www.google.com/search?q=SEARCH+TERM');
const options = {
  hostname: 'api.crawlbase.com',
  path: '/?token=JS_TOKEN&scraper=google-serp&screenshot=true&url=' + url,
};
```

API endpoints for Google Search Results MULTIPLE pages
Run each time, advancing start = 0, to 10, 20, 30, etc
```
const url = encodeURIComponent('https://www.google.com/search?q=SEARCH+TERM');
const options = {
  hostname: 'api.crawlbase.com',
  path: '/?token=JS_TOKEN&start=0&scraper=google-serp&screenshot=true&url=' + url,
};
```

---

**Libraries?**

Crawlbase offers libraries but is unnecessary. Those are just syntactic sugar syntax. The lines of code needed to scrape with or without their library remain short. It’s their api endpoint doing the heavy lifting.

> [!note] Libraries 
>  Crawlbase has libraries to make implementing the API easier:
> [https://crawlbase.com/crawling-libraries-sdk](https://crawlbase.com/crawling-libraries-sdk)
> 
> ![](https://i.imgur.com/mEOM63C.png)
> 
> NodeJs / Python:
> [https://www.npmjs.com/package/crawlbase](https://www.npmjs.com/package/crawlbase)
> [https://pypi.org/project/crawlbase/](https://pypi.org/project/crawlbase/)
> 

---

The API call (Or library options)

The required parameters (url queries) are:
- token
- url

The documentation auto populates with your tokens if you are logged in. Two types of tokens. One where content to be scrapped is loaded in by js during loading instead of already part of the html. The regular token is more performant.

![](https://i.imgur.com/1EgpMLl.png)

All other parameters optional. However for some parameters including them means you have to include certain other parameters so the use case makes sense.

Using the parameter scraper, can choose your data source even though technically your url could indicate the data source. Well, actually these are presets and how data should be parsed and presented to you on response. The default behavior is responding with thehtml of the scraped webpage.

Case in point: If your parameter url is Amazon product details, without the proper scraper parameter, it will just return html without referring to any parse and presentation present.

The scraper= parameter values are at:
https://crawlbase.com/docs/crawling-api/scrapers/


>![note] Scraper presets
>Partial screenshot of scraper presets:
>![](https://i.imgur.com/OhUvaKp.png)
>As of 1/2025, the scraper presets are:
>```
>- Amazon
>- amazon-product-details
>- amazon-serp
>- amazon-offer-listing
>- amazon-product-reviews
>- amazon-best-sellers
>- amazon-new-releases
>
>- Google
>- google-serp
>
>- Facebook
>- facebook-group
>- facebook-page
>- facebook-profile
>- facebook-hashtag
>- facebook-event
>
>- Instagram
>- instagram-post
>- instagram-profile
>- instagram-hashtag
>- instagram-reels-audio
>
>- LinkedIn
>- linkedin-profile
>- linkedin-company
>- linkedin-feed
>
>- Quora
>- quora-serp
>- quora-question
>
>- Airbnb
>- airbnb-serp
>
>- Ebay
>- ebay-serp
>- ebay-product
>
>- AliExpress
>- aliexpress-product
>- aliexpress-serp
>
>- Bing
>- bing-serp
>
>- Immobilienscout24
>- immobilienscout24-property
>
>- Walmart
>- walmart-serp
>- walmart-product-details
>- walmart-category
>
>- BestBuy
>- bestbuy-serp
>- bestbuy-product-details
>
>- G2
>- g2-product-reviews
>
>- Eventbrite
>- eventbrite-events-list
>- eventbrite-event-details
>
>- Generic
>- generic-extractor
>- email-extractor
>```

