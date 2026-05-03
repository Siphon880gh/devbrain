## Combined Conditions - Example

Here’s a **clean, practical example** that combines:

- embeddings → Ollama
    
- normal chat → cheap OpenAI model
    
- coding / long-context style requests → routed by auto router
    
- failure handling → fallback chain
    
- heavy usage → load balancing across same model group
    

LiteLLM’s current docs support all the pieces here: `model_name` aliases in `config.yaml`, load balancing across multiple deployments of the same model, ordered failover, model-group fallbacks, and auto routing based on embedding similarity against example utterances. Key/team router settings can also override the global defaults. ([liteLLM](https://docs.litellm.ai/docs/proxy/configs "Overview | liteLLM"))

### 1) `config.yaml`

```yaml
model_list:
  # Embeddings -> local Ollama
  - model_name: embeddings
    litellm_params:
      model: ollama/nomic-embed-text
      api_base: http://localhost:11434

  # Cheap default chat -> load balanced across 2 OpenAI-compatible deployments
  - model_name: chat-default
    litellm_params:
      model: openai/gpt-4o-mini
      api_key: os.environ/OPENAI_API_KEY_1
      rpm: 100

  - model_name: chat-default
    litellm_params:
      model: openai/gpt-4o-mini
      api_key: os.environ/OPENAI_API_KEY_2
      rpm: 100

  # Better long-context / coding model
  - model_name: long-context
    litellm_params:
      model: anthropic/claude-sonnet-4-20250514
      api_key: os.environ/ANTHROPIC_API_KEY
      order: 1

  # Backup for long-context if Claude path fails
  - model_name: long-context-backup
    litellm_params:
      model: openai/gpt-4.1
      api_key: os.environ/OPENAI_API_KEY_1
      order: 2

router_settings:
  routing_strategy: simple-shuffle

  fallbacks:
    - long-context:
        - long-context-backup
```

#### What this does

When your app sends `model: "chat-default"`, LiteLLM can load balance across both deployments in that model group. The docs describe this as routing multiple deployments of the same `model_name`, with `simple-shuffle` as the default strategy. ([liteLLM](https://docs.litellm.ai/docs/proxy/load_balancing "Proxy - Load Balancing | liteLLM"))

When your app sends `model: "long-context"`, LiteLLM first tries the `order: 1` deployment, then moves to higher `order` values if needed, and then can continue into the configured model-level fallback chain. That exact order-based failover pattern is documented in the proxy load balancing docs. ([liteLLM](https://docs.litellm.ai/docs/proxy/load_balancing "Proxy - Load Balancing | liteLLM"))

### 2) `router.json` for auto routing

This is the part that decides **which model group to use** based on the request content.

```json
{
  "encoder_type": "openai",
  "encoder_name": "embeddings",
  "routes": [
    {
      "name": "long-context",
      "description": "Coding, debugging, refactoring, architecture, and long-document reasoning",
      "score_threshold": 0.62,
      "utterances": [
        "debug this code",
        "refactor this function",
        "explain this stack trace",
        "write a sql query for this schema",
        "compare these two long documents",
        "summarize this long report with key risks",
        "help me understand this Python script",
        "convert this JavaScript code to TypeScript"
      ]
    },
    {
      "name": "chat-default",
      "description": "General short chat, drafting, and lightweight business writing",
      "score_threshold": 0.55,
      "utterances": [
        "rewrite this email",
        "improve this paragraph",
        "draft a short reply",
        "make this easier to read",
        "summarize this note",
        "write a short social post"
      ]
    }
  ]
}
```

LiteLLM’s auto-routing docs describe this schema directly: `encoder_type`, `encoder_name`, and `routes`, where each route has a target `name`, `utterances`, `description`, `score_threshold`, and optional `metadata`. The matching is based on embeddings of the input against your route examples, with a default model used when no route matches. ([liteLLM](https://docs.litellm.ai/docs/proxy/auto_routing "Auto Routing | liteLLM"))

### 3) How your app would call it

Your internal app can just send requests to the **auto-router model name** you create in LiteLLM UI, and LiteLLM picks the destination model group. The docs say the auto-router has an “Auto Router Name” that developers call, plus a “Default Model” used when no route is matched. ([liteLLM](https://docs.litellm.ai/docs/proxy/auto_routing "Auto Routing | liteLLM"))

Conceptually, your app does this:

```json
{
  "model": "my-smart-router",
  "messages": [
    { "role": "user", "content": "Can you debug this Python traceback?" }
  ]
}
```

Then LiteLLM can route that to `long-context`, while something like “rewrite this short email” can go to `chat-default`, based on the route similarity rules you defined. ([liteLLM](https://docs.litellm.ai/docs/proxy/auto_routing "Auto Routing | liteLLM"))

### 4) The routing flow in plain English

For the setup above, the behavior is:

- `embeddings` requests go to local Ollama
    
- general short requests go to `chat-default`
    
- coding / long reasoning requests go to `long-context`
    
- if the primary long-context deployment fails, LiteLLM can try the next `order`
    
- if that still fails, it can fall through to the configured fallback model group
    
- if `chat-default` has multiple deployments, LiteLLM spreads traffic across them ([liteLLM](https://docs.litellm.ai/docs/proxy/load_balancing "Proxy - Load Balancing | liteLLM"))
    

### 5) Good production tweak

If you want different behavior for different apps or teams, LiteLLM now supports **key-level and team-level router settings**, and the resolution order is **Key > Team > Global**. That means one internal tool could use aggressive cheap routing while another gets more premium fallbacks without changing your global config. ([liteLLM](https://docs.litellm.ai/docs/proxy/keys_teams_router_settings "UI - Router Settings for Keys and Teams | liteLLM"))

### 6) One important note

The snippet above is a **realistic pattern**, but you should still adjust:

- exact provider model names
    
- your preferred `score_threshold`
    
- whether you want Ollama only for embeddings or also for cheap chat
    
- your retry / timeout settings
    

Those knobs are supported by LiteLLM, but the best values depend on your traffic and quality bar. The structure here matches the documented routing concepts; the specific thresholds and model choices are the opinionated part. ([liteLLM](https://docs.litellm.ai/docs/proxy/load_balancing "Proxy - Load Balancing | liteLLM"))