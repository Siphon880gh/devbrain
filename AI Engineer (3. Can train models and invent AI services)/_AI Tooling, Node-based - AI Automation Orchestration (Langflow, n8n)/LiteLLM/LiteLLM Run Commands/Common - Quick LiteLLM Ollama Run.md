This works only if Ollama server is running at the default port 11434 and the model exists:
```
litellm --model ollama/deepseek-r1:latest
```

^Note this is just the command in [[Advanced - Run model server through LiteLLM without config.yaml]], except we skipped the flags `--host 127.0.0.1 --port 4000`. You can query LiteLLM using the those IP and port because they are the default when skipped.

Test the LiteLLM server with:
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