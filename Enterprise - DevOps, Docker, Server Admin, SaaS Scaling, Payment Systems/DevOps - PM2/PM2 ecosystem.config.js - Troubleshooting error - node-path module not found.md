Your error looks like:
```
6|note-taking:3006  | Error: Cannot find module 'node:path'  
6|note-taking:3006  | Require stack:  
6|note-taking:3006  | - /root/.nvm/versions/node/v22.8.0/lib/node_modules/npm/lib/cli.js  
6|note-taking:3006  | - /root/.nvm/versions/node/v22.8.0/lib/node_modules/npm/bin/npm-cli.js  
6|note-taking:3006  |     at Function.Module._resolveFilename (internal/modules/cjs/loader.js:885:15)  
6|note-taking:3006  |     at Module.Hook._require.Module.require (/usr/local/lib/node_modules/pm2/node_modules/require-in-the-middle/index.js:81:25)  
6|note-taking:3006  |     at require (internal/modules/cjs/helpers.js:88:18)  
6|note-taking:3006  |     at Object.<anonymous> (/root/.nvm/versions/node/v22.8.0/lib/node_modules/npm/lib/cli.js:2:18)  
6|note-taking:3006  |     at Module._compile (internal/modules/cjs/loader.js:1068:30)  
6|note-taking:3006  |     at Object.Module._extensions..js (internal/modules/cjs/loader.js:1097:10)  
6|note-taking:3006  |     at Module.load (internal/modules/cjs/loader.js:933:32)  
6|note-taking:3006  |     at Function.Module._load (internal/modules/cjs/loader.js:774:14)  
6|note-taking:3006  |     at Module.require (internal/modules/cjs/loader.js:957:19)  
6|note-taking:3006  |     at Module.Hook._require.Module.require (/usr/local/lib/node_modules/pm2/node_modules/require-in-the-middle/index.js:101:39)
```

This is caused by an older version of node js that does not recognize the syntax `require("node:path");` and continued to have `require("node");`

---

If you're unable to upgrade Node.js and the application is under your control, you can modify the code to use the traditional `path` import instead of `node:path`:

```
const path = require('path'); // Instead of const path = require('node:path');
```

---

Just upgrade NodeJS.

If you're using pm2 ecosystem, you have to make sure to cover all edge cases that prevents you from choosing the nodejs version for pm2 apps (pm2 is fussy about requirements):

Your ecosystem.config.js covering a lot of server edge cases to guarantee it can switch to the nodejs version (this example runs `npm run start` so note that interpreter is the node and script is the npm and args is the `run start`, and note NODE_VERSION is defined for `--env production`):
```
  {
    name: 'note-taking:3006',
    cwd: "/home/wengindustries/htdocs/wengindustries.com/app/note-taking",
    interpreter: '/root/.nvm/versions/node/v22.8.0/bin/node',
    script: '/root/.nvm/versions/node/v22.8.0/bin/npm',
    args: '--scripts-prepend-node-path=auto run start',
    env_production: {
	  NODE_VERSION: "22.8.0",
      NODE_ENV: 'production',
      PORT: 3006,
    },
```
