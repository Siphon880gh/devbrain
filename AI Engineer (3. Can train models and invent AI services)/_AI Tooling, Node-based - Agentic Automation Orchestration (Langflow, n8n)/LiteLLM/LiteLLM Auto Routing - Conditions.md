## 1. Keywords

LiteLLM can route to different models based on existence of keywords

## 2. Content / Task Type (beyond keywords)

Not just keywords — you can route based on **intent patterns** like:

- long vs short prompts
    
- presence of code blocks
    
- JSON / structured output requests
    
- embeddings vs chat vs completion
    

👉 Example:

- embeddings → `nomic-embed-text` (Ollama)
    
- code-related → GPT-4 / Claude
    
- simple chat → cheaper model
    

---

## 3. Token / Context Size

Route based on how big the request is.

- small prompts → cheap fast model
    
- large prompts / long context → large-context model
    

👉 Example:

- < 2k tokens → `gpt-3.5`
    
- > 20k tokens → `gpt-4` or Claude 200k
    

---

## 4. Cost Optimization

You can route to minimize cost automatically.

- default → cheapest model
    
- fallback → better (more expensive) model
    

👉 Example:

- try `gpt-3.5` first
    
- if fails or low quality → fallback to `gpt-4`
    

---

## 5. Latency / Speed Requirements

Route based on performance needs.

- real-time UX → fastest model
    
- background job → higher quality model
    

👉 Example:

- UI autocomplete → fast local Ollama
    
- report generation → GPT-4
    

---

## 6. Model Health / Availability

Automatic routing based on uptime.

- if model A fails → fallback to model B
    
- retry logic across providers
    

👉 This is where LiteLLM shines:

- OpenAI down → fallback to Anthropic or Ollama
    
- rate limit hit → switch provider
    

---

## 7. Load Balancing

Spread traffic across multiple deployments of the same model.

- multiple API keys
    
- multiple regions
    
- multiple instances
    

👉 Useful for:

- avoiding rate limits
    
- scaling production traffic
    

---

## 8. User / Team / API Key Rules

Different users get different models.

- premium users → better models
    
- internal tools → unrestricted
    
- public API → limited models
    

---

## 9. Endpoint Type (very important)

Route based on what you're doing:

- `/embeddings` → embedding model
    
- `/chat/completions` → chat model
    
- `/responses` → newer APIs
    

---

## 10. Custom Logic (most powerful)

You can define your own routing function.

👉 Example ideas:

- detect “generate code” → route to coding model
    
- detect “analyze CSV” → route to tool-enabled model
    
- detect “cheap bulk job” → route to local Ollama
    

---

## Combined Conditions


In practice, good setups combine:

- content type
    
- token size
    
- cost
    
- latency
    
- fallback logic
    

That’s what turns LiteLLM from a simple proxy into a **smart model router**.

Eg. A real setup usually looks like:

- embeddings → Ollama
    
- short chat → cheap OpenAI model
    
- long context → Claude
    
- failure → fallback chain
    
- heavy usage → load-balanced keys
    