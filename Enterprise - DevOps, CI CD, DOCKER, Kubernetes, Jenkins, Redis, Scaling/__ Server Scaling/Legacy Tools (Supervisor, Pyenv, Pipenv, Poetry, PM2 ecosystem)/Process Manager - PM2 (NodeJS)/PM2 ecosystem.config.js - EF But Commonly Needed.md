AKA: Easily forgotten. Review this and fundamentals when had a hiatus from pm2 ecosystem

- Configuring any environmental variable such as an app's `PORT` from pm2 or eco **overrides all pre-existing** .env file's `PORT` from app folder  

- When have **production** env variables at ecosystem.config.js: Environment production must run in pm2 ecosystem command. Don’t assume server env variable set to production will work  
  
- Using a certain node and npm version regardless if done thru nvm or not, requires a certain format in the ecosystem.config.js file
	```
	    interpreter: '/root/.nvm/versions/node/v22.8.0/bin/node',
	    script: '/root/.nvm/versions/node/v22.8.0/bin/npm',
	    args: '--scripts-prepend-node-path=auto run start:prod',
	```