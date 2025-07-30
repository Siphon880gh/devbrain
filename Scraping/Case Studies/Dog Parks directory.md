Eg. Creating a directory website of dog parks

**You want to beat out the other directory websites for dog parks. Then the trick is to be most up to date and to have more information about the dog parks.**

Scrape Google Map for dog parks:
Use a google map scraping tool, for example, [https://outscraper.com/pricing/](https://outscraper.com/pricing/) (untested)

Enrich your location data with Google Maps Reviews.

Then with the google map information in a file (like csv), run it through a data enricher that will add columns, for example, [https://directory-builder-tau.vercel.app/](https://directory-builder-tau.vercel.app/) (untested)

Then run it through your own script that makes all rows of data ID'able. Perhaps make the dog park name Id'able by having it all lowercase and all characters except numbers and alphabets stripped + appended to zipcode, separated by underscore `_`, eg. alicedogpark_91107) then on another persistent data source, check off ID's that have been generated (more on this next paragraph). You dont want it all in one csv file because you may lose that information. So the new ID's will only be saved at a secondary data source. When accessing the secondary data source on whether you've generated content for that dog park yet, it would have to hash the dog park name and zip code from the primary source.

Create your script that will generate page row/cards content from the data or create database entries from the data (that your website renders). Make sure the script checks the other data source against the ID to make sure it hasn't been already generated, before generating.


For SEO purposes you may want to have card to modal opens to change the url too and when visiting the url it would open that particular modal. Or you can generate pages for each card/modal as well. This means you have another script that generates separate pages. Regardless the approach you take, make sure the URL is slugified and its words are echoed in the title tag, H1 text, and text throughout the webpage, for SEO purposes. And also to prevent page rank issues, when a dog park is removed and you have a page for it, you may want to change that content to a "Dog Park no longer exists" instead of letting it 404 officially, because 404 hits can derank you.

Weekly Re-runs:
Create automation that will scrape for dog parks and enrich dog parks (see if there are APIs are integration SDKs for the third-party tools you use). Then along the pipeline, it runs the script creating new content and/or pages. You may take it further and double check the the ID from the second data source still exists on the primary source of dog parks (by un-ID'ing it). Dog parks could change names or be sunsetted (Remember if it's a page or dom url router, that you should sunset to a message rather than allowing 404 to take place). As part of this automation pipeline, you may want  to create a script that generates the sitemap.xml and submits its URL to Google Search Console, Index Now, etc. URLs that are no longer present in the sitemap will eventually be delisted. You cannot automate the Google Search Console's URL Removal too as of July 2025.
