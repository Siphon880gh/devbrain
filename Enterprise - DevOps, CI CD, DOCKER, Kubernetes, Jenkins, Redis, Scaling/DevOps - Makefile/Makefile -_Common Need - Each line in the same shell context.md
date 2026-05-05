
`.ONESHELL` tells Makefile NOT to run each line on its own shell but all the lines belong to the same shell (therefore in this example, not losing nvm initialization)

```
# Build the .env file for development
# .ONESHELL tells Makefile not to run each line on its own shell but all the lines belong to the same shell (therefore not losing nvm initialization)
.ONESHELL:
SHELL := /usr/bin/bash
restart:
	@source ~/.nvm/nvm.sh && \
	nvm use v22.8.0 && \
	pm2 delete ecosystem.config.js --env production && \
	pm2 update && \
	pm2 restart ecosystem.config.js --env production
```