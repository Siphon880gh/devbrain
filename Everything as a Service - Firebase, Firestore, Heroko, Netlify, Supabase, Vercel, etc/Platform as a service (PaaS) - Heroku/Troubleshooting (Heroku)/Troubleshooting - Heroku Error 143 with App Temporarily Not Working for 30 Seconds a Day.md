Knowledge required:
- Know Eco vs Basic vs Standard

---

You look back to the logs why your app wasn't working for like 30 seconds:
![[Pasted image 20260509194631.png]]

It was about that time that the app didn't work for like 30 seconds.

`143` is **not an HTTP status code** here.

It means:

```text
Process exited with status 143
143 = 128 + 15
128 = The Unix/Linux convention used to report that a process exited because of a signal
15 = SIGTERM
```

So Heroku is saying:

```text
Your dyno process was told to shut down gracefully.
```

Heroku documents that when the dyno manager restarts/stops a dyno, it sends `SIGTERM` first, gives the app up to 30 seconds to shut down cleanly, then uses `SIGKILL` only if the app refuses to exit. ([Heroku Dev Center](https://devcenter.heroku.com/articles/dyno-shutdown-behavior "Dyno Shutdown Behavior | Heroku Dev Center"))

Your log pattern:

```text
State changed from starting to up
Stopping all processes with SIGTERM
Process exited with status 143
```

Means:

```text
The dyno successfully started.
Then Heroku, or something connected to Heroku, stopped/replaced it.
The app exited because it received SIGTERM.
```

So `starting → up` is normal. The suspicious part is **why it was stopped shortly after becoming up**.

Most likely causes:

|Cause|What to check|
|---|---|
|New deploy/release|`heroku releases -a APP_NAME`|
|Config var changed|`heroku releases -a APP_NAME`|
|Manual restart|Heroku dashboard activity / team activity|
|Dyno cycling|Heroku automatically restarts dynos at least once per day unless bypassed on supported Fir apps ([Heroku Dev Center](https://devcenter.heroku.com/articles/dyno-restarts "Dyno Restarts \| Heroku Dev Center"))|
|External scaler|Heroku Scheduler, Cron To Go, CI/CD, GitHub auto-deploy, API script|
|App scaled down/up|Look for `Scale web=0`, `Scale web=1`|
|Add-on changed config|Add-ons can create releases/config changes|
|Memory or boot issue|Look nearby for `R14`, `R15`, `R10`, `H10`|

Important correction: if you are on **Basic**, this should not be “sleeping after inactivity.” Heroku’s Eco dynos sleep after inactivity; Basic is listed separately and does not have the sleep checkmark in Heroku’s dyno size table. ([Heroku Dev Center](https://devcenter.heroku.com/articles/dyno-tiers?utm_source=chatgpt.com "Dyno Tiers"))

The clean explanation is:

> The dyno came up successfully, then Heroku received or initiated a stop/restart event. Exit `143` just means the app obeyed `SIGTERM`. Find the event that happened at the same timestamp: release, config var change, deploy, scale change, scheduler, GitHub auto-deploy, Heroku API script, add-on update, or daily dyno cycling.

Run:

```bash
heroku logs --tail -a APP_NAME
heroku releases -a APP_NAME
heroku ps -a APP_NAME
```

And look around that exact timestamp for:

```text
Release v...
Deploy ...
Config var changed
Scale web=0
Scale web=1
Restarting
Cycling
Memory quota exceeded
R14
R15
R10
H10
```

If you see only `SIGTERM` + `143` and no crash/error before it, the app probably did **not** crash. Something told Heroku to replace or stop that dyno or Heroku itself stopped the app is part of normal cycling once a day.

- Something else stopping the dyno: Check Heroku Dashboard → your app → **Resources**. Look under the **Services / Add-ons** area. An add-on or external service can change config vars, trigger a new release, or restart the app. Heroku’s add-on docs note that add-ons can set/update config vars, and config var changes automatically restart the application with a new release. ([Heroku Dev Center](https://devcenter.heroku.com/articles/add-ons "Add-ons Overview | Heroku Dev Center"))
- You may have simply hit the app at the unlucky moment Heroku was **cycling** the dyno. Heroku automatically restarts dynos at least once per day, and the daily cycling window is once every 24 hours plus a random offset of up to 216 minutes. In the logs, that can appear as `Cycling`, followed by `Stopping all processes with SIGTERM`, then `Process exited with status 143`. ([Heroku Dev Center](https://devcenter.heroku.com/articles/dyno-restarts "Dyno Restarts | Heroku Dev Center")). Higher dyno tiers can reduce the user-facing impact. On Common Runtime, Heroku’s **Preboot** feature is available for **Standard and Performance dynos**. Instead of stopping the old web dyno first, Preboot starts the new web dyno, routes traffic to it, and then shuts down the old one afterward. So the old dyno can still receive `SIGTERM`, but users are less likely to feel a cold restart gap because another web dyno is already running during the swap. ([Heroku Dev Center](https://devcenter.heroku.com/articles/preboot "Preboot | Heroku Dev Center"))

