

If your web app has python/php/node scripts that write a file to your disk, and the written files become owned by root user rather than that website’s Linux user, and that causes problems when your website re-display the written file +
AND you start the server from a sh script:

You can still change ownership before running the server:
```
su - USER
```

^No password needed if sh file is ran from root user and the new USER is non-root or lower privilege.