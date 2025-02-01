This is if you decide to enrich previous scraped data (like Google Map) where you forgot to turn on Email/Socials (at tab ”Scraper Settings”). You could enrich following this tutorial OR just re-scrape the same source with Emails/Socials on.


1. At the app, select source: Email Finder
2. At the original scraped results in Excel, copy the column of sites into a text file (not copying the header):
   ![](Lu2K9QS.png)


- There may be duplicates of the same domain (eg. some-broker.com) which often the case is a big broker that doesn’t have an individual agent’s email but a more general email, and that’s ok (at later outreach, we try the general email and we may look into other data sources for decision maker emails for these big brokers, or we may target the real estate agents’ emails listed elsewhere on their website). Just copy them over to the text file too.
- There may be empty cells where our first round of scraping failed to scrape the website from Google Map source. When you copy the column to the text file, there may be blank lines - that won't crash the app LocalScraper.
	- So this means when the final csv is generated which has website, email, and social urls, it may not be in the same order as the column you copied, because of blanks. That's ok because you have to reconcile after pasting the email/social urls into the originally scraped Excel (Now dont you regret forgetting to turn on Emails/Socials at the "Scraper Settings" when you first scraped the data?)
	- Note you can't try to "hack it" with `about:blank` in place of blank lines. That will prevent Email Finder from even running.
	- Note that the resulting csv of website, email, and social urls may be out of order anyways - usually consecutive rows have been swapped (LocalScraper doesn't seem to respect the order of urls to the order of output; it may be related to how slow some websites finish loading). In addition, websites that can't be reached will be skipped over as well (row wont appear in final result).
- URL list can be sites.txt:
	```
	http://www.domain1.com  
	  
	http://www.domain3.com  
	http://www.domain4.com  
	http://www.domain5.com
	```
2. Back at the app, under "Custom URL List", load in the text file
3. Then click "Start Scraper"
4. The app will give you the email and social links: The app itself will show records. It will also show the location the records are saved to, a csv file
   ![](LA6FQtb.png)

5. Copy the emails/socials columns into the originally scrapped Excel (addresses, websites, etc):

	- The results either in LocalScraper app or the saved csv will be in the order of the urls for the most part.
	- Since you are enriching a previous LocalScraper csv, then you can copy the column(s) (depending if you want socials too, or only email) and insert paste the columns. 
		- Excel Workflow problem:  
		    If you want to insert an empty column first in Excel (Have “Insert” instead of “Insert Copied Cells, then you have to make sure no other Excel spreadsheet has any cells highlighted - Press Escape to cancel selection).
		    ![](ZR5s7JX.png)
		    ![](sHtWd9t.png)
	- With email and all socials, that’s 5 columns you could be copying, as of 1/2025
6. Now your originally scraped spreadsheet has the emails and socials. 
   ![](TeJK0KJ.png)

   
   However, you may have some emails/socials that dont match up to the rows of the originally scraped information because LocalScraper does not 100% honor the order of the textfile of website urls. It does get pretty close, so at least the cut and pasting is mostly shifting cells down and occasionally swapping rows. Here are tips:
	- CMD+X, CMD+V to cut
	- If you enriched with social links: Usually facebook/instagram group name is similar to the domain name so it’s easier to align with socials. So you can look at the newly pasted social name to the original name that's part of the original scraping
	- Email address usually has the domain name. 
		- If it does not have the domain (eg. @gmail.com instead), you can go back to look at the email/social scraping because it contains the original websites that your text file fed into LocalScraper

---

Bonus: More Emails

- Some rows dont have emails. This may not be a complete dud
	- The scraped website might be the home page and sometimes the email is listed on a separate page. So you may have to visit the url directly and look for Contact or About Us on their site menu.
	- They may use a contact form. Contact form usually does not reveal their email. But there's an off chance that the contact form opens your email app and fills in the information you typed on the contact form. In that case, the View Source will have their email at `mailto:`.
- Often the case is a big broker that doesn’t have an individual agent’s email but a more general email, and that’s ok (at later outreach, we try the general email and we may look into other data sources for decision maker emails for these big brokers, or we may target the real estate agents’ emails listed elsewhere on their website)