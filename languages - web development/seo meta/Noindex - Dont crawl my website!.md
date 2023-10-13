The `<meta name="robots" content="noindex">` tag tells search engines not to index the page on which it appears. If you place this tag on a page of your website, search engines like Google that respect the robots meta tag will eventually remove that page from their indexes the next time they crawl it.

However, just adding the tag doesn't guarantee immediate removal. Google and other search engines will need to recrawl the page to see the tag. Once they see it, they'll start the process of de-indexing the page.

If your website or a specific page is already indexed by Google and you want to ensure its removal as quickly as possible after adding the `noindex` tag:

1. **Google Search Console**: Use the Google Search Console's URL removal tool. Before using this tool, you'll need to have added and verified your website in Search Console.
2. **Update your robots.txt**: If you've disallowed the page in your robots.txt file, make sure to temporarily allow it. This is because search engines won't be able to see the `noindex` tag if they can't crawl the page due to a disallow directive in robots.txt.
3. **Recrawl**: You can request Google to recrawl specific URLs using the "Inspect any URL" tool in Google Search Console. This might speed up the process of discovering the `noindex` tag.

Remember, if you remove a page from Google's index, users won't be able to find it through Google Search. Make sure this is what you want before adding the `noindex` tag. If you only want to temporarily hide the page, you can remove the `noindex` tag later and allow search engines to re-index the page.