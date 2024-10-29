As of July 2024, Elements API with Custom Payment does not support Email input. The element it creates is actually an iframe that you do not have permission to modify.

However, there is a workaround when performing the custom payment. You would create an email input above the Elements API and conform its style to the style of what's inside the iframe. When user pays, your server will get the email and then update the existing customer at Stripe with the new email or creating the new customer at Stripe.

Result at Stripe.com:
![](https://i.imgur.com/xwWV5qb.png)

---

In contrast, no-code embed solutions like ui price card, ui payment button, or pricing tables, or checkout page links - they all have the email input at checkout.
