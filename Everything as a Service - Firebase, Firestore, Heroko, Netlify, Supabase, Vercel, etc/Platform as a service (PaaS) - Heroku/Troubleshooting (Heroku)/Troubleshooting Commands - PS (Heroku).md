A **dyno** is the running container/process that Heroku uses to run your app. For example, if you have a Node.js, Python, Ruby, or PHP web app, Heroku usually runs it as a **web dyno**.

To check whether your app’s dyno is running, use:

```bash
heroku ps -a your-app-name
```

You can also write the longer version:

```bash
heroku ps --app your-app-name
```

Heroku’s CLI uses `ps` (stands for process status) for managing and viewing dynos, workers, and related processes. The `-a` or `--app` flag tells Heroku which app you want to inspect. ([Heroku Dev Center](https://devcenter.heroku.com/articles/heroku-cli-commands?utm_source=chatgpt.com "Heroku CLI Commands"))

## Example Output

```bash
web.1: up 2026/05/07 12:15:34 -0700 (~ 12h ago)
```

Here is what each part means:

```text
web.1
```

This is the dyno name.

- `web` means it is your web process.
    
- `.1` means it is the first web dyno.
    

For older Heroku Cedar-style apps, dynos commonly appear as names like `web.1`, `web.2`, or `worker.1`. Heroku’s newer Fir-generation apps may use a different identifier style, such as `web-12a34bcd56-7efgh`. ([Heroku Dev Center](https://devcenter.heroku.com/articles/view-your-apps-dynos?utm_source=chatgpt.com "View Your App's Dynos"))

```text
up
```

This means the dyno is currently running.

If the dyno is not running correctly, you may see statuses like `starting`, `crashed`, or other states depending on what is happening.

```text
2026/05/07 12:15:34 -0700
```

This is the time when the dyno started running.

The `-0700` part is the timezone offset.

```text
(~ 12h ago)
```

This means the dyno has been up for about 12 hours.

So the full line means:

```text
The first web dyno is running, and it started about 12 hours ago.
```

## Important Note: This Is Not CPU or Memory Stats

The command:

```bash
heroku ps -a your-app-name
```

mainly shows your **dyno process status**.

It tells you things like:

- whether the dyno is up
    
- when it started
    
- what process type it is
    
- which dynos are currently running
    

It does **not** give detailed CPU, RAM, or performance metrics by itself. For performance details, you would usually check Heroku metrics, logs, or monitoring add-ons.

## When This Command Is Useful

Use this command when you want to quickly answer:

```text
Is my Heroku app actually running?
```

For example, after deploying, restarting, scaling, or troubleshooting your app, run:

```bash
heroku ps -a your-app-name
```

If you see:

```bash
web.1: up ...
```

that means your web dyno is alive and running.