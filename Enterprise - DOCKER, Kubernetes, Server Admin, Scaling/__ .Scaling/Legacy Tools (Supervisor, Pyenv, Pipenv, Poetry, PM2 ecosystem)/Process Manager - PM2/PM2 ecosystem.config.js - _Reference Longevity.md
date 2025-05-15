
## PM2 Commands
See what's running persistently at the moment:
```
pm2 list
```

Instead of having a stage of stopped instances that you can restart, you can delete them all:
```
pm2 delete all
```

## PM2 Ecosystem Commands

```
# Start all applications
pm2 start ecosystem.config.js

# Stop all
pm2 stop ecosystem.config.js

# Restart all
pm2 restart ecosystem.config.js
  
# Reload all
pm2 reload ecosystem.config.js

# Delete all
pm2 delete ecosystem.config.js
```

