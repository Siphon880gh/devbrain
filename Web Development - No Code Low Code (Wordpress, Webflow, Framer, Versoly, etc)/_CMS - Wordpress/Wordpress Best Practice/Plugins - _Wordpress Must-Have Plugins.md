## **Recommended Plugins**

SEO:
  ![[Pasted image 20250723213517.png]]
- SEOPress > Yoast (SEOPress is better, even if free. Refer to [[_SEOPress vs Yoast]])
- SiteKit by Google
- WP Rocket - caching for performance
- Search Regex by John Godley - If specific word pop up in reports that need fixing (like SEO reports) but that report is missing the source page, then use this plugin to find what the source page(s) are, so you know where to fix the problem. Access at Plugins or Sidebar Tools -> Search Regex

- Redirect 404 to Homepage by pipdig
- Link Whisper - tells you internal links from and to content. For SEO. By Link Whisper
- Broken Link Checker by WPMU DEV. Use "**L**ocal" otherwise Cloud requires signup with WPMU DEV
	- L 1 of 2:
	  ![[Pasted image 20250723214342.png]]
	- L 2 of 2:
	  ![[Pasted image 20250723214706.png]]
	- Click the Source link to go to the webpage that has the broken link. Then update the link there. OR conveniently update the link at the dashboard:
	  ![[Pasted image 20250725205028.png]]
	- As you fix those links at their respective pages, the dashboard automatically removes the respective row unless it's done that too many times (then it will say "Unchecked", and it'll check and remove on the next refresh (CMD+R))
- Redirection by John Godley (Setup particular url to 301 to another url. eg. use case. you optimize url slug for seo but older link already indexed, so older link can redirect to your new url slug with shared SEO equity). It can also detect your current 301 redirects and displays them. Can redirect 404 too.
      
    ~~Redirect 404 to Homepage. Redirect 404 missing pages to the homepage. By pipdig~~  (Obsoleted by Redirection by John Godley)
  
   Useful:
   ![[Pasted image 20250723064400.png]]



Customization:
- Header and Footer Scripts, by Anand Kumar. Add scripts at the wp builder.
- Duplicate Page → Duplicate pages and custom poses using single click. By mndpsingh287
- WPBakery Page Builder
- Happyforms

Management:
- All-in-One WP Migration
- Admin and Site Enhancements (ASE)
- Cloudflare


---

## Deep Dive: Why you need multiple link plugins

There appears to be 4 link plugins but there are actually 3.

Broken Link Checker (appearing under Plugins Page) is actually the same plugin as Link Checker (Appearing at sidebar). It may be confused as two different plugins at first because of their branding/icons. Make sure to open the local dashboard and not the cloud dashboard to access the data.

The Broken Link Checker plugin on WordPress shows more broken links than what you see in the email report. In addition to missing some page links, the report also misses broken image links. The Wordpress side does show these additional broken links as well as broken image links.

| Feature / Behavior                                                    | **Broken Link Checker on Email Report**                            | **Broken Link Checker on Wordpress**                               |
| --------------------------------------------------------------------- | ------------------------------------------------------------------ | ------------------------------------------------------------------ |
| **Enforces Link Convention (e.g. HTTPS) / Useful for Best Practices** | ✅ Flags non-HTTPS links, so `http://` and `www.` are marked broken | ✅ Flags non-HTTPS links, so `http://` and `www.` are marked broken |
| **Detects Redirects as Broken**                                       | ✅ Flags links that redirect (recommend replacing with final URL)   | ✅ Flags links that redirect (recommend replacing with final URL)   |
| **Detects Broken Images**                                             | ✅ Yes                                                              | ❌ No                                                               |
| **Total Broken Links Detected**                                       | ✅ Reports **more actual broken links**                             | ⚠️ May miss some broken links                                      |
Why is the Broken Link Checker good (if you consider using other plugins): Both the wordpress side and email report detects links that don’t start with **https** (such as those starting with **http** or just **www**) and flags them as broken (even though you can technically open the links to a webpage without any problems) . This helps enforce best practices for using secure links.  In addition, broken links are striked out on the webpage, including those that aren't HTTPS, for better or worse (doesn't look good to users, but you can catch bad links visiting your page).

![[Pasted image 20250725195424.png]]

**Hint**: If it's a long document that is hard to find strike out, you can inspect and search for the class "broken_link"
**Note:** The plugin flags links as broken if they don’t start with `https://`. Starting with just `www.` or using `http://` will still trigger a broken link warning—even if the link opens successfully when clicked. Additionally, links that redirect to a different final URL will also be marked as broken. To avoid this, simply replace the redirecting URL with the final destination link. A lot of links that may have been reported broken are the twitter.com links because they will redirect to x.com links.

Link Whisper: Shows internal links and outbound links but also outbound links to your own website. Yoast has internal links and outbound links column at the page listing, but does not have the third type.

Redirection plugin detects people visiting a broken link directly, it DOES NOT scan the webpage for broken links. Here's a test visiting /test-broken-link

How to access:
- Link Broken Checker: Access at Plugins
- Link Checker (same as Link Broken Checker): Can access at sidebar
- Link Whisper: Can access at sidebar
- Redirection: Access at Plugins or Sidebar Tools -> Redirection

Does activating plugin "**Redirect 404 to Homepage**" by pipdig block reporting of 404 hits at Redirection plugin? Yes, we are good:

![[Pasted image 20250725202359.png]]