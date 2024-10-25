**These meta tags to affect:**
- Link sharing like texted thumbnail
- Google search results
- Facebook preview
- Twitter

To make it more convertible for other people that your champion visitors/users share the link with.

```
<title>Company Assessment</title>
<meta name="description" content="Lorem ipsum dolor sit amet, consectetur adipiscing elit." />
<meta name="keywords" content="keyword1, keyword2" />

<!-- Open Graph Meta Tags for Social Previews -->
<meta property="og:title" content="Company" />
<meta property="og:description" content="Lorem ipsum dolor sit amet, consectetur adipiscing elit." />
<meta property="og:image" content="https://example.com/company/favicon.ico" /> 
<meta property="og:image:alt" content="Company Badge" /><!-- Path to your background image -->
<meta property="og:url" content="https://example.com/company" />
<meta property="og:type" content="website" />

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image" />

<!-- Favicon/Icon -->
<link rel="shortcut icon" href="/company/favicon.ico" />
```

If you're changing any details of the meta's, Facebook requires a re-scrape at:
https://developers.facebook.com/tools/debug/?q=\_\_URL\_\_

## FAQ
- Q: When I share a link to someone, it has a URL already, so why does Facebook have a "og:url".
- A: The URL being shared might have additional query parameters or be a shortened version of the original URL. The `og:url` ensures that Facebook (and other platforms) recognize the canonical, or "main" version of the URL, so that marketing analytics can report all the visits to that one main canonical URL.