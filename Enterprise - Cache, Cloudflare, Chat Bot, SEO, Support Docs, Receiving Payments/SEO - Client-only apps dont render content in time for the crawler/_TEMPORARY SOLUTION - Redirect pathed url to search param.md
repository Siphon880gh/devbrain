
While you are working on the prerendered version of your pages, you can have the pages still render for your users at least. You would disallow on robot.txt for now and have at the nginx vhost or apache htaccess level redirect to a search param that tells React to render. This approach would make it so that visitors that bookmarked a pathed url that's been rendered by React Router DOM can actually see a page when they visit a bookmark

> [!note] Is it okay to temporarily disallow a webpage?
> Temporarily blocking URLs in `robots.txt` while you fix glitches is safe for SEO if done briefly and carefully. Google won’t crawl those pages during that time, but previously indexed ones may still appear. Just make sure to unblock them as soon as fixes are done and resubmit in Search Console. Avoid blocking important assets like CSS/JS or the entire site unless absolutely necessary.
> 

Depending on if you're on apache or nginx, proceed with:
- [[Apache htaccess - Redirect pathed url to search param]]
- [[Nginx Vhost - Redirect pathed url to search param]]