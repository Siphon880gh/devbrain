Often case you would use `config.yaml` that defines the model name and what model server to hit, and you can define more than one; but in edge cases you may want to pass these settings in the command:
```
litellm --host 127.0.0.1 --port 4000 --model ollama/deepseek-r1:latest
```

Then you can test the LiteLLM server with:
```
% curl http://localhost:4000/v1/chat/completions \
  -H "Content-Type: application/json" \
  -d '{
    "model": "deepseek",
    "messages": [
      {"role": "user", "content": "Why is the grass green?"}
    ]
  }'
```