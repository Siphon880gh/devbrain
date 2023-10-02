
Status: Written as I developed a chrome extension that called OpenAI with fetch calls (no backend). 
Status: This needs to be rewritten to user friendly.

---


Highlights:
Can do in Chrome Extension content.js
There’s Chat Completion and just Completion



If not using LangChain, you can convert the sample CURL from OpenAI’s documentation into fetch

Get which model you’re using, what endpoint they support, and what’s the body format they expect

https://platform.openai.com/docs/models/

And the data that’s responded from each model might differ
eg. this works for gpt-4-0613 but not another model:
var response = data.choices[data.choices.length - 1].message.content; 

You can request for the models you have available for your API
`GET https://api.openai.com/v1/models`
https://platform.openai.com/docs/api-reference/models



ChatGPT 4 is not available if you never paid for OpenAI successfully. So you may need to cancel your payment plan, start another one, and choose to add credit. You need to pay at least $1 to unlock ChatGPT 4 model on your fresh account.

https://help.openai.com/en/articles/8264644-what-is-prepaid-billing
https://platform.openai.com/account/billing/overview




Longevity
Models keep getting discontinued, so your app might need to be continually maintained.
It’s safer to have “gpt-4" as model which will point to the latest variant
https://platform.openai.com/docs/models/continuous-model-upgrades





On setting max tokens in the fetch:

Someone’s guess -

Another point of confusion is max_tokens defaults to 16 – has anyone confirmed this? I haven’t used the API, but the ChatGPT website completions can be longer than 16 tokens.

That is only for completions endpoints, which makes setting the max_tokens value essentially required.

For chat completion endpoint, you can simply not specify a max_token value, and then all the remaining completion space not used by input can be used for forming a response, without needing careful tedious token-counting calculation to try to get close.

Reminder, max_tokens is a reservation of the model’s context length that is exclusively for forming your answer, as well as setting a limit to how much comes back.

https://community.openai.com/t/clarification-for-max-tokens/19576/6



Chat Completions vs Completions

Completions (1 prompt, many output)
https://platform.openai.com/docs/api-reference/chat
https://api.openai.com/v1/chat/completions

Chat Completions (Many prompts in a chat history)
https://api.openai.com/v1/completions
https://platform.openai.com/docs/api-reference/completions/create


---



The messages receive system (instructing how to morph into an assistant), user (your prompt(s)), and assistant (AI’s response(s))
```
    messages=[
        {"role": "system", "content": "You are a helpful assistant."},
        {"role": "user", "content": "Who won the world series in 2020?"},
        {"role": "assistant", "content": "The Los Angeles Dodgers won the World Series in 2020."},
        {"role": "user", "content": "Where was it played?"}
    ]
```



So
The full fetch
```
fetch('https://api.openai.com/v1/chat/completions', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
    'Authorization': 'Bearer ' + "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"
  },
  body: JSON.stringify({
    messages: [
        {"role": "system", "content": "You are a helpful stocks trading bot and tutor."},
        {"role": "user", "content": "Explain to me the moving average indicator? Keep it short"}
    ],
    model: "gpt-4-0613",
    temperature: 0.7,
    stop: '\n'
  })
})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.error(error));
```


Expect response to be:
```
data.choices[0].message.content;  
```


Setting max_tokens like in 
```
  body: JSON.stringify({
    messages: [
        {"role": "system", "content": "You are a helpful stocks trading bot and tutor."},
        {"role": "user", "content": "Explain to me the moving average indicator? Keep it short"}
    ],
    model: "gpt-4-0613",
    max_tokens: 8192,
    temperature: 0.7,
    stop: '\n'
  })
```

is actually allocating that much tokens expected at completion. You should just avoid doing that or it’ll likely just pass the max_tokens and error out with an error like: This model's maximum context length is 8192 tokens. However, you requested 8225 tokens (33 in the messages, 8192 in the completion). Please reduce the length of the messages or completion. 


---


What is context
This model's maximum context length is 8192 tokens. However, you requested 8201 tokens (9 in the messages, 8192 in the completion). Please reduce the length of the messages or completion."
