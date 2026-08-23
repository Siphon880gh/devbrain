### Kimi K2.6 providers


| Provider                  | Notes                                                |
| ------------------------- | ---------------------------------------------------- |
| **Fireworks AI**          | Serverless API, on-demand deployment, fine-tuning    |
| **Parasail**              | Lowest blended price in Artificial Analysis tracking |
| **CoreWeave**             | Fastest output speed in Artificial Analysis tracking |
| **Clarifai**              | API provider with tool/JSON support                  |
| **Cloudflare Workers AI** | Model ID: `@cf/moonshotai/kimi-k2.6`                 |
| **Together AI**           | Model page: Kimi K2.6 / `moonshotai/Kimi-K2.6`       |
| **Kimi / Moonshot**       | Official provider                                    |
| **Microsoft Azure**       | Cloud platform provider                              |
| **DeepInfra**             | Listed as K2.6 FP4                                   |
| **SiliconFlow**           | Listed as K2.6 FP8                                   |
| **Novita AI**             | Serverless model API provider                        |

Artificial Analysis says all 11 K2.6 providers support **JSON mode** and **function/tool calling**.

### Kimi K2.5 providers

| Provider            |
| ------------------- |
| FriendliAI      |
| CoreWeave       |
| Microsoft Azure |
| Clarifai        |
| Nebius Fast     |
| Amazon Bedrock  |
| Nebius          |
| Lightning AI    |
| Together.ai     |
| Novita          |
| Kimi / Moonshot |
| DeepInfra       |
| SiliconFlow     |
| Parasail        |
| Fireworks       |
**Notes:**
For K2.5, DeepInfra, Fireworks, and SiliconFlow are among the lowest-cost providers, while Together.ai, Clarifai, and Fireworks are among the lowest-latency providers in its benchmark data.

## Router-style options

|Provider|Why it matters|
|---|---|
|**OpenRouter**|Lets you use one API key and route to Kimi K2.5/K2.6 across providers|
|**Inworld Router**|Lists Kimi K2.6 via a router-style OpenAI-compatible API|

OpenRouter lists `moonshotai/kimi-k2.6` and `moonshotai/kimi-k2.5`, provides an API key flow, and says it routes requests across providers with fallbacks.

## Best practical shortlist

For developer / OpenClaw-style usage, I’d shortlist:

1. **Kimi / Moonshot direct** — official source, model names are clean: `kimi-k2.6`, `kimi-k2.5`.
2. **OpenRouter** — easiest if you want one API key and fallback routing.
3. **Fireworks AI** — strong for agent/coding workflows; K2.6 is serverless and ready.
4. **Together AI** — simple OpenAI-compatible API and clear model pages.
5. **DeepInfra** — often competitive on price.
6. **Cloudflare Workers AI** — good if your app is already on Cloudflare.
7. **Novita AI** — another straightforward OpenAI-compatible serverless option.

For a coding-agent setup, I’d start with **OpenRouter**, **Fireworks**, or **Kimi direct**, then benchmark cost/speed on your actual prompts.