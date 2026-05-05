# Configure Default Model in `openclaw.json`

Set the default model in:

`~/.openclaw/openclaw.json`

Example snippet:

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
