Aka: Get Started

**Applies to what:** Nodejs, python, php, html on the same domain and web host. Different subpaths lead to different nodejs and/or python apps like:
- https://domain.tld/app/node-app1
- https://domain.tld/app/node-app2
- https://domain.tld/app/py-app1
- https://domain.tld/app/py-app2
- https://domain.tld/app/my-cool-app

**Applies to who:** Tech entrepreneur that is bootstrapping various app ideas with limited budget,

If you have Nodejs apps you might consider services like heroku however they cost money and the cheapest plan loads slow on the first visit especially if low traffic which does not impress visitors

With Nodejs and python apps one approach is for each app you have an instance with AWS, but outside the initial credits AWS gives to starters, it may be out of budget

So you want fast loading and you’ll have low traffic and you want to make it affordable. You can consolidate all languages whether it is Nodejs or python or php or html into the same web host

Just like your computer can spin up multiple Nodejs apps at ports 3000,3001, 3002 etc simultaneously while running also python flask servers at port 5000, 5001, etc, you can do this at your web host that’s a VPS or Dedicated server with SSH root access (you login to the terminal of your server to run Nodejs or python scripts). As for php and html, http and https are running on ports 80 and 443 which are by default in the web browser and supported on nginx or Apache. Most common web hosting providers already provide nginx or Apache. You may need to install python or Nodejs on ssh terminal with root access

Then you would be able to visit domain.tld:3001 but that isn’t going to be SSL https and it isn’t going to get ranked under Google search. So you perform reverse proxy to hide those ports like 3001 under a friendlier url like domain.tld/app/app1.

---

FYI, by reverse proxying a friendly url to the true ported address, you have advantages inferred from that

Benefits of reverse proxying a friendly url to app port is:
- Easier for user to memorize the url
- Google will rank your webpage
- It can go through https so the webpage gets SSL signed along with the rest of your domain. Your app won't get the scary "not a secured website" warning in the web browser.

Security benefits are:
- Hide underlying technology and possible exploits hackers can try
- Close off another port hackers can try to access

---

Continue onto Part 2: [[_PRIMER Pt 2 - How Mixed Server (PHP, HTML, NodeJS, Python)]]