## Helpful checks

Before debugging LiteLLM, check these first:

```bash
curl http://localhost:11434
ollama list
```

You want:

- `curl` to return `Ollama is running`
- `ollama list` to show at least one installed model
    
If both are good, then LiteLLM has a live local backend it can use. ([Ollama](https://ollama.com/blog/openai-compatibility?utm_source=chatgpt.com "OpenAI compatibility · Ollama Blog"))

## Bottom line

Ollama gives you the local model server. LiteLLM gives you the cleaner gateway layer on top. A good rule is: verify Ollama first, then connect LiteLLM to it. ([liteLLM](https://docs.litellm.ai/ "liteLLM"))