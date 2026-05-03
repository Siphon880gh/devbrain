When you or your server is triggering a n8n workflow via the webhook trigger, you want to have protective measures.

You could turn on the workflow only for the time it's needed and/or password protect your webhook trigger:

![[Pasted image 20250702212358.png]]

Otherwise if a malicious hacker or bot scanned your webhook, you're gonna get a huge bill, especially if it's connected to OpenAI.