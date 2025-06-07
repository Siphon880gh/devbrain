### Testing a Webhook Workflow in n8n

You are testing a workflow that triggers when a remote script or local development script connects to your n8n **Webhook Trigger**'s URL

The webhook node:
![[Pasted image 20250606225123.png]]

Let's test this out. First open into the Webhook node:
![[Pasted image 20250606224242.png]]

Next, **click "Listen"** at the left panel. This activates the webhook so it can receive incoming requests for one time. To trigger your webhook from a remote app or your local developmemt machine, make sure you have some checks done:
- **Test and Production URLs are different**. You switch between them by clicking the tabs at either "Test URL" or "Production URL". Either selection is fine.
- Make sure your app or script that will make a request, has the correct URL depending on whether you're testing the Test URL or the Production URL. You can copy the URL below the tabs, or you can copy the URL on the panel that's listening.
![[Pasted image 20250606224516.png]]

Then, send a request to your n8n server—either from your app or via the terminal using a tool like `curl`. Optionally, you can send a request with payload (See body field in the output at the below screenshot).

Example production request:
```
curl -X POST https://your-n8n-server/webhook/my-webhook \
  -H "Content-Type: application/json" \
  -d '{"message": "Hello from production"}'
```

After request, the listening will stop, the result will produce on the right panel:
![[Pasted image 20250606224620.png]]

---

### Going Live with Your Webhook

When you're ready to move the workflow to **production** (i.e., 24/7 access), you need to **enable the workflow**. Once enabled, n8n will automatically listen for incoming requests at the **production webhook URL**, without needing to manually click "Listen".
![[Pasted image 20250606225407.png]]

Just make sure your app or script is sending requests to the **production URL**—this is the one n8n will respond to once the workflow is live.