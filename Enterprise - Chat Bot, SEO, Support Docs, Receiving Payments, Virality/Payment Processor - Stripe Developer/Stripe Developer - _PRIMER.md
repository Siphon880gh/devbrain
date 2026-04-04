Aka: Get Started

## REFERENCE

Their Get Started Guide is at:
https://docs.stripe.com/api

Their boilerplates and sample codes are at:
https://docs.stripe.com/samples

---

## SETUP

### Create Stripe account, Activate Test Mode, Get Test Credit Card
You have to create a Stripe account and I recommend you get setup with Test Mode and testing credit cards so you can connect your code to Stripe and test your code before going into production. This setup does not require coding knowledge. Follow the instructions on my business notes on Stripe:  https://wengindustries.com/app/bizbrain/?open=Stripe%20-%20_PRIMER

Make sure you’re in Test Mode first. For more information on Test Mode:
![](460aIq1.png)

### API Keys

Get your API Key  

Top right "Developers" -> API Keys, Or visit https://dashboard.stripe.com/apikeys

There is more than one type of API key that you need. 

**Understandard there are standard vs restricted keys**
- Restricted keys lets you control access to their API
- Regardless of standard or restricted keys, further subclassified:

- Publishable keys (API key starts with pk_xxxx)
- Secret key (API key starts with sk_xxxx)

- Since you are in test mode, they actually precede with **pk_test_xxxx** and **sk_test_xxxx**. (This in contrast with pk_live_xxxx and sk_live_xxxx).


---

## PATHWAYS - SETUP CHARGEABLES 

### Non-Developer
Many of Stripe's features do NOT require coding. For managing Stripe information like products, its prices, pricing tables, etc, or implementing no-code embeds like ui price cards / payment button / link to checkout page into your website or app, go check out my Business notes on Stripe: https://wengindustries.com/app/bizbrain/?open=Stripe%20-%20_PRIMER

When it comes to making Stripe accessible on your website or app:
If you prefer no-code embed solutions (ui price card, ui payment button, pricing table), go check out my Business notes on Stripe: https://wengindustries.com/app/bizbrain/?open=Stripe%20-%20Payment%20links,%20ui%20price%20card,%20and%20ui%20pay%20button
### Developer
At a minimum, if you have a Stripe account but with no products, you can go ahead and start coding by setting up a custom payment. This is the type of payment where the price is generated on demand based on user's behavior and user's own configuration. The user sees the final price. Continue with the developer route, referring to [[Stripe Developer - Payments - Custom Payment]]

When it comes to making Stripe accessible on your website or app:
If instead of no-code embed solutions (ui price card, ui payment button, pricing table), you want to use Stripe Elements that lets you configure the element that renders because that depends on user behavior or user's own configurations, continue with the developer route, referring to [[Stripe Developer - Stripe Elements]]

---

## The Rest

Designing the products, their prices, any pricing tables, testing payment on your website or app, checking if your payment with the test credit card went through, checking if your email as a "customer" is saved at Stripe, etc, that all doesn't require coding, so follow my guide at the business notes for Stripe: https://wengindustries.com/app/bizbrain/?open=Stripe%20-%20_PRIMER
