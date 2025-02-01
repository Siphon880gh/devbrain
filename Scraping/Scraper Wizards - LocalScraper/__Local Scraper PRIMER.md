Aka Get Started
## Intro

Scrape local business address/phone/email in your specific industry. 

As of 1/2025 it’s $15-20 every month. Was on appsumo with a lifetime deal https://appsumo.com/products/local-scraper-lead-generation-software/

**About/Download**: https://www.localscraper.com/

**Readme**: http://www.localscraper.com/readme.php 

**How to use this tutorial**: Please navigate using the table of contents.

---
## CAVEATS - PROXIES


LocalScraper uses your computing resource and internet to perform the scraping and reporting. Certain sources are more likely to ban your IP if they detect ANY possible scraping by the volume of requests from your IP address.

See which source requires proxies at their Readme section “The Scrape Targets”
[https://www.localscraper.com/readme.php](https://www.localscraper.com/readme.php)  

For your convenience, I copied the table of proxy requirements here.

As of 1/2025, those that dont require proxies are: 
Google Map and Google Places, Email Finder, Bing Maps Quick (However Bing Maps Full DOES require proxies), and Yellow AU/DE (Australia, Germany)

| **Scraper Name**  | **Requires Proxies** |
| :---------------- | :------------------: |
| Google Maps Quick |          ✗           |
| Google Maps Full  |          ✗           |
| Google Places     |          ✗           |
| Yahoo Local       |          ✓           |
| Yellow USA Full   |          ✓           |
| Yellow USA Quick  |          ✓           |
| Home Advisor      |          ✓*          |
| Email Finder      |          ✗           |
| Bing Maps Full    |          ✓           |
| Bing Maps Quick   |          ✗           |
| Yellow AU         |          ✗           |
| Yellow DE         |          ✗           |
\*For Home Advisor, proxies may only be needed in certain regions or at higher scraping volumes.

On how to use Proxies, refer to their Readme sections x2 “Proxy API / Rotating Proxy / VPN” AND “Using Proxies”

Here's how to connect your Proxy service (likely you are paying) to LocalScraper:
- Watch or refer to this list’s instructions: [https://youtu.be/_eaxOE5WGu4](https://youtu.be/_eaxOE5WGu4)
- Proxy list can be downloaded, eg. proxybananza (not free)
- “Main Settings” tab → Enter Username and Password of the proxy service, then Set the Proxy File
- Make sure “Use Proxies” is on. You may initially “Test Proxies if you just set new proxies”

---

## GENERAL SCRAPING PROCEDURE

1. Search at a source:
	- Either scope target list (Google Maps Quick, etc)
	- Or Custom URL
	- The keyword list, location list, and custom url list lets you search multiple sets and combine them simultaneously

2. Adjust keyword and location. 

3. Start scraping
   Scraper could take 30+ seconds. Depending on the source, it might have to open Chrome. 
	- It might be a blank page for a few seconds before the source loads inside Chrome
	- Make sure not to touch Chrome as it’s dynamically updating (eg. List of addresses being added to the left on Google Map). The app is performing operations on Chrome, then it will save this information from Chrome back to the main app interface
4. When it finishes scraping: The app itself will show records. It will also show the location the records are saved to, a csv file

In this example, we scrape for real estate agents and brokers in Pasadena, California:
![](uvp8Ois.png)

![](ZdikxJW.png)

Next sections will be specific types of scraping. The example used in GENERAL PROCEDURE here is a Google Maps scraping, which we will cover immediately next.

---

## GOOGLE MAPS SCRAPING

Required Setup
- If you want email and socials, go to “Scraper Settings” → tick “Find Emails”
- If you want to add the emails later, you can Scrape for emails, but you will regret it because you have to paste the emails into the appropriate rows and sometimes it's out of order.

1. Select Google Map source  
	- Google Maps Quick (Gets phone number and address and name)
	- Or Google Maps Full (Gets reviews too)
	- For more details, refer to [[Google Maps Quick vs Google Maps Full]]

2. Proxy not needed  
3. Enter keywords and location (Adjust accordingly to your industry and use case)
	- Keywords: Real estate
	- Location: Pasadena
4. It starts scraping. Chrome may get opened per General Procedure.
5. When it finishes scraping: The app itself will show records. It will also show the location the records are saved to, a csv file

![](uvp8Ois.png)
^ Just visit that folder and sort by last modified to get the most recent saved csv.
^Or if you use the Mac terminal, you can run a command open "__"  where you copied and pasted the csv filepath.

![](ZdikxJW.png)

