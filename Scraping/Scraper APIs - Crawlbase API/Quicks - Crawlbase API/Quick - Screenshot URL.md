**Missing screenshot_url sometimes**

I made sure screenshot=true but screenshot_url does not appear in the response. This one is hard to replicate because it’s random when the screenshot_url doesn’t show

![](https://i.imgur.com/sGem9nj.png)

It doesn't store any failed attempt at Crawlbase Storage (where it would usually store screenshots).

---

HTML entity in screenshot_url
No big deal, I can have my code do a search and replace:
```
{
    "original_status": 200,
    "pc_status": 505,
    "url": "https://www.google.com/search?start=20\u0026q=pasadena+california+real+estate+\"@\"+email",
    "body": "\u003chtml dir=\"LTR\"\u003e\u003chead\u003e\u003cmeta http-equiv=\"content-type\" content=\"text/html; charset=UTF-8\"\u003e\u003cmeta name=\"viewport\" content=\"initial-scale=1\"\u003e\u003ctitle\u003ehttps://www.google.com/search?start=20\u0026amp;q=pasadena+california+real+estate+%22@%22+email\u0026amp;sei=5mCLZ7W8JJyp4-EPy9vxuA4\u003c/title\u003e\u003c/head\u003e\n\u003cbody style=\"font-family: arial, sans-serif; background-color: #fff; color: #000; padding:20px; font-size:18px; overscroll-behavior:contain;\" onload=\"e=document.getElementById('captcha');... {TRUNCATED},
    "screenshot_url": "https://api.crawlbase.com/storage?token=tKqOU1L5mmNyNiA7dxal8w\u0026rid=e45d76e84b581c4ac6a55426"
}
```