## Stack architecture

```text
Ollama CLI (:11434)     → pull and serve real models
LiteLLM (:4000)         → OpenAI-compatible wrappers over Ollama aliases
OpenClaw (~/.openclaw)  → agents use litellm provider models, not raw Ollama
Tailscale serve 4000    → optional remote edge (Bearer token); no direct OpenClaw exposure
```

- **Wiring OpenClaw to LiteLLM:** [[Wire OpenClaw to LiteLLM provider - models.json and openclaw.json]]
- **LiteLLM concepts:** [[0. _PRIMER - LiteLLM Server vs Python Library]]
- **Device-specific `config.yaml`:** [[Devices and their appropriate models - config.yaml]]

---

## Chain commands to startup the stack

Open multiple terminal shells and run these commands in order:
  
1. Start ollama because that's your manager of models (pull models, presents models, etc)
```
ollama serve
```

2. Load litellm with your config file because it points to the ollama models and standardizes their calls to OpenAI calling style:
```
litellm --config ~/litellm/config.yaml
```

3. Test local port works
- Adjust your password and model
```
curl -s http://localhost:4000/v1/chat/completions -H "Authorization: Bearer {YOUR_PASSWORD}" -H "Content-Type: application/json" -d '{"model":"llama3","messages":[{"role":"user","content":"Reply with one word: ok"}],"max_tokens":8}' | python3 -m json.tool 2>/dev/null | head -30
```
  

4. **Optional - Tailscale**: If you're making litellm available to other computers on your local network or reverse proxied to the internet, serve the litellm's port on tailscale, making litellm the entry point (and Openclaw just becomes the local tui for managing data, creating md files, and having heartbeats on the machine)
```
tailscale serve 4000
```

**Optional - Tailscale ported**: Test works on the new tailscale hostname or IP. You're testing on the same machine, so if it passes, but you can't connect to it on the other machines, at least it narrows down the problem.
- Adjust your TAILSCALE_HOSTNAME_OR_IP, password, and model
```
curl -s http://TAILSCALE_HOSTNAME_OR_IP:4000/v1/chat/completions -H "Authorization: Bearer {YOUR_PASSWORD}" -H "Content-Type: application/json" -d '{"model":"llama3","messages":[{"role":"user","content":"Reply with one word: ok"}],"max_tokens":8}' | python3 -m json.tool 2>/dev/null | head -30
```

  
5. Restart Openclaw gateway:
```
openclaw gateway restart
```


6. Open Openclaw TUI ready for quick management:
```
openclaw tui
```

---

## Suggested Usage Approaches
  
You can expose litellm via tailscale to local machines for internal organization use. Or you can expose litellm to reverse proxy nginx or apache. In either case, there's no direct entry point from other machines to your openclaw, and Openclaw just becomes the local tui for managing data, creating md files, and having heartbeats on the machine. You can setup a 24/7 remote access (eg. Google's RemoteDesktop via a Google account).

And you can create a dashboard wrapper that connects to Litellm so you don't interact with calls to port 4000. That dashboard could be a NodeJS app with certain components dockerized, such as its Postgres database.

In addition, you can have the dashboard (Node.js + Dockerized Postgres) own a **scheduled / operator cron** workflows related to your business. If you choose to have OpenClaw TUI running, the OpenClaw's cronjobs/heart beats can just deal with improving skills and md files over time. That way there is a separation of concern. If you distribute the dashboard to other people in your organization, you can abstract away the OpenClaw complexity and have the dashboard as the scheduler and management place for your agents and automations. 

Remote and app traffic still hits LiteLLM on port 4000 with a token—not the OpenClaw gateway.

Full target architecture: [[Edge Dashboard - Planned cron orchestration via LiteLLM]].

---

## Suggested to Have Startup Script

You should have a startup script that will rev up those chain of commands. And make sure have a way to see if any command failed.

When it comes to power outage, server crashes, etc this assures your stack runs back up when the system restarts.

You can have a message like this:
```
echo "\n\nAGENTIC STACK STARTUP SCRIPT:\nReloaded on \n"`date`"\n\nPlease check previous tabs if loading agentic stack passes.
```

If you have a dashboard wrapper that connects to Litellm (so you don't interact with calls to port 4000):
- Let's say that dashboard is a NodeJS app with certain components dockerized, such as its Postgres database:
```
echo "\n\nAGENTIC STACK STARTUP SCRIPT:\nReloaded on \n"`date`"\n\nPlease check previous tabs if loading agentic stack passes. Please check \`docker compose up\` (and if in development mode then also check \`npm run dev\`) whether dashboard agents such as a Quizzer works"
```