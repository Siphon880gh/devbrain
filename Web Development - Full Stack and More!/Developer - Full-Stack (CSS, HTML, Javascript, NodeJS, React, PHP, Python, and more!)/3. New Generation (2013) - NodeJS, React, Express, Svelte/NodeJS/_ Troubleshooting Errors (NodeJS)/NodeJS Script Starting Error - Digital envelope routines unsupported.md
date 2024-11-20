
Error message when running your node script:
```
[1] Error: error:0308010C:digital envelope routines::unsupported  
[1] at new Hash (node:internal/crypto/hash:79:19)  
[1] at Object.createHash (node:crypto:139:10)  
[1] at module.exports (/Users/wengffung/dev/web/weng/app/book-search/client/node_modules/webpack/lib/util/createHash.js:135:53)  
[1] at NormalModule._initBuildHash (/Users/wengffung/dev/web/weng/app/book-search/client/node_modules/webpack/lib/NormalModule.js:417:16)  
[1] at handleParseError (/Users/wengffung/dev/web/weng/app/book-search/client/node_modules/webpack/lib/NormalModule.js:471:10)  
[1] at /Users/wengffung/dev/web/weng/app/book-search/client/node_modules/webpack/lib/NormalModule.js:503:5  
[1] at /Users/wengffung/dev/web/weng/app/book-search/client/node_modules/webpack/lib/NormalModule.js:358:12  
[1] at /Users/wengffung/dev/web/weng/app/book-search/client/node_modules/loader-runner/lib/LoaderRunner.js:373:3  
[1] at iterateNormalLoaders (/Users/wengffung/dev/web/weng/app/book-search/client/node_modules/loader-runner/lib/LoaderRunner.js:214:10)  
[1] at iterateNormalLoaders (/Users/wengffung/dev/web/weng/app/book-search/client/node_modules/loader-runner/lib/LoaderRunner.js:221:10)  
[1] /Users/wengffung/dev/web/weng/app/book-search/client/node_modules/react-scripts/scripts/start.js:19  
[1] throw err;  
[1] ^  
[1]   
[1] Error: error:0308010C:digital envelope routines::unsupported  
[1] at new Hash (node:internal/crypto/hash:79:19)  
[1] at Object.createHash (node:crypto:139:10)  
[1] at module.exports (/Users/wengffung/dev/web/weng/app/book-search/client/node_modules/webpack/lib/util/createHash.js:135:53)  
[1] at NormalModule._initBuildHash (/Users/wengffung/dev/web/weng/app/book-search/client/node_modules/webpack/lib/NormalModule.js:417:16)  
[1] at /Users/wengffung/dev/web/weng/app/book-search/client/node_modules/webpack/lib/NormalModule.js:452:10  
[1] at /Users/wengffung/dev/web/weng/app/book-search/client/node_modules/webpack/lib/NormalModule.js:323:13  
[1] at /Users/wengffung/dev/web/weng/app/book-search/client/node_modules/loader-runner/lib/LoaderRunner.js:367:11  
[1] at /Users/wengffung/dev/web/weng/app/book-search/client/node_modules/loader-runner/lib/LoaderRunner.js:233:18  
[1] at context.callback (/Users/wengffung/dev/web/weng/app/book-search/client/node_modules/loader-runner/lib/LoaderRunner.js:111:13)  
[1] at /Users/wengffung/dev/web/weng/app/book-search/client/node_modules/babel-loader/lib/index.js:59:103 {  
[1] opensslErrorStack: [  
[1] 'error:03000086:digital envelope routines::initialization error',  
[1] 'error:0308010C:digital envelope routines::unsupported'  
[1] ],  
[1] library: 'digital envelope routines',  
[1] reason: 'unsupported',  
[1] code: 'ERR_OSSL_EVP_UNSUPPORTED'  
[1] }  
[1]   
[1] Node.js v22.7.0
```

**Solution:**
Your package:
```
    "scripts": {  
        "start": "export NODE_OPTIONS=--openssl-legacy-provider node server.js"  
    // ...
```

Or you run in terminal:
```
export NODE_OPTIONS=--openssl-legacy-provider npm run start
```

If still doesn’t work
1. Delete `node_modules`  folder
2. Then install with: `npm install --openssl-legacy-provider`  and you may want to run npm audit fix --force

---

Note if you’re on the newer node versions that don’t even allow you to use the openssl-legacy that’s less secured (but some of your dependencies or old apps might require!), you get this error:
```
node: --openssl-legacy-provider is not allowed in NODE_OPTIONS
```

Then you may need to install nvm, then install a particular version of node using nvm, then run the script with nvm like so:
```
"build": "nvm use v22.8.0; NODE_OPTIONS=--openssl-legacy-provider react-scripts build",
```
^ CRA React  build script

Or like so:
```
        "start": "nvm use v22.8.0; export NODE_OPTIONS=--openssl-legacy-provider && if-env NODE_ENV=production && npm run start:prod || npm run start:dev",  
        "start:prod": "cd server && npm start",  
        "start:dev": "concurrently \"cd server && npm run watch\" \"cd client && npm start\"",
```
^ Typical npm start for full stack app with client/ and server/ folder split