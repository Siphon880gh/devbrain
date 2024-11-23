Ecosystem.config.js starting a node js script file directly:
```
 script: 'server.js',
```

Ecosystem.config.js starting a npm script aka starting via npm - You need a `script` AND an `args` (two properties):
```
 script: 'npm',  
 args: 'run start',
```

And let's say you have a custom npm script `start:prod`, then your lines are:
```
 script: 'npm',  
 args: 'run start:prod',
```

If using a specific nodejs (which means a specific npm), you have to set both the node path AS WELL as the npm path. These node and npm paths could be nvm created or it could be what's on your server's system. Your exec command is actually `npm`  and you can have a path to npm as the exec command:
```
  {  
    name: 'image-gallery-nft-collab:3005',  
    cwd: "/home/wengindustries/htdocs/wengindustries.com/app/image-gallery-nft-collab",  
    interpreter: '/root/.nvm/versions/node/v22.8.0/bin/node',  
    script: '/root/.nvm/versions/node/v22.8.0/bin/npm',  
    args: '--scripts-prepend-node-path=auto run start:prod',  
    env_production: {  
       NODE_ENV: 'production',  
       PORT: 3005,  
    },  
    watch: false,  
    exec_mode: 'cluster',  
    instance_var: 'INSTANCE_ID',  
    log_date_format: 'YYYY-MM-DD HH:mm Z'  
  },
```

---

If you want the process to **restart in production mode** after a server reboot:
```
pm2 save
```

Then enable the PM2 startup script:
```
pm2 startup
```