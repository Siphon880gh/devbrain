400 f"error": "registry.ollama.ai/library/deepseek-rl:latest does not support tools"}
![[Pasted image 20260509083813.png]]

Zoomed out:
![[Pasted image 20260509083820.png]]

That warning means OpenClaw may not be able to make it read files, run shell commands, call tools, or manage workspace actions correctly.

You could use (if OpenClaw used only for coding related tasks):
```
ollama pull qwen2.5-coder:7b-instruct
```

Or
```
ollama pull qwen2.5-coder:14b-instruct

```

Then launch into openclaw tui:
```
ollama launch openclaw --model qwen2.5-coder:14b-instruct
```

Ollama supports tool calling, but only with models that are compatible with tool/function calling. OpenClaw also recommends a large context window, around 64k tokens, for local models.

DeepSeek is not the model to use to bootstrap OpenClaw. Use Qwen Coder Instruct first, get tools working, then experiment with Deep Seek later as a non-tool chat/reasoning fallback.

You can configure the default model

`vi ~/.openclaw/openclaw.json` -
(Partial):
```
{
  "agents": {
    "defaults": {
      "model": {
        "primary": "ollama/qwen2.5-coder:7b-instruct"
      },
      "workspace": "/Users/wengffung/.openclaw/workspace"
    },
    "list": [
      {
        "id": "main"
      },
      {
        "id": "project-a",
        "name": "project-a",
        "workspace": "/Users/wengffung/.openclaw/workspace/project-a",
        "agentDir": "/Users/wengffung/.openclaw/agents/project-a/agent"
      },
      {
        "id": "project-b",
        "name": "project-b",
        "workspace": "/Users/wengffung/.openclaw/workspace/project-b",
        "agentDir": "/Users/wengffung/.openclaw/agents/project-b/agent"
      }
    ]
  },
  "auth": {
    "profiles": {
      "ollama:default": {
        "mode": "api_key",
        "provider": "ollama"
      }
    }
  },

```