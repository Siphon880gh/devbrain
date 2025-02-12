You can change langflow into an api call. So whatever flow gets designed in langflow, it can be called at an api endpoint. You can also pass in a text prompt into that api endpoint.

Go to the API section (next to Playground):
![[Pasted image 20250211023117.png]]

Then go to JS API even if that's not your intended language, because we can quickly test the API endpoint works:
![[Pasted image 20250211023138.png]]

You can leave api key empty since we didn’t design it to have api key. 

inputVal is where you ask the question

Notice you leave it as an empty object at `"ChatInput-nzReG": {},` 

Leave x-api-key as an empty string if you have not set your personal API key (at Create Secret Key under user settings). Must be empty string or your proper api key. Note omitting the field entirely will just have the api call not work.

The code could be:
```
let inputValue = "How tall is Mt Everest?"; // Insert input value here  
  
fetch(  
  "http://127.0.0.1:7860/api/v1/run/4dcc99b0-abbc-4ead-ac35-f06662ca7076?stream=false",  
  {  
    method: "POST",  
    headers: {  
      "Authorization": "Bearer <TOKEN>",  
      "Content-Type": "application/json",  
      "x-api-key": ""  
    },  
    body: JSON.stringify({  
			input_value: inputValue,   
      output_type: "chat",  
      input_type: "chat",  
      tweaks: {  
        "ChatInput-nzReG": {},  
        "ParseData-FbccD": {},  
        "Prompt-biLDw": {},  
        "SplitText-BOjKF": {},  
        "ChatOutput-nVBSx": {},  
        "OpenAIEmbeddings-kewwl": {},  
        "OpenAIEmbeddings-6N9he": {},  
        "File-gwhdc": {},  
        "OpenAIModel-vkFdj": {},  
        "AstraDB-Mgox3": {},  
        "AstraDB-SntPT": {}  
}  
    }),  
  },  
)  
  .then(res => res.json())  
  .then(data => console.log(data))  
  .catch(error => console.error('Error:', error));
```

Then just run in the Chrome DevTools console
Chrome: CMD+SHIFT+I → Console tab

Wait a few seconds for the response
![[Pasted image 20250211031012.png]]

The path to it was:
`data.outputs[0].outputs[0].results.message.text;`

Message object was:
```
{
    "text_key": "text",
    "data": {
        "timestamp": "2025-02-11T11:09:23+00:00",
        "sender": "Machine",
        "sender_name": "AI",
        "session_id": "4dcc99b0-abbc-4ead-ac35-f06662ca7076",
        "text": "Mt Everest is approximately 8,848 meters or 29,029 feet tall.",
        "files": [],
        "error": false,
        "edit": false,
        "properties": {
            "text_color": "",
            "background_color": "",
            "edited": false,
            "source": {
                "id": "OpenAIModel-vkFdj",
                "display_name": "OpenAI",
                "source": "gpt-4"
            },
            "icon": "OpenAI",
            "allow_markdown": false,
            "positive_feedback": null,
            "state": "complete",
            "targets": []
        },
        "category": "message",
        "content_blocks": [],
        "id": "b6ff6ffe-33ed-4db1-9448-ac67e141ceaa",
        "flow_id": "4dcc99b0-abbc-4ead-ac35-f06662ca7076"
    },
    "default_value": "",
    "text": "Mt Everest is approximately 8,848 meters or 29,029 feet tall.",
    "sender": "Machine",
    "sender_name": "AI",
    "files": [],
    "session_id": "4dcc99b0-abbc-4ead-ac35-f06662ca7076",
    "timestamp": "2025-02-11T11:09:23+00:00",
    "flow_id": "4dcc99b0-abbc-4ead-ac35-f06662ca7076",
    "error": false,
    "edit": false,
    "properties": {
        "text_color": "",
        "background_color": "",
        "edited": false,
        "source": {
            "id": "OpenAIModel-vkFdj",
            "display_name": "OpenAI",
            "source": "gpt-4"
        },
        "icon": "OpenAI",
        "allow_markdown": false,
        "positive_feedback": null,
        "state": "complete",
        "targets": []
    },
    "category": "message",
    "content_blocks": []
}
```

Results object was just:
```
{
	message: {..}
}
```

**Congratulations! You made an API call with a desired prompt, and you've gotten a proper response back with an AI answer from the flow**

---

**Correlating to the official docs**

If you read the official docs on how to trigger a flow to run:
https://docs.langflow.org/api-reference-api-examples

You'll see it recommended saving the domain URL to langflow gui and the flow id. One of the api endpoints in the docs is:
```
curl -X POST \
  "$LANGFLOW_URL/api/v1/build/$FLOW_ID/flow" \
  -H "accept: application/json" \
  -H "Content-Type: application/json" \
  -H "x-api-key: $LANGFLOW_API_KEY" \
  -d '{"input_value": "hello, how are you doing?"}'
```

That's pretty similar to the API endpoint that we've used from the API page. The difference is that the curl command here is using the two variables to build the URL. The URL would've still equated similar to `http://127.0.0.1:7860/api/v1/run/4dcc99b0-abbc-4ead-ac35-f06662ca7076?stream=false`

---


**FYI:**  
Tweaks is where you can override some settings already in the flow:
![[Pasted image 20250211023223.png]]

----

**Challenge**
A good challenge is to dockerize this so you can easily launch it on your server and connect to a specific port. This would mean you can create AI apps or microservices with minimal coding because you can leverage the drag and drop nature of Langflow, then deploy to your server!
