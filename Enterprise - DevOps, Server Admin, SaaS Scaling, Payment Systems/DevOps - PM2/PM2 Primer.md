
AKA: Get Started

## Requirements

Required:
- npm is installed

Optional requirements:
- Have a nodejs app (.js files). We will create them anyways as a test that pm2 is working

Required knowledge  
- Know what is process supervision: 
## What is Pm2

For NodeJS, we use pm2 which has supervision and process scaling .
- Supervision: Keeping an app persistent 24/7, usually a script that listens for incoming connections to a specific port and specific URL. That app could be a Nodejs server or Python server. 
- Manage multiple apps: You can keep an eye on multiple apps that are running at the same time.
- Process scaling: We can configure an app run to have cloned instances of the same process and they all share the responsibility of listening to the same port if applicable like in an express server, versus having multiple threads going at the same time for concurrency and I/O operations.
  

---

## Installations

Installing pm2 globally  
- Run with npm to install globally: `npm install -g pm2`
- Test that the command works: `pm2` 
	- If fails, fix your $PATH or stick to running with npx, eg. `npx pm2`

---


## Orientation

Following this will get you used to pm2 operations

Test the process supervision works by supervising a node script then cleaning up:
- Go into an empty folder if possible. Make sure there is no “test.js” in the folder
- Run this to create a test nodejs file and load it into pm2’s supervising: 

    ```
    echo "console.log('hi');" >> test.js; pm2 start test.js;
    ```

Optionally, you can test running multiple apps and managing multiple apps:
- Copy the test.js then run it too:
	```
	cp test.js test2.js; pm2 start test2.js;
	```
- Confirm that running the same app will FAIL (it knows by the filepath) which is what you want in case you forgot an app is running: `pm2 start test.js`

Run this to test pm2 supervising is working. If it can list the app then it’s a success `pm2 list`
- Run this to see the console logging is frequent and continuous (press q to exit):
	- `pm2 dashboard` 
- Often times you will run this command to see a quick snapshot what nodejs apps are running persistently:
	- `pm2 list`
- Run this to cleanup pm2 and test.js: `pm2 stop all; pm2 delete all; rm test.js`

---

## Orientation - Stop vs Shutdown

When you stop an app, you stop it based on the filename because with the above examples test.js, it shows up as test:
![](https://i.imgur.com/xw36DcZ.png)

If you had pm2 ran two test.js (which is only allowed if different folder paths, otherwise it'll stop you saying that it's already running) - the names are the same:
![](https://i.imgur.com/CwJf44s.png)

Therefore when you stop running an app, both those apps stop:
```
pm2 stop test
```

![](https://i.imgur.com/S74JRnc.png)

Shortcut apps: They are "stopped" but persists on the pm2 list. This means the filenames don't have to exist for you to restart them. By running `pm2 start test`, it'll start any apps with the same name in stopped status

You may find this clusters your pm2 list, so to permanently clear them off the list:
```
pm2 delete test
```
![](https://i.imgur.com/8qJHIsy.png)

Note as a shorter workflow, you can outright delete app(s) without stopping them first.

Now a few edge cases to mention:
- Watching:
	- Notice from the pm2 list "watching" is disabled. You can start an app with watching mode by running: `pm2 start test.js --watch`. Any file changes will restart the process, helpful when you're developing, but you would normally not develop in production.
- Designating another name for the app:
	- As discussed in shortcut apps, you can stop apps and re-run them by their names. They're assigned the names they're assigned based on the filename that you start with (pm2 start test.js would be named "test" in the pm2 list)
		- This may be undesirable if you have many apps that will run from a similar named file, often is the case with server.js because you've been naming the express server files server.js by convention for all your apps:
		```
		pm2 start yourAppFile.js --name "yourAppName"
		```

---

## PM2 Plus

- Web browser monitor with premium features. Sign up without credit card for 14 days free trial.
- Has email and slacking on app crashes https://pm2.io/docs/plus/overview/
	
Running either this will open web browser to sign up or login:
- `pm2 monitor`
- `pm2 plus

If there's no web browser because it's a server-only distro whose terminal you ran on, then it'll do non-browser authentication, which will interactively ask if you need to sign up or login, and it'll authenticate you via terminal.

---

## Reference

- pm2 start APP.js
- pm2 start APP.js --name "yourAppName"

- pm2 stop APP
- pm2 delete APP
- pm2 delete all

- pm2 list
- pm2 dashboard
	- same as `pm2 monit`
- pm2 monitor
	- same as `pm2 plus`
	- Refer to pm2 plus

- pm2 stop all
- pm2 delete all