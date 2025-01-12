Get your API Key (for example, at OpenAI API Developer Platform).

See what models are available to you with the API key at their vendor's resources available endpoint (In this case, OpenAI):
```
https://api.openai.com/v1/models \  
  -H "Authorization: Bearer {KEY}" \  
  -H "OpenAI-Organization: {ORG_ID}"
```

You may need to enable models manually at your AI vendor's dashbaord (Eg. OpenAI):
![](https://i.imgur.com/YeMnjFs.png)


And in Cursor AI, make sure to enable the models that were in your resources endpoint response:
![](https://i.imgur.com/DaBBW6X.png)


If you keep seeing that it says you’ve reached your limits when using an api key in cursor, make sure correct models are enabled and you have enough credits at your AI vendor (eg. OpenAI, which requires at least $10)
