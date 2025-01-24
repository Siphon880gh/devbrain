
If a lot of data, recommend you prototype the scraping logic with Crawler API, then perform with Crawler

1. Crawler API:
See if you can crawl a set of data successfully with crawler api per the primer: [[_PRIMER - Crawlbase API]]

2. Crawler and custom webhook:
Then setup Crawler that will send results to your custom webhook. Develop the webhook. The Crawler will take care of captchas and fails (retries until successful) and only sends you successful results. Fails wont count against your credits.