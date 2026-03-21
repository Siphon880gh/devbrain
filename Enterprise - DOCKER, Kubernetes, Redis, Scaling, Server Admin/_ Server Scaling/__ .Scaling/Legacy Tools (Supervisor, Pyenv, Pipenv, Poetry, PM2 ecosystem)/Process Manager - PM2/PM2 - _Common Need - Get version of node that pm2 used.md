You can run `pm2 show APP` to confirm the node version at the row `node.js version` which is the node interpreter version that pm2 used to run the app

The output looks like this:
```
escribing process with id 1 - name book-search:3001 
┌───────────────────┬────────────────────────────────────────────────────────────────┐
│ status            │ online                                                         │
│ name              │ book-search:3001                                               │
│ namespace         │ default                                                        │
│ version           │ 0.39.3                                                         │
│ restarts          │ 1                                                              │
│ uptime            │ 3m                                                             │
│ script path       │ /root/.nvm/versions/node/v22.8.0/bin/npm                       │
│ script args       │ --scripts-prepend-node-path=auto run start:prod                │
│ error log path    │ /root/.pm2/logs/book-search-3001-error-1.log                   │
│ out log path      │ /root/.pm2/logs/book-search-3001-out-1.log                     │
│ pid path          │ /root/.pm2/pids/book-search-1.pid                              │
│ interpreter       │ /root/.nvm/versions/node/v22.8.0/bin/node                      │
│ interpreter args  │ N/A                                                            │
│ script id         │ 1                                                              │
│ exec cwd          │ /home/wengindustries/htdocs/wengindustries.com/app/book-search │
│ exec mode         │ cluster_mode                                                   │
│ node.js version   │ 22.8.0                                                         │
│ node env          │ production                                                     │
│ watch & reload    │ ✘                                                              │
│ unstable restarts │ 0                                                              │
│ created at        │ 2024-11-29T09:28:40.324Z                                       │
└───────────────────┴────────────────────────────────────────────────────────────────┘

```