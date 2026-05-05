
You'd want to install jq.

Pipe the json output to jq for a prettified output with tabs etc:

```
curl http://API_ENDPOINT -H "Authorization: Bearer TOKEN_HERE" -H "Content-Type: application/json" | jq
```

**Came included?**
Most systems don't come with jq. For example on Debian 12, you install with `sudo install jq`.