
Usually you may have variables:
```
module.exports = {  
  apps: [{  
    name: 'app1:3100',  
    cwd: "/home/wengindustries/htdocs/wengindustries.com/app/app1",  
    script: 'server.js',  
    interpreter: '/root/.nvm/versions/node/v22.8.0/bin/node',  
    env: {  
      NODE_ENV: 'development',  
      PORT: 3100
    },  
    env_production: {  
      NODE_ENV: 'production',  
      PORT: 3100
    },  
    watch: false,  
    exec_mode: 'cluster',  
    instance_var: 'INSTANCE_ID',  
    log_date_format: 'YYYY-MM-DD HH:mm Z'  
  }]  
};
```

To ensure the application runs in **production mode** with `pm2` using the environment variables defined under `env_production`, you need to start or reload the application with the `--env production` flag.

DO NOT rely on the server's env variables to have Node JS run in production when using pm2 or pm2 ecosystem.

```
pm2 start ecosystem.config.js --env production
```

---

For development:
```
pm2 start ecosystem.config.js --env development
```