## **Problem**
- Problem: Heroku not showing enough errors

**Example** - Shows this error that doesn't help you identify the actual problem:
```
2025-10-25T08:48:35.071577+00:00 app[web.1]:     }
2025-10-25T08:48:35.071577+00:00 app[web.1]:   }
2025-10-25T08:48:35.071577+00:00 app[web.1]: }
2025-10-25T08:48:35.079908+00:00 app[web.1]: npm notice
2025-10-25T08:48:35.079909+00:00 app[web.1]: npm notice New major version of npm available! 10.9.4 -> 11.6.2
2025-10-25T08:48:35.079909+00:00 app[web.1]: npm notice Changelog: https://github.com/npm/cli/releases/tag/v11.6.2
2025-10-25T08:48:35.079910+00:00 app[web.1]: npm notice To update run: npm install -g npm@11.6.2
2025-10-25T08:48:35.079910+00:00 app[web.1]: npm notice
2025-10-25T08:48:35.151821+00:00 heroku[web.1]: Process exited with status 1
2025-10-25T08:48:35.178680+00:00 heroku[web.1]: State changed from starting to crashed
```

It will save the same short unhelpful error if you had clicked "Save" at the bottom right:
![[Pasted image 20251027020845.png]]

---

## **Solution**

Pull the actual stack trace:
```
heroku logs --tail --dyno web.1 --app postcraft-api
```

If that’s still terse, grab a larger slice
```
heroku logs -n 3000 --source app
```

Sometimes the failure shows up at the build logs. To see the build logs for the last release:
```
heroku releases:output
```


If you still don’t see a stack, run an interactive shell and start the app manually:
```
heroku run bash  
node -v  
echo "PORT=$PORT"  
npm start
```