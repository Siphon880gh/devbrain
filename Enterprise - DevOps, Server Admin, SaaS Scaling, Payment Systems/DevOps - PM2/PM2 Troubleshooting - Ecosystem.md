
If you suspect ecosystem.config.js to be causing app problems:
1. Run at a pm2 start level on the foreground and enabling logging:
   ```
   pm2 start app.js --interpreter /root/.nvm/versions/node/v22.8.0/bin/node --env production --no-daemon --log
	```
2. If that doesn't help you figure out the problem, run at the node interpreter level:
```
node app.js
```