New Relic is another way developers have historically kept low-traffic Heroku apps from idling. The idea is similar to Uptime by Better Stack, cron-job.org, Pingdom, or UptimeRobot: a service sends regular HTTP requests to your app so Heroku sees traffic.

But New Relic is a little different because it is available directly as a **Heroku add-on**. Heroku Elements currently lists **New Relic APM** as a Heroku monitoring add-on, including a **Wayne Free** plan, plus paid plans above it.

The practical setup looks like this:

```
New Relic Availability / Synthetic monitor   ↓Pings your Heroku app URL   ↓Heroku sees web traffic   ↓Eco web dyno wakes up or stays awake
```

This can work because Heroku Eco web dynos sleep after 30 minutes with no web traffic, and a sleeping Eco web dyno can become active again after receiving web traffic, as long as the account still has Eco dyno hours available. Heroku also specifically notes that monitoring services such as **Pingdom or New Relic monitoring** can prevent a web dyno from sleeping.

---

# Important Correction: Installing New Relic Alone Does Not Keep the App Awake

The key point is this:

```
Installing the New Relic add-on is not enough.
```

The add-on gives you New Relic monitoring integration, but the “keep awake” behavior comes from creating an **Availability / Synthetic ping monitor** that checks your actual Heroku app URL.

New Relic’s docs describe creating a synthetic monitor by going to **Synthetic monitoring → Create monitor**, then choosing the **Availability** tile for ping monitors.

So the correct mental model is:

```
Bad assumption:New Relic add-on installed = app stays awakeCorrect:New Relic add-on installed+ Availability / ping monitor created+ monitor points to your Heroku app URL= app receives regular traffic
```

That is why some people say “New Relic did not work.” Often what they mean is that they installed the add-on but did not configure the availability monitor.