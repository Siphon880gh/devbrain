Top-level `web_search` is the current setting. Default is `"cached"`.

```toml
web_search = "cached"
web_search = "indexed"
web_search = "live"
web_search = "disabled"
```

- `cached` — OpenAI-maintained index, no live external web
- `indexed` — external access only when the search index allows it
- `live` — unrestricted live retrieval
- `disabled` — remove the tool

`--yolo` or another full-access sandbox defaults this to `"live"`.

These search-domain filters are separate from sandboxed-command network rules. They do not restrict connectors or MCP servers.

Old feature flags are deprecated. Prefer the top-level key:

- `features.web_search`
- `features.web_search_cached` (maps to `"cached"`)
- `features.web_search_request` (maps to `"live"`)
