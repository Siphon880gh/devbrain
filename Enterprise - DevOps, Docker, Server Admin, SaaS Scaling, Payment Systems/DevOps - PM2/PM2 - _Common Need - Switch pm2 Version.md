When you run `node -v`, or you switched node version with `nvm use 22.11.00`, but yet pm2 is using the wrong node version (You can run `pm2 show APP` to confirm the node version at the row `node.js version` which is the node interpreter version that pm2 used to run the app):

The key is you had to run `pm2 update` in order to update pm2 to the current node your shell is using!

```
nvm use v22.8.0
pm2 update
```

**THEN** you may need to restart your pm2 app(s) or pm2 ecosystem app(s) for the desired nodejs version.