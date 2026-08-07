**Headless scraping** refers to web scraping that uses a **headless browser**—a browser that runs without a visible user interface. It behaves like a normal browser (loading JavaScript, handling cookies, rendering DOM, etc.) but doesn't show a window. It's great for automation and speed.

When you do not want to run the browser yourself for a known URL, use a [[Method 2 - URL Scraping API]]. Plain HTTP without a browser is [[Method 1 - Direct HTTP Fetch]] / [[Vocabs - Fetch Tool, Headless Browser, User-Spoofing, Request header spoofing, etc]].

### 🔍 Comparison:

|   |   |
|---|---|
|Type|Description|
|**Headed scraping**|Browser opens visibly (e.g., Chrome with a window).|
|**Headless scraping**|Browser runs invisibly in the background.|