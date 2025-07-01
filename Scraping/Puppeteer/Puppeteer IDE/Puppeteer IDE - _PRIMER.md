
Coming soon!

As a sneak peak, here's puppeteer chrome extension visiting every workflow link on https://n8n.io/creators/n8n-team/. In this tutorial when I come back to writing it, I'll reveal how to scrape the workflow JSON from each page before opening the next page.

![[puppeteer-visiting-links.gif]]

The for loop in the above screen recording is not the complete scraping code. We will get to it. But after the scraping is successful, you get a large array of objects you can copy into VS Code.

In particular - scraped from their website by puppeteer visiting each link is an array of objects representing each page:
![[Pasted image 20250701005017.png]]

Optional - Then optionally we enrich on a separate script to make a browsable search engine of their workflows:
![[Pasted image 20250701005105.png]]

Optional - The json is condensed down and the actual workflow json are saved as files:
![[Pasted image 20250701005132.png]]

Optional - So you can create a browsable experience:
![[Pasted image 20250701005231.png]]

The above optional milestones is really going beyond scraping to enriching the scraped data and make it useable/visualized.

---

**Coming soon!**