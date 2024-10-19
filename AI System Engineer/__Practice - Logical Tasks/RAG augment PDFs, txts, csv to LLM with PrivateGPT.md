
Goal: You want the LLM to be aware of PDFs, txt, etc files on your computer. You will prompt the LLM and it will answer with citations to which file and text.

Reworded: Query your pdf, ppt, txt etc by using RAG on top of a LLM mode on PrivateGPT

The supported extensions are:
- `.csv`: CSV,
- `.docx`: Word Document,
- `.doc`: Word Document,
- `.enex`: EverNote,
- `.eml`: Email,
- `.epub`: EPub,
- `.html`: HTML File,
- `.md`: Markdown,
- `.msg`: Outlook Message,
- `.odt`: Open Document Text,
- `.pdf`: Portable Document Format (PDF),
- `.pptx` : PowerPoint Document,
- `.ppt` : PowerPoint Document,
- `.txt`: Text file (UTF-8)

On modern computers 2024 and ram 16gb, simple question and answer could take seconds to minutes. And say the RAG materials is a txt file of 39 KB
## Concepts

PrviateGPT is made of a few components
- ingest.py reads the .env file which has the word embed model name to convert your PDFs, txts, etc from `source_documents/` into tokens and store them in the database Chromadb as vector embeds at `db/`. 
	- Note the word embed model value in .env is not a filepath, but is only the name because in ingest.py, langchain will import the actual hunggingface embed model's loader class based on the string matched from .env's word embed model name.
- in order for ingest.py to parse from txt, csv, pdf, etc, it switches to the appropriate document loader class based on the globed filename's file extension. One of the more troubling (in terms of installation) is PyMuPDF that parses PDFs.
	- PyMuPDF is a self-contained package that includes the MuPDF source code within its own distribution package. This ensures that PyMuPDF uses a specific version of MuPDF that it is fully compatible with. 
		- Normally Python packages named with the prefix Py that use a non-python counterpart is actually a wrapper connecting to the system's cli. In this case, yes you could keep the MuPDF cli on your system if you already have it, but PyMuPDF will always use its own that came packaged together, so you do not have to uninstall the system MuPDF if you have it.
		- This also means that if you're installing PyMuPDF with pip and you're not installing binaries (`pip install --prefer-binary..`), it will have to compile the C source code into the binary called a "C extension" that get bundled into the Python .whl file (as a review, .whl is the final binary of the Python package, thinking back to a cheese wheel that can be easily distributed, like with pip - Python has a lot of Monty Python jokes). If cmake has difficulty compiling it into a C extension, you can download the .whl file directly from PyMuPDF's PyPi repo which has .whl for different architectures, eg. Apple Macs M1's wheel is named `PyMuPDF-1.24.11-cp38-abi3-macosx_11_0_arm64.whl`
- privateGPT.py is called after ingest.py's done converting your source documents into tokens and saving the tokens as vector embeds at db/ in the chromaDB format. privateGPT.py refers to .env for the filepath to the LLM model and then loads the LLM model. Then privateGPT.py responds to your questions/prompts with your vector embeds database and its own LLM. Below explains the RAG process:
	- How privateGPT.py loads the LLM model is through langchain supporting LlmCPP and GPT4All
		- Nomic AI's GPT4All allows language models on consumer hardware and can run with CPU or GPU.
		- LlamaCpp allows LLaMA models in environments where GPU access is limited or expensive, enabling users to leverage these large models without the need for powerful hardware.
	- How the code loads in the LLM model at privateGPT.py:
	```
    model_type = os.environ.get('MODEL_TYPE')  
  
    # ...  
  
    match model_type:  
        case "LlamaCpp":  
            llm = LlamaCpp(model_path=model_path, max_tokens=model_n_ctx, n_batch=model_n_batch, callbacks=callbacks, verbose=False)  
        case "GPT4All":  
            llm = GPT4All(model=model_path, max_tokens=model_n_ctx, backend='gptj', n_batch=model_n_batch, callbacks=callbacks, verbose=False)  
        case _default:  
            # raise exception if model_type is not supported  
            raise Exception(f"Model type {model_type} is not supported. Please choose one of the following: LlamaCpp, GPT4All")  
  
    qa = RetrievalQA.from_chain_type(llm=llm, chain_type="stuff", retriever=retriever, return_source_documents= not args.hide_source)
	```

RAG Process (Retrieval-Augmented Generation)
- **Ingesting Process**: When you run `ingest.py`, it processes your source documents, transforming them into vector embeddings. These embeddings capture the semantic meaning of your documents and are stored in a database, often using a vector database like ChromaDB which stores persistently to a directory, like db/.
- **PrivateGPT.py's Role**: The `privateGPT.py` script uses a pre-trained language model (LLM) to answer questions and augment its responses with relevant information retrieved from your own vector embeddings database. Here's how:
	- **Augmentation Process**: When you ask a question, the following happens:
	    - The question is converted into an embedding using the same technique.
	    - This embedding is compared to the embeddings of your ingested documents at db/ to find the most relevant matches (based on semantic similarity).
	    - The relevant text chunks are retrieved and passed alongside the original question to the LLM.
	- **Response Generation**: The LLM then uses the retrieved information (from your documents) to generate a more contextually accurate response. In this case, the emphasis is indeed on the retrieved vector embeddings, but the LLM itself also plays a significant role in structuring and augmenting the final answer.


---

**INSTALLATION INSTRUCTIONS COMING SOON**

---


## Troubleshooting PyMuPDF installation
As discussed under Concepts section, that could be the most problematic installation

Refer to [[Rag Troubleshooting - PyMuPDF]] for a full investigation and tweaking to get PyMuPDF working