See all logs:
```
pm2 log
```

See logs for a specific app (as appearing from `pm2 list`)... you need the full name (no partial search)... eg. `pm2 log note-taking:3006`
```
pm2 log appName|appId
```

^ Note if the app name doesn't exist, the terminal will show a blank log and no indication there were any errors

**Another way to see all logs:**

```
pm2 logs --lines 100 | grep -i "appName|appId"
```

^Note if your app name has double colons or other filename-unfriendly symbols, they become a hyphen `-` and you have to adjust the command accordingly.

For example, for an app name `note-taking:3006`, we're actually logging from a `note-taking-3006` file:
```
/root/.pm2/logs/note-taking-3006-out-6.log last 15 lines:

6|note-tak | > simple-note-taker@1.0.0 start /home/wengindustries/htdocs/wengindustries.com/app/note-taking

6|note-tak | > node server

6|note-tak | 

6|note-tak | 2024-11-22 02:42 +00:00: 2024-11-22 02:42 +00:00: 

6|note-tak | > simple-note-taker@1.0.0 start /home/wengindustries/htdocs/wengindustries.com/app/note-taking

6|note-tak | > node server

6|note-tak | 

6|note-tak | 2024-11-22 02:44 +00:00: 2024-11-22 02:44 +00:00: 

6|note-tak | > simple-note-taker@1.0.0 start

6|note-tak | > node server

6|note-tak | 

6|note-tak | 2024-11-22 02:54 +00:00: 

6|note-tak | > simple-note-taker@1.0.0 start

6|note-tak | > node server

6|note-tak |
```

---


Flush all logs
```
pm2 flush
```

Flush logs for a specific app (as appearing from `pm2 list`):
```
pm2 flush appName|appId
```
