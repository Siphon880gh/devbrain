Goal: Scrape pickleball companies and their key decision maker contacts that may want us to manufacture with or without us design bags

---

**LinkedIn**

Firstly, look up Pickleball companies (eg. Selkirk) on LinkedIn if you have Sales Navigator access or you have ever tried Sales Navigator (then LinkedIn gives a sneak peak a few decision maker connections):
![](bqDSE9h.png)

---

LocalScraper (Fails)

Searched for in our area Pasadena:
- Sports bag
- Pickleball
- Tennis

![](ZEDuENN.png)


![](74vQpLT.png)

You can see where the problem is. Google Map or LocalScraper is not appropriate.  We want  decision maker contacts that may want us to manufacture with or without us design bags. Instead, "Sports Bag" in Google Map (or many of the other sources on LocalScraper) would've given us retail stores (like Big 5) instead of an organizations that want to push a brand and often sell paddles, bags, decals, etc. 

And when it's "Pickleball" or "Tennis", it will be that city's courts/parks/recreation centers that get scraped. You may think about an exclusion operator with `-` like in Google Search, however that doesn't work on Google Map, and neither does it work on LocalScraper. And even if you chose to ignore the courts/parks/recreation centers, it's often the case that most if not all are just that:
![](as7ncod.png)

Let's move onto the next step

---

Next we try scraping Google Search results with Crawler API. But first we need to reconstruct what keywords that a company that may want to manufacture their own branded pickleball bags would be.

You can use Semrush's Organic Research (Unfortunately free is limited in how many domains you can search and how many results appear, usually 10's):
[https://www.semrush.com/analytics/organic/overview?db=us](https://www.semrush.com/analytics/organic/overview?db=us)

1. Let's choose Selkirk. Then checking out insights at Semrush's Organic Research:
![](aPX3hks.png)

![](4tEgxwa.png)

![](lGWJCV6.png)

![](Zg7NhIO.png)

![](suONZwC.png)


2. From the above insights, we figured some keywords are paddles, shoes, bags, decal, and sports.
We start forming the google url for crawler api:
```
pickleball ("email" or "contact" or "about" or "@") paddles or shoes or bags or decal or sport -reddit -amazon
```

^ Notice the major keyword or key phrase “pickleball” followed by a logical group that tells google search to only list search results with contact information, and lastly followed by another logical group that says at least one of the insight keywords should match.

> [!note] Google grouping logical operators?
> Yes, Google search does support the use of parentheses for grouping terms and logical operators. While it does not officially recognize AND, it implies it, and in our case, it’s logical group 1 AND logical group 2.


3. Therefore the Crawler API line may be:
```
const url = encodeURIComponent('https://www.google.com/search?start=0&q=pickleball ("email" or "contact" or "about" or "@") paddles or shoes or bags or decal or sport -reddit -amazon');
```

4. The start=0 we call again and again at 10, 20, 30, ... But when to stop? When the quality of results drop (like random fan pages instead of actual companies).

On a related note, make sure to check the scraped result isn’t a captcha page on Google Search page (in that case, just refetch because Crawlbase’s agents would have verified against the captchas already).

This will give you a set of scraped results that are more weighted heavily to the main keyword and an insightful keyword.

We should generate another set of scraped results that are weighted towards related companies, the main keyword, and an insightful keyword.

1. Find similar companies to selkirk:
	- By Google search: type vs to see dropdown suggestions:
	  ![](LXqoVl9.png)

	- Use similiarweb.com to look up its alternative websites. Unfortunately, SimilarWeb is not free, but they do offer a free trial.
2. Your Crawler API line may be:
```
const url = encodeURIComponent('https://www.google.com/search?start=40&q=selkirk+joola+pickleball ("email" or "contact" or "about" or "@") paddles or shoes or bags or decal or sport -reddit -amazon');
```

---

Finally, data providers and data aggregators can be looked into if you have the budget. ZoomInfo has contacts of business decision.