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

**The API call**

If you're using the library provided by CrawlBase, it's similar to the API call except their library makes the API call for you, and the options you feed in (toke, url, optional scrapers etc) are sugarly syntax.

The required parameters (url queries) are:
- token
- url
And these two parameters make up the basic API endpoint

The documentation auto populates with your tokens if you are logged in. Two types of tokens. One where content to be scrapped is loaded in by js during loading instead of already part of the html. The regular token is more performant.

![](https://i.imgur.com/1EgpMLl.png)

Let's test the API endpoint to scrape HTML with only the mandatory parameters. We'll get more complex by adding optional parameters in a bit. Bare bones (use python equivalent, or library equivalent, etc depending on your preferred coding style)
```
const https = require('https');  
  
const url = encodeURIComponent('https://wengindustries.com');  
const options = {  
  hostname: 'api.crawlbase.com',  
  path: '/?token=REGULAR_TOKEN&url=' + url,  
};  
  
https  
  .request(options, (response) => {  
    let body = '';  
    response.on('data', (chunk) => (body += chunk)).on('end', () => console.log(body));  
  })  
  .end();
```
On success, it returns HTML. You can also simply test it by building the url and visiting directly in your web browser, and after a slight delay, it should return HTML, visiting directly `https://api.crawlbase.com/?token=REGULAR_TOKEN&url=https%3A%2F%2Fwengindustries.com

---

Let's continue to more complex use cases using optional parameters and scraper presets

All other parameters optional. Some parameters are used in common use cases. And some parameters, having them means you have to include certain other parameters so the use case makes sense.

A common parameter is for scraping in a cleaner format. The optional parameter `scraper=` can recognize google search results, amazon product page, etc, and therefore produce a cleaner json response for your code or analyst to work with. If no scraper parameter is set, the default behavior is responding with the html of the scraped webpage, even if the url would be a source that one of the scrapers can recognize.

Case in point: If your parameter url is Amazon product details, without the proper scraper parameter, it will just return html without referring to any parse and presentation present.

The scraper= parameter values are at:
https://crawlbase.com/docs/crawling-api/scrapers/


> [!note] Scraper presets
> Partial screenshot of scraper presets:
> ![](https://i.imgur.com/OhUvaKp.png)
> ^ Scroll down on webpage for more
> 
> Again - scraped= is an optional parameter. If you don't use it, you will receive back the full HTML of the page so you can scrape it freely.
> 
> As of 1/2025, the scraper presets are:
> ```
> - Amazon
> - amazon-product-details
> - amazon-serp
> - amazon-offer-listing
> - amazon-product-reviews
> - amazon-best-sellers
> - amazon-new-releases
> 
> - Google
> - google-serp
> 
> - Facebook
> - facebook-group
> - facebook-page
> - facebook-profile
> - facebook-hashtag
> - facebook-event
> 
> - Instagram
> - instagram-post
> - instagram-profile
> - instagram-hashtag
> - instagram-reels-audio
> 
> - LinkedIn
> - linkedin-profile
> - linkedin-company
> - linkedin-feed
> 
> - Quora
> - quora-serp
> - quora-question
> 
> - Airbnb
> - airbnb-serp
> 
> - Ebay
> - ebay-serp
> - ebay-product
> 
> - AliExpress
> - aliexpress-product
> - aliexpress-serp
> 
> - Bing
> - bing-serp
> 
> - Immobilienscout24
> - immobilienscout24-property
> 
> - Walmart
> - walmart-serp
> - walmart-product-details
> - walmart-category
> 
> - BestBuy
> - bestbuy-serp
> - bestbuy-product-details
> 
> - G2
> - g2-product-reviews
> 
> - Eventbrite
> - eventbrite-events-list
> - eventbrite-event-details
> 
> - Generic
> - generic-extractor
> - email-extractor
> ```
> 

When using any of their scraper preset, make sure to follow instruction about adding the scraper parameter. 

For example, let's create a scraper that works with google search results. Then make sure the scraper parameter, per document, is google-serp AND you are using js token per instructions for Google search:

Google SERP
```
&scraper=google-serp  
```

Final code with scraper parameter and js token (your code may vary if you use Crawlbase libraries) below

Our example use case here is finding all real estate agents and brokers’ email addresses using Google Search:
```
const https = require('https');  
  
const url = encodeURIComponent('https://www.google.com/search?start=0&q=pasadena+california+real+estate+"@"+email');  
const options = {  
  hostname: 'api.crawlbase.com',  
//   path: '/?token=HwEKH-wla3iYoQ3DEXmDsw&scraper=google-serp&url=' + url,  
  path: '/?token=HwEKH-wla3iYoQ3DEXmDsw&scraper=google-serp&screenshot=true&url=' + url,  
};  
  
https  
  .request(options, (response) => {  
    let body = '';  
    response.on('data', (chunk) => (body += chunk)).on('end', () => console.log(body));  
  })  
  .end();
```

Next pages using start parameter
```
const url = encodeURIComponent('https://www.google.com/search?start=10&q=pasadena+california+real+estate+"@"+email');
```


^ finding all real estate agents and brokers’ email addresses using Google Search, having "@" with double quotes:
- emails have @ in their text
- By surrounding with double quotations, you are telling Google this keyword is mandatory

For scraping next pages, you adjust Google url
- Page 1: `start=0`
- Page 2: `start=10`
- Page 3: `start=20`
- Page 4: `start=30`

> [!note] Curious: To prove, you can turn on screenshot to true and look at the screenshot for start=20 which will say Page 3
> ![](https://i.imgur.com/5uzrYog.png)
>

**Caveat**: There could be captcha errors from Google Search every so often. Your code or developer has to catch the word captcha or other keywords, then retry the fetch until no more captcha. You do not have to visit the url to the captcha. By the time you re-fetch, likely Crawlbase API already has performed this for you. If you don't want to developer further, the Crawler (Not the API) will automatically retry each request, including those that encounter captchas, to ensure optimal data retrieval, and can send to your custom webhook or save to Crawlbase Storage. For a better success rate, we recommend testing using the JS Crawler at the Crawler.

---

After sending the request, the data gets printed to the console when the end event is emitted by the response object. This event is triggered when the entire response has been received (before that, it was just appending information to the response body). There may be some waiting while your script appears to “hang”.

When using other sources besides Google search you want to see if they have a preset `scraper=`. And depending on your use case and/or the source, you may want to:  
- Use a performant regular token or a js token that waits for content to finish generating with the site’s js  
- Parameters needed for example country making sure it’s English (sometimes rotates to foreign IP and website can switch language). Or setting country because website is blocked in your own country. Or that specific content is only available in another country.
	- country=
	- United States (US)
	- China (CN)
	- Japan (JP)
	- India (IN)
- The website’s js take a long time to finish loading so you want to add a delay before scraping
	- page_wait=
	- Eg. 2000
- The website’s content loads as the user scrolls, and you want to capture that content
	- scroll=
	- Eg. true
	- The API this will by default scroll for a scroll_interval of 10 seconds.
	- If you want to scroll more than 10 seconds please send the `&scroll=true&scroll_interval=20`. 
	- Those parameters will instruct the browser to scroll for 20 seconds after loading the page. The maximum scroll interval is 60 seconds.
- The website's content loads when a specific element is pressed on the page:
	- css_click_selector
	- Eg. `#btn-show-tips`
	- Eg. `[data-tab-item="tab1"]`
	- Selector not found will fail with pc_status 595.
- The destination is JSON content
	- autoparse=
	- Eg. true

Other optional parameters will better fit your workflow
- Screenshot of the scraped page as well (Great for debugging scraping problems, and/or because you want to scrape screenshots)
	- screenshot=true
	- Saves to the Crawlbase Storage page
	- For more dependent parameters of screenshot, such as setting the size of the screenshot, etc, refer to [[Scrape screenshot - Crawler API]]
- If you want the scraped results to store at Crawlbase Storage page for later:
	- `&store=true` parameter to store a copy of the API response in the Crawlbase Cloud Storage 
	- Crawlbase will send you back the `storage_url` in the response headers (or in the json response if you use `&format=json`).


^ Read more including what their values could be at the documentation on parameters:
https://crawlbase.com/docs/crawling-api/parameters/

These are some more optional parameters at their documentation
![](https://i.imgur.com/hHlzkU0.png)