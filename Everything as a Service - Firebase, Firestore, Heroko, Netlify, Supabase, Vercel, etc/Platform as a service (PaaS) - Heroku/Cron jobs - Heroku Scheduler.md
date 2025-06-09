Heroku Scheduler = Cron jobs in Heroku

You can add Heroku Scheduler under Resources tab of your app:
![[Pasted image 20250609024509.png]]

Free is fine
![[Pasted image 20250609025753.png]]

Adjusting the jobs:
- Common uses include adding a job that calls cURL to an API endpoint, executing a nodejs script, etc
![[Pasted image 20250609025802.png]]

---

Heroku dynos sleep on free plans, so ensure you're on a paid tier for reliable cron behavior.
- Heroku Scheduler will still trigger your jobs even if the dyno is asleep — it will wake it up to run the job.
- However, cold start time may delay the actual execution by a few seconds to a minute.
- Scheduler-triggered wakeups count against your quota

**Example Usage**
Configure the scheduler in the Heroku dashboard:
- Go to Resources → Heroku Scheduler
- Click "Add Job"
- Set the command to: `curl -X POST $BASE_URL/timestamps/`
- Choose your desired frequency (e.g., every 10 minutes)


**Scripting / CLI:**
As of 6/2025, **Heroku does not provide a CLI command to directly add a new job to the Scheduler with a shell command**.

Although you can use CLI to open the scheduler dashboard:
```bash
heroku addons:open scheduler --app your-app-name
```

But you **must manually add the job** through the web UI that opens. 