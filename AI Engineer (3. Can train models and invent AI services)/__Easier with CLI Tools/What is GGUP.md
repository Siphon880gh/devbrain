**GGUF (GPTQ-GGUF Unified Format)** is a **model file format** used for **quantized** versions of large language models (LLMs). This quantization process reduces the model's size and computational requirements, facilitating more efficient deployment.

Searching Hugging Face, not all models are GGUF, but you'll find some are. Usually it's in the description or the name, eg. YuisekinAI-mistral-0.3B-GGUF

Ollama can readily run GGUP (unless you're on the older version of ollama which requires you to script a .model file and run off that)