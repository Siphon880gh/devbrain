**Why**

Using custom payment in the Stripe API is advantageous when you have pricing that changes depending on the app and user. With custom payments, you can dynamically calculate and charge varying amounts based on factors like user actions, product configurations, or usage within your app. This flexibility is particularly useful for apps offering personalized pricing, metered billing, or complex subscription models. You can integrate Stripe's API to handle custom logic on your server and ensure the correct amount is charged at the right time.

We will show the payable with Stripe Elements API rather than the no-code embed solutions like ui pricing card, ui payment button, etc

**Overview of Developer Custom Payment**

There are some reroutes. Stripe needs to initialize for a custom payout by creating a payment intent. stop payment and that will send a secret key back to the frontend so that the site element can render the iFrame that is your single price pay now form

On the frontend when the user is done filling in the information and clicking Pay Now, that is when you have a call back on whether it's a successful pay and that's when you can custom call your backend and this time your backend will create the customer account at Stripe if the email doesn't exist there or look up successfully the customer by the email address. Next your backend will attach the current payment that's successful to the customer by the payment intent ID which gets returned as part of the callback when the user clicks Pay Now and it reaches Stripe's backend. If your app logs in and signs up users, your backend should also save the customer ID upon creating a customer for the first time and you save it to your database by associating the customer id with the current logged in user

During anytime throughout the apps lifecycle you my query for all the payments are successful for a specific customer ID to check status etc

---

Custom payment is generated in real time by your server, and the ui for user to pay is also generated in real time with Stripe Elements API

Try sample code at **Custom Payment Flow**:  
[https://docs.stripe.com/payments/quickstart?lang=node](https://docs.stripe.com/payments/quickstart?lang=node)  


Or Weng’s sample code:
[https://github.com/Siphon880gh/stripe-api-elements-custom-payment-with-email-address-customers](https://github.com/Siphon880gh/stripe-api-elements-custom-payment-with-email-address-customers)

---

Check point. Do you have browser console error?

Browser console showing:
```
checkout.js:64 Uncaught (in promise) IntegrationError: stripe.confirmPayment(): expected either `elements` or `clientSecret`, but got neither.  
    at rawElements (v3/:1:369571)  
    at go (v3/:1:369661)  
    at bo (v3/:1:372300)  
    at wo (v3/:1:372818)  
    at v3/:1:434324  
    at async HTMLFormElement.handleSubmit (checkout.js:44:21)  
rawElements @ v3/:1  
go @ v3/:1  
bo @ v3/:1  
wo @ v3/:1  
(anonymous) @ v3/:1Understand this error
```

Vague error but if from starting out then make sure sk_test in server.js and the pk_test in checkout.js are valid

Move checkout.js script src to near bottom of body

Make sure you’ve opened http://localhost:4242/checkout.html and not use VS Code Live Preview or Open Default. When in VS Code Live Preview, you probably get an additional error “Method not allowed” for the POST because it would be posting to the VS Code’s Live Preview Port! Remember server.js sets public assets to public/ so that the filepath opens the filepath so http://localhost:4242/checkout.html opens the public/checkout.html file AND its fetch will connect on the same 4242 port.

![](https://i.imgur.com/ynd203z.png)

![](https://i.imgur.com/fLNqc3d.png)

---

Notice it’s missing the total price on this sample code though but that the calculateOrderAmount at server.js is 140 which means $1.40. Yes, the paymentIntents.create accepts in CENTS!

```
const calculateOrderAmount = (items) => {  
  // Replace this constant with a calculation of the order's amount  
  // Calculate the order total on the server to prevent  
  // people from directly manipulating the amount on the client  
  return 140;  
};  
  
app.post("/create-payment-intent", async (req, res) => {  
  const { items } = req.body;  
  
  // Create a PaymentIntent with the order amount and currency  
  const paymentIntent = await stripe.paymentIntents.create({  
    amount: calculateOrderAmount(items),  
    currency: "usd",  
    // In the latest version of the API, specifying the `automatic_payment_methods` parameter is optional because Stripe enables its functionality by default.  
    automatic_payment_methods: {  
      enabled: true,  
    },  
  });
```

^If you’re curious you can console.log the paymentIntent. The most important part is the status which will read 

“requires_payment_method" which is normal because card etc not selected yet. This endpoint is hit with frontend's initialize()

![](https://i.imgur.com/jPRmV8v.png)


Now test with a test credit card. For how to get a test credit card, refer to my Business notes for Stripe: 
https://wengindustries.com/app/bizbrain/?open=Stripe%20-%20_Test%20Credit%20Cards.md


And check your dashboard! Make sure you are in the Test version of the dashboard as you are testing with test keys
![](https://i.imgur.com/a65eQfM.png)

Click one of the successful rows like the $1 to see:
```
Payment details  
Statement descriptor: DEVELOPER  
Amount: $1.00  
Fee: $0.33  
  
Net: $0.67  
Status: Succeeded  
Description: No description
```



Stripe charges a 2.9% + .30 cents fee for every transaction
For $75, they receive $2.48

Summary:
From a webpage in my code, I used test credit cards to pay for a service. Then this Stripe dashboard shows the charges.

Customize being able to associate email to paid account (force sign in if email exists account)

Unfortunately Stripe Elements (provided ui's to developers) as of 7/2024 do not support email field. But we can work around that

Notice the fields are iframe, so you can’t modify them
![](https://i.imgur.com/a7TYN1i.png)

Trying to modify the iframe directly gets you the error: VM3841:1 Uncaught DOMException: Failed to read a named property 'document' from 'Window': Blocked a frame with origin "[http://localhost:4242](http://localhost:4242)" from accessing a cross-origin frame.  
at `<anonymous>:1:80`

But you can insert your email above the iframe. So you have code to insert that (Email field) once payment method is ready:
```
  const paymentElement = elements.create("payment", paymentElementOptions);  
  paymentElement.mount("#payment-element");  
  
  paymentElement.on("ready", handleReady);  
  async function handleReady(e) {  
    // alert("Ready")  
    var paymentElementInner = document.querySelector("#payment-element .__PrivateStripeElement");  
    var iframeElement = paymentElementInner.querySelector("iframe");  
    var newElement = document.createElement("div");  
  
    newElement.innerHTML = `  
      <div class="p-GridCell p-GridCell--12 p-GridCell--sm6">  
        <div data-field="email" class="p-Field">  
          <label class="p-FieldLabel Label Label--empty" for="Field-email">Email</label>  
          <div>  
            <div class="p-Input">  
              <input type="text" name="email" id="Field-email" placeholder="name@domain.com" aria-invalid="false" aria-required="true" class="p-Input-input Input Input--empty p-Input-input--textRight" value="demo_1@tests.videolistings.ai">  
            </div>  
          </div>  
          <div class="AnimateSinglePresence"></div>  
        </div>  
      </div>  
    `;
```

You want the styling of your email to look right
![](https://i.imgur.com/v80Wf8y.png)

Use this css:

Notice it might not be perfect or wont work if Stripe changes their styling / coding
```
<style>  
      .p-GridCell--12 {  
          width: 100%;  
      }  
      .p-GridCell {  
          display: inline-block;  
          margin-bottom: 0.75rem;  
          /* padding-left: 1.75rem; */  
          vertical-align: top;  
      }  
      .Label {  
          margin-bottom: 0.25rem;  
          font-size: 0.93rem;  
          transition: transform 0.5s cubic-bezier(0.19, 1, 0.22, 1), opacity 0.5s cubic-bezier(0.19, 1, 0.22, 1);  
      }  
      .p-FieldLabel {  
          display: block;  
      }  
      .p-CardNumberInput {  
          position: relative;  
      }  
      .p-Input {  
          position: relative;  
      }  
  
    .Input, .p-FauxInput {  
        padding: 0.75rem;  
        background-color: #fff;  
        border-radius: 5px;  
        transition: background 0.15s ease, border 0.15s ease, box-shadow 0.15s ease, color 0.15s ease;  
        border: 1px solid 5px;  
        box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.03), 0px 3px 6px rgba(0, 0, 0, 0.02);  
    }  
    .p-Input-input {  
        -webkit-animation: native-autofill-out 1ms;  
        animation: native-autofill-out 1ms;  
        display: block;  
        width: 100%;  
    }  
    input, optgroup, select, textarea {  
        -webkit-appearance: none;  
        -moz-appearance: none;  
        appearance: none;  
        border-radius: 0;  
        border-style: none;  
        box-shadow: none;  
        color: inherit;  
        -webkit-filter: none;  
        filter: none;  
        font: inherit;  
        letter-spacing: inherit;  
        outline-offset: 0;  
        outline-width: 2px;  
        font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;  
    }  
    </style>
```

Then you need to capture the id’s etc so adjust confirmPayment from frontend:

And look at result on success. Btw `redirect: “if_required”`  is so you’re not forced to provide a redirect url with a `confirmParams.return_url`
```
  const rpromPaid = await stripe.confirmPayment({  
    elements,  
    redirect: 'if_required'  
  }).then(function(result) {  
    if (result.error) { alert("Error: ", result.error); return; }  
    console.log(result);  
    debugger;  
  });
```

In the then, you can redirect the user at that time. For your feature engineering, the callback url gets appended the url params: `?payment_intent=pi_3PcNBtGTagL4o8i40RwjfBBC&payment_intent_client_secret=pi_3PcNBtGTagL4o8i40RwjfBBC_secret_EJRCr7csYojAzNa8s4qx186EF&redirect_status=succeeded` 

More specifically, adjust that to:
```
  const rpromPaid = await stripe.confirmPayment({  
    elements,  
    redirect: 'if_required'  
    // confirmParams: {  
    //   // Make sure to change this to your payment completion page  
    //   return_url: "http://localhost:4242/checkout.html",  
    // },  
  }).then(function(result) {  
    if (result?.error) { alert("Error: ", result.error?.message); return; }  
  
    console.log(result);  
  
  
    /* Send to backend  
     * result.paymentIntent.id  
     * pi_XXX  
  
     * result.paymentIntent.status  
     * "succeeded"  
     *   
     */   
  
    fetch("/confirmed-payment", {  
      method: "POST",  
      headers: { "Content-Type": "application/json" },  
      body: JSON.stringify({   
        paymentIntentId: result.paymentIntent.id,   
        email: document.getElementById("Field-email").value}),  
    }).then(response => response.json())  
    .then(data => {  
        console.log(data);  
        // alert("Payment confirmed");  
    });  
  
    // debugger;  
  
  }).catch(function(error) {  
    console.log({error});  
  })
```

Their sample code expects the page to have redirected already otherwise the else will show a general error occurred. So adjust the error reporting still at checkout.js:
```
  // This point will only be reached if there is an immediate error when  
  // confirming the payment. Otherwise, your customer will be redirected to  
  // your `return_url`. For some payment methods like iDEAL, your customer will  
  // be redirected to an intermediate site first to authorize the payment, then  
  // redirected to the `return_url`.  
  if (error?.type === "card_error" || error?.type === "validation_error") {  
    showMessage(error.message);  
  } else if(error?.code) {  
    showMessage("An unexpected error occurred.");  
  } else {  
    checkStatus()  
  }
```


Payments can now be associated with emails, Which means we are a lot closer to tracking if an user has paid their bills in our web app.

![](https://i.imgur.com/RPPb3w9.png)


My small checkout form is updated with email field:
![](https://i.imgur.com/S6c7UMF.png)

You’ll want to test that new customers are created when you paid with an email address. Go to Customers. If you use a new email and pay, it creates a new customer. If using an old email and pay, it does not create a new customer.
![](https://i.imgur.com/3eptchc.png)

![](https://i.imgur.com/KbhyvCa.png)

Clicking the customer will show you ALL previous payments
![](https://i.imgur.com/p2XpgTY.png)
  
Now for your app to fully work you’ll need another endpoint to retrieve successful payments. Our goal is to fetch the backend like [http://localhost:4242/payments/:customerID](http://localhost:4242/payments/:customerID) and it could return something like this:
```
{  
"successfulPayments": [  
 {..}  
],  
"failedPayments": []  
}
```

Add the endpoint to server.js like this:
```
app.get('/payments/:customerId', async (req, res) => {  
  const customerId = req.params.customerId;  
  
  try {  
    // Retrieve all PaymentIntents for the customer  
    const paymentIntents = await stripe.paymentIntents.list({  
      customer: customerId,  
      limit: 100,  
    });  
  
    // Filter for successful and failed payments  
    const successfulPayments = paymentIntents.data.filter(pi => pi.status === 'succeeded');  
    const failedPayments = paymentIntents.data  
      .filter(pi => pi.status === 'requires_payment_method')  
      .map(pi => ({  
        paymentIntent: pi,  
        failureReason: pi.last_payment_error ? pi.last_payment_error.message : 'Unknown reason',  
      }));  
  
    const filteredPayments = {  
      successfulPayments,  
      failedPayments,  
    };  
  
    res.status(200).json(filteredPayments);  
  } catch (error) {  
    console.error('Error retrieving payments:', error);  
    res.status(500).json({ error: error.message });  
  }  
});
```


Visit [http://localhost:4242/payments/:customerID](http://localhost:4242/payments/:customerID) directly with one of your customer Id’s, for example [http://localhost:4242/payments/cus_XAKmNWwIuWEnbE](http://localhost:4242/payments/cus_QTKmNWwIuWEnbE)

Btw to have a smoother developer experience I recommend at the Dashboard Customers, you add the column customer id:

![](https://i.imgur.com/BPAppZW.png)
  
The default view didn’t have customer id which is a bad move on Stripe. Now we have customer_id column:
![](https://i.imgur.com/jBSnK8j.png)

This Primer could go on and on to create you a full app but you should have enough foundation at this point. Next things you might want to consider. When you’re checking users’ latest tier, you have to use logic to check the payments to see which one most relevant (the most latest payment). You may need other identifying or meta data. You can add metadata to both customers and payment intents in Stripe, depending on what you need to achieve. Refer to [[Stripe - Add meta data (Payment or Customer)]]. For your full app, you might also need a live server that takes web hooks: Stripe has webhooks for many events like new customer or new payment creations, then Stripe can send that information to your live server, and your live server can update your app’s database.  

Next tasks for the full app when it comes to user logging in to buy items or not needing to login to buy items or not even needing to have an account to login (less user friction to buying if you dont force them to sign up right away):

- if user is already logged in, then the email field is hidden so they wont accidentally make a typo

- If the email address isn't registered with an account with us, it'll ask for their password so they can sign up after the cart

- Another coding task is if they paid at checkout and dont register right away after the cart, we still have their email and as long as they register with the same email address in the future, they will have access to what they purchased in our web app.

---

**Next challenges:**

- **You may notice after clicking Pay Now, it refreshes the checkout. It didn’t actually refresh. That’s the page that shows when successful. Change it to a Thank you page. Clue: We disabled redirecting in the above primer. So you can redirect with window.location in the then. Notice at checkout.js:**
- Change:
	```
	async function handleSubmit(e) {  
	  e.preventDefault();  
	  setLoading(true);  
	  
	  const { error } = await stripe.confirmPayment({  
	    elements,  
	    confirmParams: {  
	      // Make sure to change this to your payment completion page  
	      return_url: "http://localhost:4242/checkout.html",  
	    },  
	  });
	```
	changed into:
	```
	const rpromPaid = await stripe.confirmPayment({  
	    elements,  
	    redirect: 'if_required' // to disable strictness about redirecting with return_url  
	    // confirmParams: {  
	    //   // Make sure to change this to your payment completion page  
	    //   return_url: "http://localhost:4242/checkout.html",  
	    // },  
	  }).then(function(result) {  
	//...  
	  
	 })  
	  
	  var error = {rpromPaid};  
	  
	  if (error?.type === "card_error" || error?.type === "validation_error") {  
	    showMessage(error.message);  
	  } else if(error?.code) {  
	    showMessage("An unexpected error occurred.");  
	  } else {  
	    checkStatus()  
	  }
	```

- **Then test the card variations that will trigger failed payment etc**
- Associate with accounts and bills**
- **be able to query api for that account’s information (have they paid, etc)**

---

**More Events?**

If you need code to run when the ui that lets people pay is done loading at `element.on('ready',handler)`: [https://docs.stripe.com/js/element/events](https://docs.stripe.com/js/element/events)

There are also other events like click, focus (when user gest the ui in focus), blur