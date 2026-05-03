Goal:
Asynchronously invoke flows to run in the background. No waiting for response.

Requirement:
You already know how to change Langflow into an api call that can invoke the flow to run, per [[Lv 5.4 - Langflow - Flow API Endpoint]]

You changed Langflow into an api call. So whatever flow gets designed in langflow, it can be called at an api endpoint. 

You want to create a webhook at the Langflow side so that when you plan to invoke the Langflow, you intend to have that flow run in the background. It's a quick invoke and go, invoke and go, etc. 

Unfortunately as of 2/2025, the Langflow webhook responds with a 
```
{"message":"Task started in the background","status":"in progress"}
```

But it does not respond with a job id that you can check the status or get result from. You won't be able to see the AI response at the canvas. Therefore, you log to an external api point, referring to [[Lv 5.3 - Langflow - Send an API request to an external endpoint]]

---

**Setup**

Use a Basic Prompting without System Message as a base:
![[Pasted image 20250209214038.png]]


Then change it to:
- Leave Webhook payload blank because that will be filled by your webhook api call
- At Data to Message, make sure Template is: `{text}`
![[Pasted image 20250213011746.png]]

Then, finally add a way to see your webhook job's get finished, referring to [[Lv 5.3 - Langflow - Send an API request to an external endpoint]] to create an external logger of AI responses.... so to the right of "Chat Output":
![[Pasted image 20250213014722.png]]

---

By adding a webhook, when you go to API
![[Pasted image 20250213011802.png]]

A new tab will appear showing you the api request to make in order to trigger the Langflow webhook for an asynchronous background job
![[Pasted image 20250213011825.png]]

When you send the data to the api endpoint, the webhook part of the flow will intercept your data, then extract the `text` key's value (because Data to Message template is set to `{text}`), then sends it to the OpenAI Input. Write a cURL request at your terminal; here I'm asking the average height of NBA players:
```
curl -X POST \
  "http://localhost:7860/api/v1/webhook/ccf75710-aee9-402e-80b5-bc846d9d4143" \
  -H 'Content-Type: application/json'\
  -d '{"text": "How tall is the average NBA player?"}'
```


![[Pasted image 20250213011746.png]]

You'll get back a response:
```
{"message":"Task started in the background","status":"in progress"}
```


Then visit the logged text file at your webhost, like:
https://wengindustries.com/test_langflow/langflow.txt

You should get the AI response like:
![[Pasted image 20250213014855.png]]

Specifically, the log is:
```
2025-02-13 06:15:32 - POST request - Data: "{\n    \"timestamp\": \"2025-02-13 09:36:32 UTC\",\n    \"sender\": \"Machine\",\n    \"sender_name\": \"AI\",\n    \"session_id\": \"ccf75710-aee9-402e-80b5-bc846d9d4143\",\n    \"text\": \"As of recent data, the average height of an NBA player is approximately 6 feet 7 inches (about 2.01 meters). This average can vary slightly from season to season, but it has generally remained around this height in recent years.\",\n    \"files\": [],\n    \"error\": false,\n    \"edit\": false,\n    \"properties\": {\n        \"text_color\": \"\",\n        \"background_color\": \"\",\n        \"edited\": false,\n        \"source\": {\n            \"id\": \"OpenAIModel-vUuHz\",\n            \"display_name\": \"OpenAI\",\n            \"source\": \"gpt-4o-mini\"\n        },\n        \"icon\": \"OpenAI\",\n        \"allow_markdown\": false,\n        \"positive_feedback\": null,\n        \"state\": \"complete\",\n        \"targets\": []\n    },\n    \"category\": \"message\",\n    \"content_blocks\": [],\n    \"id\": \"5330663e-098a-4ff2-82b0-0fc9fb6380d9\",\n    \"flow_id\": \"ccf75710-aee9-402e-80b5-bc846d9d4143\"\n}"
```

**Congratulations!** You now leverage the webhook component which allows for a webhook api endpoint to trigger flows to run as asynchronous jobs, allowing you to run a batch of flows in a quick "touch and go" fashion.