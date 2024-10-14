
You can see the price ID at Stripe.com
![](https://i.imgur.com/RkL7BZX.png)

Or you can list your prices with API call
NodeJS for all prices:
```
const stripe = require('stripe')('sk_test_51PbzEZ...');

const prices = await stripe.prices.list({

limit: 3,

});
```

You can search all prices who belongs to product id:
https://docs.stripe.com/api/prices/search?lang=node

You can list all products however they list the default price
https://docs.stripe.com/api/products/list?lang=node