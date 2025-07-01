
To summarize, you've learned that:
- [`page.$()`](https://pptr.dev/api/puppeteer.page._/) returns a single element matching a selector.
- [`page.$$()`](https://pptr.dev/api/puppeteer.page.__) returns all elements matching a selector.
- [`page.$eval()`](https://pptr.dev/api/puppeteer.page._eval) returns the result of running a JavaScript function on the first element matching a selector.
- [`page.$$eval()`](https://pptr.dev/api/puppeteer.page.__eval) returns the result of running a JavaScript function on each element matching a selector.

You've also learned selectors that wait until element is done loading on the webpage:
- `page.waitForSelector` however you know that `page.waitForXPath` doesn't work despite linting suggestions inside of Puppeteer IDE panel okaying it.
- Related, there's a `page.waitForTimeout` that will wait for some X milliseconds after the script started