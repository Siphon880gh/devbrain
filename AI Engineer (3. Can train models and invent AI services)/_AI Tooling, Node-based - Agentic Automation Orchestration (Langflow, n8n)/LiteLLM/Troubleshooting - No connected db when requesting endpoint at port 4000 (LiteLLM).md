```
 curl http://localhost:4000/v1/chat/completions \
  -H "Authorization: Bearer sk-your-litellm-master-key" \
  -H "Content-Type: application/json" \
  -d '{
    "model": "deepseek",
    "messages": [
      {"role": "user", "content": "Give me a one-sentence summary of LiteLLM"}
    ]
  }'
{"error":{"message":"No connected db.","type":"no_db_connection","param":null,"code":"400"}}%  
```

Make sure your Authorization Bearer matches the master password in config.yaml that you ran LiteLLM with