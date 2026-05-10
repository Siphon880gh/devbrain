Required knowledge:
- Eco dynos go to sleep after 30 seconds of inactivity

TLDR: 
- Only practical if you have one eco app you want to keep always awake due to the 1000 eco hours limit per account (not per app).

---

Heroku no longer has the old truly free dyno experience. The low-cost replacement is the **Eco dyno plan**, which is cheaper than a Basic dyno but comes with intentional limits. As of Heroku’s current docs, Eco costs **$5/month** and gives you **1,000 Eco dyno hours per month**, shared across all Eco dynos in your account. Basic is listed around **$7/dyno per month**. ([Heroku Dev Center](https://devcenter.heroku.com/articles/eco-dyno-hours?utm_source=chatgpt.com "Eco Dyno Hours"))

The main catch is that **Eco web dynos sleep after inactivity**. Heroku’s Eco dynos are designed to conserve usage by sleeping automatically when they are not receiving traffic. Historically, the sleep trigger is commonly described as about **30 minutes of no web traffic**. ([Heroku Dev Center](https://devcenter.heroku.com/articles/eco-dyno-hours?utm_source=chatgpt.com "Eco Dyno Hours"))

Because of that, developers often try to “keep the app awake” by pinging it on a schedule. They may use uptime-monitoring services or a small script running from another VPS. For example, a developer could run a tiny Node.js app on a separate server that pings the Heroku app every few minutes, then keep that pinger alive with **PM2** and an `ecosystem.config.js` file.

Uptime-Monitoring Services as a Wake-Up Ping:
- [[Better Stack Uptime as a Wake-Up Ping]]
- [[cron-job.org as a Scheduled Wake-Up Ping]]
- [[Uptime Monitoring as a Wake-Up Ping]]
- [[New Relic as a Wake-Up Ping (Heroku Add-on)]]

A small script running from another VPS as a Wake-Up Ping:
- [[Node Script as a Wake-Up Ping]]

But Heroku already accounted for this workaround. They haven't entirely blocked you from gaming their eco plan. However, they limit you from having multiple forever-on eco dynos with this method. 

Heroku gives the **account** a shared monthly pool of **1,000 Eco dyno hours**. If one eco app is kept awake 24/7 for a full 31-day month, that is about **744 hours**. So one always-awake Eco app can fit inside the 1,000-hour pool, but multiple always-awake Eco apps can burn through the account limit quickly. Heroku says that when the monthly Eco hours are exhausted, all Eco dynos on that account are forced to sleep until the next monthly reset, and you cannot buy extra Eco hours. ([Heroku Dev Center](https://devcenter.heroku.com/articles/eco-dyno-hours?utm_source=chatgpt.com "Eco Dyno Hours"))

So the “keep-alive” trick works only in a limited sense. It can stop a single Eco web app from sleeping, but it does not bypass the monthly account-wide hour pool. If you keep several Eco apps awake, you are just consuming the shared limit faster.

Creating multiple Heroku accounts just to spread the 1,000-hour pool across accounts is also not a clean strategy. Heroku/Salesforce terms restrict using access in a way that circumvents contractual usage limits, so treating extra accounts as a quota-bypass strategy is risky and not something to build a serious workflow around. ([Heroku](https://www.heroku.com/policy/heroku-elements-terms/?utm_source=chatgpt.com "Heroku Elements Terms of Use (Default)"))

The practical takeaway: **Eco is good for prototypes, demos, personal tools, and low-traffic apps where sleeping is acceptable.** If the app needs reliable 24/7 availability, the price difference between Eco and Basic is small enough that Basic is usually the cleaner choice. Eco is $5/month for a shared pool; Basic is about $7/month per dyno and is designed for always-on use. ([Heroku](https://www.heroku.com/dynos/?utm_source=chatgpt.com "Heroku Dynos: Lightweight Containers for Running Apps"))