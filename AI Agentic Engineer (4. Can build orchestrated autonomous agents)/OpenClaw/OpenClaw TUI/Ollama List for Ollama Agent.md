# Why `ollama list` Helps in OpenClaw

If your OpenClaw agent is backed by Ollama, you can switch models in TUI with `/model`.

`ollama list` is useful because it shows the exact local model names/tags available to switch to (for example, `qwen2.5-coder:7b-instruct`).

```bash
ollama list
```

Use it when:
- You are not sure which Ollama models are installed locally
- `/model` needs an exact model name

If you already know the exact installed model name, you can skip `ollama list`.
