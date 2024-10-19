
#### Models
- Meta Llama, Microsoft Phi, Mistral Instruct, Nomic GPT4All, Google Gemma, and other models.
- BERT models are often used in research and universities.
- Models from Claude and OpenAI

### Model Types
- Text, Vision, etc

### Criteria to choose model
- What is its use case: Eg. Vision makes sense for images, so a model like "Llama3.2-11B-Vision-Instruct" makes sense for images
- Computer resources: 
	- Quick checklist: Do you have a GPU? Is it NVIDIA? Or do you have to stick with CPU? How much storage space?
	- The larger the number of parameters, the more weights etc, and therefore the more accurate the model is, however requires much CPU/GPU power to run at a reasonable speed (less than 1 minute rather than hours):
		- Learn by reading title - "Introducing LLaMA: A foundational 65-billion parameter large language model": https://ai.meta.com/blog/large-language-model-llama-meta-ai/
		- The folder could be named "Llama3.2-11B-Vision-Instruct". Notice that is a 11 billion parameter large language model
		- A 8B model runs pretty reasonable on an Apple M1 chip on 16GB Ram. Simple query will have a response time of 30seconds - 1 minute.
- How large of training materials, if any (RAG?)
	- RAG is Retrieval-augmented generation which is you augmenting the LLM with documents (PDFs, txt, etc), then you can query with more accurate responses.
	- Learn by reading their tag line: "A high-performing open embedding model with a large context window" https://ollama.com/library/nomic-embed-text. This model is open to you adding more information to it (open embedding model) and has a large context window (it's performant even with a large amount of text being ingested)
	- When a model's information page talks about how many tokens, you can approx how many words, sentences, or paragraphs. Refer to
- How accurate it needs to be - Billions of parameters
	- The larger the parameter number, the better. It's usually in the billions. 
	- A model with the word "8B" means it has 8 billion parameters. At 8B, that may be often incorrect when asked questions, and they will hallucinate and lie to sound confident. A 8B model runs pretty reasonable on an Apple M1 chip on 16GB Ram. Simple query will have a response time of 30seconds - 1 minute.
	- GPT4All by Nomic gives head scratching results. There is discussion that Meta’s Llama 3 8B model is more accurate than Nomic’s GPT4All’s 8B model. The instructions on PrivateGPT primordial branch (popular for running a local LLM and leveraging RAG with documents) lead you to using GPT4All, however you can and should use other models for more accuracy.
	- You can compare Cloud Providers or compare computers:
		- Compare Cloud providers: https://artificialanalysis.ai/leaderboards/models
		- Compare computers: https://github.com/XiongjieDai/GPU-Benchmarks-on-LLM-Inference

#### Download Models
You can download models for use from hugging face, meta, and elsewhere
- Meta Llama Request Form (Access usually instant, gives you pre-signed url and llama model downloader cli): https://www.llama.com/llama-downloads/
- Microsoft Model catalog: https://ai.azure.com/explore/models?selectedCollection=phi
- Nomic GPT4All (Direct link to download, otherwise their official website pushes their GUI software): https://gpt4all.io/models/ggml-gpt4all-j-v1.3-groovy.bin
- Google BERT: https://www.kaggle.com/models/google/bert/tensorFlow1/uncased-l-12-h-768-a-12/1?tfhub-redirect=true
- Hugging Face models: https://huggingface.co/models
- Ollama model downloader cli: https://ollama.com
And more!

Note that often downloads are from Github or using a CLI

How to Google:
download \_\_ model
eg. download meta llama model

### After downloading models - how to use .pth, .bin, cuda, metal

If your main files may end with .pth (PyTorch) or .bin (ggml format that's written to be performant on commodity hardware). Determine if your script (if you're using another AI Engineer's code) takes in .pth or bin. You can find conversion tools between .pth and .bin.

When your code runs the model, it may load from a vector database if there was RAG (augmented the model with pdfs, txt's, etc). But you also select how the processing works -  Metal for Mac, CUDA for NVIDIA GPUs, CUDA (with ROCm toolkit installed) for AMD GPUs.

For more indepth breakdown on what to type into your code where PyTorch or Tensorflow selects the device and algorithm to run the AI training or inference from, refer to [[Run Locally - Compare Computers]]

----

## Next Reading

The next suggested reading is [[Concept Primer - 4. Practice engineering AI]]

