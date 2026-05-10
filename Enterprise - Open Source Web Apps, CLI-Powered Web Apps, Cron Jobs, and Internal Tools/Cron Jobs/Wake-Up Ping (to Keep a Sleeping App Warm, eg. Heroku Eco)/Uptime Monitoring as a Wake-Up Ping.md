
Some hosting platforms save resources by putting apps to sleep after a period of inactivity. This commonly happens on cheap, free, or low-cost app hosting plans. The app is not broken; it is simply paused until another web request comes in.

That is where uptime monitoring services come in.

An uptime monitor repeatedly visits a URL on your app, usually something like:

```
https://your-app.com/health
```

or:

```
https://your-app.com/
```

If the hosting platform wakes the app when traffic arrives, the monitor request can wake it. If the monitor runs often enough, it may also prevent the app from going to sleep in the first place.

For example, Better Stack’s uptime monitor checks URLs for successful HTTP status codes, and its check frequency ranges from 3 minutes on free plans to 30 seconds on paid plans.

The practical idea is simple:

```
Uptime monitor   ↓ every few minutesGET https://your-app.com/health   ↓Hosting platform sees traffic   ↓App wakes up or stays warm
```

This works best for apps that sleep because of **HTTP inactivity**. It does not work if the host has disabled the app, suspended the account, exhausted the monthly quota, blocked the request, or requires a paid always-on plan.