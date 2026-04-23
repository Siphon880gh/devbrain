Below is a simple example of how you might configure **auto routing** in LiteLLM based on the **type of request**.

### 1. Conceptual Rules (Plain English)

Think of it like this:
- If the prompt looks like **chat / general questions → use a fast, cheap model**
- If the prompt looks like **coding → use a stronger reasoning model**
- If the prompt is **long or complex → upgrade to a more powerful model**
- If the request is **embeddings → route to an embedding model**

For a breakdown on conditions, refer to 

---

### 2. Example Routing Config (YAML-style)

```yaml
model_list:
  - model_name: gpt-4o-mini
    litellm_params:
      model: openai/gpt-4o-mini

  - model_name: gpt-4o
    litellm_params:
      model: openai/gpt-4o

  - model_name: deepseek-coder
    litellm_params:
      model: deepseek/deepseek-coder

  - model_name: nomic-embed
    litellm_params:
      model: ollama/nomic-embed-text

router_settings:
  routing_strategy: "auto"

  rules:
    # 1. Coding-related prompts → coder model
    - condition:
        contains_keywords: ["code", "bug", "error", "function", "api"]
      action:
        model: deepseek-coder

    # 2. Long or complex prompts → stronger model
    - condition:
        prompt_length_gt: 2000
      action:
        model: gpt-4o

    # 3. Embeddings requests
    - condition:
        request_type: "embedding"
      action:
        model: nomic-embed

    # 4. Default → fast + cheap
    - default:
        model: gpt-4o-mini
```

---

### 3. Example Behavior

|Input Prompt|Routed Model|Why|
|---|---|---|
|“Write a Python function to parse JSON”|`deepseek-coder`|Matches coding keywords|
|“Summarize this paragraph”|`gpt-4o-mini`|Simple task|
|“Analyze this 5,000 word document…”|`gpt-4o`|Long + complex|
|Embedding API call|`nomic-embed`|Explicit request type|

---

### 4. Add Fallbacks (Optional but Recommended)

```yaml
fallbacks:
  - deepseek-coder:
      - gpt-4o
  - gpt-4o:
      - gpt-4o-mini
```

If your primary model fails, LiteLLM will automatically retry with the fallback.

---

### 5. Key Takeaway

Auto routing in LiteLLM is:

- **Rule-based (you define logic)**
    
- **Flexible (keywords, length, request type, etc.)**
    
- **Composable (can combine with load balancing + fallbacks)**
    

It’s less “AI guessing the best model” and more like a **smart traffic controller you configure once**.