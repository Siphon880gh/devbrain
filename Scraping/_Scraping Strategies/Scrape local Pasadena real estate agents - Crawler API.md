Goal: Scrape local Pasadena real estate agents because want to sell them a listing to video converter.

Use scraper google-serp, and make multiple requests to start=0, start=10, start=20, with url searching
pasadena+california+real+estate+”@”+email
thereby you want to encode uri component.

If you’re using one of the scrapers, it will by default return json, so you can:
node index > a.json
node index > b.json
node index > c.json

Those files being search results 0-9, 10-19, 20-29

Then you can right click and beautify it in VS Code for each file if necessary:
![](https://i.imgur.com/BlWT7UQ.png)

Once Pasadena appears to be exhausted (no more emails in search description), pivot to another city nearby.

Thusly, you have multiple folders of the cities in this region of California.

