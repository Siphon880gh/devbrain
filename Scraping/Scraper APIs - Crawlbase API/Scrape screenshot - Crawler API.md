
Required knowledge: 
- Basic API endpoint from [[_PRIMER - Crawlbase API]]

---
## screenshot

- Optional
- Type `boolean`

If you are using the **JavaScript token**, you can optionally pass `&screenshot=true` parameter to get a screenshot in the `JPEG` format of the whole crawled page.

Crawlbase will send you back the `screenshot_url` in the response headers (or in the json response if you use `&format=json`). The `screenshot_url` expires in one hour.

**Note:** When using the `screenshot=true` parameter, you can customize the screenshot output with these additional parameters:

- `mode`: Set to `viewport` to capture only the viewport instead of the full page. Default is `fullpage`.
- `width`: Specify maximum width in pixels (only works with `mode=viewport`). Default is screen width.
- `height`: Specify maximum height in pixels (only works with `mode=viewport`). Default is screen height.

Optional dependent parameters example: `&screenshot=true&mode=viewport&width=1200&height=800` 

  
  
Note your response may include a glitched screenshot_url:  

"screenshot_url":"https://api.crawlbase.com/storage?token=tKqOU1L5mmNyNiA7dxal8w\u0026rid=309c46209834b4891ad8de11"}  
  

  

That’s a bug on crawlbase’s side. \u0026 means &

so your correct url is:

https://api.crawlbase.com/storage?token=tKqOU1L5mmNyNiA7dxal8w&rid=309c46209834b4891ad8de11  
  

  

Note there’s a glitch in Crawlbase as of 1/2025 where sometimes there’s no screenshot_url... so it’s not reliable