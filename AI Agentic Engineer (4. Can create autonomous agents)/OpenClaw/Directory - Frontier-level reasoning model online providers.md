**Even with a Mac Studio, some tasks may still need cloud AI APIs or additional hardware**. Frontier-level reasoning often depends on very large models with hundreds of billions of parameters, such as Llama 3.1 405B, DeepSeek-V3 671B total parameters, or Qwen3-235B-A22B.

If you can't afford that enterprise hardware, you'll need to use the AI APIs that are in the cloud:
- OpenAI
- Anthropic
- Cloud services providing usually local models but at the high hundreds of billions of parameters

---

Also known as **hosted open-weight / open-source model inference**: models that people _could_ run locally with enough hardware, but are so large that most users rent them through a cloud API instead.

> [!note] FYI on billions of parameters
> For **MoE models** (Mixture of Experts, smaller "expert" networks inside one big model but not all of them used for every model), “hundreds of billions” often means **total parameters**, while only a smaller number are active per token. Example: Llama 4 Maverick is listed as **400B total / 17B active**, and DeepSeek V4 Pro is listed as **1.6T total / 49B active**. ([GroqCloud](https://console.groq.com/docs/model/meta-llama/llama-4-maverick-17b-128e-instruct?utm_source=chatgpt.com "Llama 4 Maverick - GroqDocs"))
>

|Service|What it is|Common big-model examples|
|---|---|---|
|**Synthetic.new**|Private hosted open-source LLM service. Their site says they run open-source AI models in private datacenters and support vLLM-compatible open-source architectures.|Kimi K2.5, MiniMax M2.5, GLM 5.1, GLM 4.7 Flash. ([Synthetic](https://synthetic.new/?utm_source=chatgpt.com "Synthetic \| Run LLMs, privately"))|
|**Together AI**|Popular open/open-weight model API provider.|DeepSeek, Qwen, Kimi, GLM, Llama, MiniMax, GPT-OSS; their pricing page lists models like GLM-5.1, Kimi K2.6, DeepSeek V4 Pro, Qwen3.5-397B. ([Together AI](https://www.together.ai/pricing?utm_source=chatgpt.com "Pricing"))|
|**Fireworks AI**|Open-source model API + fine-tuning/deployment platform.|DeepSeek R1/V3/V4, Kimi, Llama 4, Qwen, etc. ([Fireworks AI](https://fireworks.ai/models?utm_source=chatgpt.com "Try Open Source LLMs & Image Models \| Deploy in Seconds"))|
|**SambaNova Cloud**|High-speed inference cloud focused on large models.|DeepSeek-R1 671B, GPT-OSS 120B, Llama 4 Maverick. ([SambaNova](https://sambanova.ai/blog/sambanova-cloud-launches-the-fastest-deepseek-r1-671b?utm_source=chatgpt.com "Run DeepSeek 671B on SambaNova Cloud - Get Access ..."))|
|**Cerebras Inference**|Very fast inference platform using Cerebras wafer-scale hardware.|Llama 4 Maverick 400B, Qwen3 Coder 480B, GPT-OSS 120B. ([Cerebras](https://www.cerebras.ai/press-release/maverick?utm_source=chatgpt.com "Cerebras beats NVIDIA Blackwell: Llama 4 Maverick ..."))|
|**GroqCloud**|Fast inference API on Groq LPUs.|Llama 4 Maverick 400B total / 17B active, GPT-OSS 120B, Llama 70B-class models. ([GroqCloud](https://console.groq.com/docs/models?utm_source=chatgpt.com "Supported Models - GroqDocs"))|
|**Hugging Face Inference Providers**|Marketplace/router for hosted inference across many providers.|DeepSeek V4 Pro through Novita/Together, Kimi K2.6, GLM, DeepSeek R1/V3, Qwen, etc. ([Hugging Face](https://huggingface.co/inference/models?utm_source=chatgpt.com "Hugging Face Inference Providers · Supported Models"))|
|**OpenRouter**|Unified API router across many model providers.|DeepSeek R1, DeepSeek V4 Pro, Llama 4 Maverick, Kimi, Qwen, GLM, etc. ([OpenRouter](https://openrouter.ai/meta-llama/llama-4-maverick?utm_source=chatgpt.com "Llama 4 Maverick - API Pricing & Providers"))|
|**Novita AI**|Open-source model API/dedicated endpoint provider.|DeepSeek V4 Pro, DeepSeek V4 Flash, DeepSeek V3.2, GLM, Kimi, MiniMax. ([Novita AI](https://novita.ai/models/model-detail/deepseek-deepseek-v4-pro?utm_source=chatgpt.com "Deepseek V4 Pro API & Playground"))|
|**Nebius AI Studio / Token Factory**|Cloud AI model API platform.|Llama 3.1 405B, DeepSeek R1/V3-family models. ([Nebius](https://nebius.com/blog/posts/run-meta-llama-405b-in-ai-studio?utm_source=chatgpt.com "How to run Meta Llama 3.1 405B with Nebius AI Studio API"))|
|**Ollama Cloud**|Cloud-hosted Ollama models, useful when a local Ollama-style model is too big.|DeepSeek V4 Pro, DeepSeek V4 Flash, cloud-tagged models. ([Ollama](https://ollama.com/library/deepseek-v4-pro%3Acloud?utm_source=chatgpt.com "deepseek-v4-pro:cloud"))|
|**AWS Bedrock / SageMaker JumpStart**|Hyperscaler model hosting and managed inference.|DeepSeek R1/V3.1, Llama 4 Maverick/Scout, other open models. ([AWS Documentation](https://docs.aws.amazon.com/bedrock/latest/userguide/model-parameters-deepseek.html?utm_source=chatgpt.com "DeepSeek models - Amazon Bedrock - AWS Documentation"))|
|**Google Vertex AI Model Garden**|Google Cloud’s model garden + managed model APIs.|DeepSeek R1, Llama 4 Maverick, Llama 4 Scout, partner/open models. ([Google Cloud](https://cloud.google.com/blog/products/ai-machine-learning/deepseek-r1-is-available-for-everyone-in-vertex-ai-model-garden?utm_source=chatgpt.com "Deepseek R1 is available for everyone in Vertex AI Model ..."))|
|**Microsoft Foundry / Azure AI Foundry**|Microsoft’s model catalog/deployment platform.|DeepSeek R1/R1-0528, Kimi K2.5, other Foundry catalog models. ([Microsoft Learn](https://learn.microsoft.com/en-us/azure/foundry/foundry-models/tutorials/get-started-deepseek-r1?utm_source=chatgpt.com "Tutorial: Get started with DeepSeek-R1 in Foundry Models"))|
|**Cloudflare Workers AI / AI Gateway models**|Edge AI/model routing and hosted/proxied model access.|Qwen3.5-397B-A17B is listed as a proxied model; Workers AI also hosts smaller models directly. ([Cloudflare Docs](https://developers.cloudflare.com/ai/models/?utm_source=chatgpt.com "Models - AI"))|

Common **large open-weight model families** to know:

|Model family|Why it matters|
|---|---|
|**DeepSeek R1 / V3 / V4**|Common “too large for normal local use” open model family. DeepSeek V4 Pro is listed at **1.6T total / 49B active**. ([Hugging Face](https://huggingface.co/deepseek-ai/DeepSeek-V4-Pro?utm_source=chatgpt.com "deepseek-ai/DeepSeek-V4-Pro"))|
|**Kimi K2 / K2.5 / K2.6**|Very large Moonshot open model family; Hugging Face listings show Kimi K2.6 around **1.1T**. ([Hugging Face](https://huggingface.co/models?inference_provider=together&utm_source=chatgpt.com "Models available on Together AI"))|
|**Llama 3.1 405B / Llama 4 Maverick**|Meta open-weight models; Llama 4 Maverick is **400B total / 17B active**. ([Together AI](https://www.together.ai/models/llama-3-1-405b?utm_source=chatgpt.com "Llama 3.1 405B API"))|
|**Qwen large MoE / Qwen Coder**|Alibaba/Qwen family; examples include **Qwen3.5-397B-A17B** and **Qwen3 Coder 480B**. ([Cloudflare Docs](https://developers.cloudflare.com/ai/models/?utm_source=chatgpt.com "Models - AI"))|
|**GLM / Z.ai**|Large Chinese open model family; provider catalogs list GLM-5/5.1 in the ~754B range. ([Hugging Face](https://huggingface.co/models?inference_provider=together&utm_source=chatgpt.com "Models available on Together AI"))|
|**MiniMax M-series**|Large open model family often available through Together, Synthetic, Novita, and HF providers. ([Synthetic](https://synthetic.new/?utm_source=chatgpt.com "Synthetic \| Run LLMs, privately"))|

For your article, I’d group them like this:

**Most common API providers:** Together AI, Fireworks AI, Groq, SambaNova, Cerebras, Novita, Nebius, Synthetic.new.  
**Aggregators/routers:** OpenRouter, Hugging Face Inference Providers, Cloudflare AI Gateway.  
**Big-cloud platforms:** AWS Bedrock, Google Vertex AI, Microsoft Foundry.  
**Local-tool-to-cloud bridge:** Ollama Cloud.