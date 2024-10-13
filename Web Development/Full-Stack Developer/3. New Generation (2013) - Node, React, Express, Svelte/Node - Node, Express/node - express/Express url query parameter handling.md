
To handle URL query parameters (the part of the URL after the `?` symbol), Express provides a separate middleware called `express.query`. However, it's worth noting that Express automatically parses URL query parameters by default, so you don't need to use the `express.query` middleware explicitly to access query parameters. They will be available in the `req.query` object directly.


To handle URL query parameters (the part of the URL after the `?` symbol), Express provides a separate middleware called `express.query`. However, it's worth noting that Express automatically parses URL query parameters by default, so you don't need to use the `express.query` middleware explicitly to access query parameters. They will be available in the `req.query` object directly.

Here's an example of how to use `express.urlencoded` and handle URL query parameters in an Express app:

```javascript
const express = require('express');
const app = express();

app.get('/example', (req, res) => {
  // Accessing query parameters
  const queryParam1 = req.query.param1;
  const queryParam2 = req.query.param2;

  // Respond with the query parameters
  res.send(`Query Param 1: ${queryParam1}, Query Param 2: ${queryParam2}`);
});


app.listen(3000, () => {
  console.log('Server running on http://localhost:3000');
});
```

With this setup, when you make a GET request to `/example?param1=value1&param2=value2`, you'll see the query parameters displayed in the response. 
