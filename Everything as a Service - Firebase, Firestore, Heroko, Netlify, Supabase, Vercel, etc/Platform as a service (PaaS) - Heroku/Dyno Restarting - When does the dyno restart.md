
There are a few scenarios when a dyno restarts:

1. **Scheduled restarts**: Heroku restarts all dynos, regardless of their type, once per day. This is called "cycling" and is done to maintain the health of applications running on the platform. The timing of this cycling process is random for each 24 hour period.
2. **Deployments**: Whenever you deploy a new version of your application, Heroku restarts your dynos to start running the new code.
3. **Scaling operations**: If you manually scale your application up or down, that is, change the number of running dynos, Heroku restarts your dynos to apply the changes.
4. **Crashes**: If your application crashes for any reason, Heroku restarts your dynos in an attempt to recover the application.
5. **Configuration changes**: If you change your application's configuration, for example, modifying environment variables, Heroku restarts your dynos to apply the changes.