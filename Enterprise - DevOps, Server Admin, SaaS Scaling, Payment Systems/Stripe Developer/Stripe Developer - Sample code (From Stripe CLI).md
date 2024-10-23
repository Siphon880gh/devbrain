#### Option 1: Installing with Stripe CLI

1. If you haven't already installed the CLI, follow the [installation steps](https://stripe.com/docs/stripe-cli#install) ([https://docs.stripe.com/stripe-cli#install](https://docs.stripe.com/stripe-cli#install)) (`brew install stripe/stripe-cli/stripe`) . The CLI is useful for cloning samples and locally testing webhooks and Stripe integrations.
    
2. Ensure the CLI is linked to your Stripe account by running:
	```
	stripe login
	```

3. Start the sample installer and follow the prompts with:
	```
	stripe samples create subscription-use-cases
	```

The CLI will walk you through picking your integration type, server and client languages, and partially configuring your `.env` file with your Stripe API keys.

From:
https://github.com/stripe-samples/subscription-use-cases#option-1-installing-with-stripe-cli

---

Nice because:
```
✔ Selected integration: fixed-price-subscriptions   
✔ Selected client: vanillajs   
✔ Selected server: node   
✔ Files copied  
✔ Project configured  
You're all set. To get started: cd subscription-use-cases
```

You can list all samples with:
```
stripe samples list
```

You can view them more comfortably in a text file than in the terminal with:
```
stripe samples list >> a.txt
```
^Then open a.txt

---

The sample code generated by stripe cli are more complicated but that’s because the UI is more educational:

cli:
![](https://i.imgur.com/6cVfWB5.png)

When you download directly from their get started guides:
[https://docs.stripe.com/payments/quickstart](https://docs.stripe.com/payments/quickstart)

![](https://i.imgur.com/GTaqwG8.png)