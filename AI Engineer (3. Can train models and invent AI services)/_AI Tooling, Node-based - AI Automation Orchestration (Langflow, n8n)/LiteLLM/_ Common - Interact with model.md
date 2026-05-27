
**Send a prompt to a model**

Adjust your password and model (And here is a basic prompt to test it works):
```
curl -s http://localhost:4000/v1/chat/completions -H "Authorization: Bearer {YOUR_PASSWORD}" -H "Content-Type: application/json" -d '{"model":"llama3","messages":[{"role":"user","content":"Reply with one word: ok"}],"max_tokens":8}' | python3 -m json.tool 2>/dev/null | head -30
```
  
---

**Tailscale?**

If you're making litellm available to other computers on your local network or reverse proxied to the internet, serve the litellm's port on tailscale, making litellm the entry point (and Openclaw just becomes the local tui for managing data, creating md files, and having heartbeats on the machine)
```
tailscale serve 4000
```

Then adjust your TAILSCALE_HOSTNAME_OR_IP, password, and model (And here is a basic prompt to test it works):
```
url -s http://TAILSCALE_HOSTNAME_OR_IP:4000/v1/chat/completions -H "Authorization: Bearer {YOUR_PASSWORD}" -H "Content-Type: application/json" -d '{"model":"llama3","messages":[{"role":"user","content":"Reply with one word: ok"}],"max_tokens":8}' | python3 -m json.tool 2>/dev/null | head -30
```

  