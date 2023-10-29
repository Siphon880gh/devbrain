Debug Express route method, url, payload - Place into server.js before all your routes:
```
// Debug
const debugMiddleWare = (req,res,next) => {
    console.log("*** Route Debugging ***");
    console.log({req_originalUrl:req.originalUrl, req_method:req.method});
    console.log({req_body:req?.body})
    console.log({req_query:req?.query})
    console.log({req_headers:req?.headers})

    next();
}
server.use(debugMiddleWare);
```

If you have no access to the console, then fs.appendFile appending to a log:

```
javascript
const fs = require('fs');

fs.appendFile('express.log', 'data to append', function (err) {
  if (err) throw err;
  console.log('Saved!');
});
```

Alternate:
```
const fs = require('fs');

fs.appendFileSync('message.txt', 'data to append');
```
