### Testing a Webhook Workflow in n8n

You are testing a workflow that triggers when a remote script or local development script connects to your n8n **Webhook Trigger**'s URL

The webhook node:
![[Pasted image 20250606225123.png]]

Let's test this out. First open into the Webhook node:
![[Pasted image 20250606224242.png]]

Next, **click "Listen"** at the left panel. This activates the webhook so it can receive incoming requests for one time at the Test URL. It can receive payload. To trigger your webhook from a remote app or your local developmemt machine, make sure you have some checks done:
- **Test and Production URLs are different**. When clicking "Listen for test event", it will use the Test URL, regardless which Test tab or Production tab is selected. The purpose of the tabs "Test URL" and "Production URL" isn't to change what URL is for the webhook test - it's to change the authentication, responding, and other options. The "Production URL" only gets used when the Workflow is turned to on. The "Test URL" only gets used when you click the button to "Listen for test event". The difference between those two urls are whether or not "-test" suffixes the `/workflow` subpath in the URL.
	- Test URL: http://localhost:5678/webhook-test/2fef566c-411c-459e-9d94-3e461908733a
	- Production URL: http://localhost:5678/webhook-test/2fef566c-411c-459e-9d94-3e461908733a
	- If you don't like the long hashed subpath, you can customize into a more readable URL at the field "Path"
- Make sure your app or script that will make a request has the correct URL (the Test URL). You can copy the URL below the tabs, or you can copy the URL on the "Test URL" tab panel.
![[Pasted image 20250606224516.png]]

Then, send a request to your n8n server—either from your app or via the terminal using a tool like `curl`. Optionally, you can send a request with payload (See body field in the output at the below screenshot).

Example production request:
```
curl -X POST https://your-n8n-server/webhook/my-webhook \
  -H "Content-Type: application/json" \
  -d '{"message": "Hello from production"}'
```

Or you could send via a Postman request:
![[Pasted image 20250617064614.png]]

After request is sent, the listening will stop immediately because we are running the webhook in Test Mode when we pressed the button "Listen for test event". The result will produce on the right panel:
![[Pasted image 20250606224620.png]]

---

### Going Live with Your Webhook

When you're ready to move the workflow to **production** (i.e., 24/7 access), you need to **enable the workflow**. Once enabled, n8n will automatically listen for incoming requests at the **production webhook URL**, without needing to manually click "Listen".
![[Pasted image 20250606225407.png]]

Just make sure your app or script is sending requests to the **production URL**—this is the one n8n will respond to once the workflow is live.