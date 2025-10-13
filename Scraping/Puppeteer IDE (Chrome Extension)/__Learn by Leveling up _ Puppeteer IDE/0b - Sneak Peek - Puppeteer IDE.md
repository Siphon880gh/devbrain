
As a sneak peek, here's puppeteer chrome extension visiting every workflow link on https://n8n.io/creators/n8n-team/.

![[puppeteer-visiting-links.gif]]

The for-loop in the above screen recording is not the complete scraping code. But we will be implementing that later. Currently, that's outside of your abilities. Small baby steps first.

---

And typically what would be done after a successful scrape with Puppeteer IDE:

After the scraping is successful, you get a large array of objects you can copy into VS Code. In particular - scraped from their website by puppeteer visiting each link is an array of objects representing each page:
![[Pasted image 20250701005017.png]]

Optional - Then optionally we enrich on a separate script to make a browsable search engine of their workflows:
![[Pasted image 20250701005105.png]]

Optional - The json is condensed down and the actual workflow json are saved as files:
![[Pasted image 20250701005132.png]]

Optional - So you can create a browsable experience:
- No more clicking "Load more" to view more results like on n8n page
- Can search by name, integration, and category unlike the n8n page
![[Pasted image 20250701005231.png]]

The above optional milestones is really going beyond scraping, and towards enriching the scraped data and making it useable/visualized, which are often tasks coupled with scraping activities. Those enrichment and browsing code are at https://github.com/Siphon880gh/n8n-templates/tree/main/n8n-partners, if you're curious.