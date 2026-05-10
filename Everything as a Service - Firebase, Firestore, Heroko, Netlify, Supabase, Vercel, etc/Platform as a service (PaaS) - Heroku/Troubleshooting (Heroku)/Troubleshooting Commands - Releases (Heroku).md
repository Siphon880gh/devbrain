## What are releases

You can get release events for your Heroku app at the terminal


A **release** in Heroku usually means something changed in the app, such as:

|Release type|What it means|
|---|---|
|`Deploy ...`|New code was deployed|
|`Set config vars` / `Config var changed`|Environment variables changed|
|`Scale web=1` / `Scale web=0`|Dyno count changed|
|`Rollback`|App was rolled back to an older release|
|`Add-on provisioned/removed/updated`|An add-on changed|
|`Restart` / `Release command`|Something triggered a new runtime release|


---

## Get release information

Get release information with
```
heroku releases --num 20 -a YOUR_APP
```

You'll see output like:
```
(base) user@MacBook-Pro ~ % heroku releases --num 20 -a app1
=== ⬢ app1 Releases - Current: v34

  v     description       user                  created_at                 
 ───────────────────────────────────────────────────────────────────────── 
  v34   Deploy f5f6530e   your_email@domain.com   2026/01/12 18:03:43 -0800  
  v33   Deploy f5f6530e   your_email@domain.com   2025/12/07 21:11:29 -0800  
  v32   Deploy 2e978b4d   your_email@domain.com   2025/12/06 05:04:59 -0800  
  v31   Deploy 87374322   your_email@domain.com   2025/12/05 22:00:43 -0800  
  v30   Deploy 019062e9   your_email@domain.com   2025/12/05 02:00:10 -0800  
  v29   Deploy 2fcf1c1a   your_email@domain.com   2025/12/04 05:06:08 -0800  
  v28   Deploy 85395bfb   your_email@domain.com   2025/12/04 03:59:17 -0800  
  v27   Deploy d674a988   your_email@domain.com   2025/12/04 00:33:42 -0800  
  v26   Deploy d674a988   your_email@domain.com   2025/12/04 00:32:06 -0800  
  v25   Deploy 59d4ea4d   your_email@domain.com   2025/12/04 00:20:46 -0800  
  v24   Deploy ee63ddbe   your_email@domain.com   2025/12/02 03:37:07 -0800  
  v23   Deploy 8548ceda   your_email@domain.com   2025/11/25 17:31:01 -0800  
  v22   Deploy 1c8817ac   your_email@domain.com   2025/11/24 05:07:35 -0800  
  v21   Deploy 1c8817ac   your_email@domain.com   2025/11/24 05:05:30 -0800  
  v20   Deploy 5b20f109   your_email@domain.com   2025/10/31 05:31:49 -0700  
  v19   Deploy e32d4630   your_email@domain.com   2025/10/31 02:58:04 -0700  
  v18   Deploy bbaeb942   your_email@domain.com   2025/10/31 02:52:25 -0700  
  v17   Deploy 8285af42   your_email@domain.com   2025/10/31 01:09:37 -0700  
  v16   Deploy 1a625ae2   your_email@domain.com   2025/10/30 23:53:26 -0700  
  v15   Deploy 46294ca6   your_email@domain.com   2025/10/29 07:32:45 -0700
```

---

## Does not include restart events, however..

`heroku releases --num 20 -a YOUR_APP` usually **does not list the daily dyno cycling as a release**. However, the normal logs does contain the cycling events.

Daily cycling is a **dyno restart event**, not a new app release. Heroku says dynos restart automatically at least once per day, and that these automatic restart events appear in **application logs**. Heroku’s example log line is:

```
heroku[web.1]: Cycling
```

So check this instead:

```
heroku logs --num 1500 -a YOUR_APP | grep -i cycling
```

or:

```
heroku logs --tail -a YOUR_APP
```

A **release** is more like:

```
Deploy codeChange config varsChange add-onsRollbackScale process type
```

A **daily cycle** is more like:

```
heroku[web.1]: Cyclingheroku[web.1]: State changed from up to startingheroku[web.1]: Stopping all processes with SIGTERMheroku[web.1]: Process exited with status 143
```

Important detail: Heroku says manual restarts and releases reset the 24-hour daily cycling timer. So if you deploy or change config vars often, you may not see the normal daily cycle happen on schedule