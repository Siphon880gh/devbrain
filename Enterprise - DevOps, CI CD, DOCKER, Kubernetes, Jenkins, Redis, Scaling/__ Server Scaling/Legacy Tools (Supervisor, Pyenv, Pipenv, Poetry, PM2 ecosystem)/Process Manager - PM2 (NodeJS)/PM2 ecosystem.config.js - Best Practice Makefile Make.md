
Create a Makefile and manage by running make commands such as `make restart` and `make stop` per definitions below, which works on many Linux commands
```
.PHONY: default ls restart stop log log\:app1

# Default message when no target is specified
default:
        @echo "Please choose one of the commands after '.PHONY:'"
        @head -1 Makefile

ls:
        @ls -la --group-directories-first

# Build the .env file for development
restart:
        @pm2 delete ecosystem.config.js --env production
        @pm2 restart ecosystem.config.js --env production

# Build the .env file for production
stop:
        @pm2 delete ecosystem.config.js --env production

# See logs
log:
        @pm2 logs --lines 100

# See log for app app1
log\:app1:
        @pm2 logs --lines 100 | grep -i "app1"
```

This is a best practice because pm2 ecosystem commands are a bit wordy and pm2 ecosystem is fussy on its requirements. Also pm2 ecosystem is not good at reporting errors (often failing silently or looking like it works). Having Makefile saved the commands that you can run easily will make sure seamless management in the long-run.