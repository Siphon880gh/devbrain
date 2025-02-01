You can add google search url parameters to assist in the scraping

A cleaner more performant scraper from Google SERP would be to:
- js turned off
- mobile 
- accessible

However as of 1/2025, there is no way the url can turn off js or enable accessibility. Mobile view is determined responsively rather than by the url.

But the following are another set of Google SERP parameters to help us:

&strip=1
strips queries in search result urls

num to change how many results per Google SERP page:
[https://www.google.com/search?q=aaa&num=30](https://www.google.com/search?q=aaa&num=30)  

`pws` and `nfpr`
- **`pws=0` Without `nfpr=1`**:
    - General search results will not consider your history or preferences.
    - If you are logged in, you might still see private results like Google Drive links.
- **`nfpr=1` Without `pws=0`**:
    - Search results can still be influenced by your history and location.
    - Explicitly personal results (e.g., files from Google Drive) will not appear.
- **Both Together (`pws=0&nfpr=1`)**:
    - No personalization is used in the results (neither ranking nor private results).

**`spell`**:
- This parameter determines whether Google's auto-correct or "Did you mean?" functionality is applied to your query.
- Useful when you are scraping for a keyword that isn't well recognized and that kept getting autocorrected into a wrong keyword (`screenshot=true` at the Crawlbase API scope can let you audit at Crawlbase Storage.)
- Common Values:
    - `spell=1`: Autospelling or auto-correction is enabled. If your query has a typo, Google will auto-correct it or suggest an alternative spelling.
    - `spell=0`: Disables autospelling and auto-corrections. Google will search for exactly what you typed.

`safe`:
- &safe=off
- Safe search or not

Language and Regional Filtering
- If changing at the google search parameter level:
	- **`hl`**: Sets the interface language.
		- Example: `hl=en` for English.
	- **`gl`**: Specifies the geographic location of results.
		- Example: `gl=us` for United States.
	- **`lr`**: Limits results to a specific language.
		- Example: `lr=lang_en` (only English results).
- RECOMMENDED: Just use country=US at the Crawler api level and they will handle that
