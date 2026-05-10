## 1. When you may want to scale to 1 web dyno

```bash
heroku ps:scale web=1 -a your-app-name
````

You use this when you want to make sure your Heroku app has **one running web dyno**. In other words, the app has a web server process available to receive HTTP traffic. This is useful after deployment, after changing dyno settings, or if the app was accidentally scaled down to `web=0`. For a small app, prototype, admin dashboard, API, or low-traffic website, `web=1` is the normal baseline.

Think of it like this:

```text
web=0  → no web dyno is running
web=1  → one web dyno is running and can serve requests
```

For **Eco** and **Basic** dynos, `web=1` is also the maximum per process type. Heroku states that Eco and Basic apps can have only one dyno running per process type. ([Heroku Dev Center](https://devcenter.heroku.com/articles/scaling?utm_source=chatgpt.com "Scaling Your Dyno Formation"))

## 2. When you may want to scale above 1 web dyno

If you are expecting a lot of traffic, you may want more than one web dyno:

```bash
heroku ps:scale web=3 -a your-app-name
```

This can help when you know traffic is about to spike. For example, maybe you are speaking at an event, running a workshop, launching a QR code in the physical world, sending people to a signup page, or promoting a URL during a live presentation. In that case, one dyno may not be enough to handle the burst of visitors.

Example:

```text
web=1  → normal baseline
web=3  → more capacity for expected traffic
web=5  → even more parallel request handling
```

However, this applies to **Standard tier and higher**, not Eco or Basic. Eco and Basic are stuck at one running dyno per process type, so you would need to upgrade the dyno tier before scaling the web process horizontally. Heroku’s scaling docs say you can’t run more than one Eco or Basic dyno per process type, and you must upgrade to a larger dyno tier before adding more dynos. ([Heroku Dev Center](https://devcenter.heroku.com/articles/scaling?utm_source=chatgpt.com "Scaling Your Dyno Formation"))