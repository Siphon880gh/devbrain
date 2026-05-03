
Choosing local AI models gets easier when the setup is split into two ideas:

**Model family** means the group or brand the model belongs to, such as Llama, Qwen, Mistral, Gemma, Phi, or Nomic.

**Model category** means the job the model is best suited for, such as general chat, reasoning, coding, embedding, reranking, vision, or speech-to-text.

This distinction matters because a model family is not the same thing as a model role.

For example, **Llama** is a model family. A Llama model may be used for general chat, light coding, reasoning, or agent workflows depending on the size and version. Meta describes Llama models as open models that can be fine-tuned, distilled, and deployed across many use cases. ([Llama](https://www.llama.com/models/llama-3/?utm_source=chatgpt.com "Open-source AI Models for Any Application | Llama 3"))

On the other hand, **Nomic Embed Text** is not a normal chat model. It is an embedding model used for retrieval, semantic search, similarity, clustering, and classification. ([Nomic Platform](https://docs.nomic.ai/reference/api/embed-text-v-1-embedding-text-post?utm_source=chatgpt.com "Embed Text | Nomic Platform Documentation"))

A good local AI setup usually does not rely on one model for everything. It uses a small group of models, each assigned to the type of work it handles best.

---

## Table 1: Common Local Model Families

|Model Family|Example Models|Common Model Category|Best Use|Simple Description|
|---|---|---|---|---|
|**Llama**|Llama 3, Llama 3.1, Llama 3.2, Llama 3.3, Code Llama|General chat, reasoning, coding|Everyday assistant work, rewriting, summaries, Q&A, light coding, agent workflows|A strong general-purpose model family from Meta. Smaller versions are useful for faster local tasks, while larger versions are better for reasoning and analysis. Meta’s Llama 3.1 line includes 8B, 70B, and 405B instruction-tuned sizes. ([Llama](https://www.llama.com/models/llama-3/?utm_source=chatgpt.com "Open-source AI Models for Any Application \| Llama 3"))|
|**Qwen**|Qwen 2.5, Qwen 3, Qwen Coder, Qwen-VL|General chat, reasoning, coding, vision, multilingual|Multilingual tasks, coding, document analysis, tool use, agent workflows|A broad model family from Alibaba. Qwen includes language models and multimodal models, with support for natural language, vision, audio, tool use, and agent-style workflows. ([Qwen](https://qwen.readthedocs.io/?utm_source=chatgpt.com "Qwen - Read the Docs"))|
|**Mistral**|Mistral 7B, Mixtral, Codestral, Devstral, Mistral Large|General chat, efficient reasoning, coding, agents|Fast local chat, coding support, reasoning, agent workflows|A model family known for efficient models and strong open-weight options. Mistral’s model docs include general-purpose, multimodal, coding, and agent-optimized models. ([Mistral AI Documentation](https://docs.mistral.ai/models/overview?utm_source=chatgpt.com "Models Overview"))|
|**Gemma**|Gemma 2, Gemma 3, Gemma 4|General chat, lightweight reasoning, vision in some versions|Chat, summaries, classification, local apps, lightweight assistants|Google’s lightweight open model family, built from the same research and technology used for Gemini models. ([Google AI for Developers](https://ai.google.dev/gemma/docs?utm_source=chatgpt.com "Gemma models overview \| Google AI for Developers"))|
|**Phi**|Phi-3, Phi-4|Small language model, lightweight reasoning|Low-resource tasks, simple reasoning, routing, short answers, edge devices|Microsoft’s small language model family. Phi models are designed for useful AI performance at smaller sizes, including memory-constrained and latency-sensitive environments. ([Microsoft Azure](https://azure.microsoft.com/en-us/products/phi?utm_source=chatgpt.com "Phi Open Models - Small Language Models"))|
|**Nomic**|Nomic Embed Text, Nomic Embed Text v1.5|Embedding|RAG, semantic search, retrieval, similarity matching|Not a chat model. Nomic embedding models turn text into vectors so a system can search by meaning instead of only exact keywords. ([Nomic Platform](https://docs.nomic.ai/reference/api/embed-text-v-1-embedding-text-post?utm_source=chatgpt.com "Embed Text \| Nomic Platform Documentation"))|
|**BGE**|BGE Embeddings, BGE Reranker|Embedding, reranking|Better document retrieval, RAG result ranking|Often used in search and RAG pipelines. BGE rerankers help score query-document relevance after an initial search step. ([BGE Model](https://bge-model.com/tutorial/5_Reranking/5.2.html?utm_source=chatgpt.com "BGE Reranker — BGE documentation"))|
|**Whisper-style models**|Whisper, Whisper Large|Speech-to-text|Transcription, meetings, calls, voice notes|Speech models convert audio into text. OpenAI describes Whisper as a general-purpose speech recognition model that can handle multilingual speech recognition, translation, and language identification. ([GitHub](https://github.com/openai/whisper?utm_source=chatgpt.com "openai/whisper: Robust Speech Recognition via Large- ..."))|
|**Vision-language model families**|LLaVA, Qwen-VL, Gemma vision models|Vision + language|Screenshots, UI review, image Q&A, visual documents|These models can process images and text together. They are useful when an AI agent needs to inspect screenshots, diagrams, browser pages, or visual documents. ([GitHub](https://github.com/haotian-liu/llava?utm_source=chatgpt.com "haotian-liu/LLaVA: [NeurIPS'23 Oral] Visual Instruction ..."))|

---

## Table 2: Model Categories and What They Are For

|Model Category|Reasoning / Tool Use|Example Models|Best For|Simple Description|
|---|---|---|---|---|
|**General Chat Model**|Tooling|Llama 3 8B, Mistral 7B, Gemma, smaller Qwen models|Rewriting, summaries, Q&A, article drafts, basic explanations|This is the everyday assistant model. It handles normal writing, summarization, simple questions, and lightweight workflows.|
|**Heavy Reasoning Model**|Reasoning + Tooling|Qwen 2.5 32B, larger Llama models, larger Mistral models|Long prompts, planning, complex analysis, document review, multi-step reasoning|This model is used when the task needs deeper thinking. It is usually slower and needs more hardware, but it gives better results on difficult prompts.|
|**Embedding Model**|No|Nomic Embed Text, BGE embeddings|Semantic search, RAG, memory, document retrieval, similarity search|This model does not chat with the user. It turns text into vectors so the system can search by meaning.|
|**Reranker Model**|No|BGE Reranker, other reranking models|Ranking search results, improving RAG quality|A reranker looks at retrieved chunks and scores which ones are most relevant. It helps the main chat model receive better context.|
|**Code Model**|Reasoning + Tooling|Code Llama, Qwen Coder, Codestral, Devstral|Code generation, debugging, refactoring, repo analysis|A code model is tuned for programming work. It is most useful when paired with file access, terminal commands, tests, and developer tools. Meta describes Code Llama as a family of models for code with foundation, Python-specialized, and instruction-following versions. ([Meta AI](https://ai.meta.com/research/publications/code-llama-open-foundation-models-for-code/?utm_source=chatgpt.com "Code Llama: Open Foundation Models for Code - Meta AI"))|
|**Vision-Language Model**|Tooling|LLaVA, Qwen-VL, Gemma vision models|Screenshots, UI inspection, diagrams, visual documents|This model can understand images and text together. It is useful for agents that need to inspect a UI, read a screenshot, or answer questions about an image.|
|**Speech-to-Text Model**|No|Whisper, Whisper Large|Transcription, voice notes, meetings, calls|This model converts audio into text. Another model can then summarize, search, classify, or analyze the transcript.|
|**Small Routing Model**|Tooling|Phi, small Llama models, small Qwen models|Classification, routing, simple decisions, background jobs|A small model can be used to decide where a request should go. For example, it can route a prompt to a chat model, code model, search tool, or reasoning model.|
|**Multilingual Model**|Reasoning / Tooling|Qwen, Llama multilingual models, Gemma, Mistral models|Translation, multilingual chat, international document analysis|Some model families are stronger than others across languages. These models are useful when the system needs to handle non-English prompts or documents.|
|**Agent Model**|Reasoning + Tooling|Qwen, larger Llama models, Mistral agent/coding models|Tool calling, task planning, multi-step workflows, automation|An agent model needs to understand instructions, decide when to use tools, evaluate results, and continue working across multiple steps.|

---

## How to Think About Reasoning / Tool Use

The **Reasoning / Tool Use** column is a quick way to describe how the model should be used.

**No** means the model is not meant to reason or call tools directly. This does not mean the model is bad. It means the model has a narrow job. Embedding models, rerankers, and speech-to-text models are good examples.

**Reasoning** means the model is useful for deeper thinking, planning, analysis, comparison, and multi-step answers.

**Tooling** means the model can be useful inside an agent workflow. It may classify tasks, route prompts, summarize tool results, or decide which action should happen next.

**Reasoning + Tooling** means the model is useful for agent workflows that require judgment. These models are better suited for planning, using tools, checking results, and making decisions across multiple steps.

---

## Example Local AI Stack

A practical local AI stack may include:

- A **general chat model** for everyday writing, summaries, and Q&A.
    
- An **embedding model** for document search and RAG.
    
- A **heavy reasoning model** for complex prompts and long document analysis.
    
- A **code model** for programming tasks.
    
- A **vision-language model** for screenshots and visual documents.
    
- A **speech-to-text model** for audio transcription.
    

This approach avoids forcing one model to do every job.

The better rule is:

**Use the smallest model that can do the job well.**

Small models are faster and cheaper to run. Larger models should be saved for work that actually needs deeper reasoning, longer context, or stronger judgment.

---

## Simple Routing Examples

For rewriting a paragraph, use a **general chat model**.

For searching a folder of documents, use an **embedding model** first, then send the best results to a chat or reasoning model.

For analyzing a long PDF, use a **heavy reasoning model**.

For debugging a codebase, use a **code model** or a heavy reasoning model with developer tools.

For ranking retrieved document chunks, use a **reranker model**.

For reading a screenshot, use a **vision-language model**.

For transcribing a meeting, use a **speech-to-text model**, then send the transcript to a chat or reasoning model.

---

## Final Takeaway

Local AI model selection is not just about picking the “best” model.

It is about matching the model to the job.

A clean setup separates:

**Model family** — Llama, Qwen, Mistral, Gemma, Phi, Nomic, BGE, Whisper-style models.

From:

**Model category** — chat, reasoning, embedding, reranking, coding, vision, speech-to-text, routing, and agents.

Once those are separated, the system becomes easier to design.

A strong local AI stack is not one giant model.

It is a small toolbox of models, each doing the job it is best at.