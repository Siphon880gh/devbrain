Better Stack Uptime is normally meant for monitoring, not gaming hosting limits. Its main job is to check whether your app is online and alert you if it is not. But because it sends regular HTTP requests, it can also act as a lightweight wake-up ping.

Better Stack says an HTTP status code monitor checks your URL for a successful `2xx` response. If the URL does not return a success response, it can create an incident and alert you.

For sleeping apps, you can point Better Stack at a small health endpoint:

```
GET /health
```

Example response:

```
{  "ok": true}
```

A good health endpoint should be cheap to run. It should not hit heavy database queries, generate reports, call third-party APIs, or trigger expensive app logic. The goal is only to confirm that the app can respond.

A simple Node/Express example:

```
app.get("/health", (req, res) => {  res.status(200).json({ ok: true });});
```

Better Stack can help wake or keep warm a Heroku Eco app because Heroku Eco web dynos sleep after 30 minutes without web traffic, and web traffic can wake them if Eco hours remain. Heroku also notes that monitoring services can prevent an Eco web dyno from sleeping.

The catch is that keeping an Eco dyno awake consumes Eco dyno hours. Heroku’s Eco plan gives 1,000 dyno hours per month shared across all Eco dynos in the account, and when the pool is exhausted, all Eco dynos are forced to sleep for the rest of the month.

So Better Stack helps, but it does not erase the platform’s limits.

---