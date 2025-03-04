## PATHWAYS
If instead of no-code embed solutions (ui price card, ui payment button, pricing table), you want to use Stripe Elements that lets you configure the element that renders because that depends on user behavior or user's own configurations, continue with this tutorial.

If you want no-code embed solutions, refer to my business notes on Stripe: https://wengindustries.com/app/bizbrain/?open=Stripe%20-%20Payment%20links,%20ui%20price%20card,%20and%20ui%20pay%20button

---

## Stripe Elements API

The code usually starts with:
```
const elements = stripe.elements(options);
```

Your options are the configurations that lets Stripe Elements API know what to render. It's usually a checkout page in a card.

The rendered element is actually an iframe that you do not have permission to modify its contents of.

For guides:
https://docs.stripe.com/payments/elements

My tutorial on creating Custom Payment actually uses Stripe Elements API: [[Stripe Developer - Payments - Custom Payment]]