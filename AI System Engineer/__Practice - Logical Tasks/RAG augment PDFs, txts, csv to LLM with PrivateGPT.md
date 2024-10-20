
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
		- Normally Python packages named with the prefix Py that use a non-python counterpart is actually a wrapper connecting to the system's cli. In this case, yes you could keep the MuPDF cli on your system if you already have it, but PyMuPDF will always use its own that came packaged together, so you do not have to uninstall the system MuPDF if you have it. However, it's not pretty good at detecting what architecture and platform you're at and the MuPDF needs to use system-level libraries, so PyMuPDF is prone to installation problems on people's systems. It may even properly install and doesnt complain when `pip show pymupdf` but when importing at a python script, it claims to not exist (despite the python interpreter is the correct one associated with the pip or poetry with PyMuPDF). Refer to [[Rag Troubleshooting - PyMuPDF]] to fix problems.
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

## Installation, Setup, and Prompt/Query

### Git clone primordial cli

We will clone the Primordial branch into our system (because the most recent commits have already moved away from cli into having a ui, which is friendly but doesn’t easily allow us to leverage it for scripts and making web apps, and also abstracts away how AI works):

```
git clone --branch primordial https://github.com/zylon-ai/private-gpt.git
```

### Install the python packages

Now it’s time to install the python packages so the python scripts works. You may see myproject.toml (for poetry) and requirements.txt (for pip). I recommend poetry because it’s less likely to have package conflicts.

Poetry is a python package manager that can be installed with pip. However, your system’s python/pip may be too updated compared to primordial's. Use pyenv to install and switch to 3.10.0 python version (That’s the python version the primordial cli works on). Once you switch to the appropriate python version, then you install poetry because the associated pip will pull in the version of poetry meant to work with the primordial branch (and then the poetry installing python packages will pull in the appropriate versions of python packages).

```
pyenv install 3.10.0  
pyenv local 3.10.0  
python --version
```

If it didn’t switch python versions, initiate pyenv:
```
pyenv init --path
```

Once you have switched over, you should install:
```
pip install poetry
```

Test poetry works by running:
```
poetry
```

Then you can install from the toml file:
```
poetry install
```

At this point, poetry has installed all the packages from the toml file! 

In order to run the python scripts with the packages that were installed inside poetry, you have to run
```
poetry shell
```

That kicks you into poetry’s virtual environment with its own packages, python, and pip. Well, that’s the hope anyways:

You may want to check that the poetry shell is using its own python, which you want to be the case, because you want to use its associated python packages that poetry just installed. Sometimes the computer will still fallback on other versions of python rather than let poetry take over. Run this to help check:
```
whereis python
```

There could be one path that shows up or multiple paths. If multiple paths, the first path, should be a poetry created path like:
```
/Users/wengffung/Library/Caches/pypoetry/virtualenvs/privategpt-LcxwhDfB-py3.10/bin/python 
```

**If another python is taking over**, then your poetry packages won’t be picked up when being imported by the python scripts. You’d have to modify your system paths

And, add and make sure it’s the final PYTHONPATH if any exists at your .bash_profile, .zsrc, etc. **Please adjust pythonX.Y/** to the version number you saw from `syst.path` :
```
# Poetry  
if command -v poetry &> /dev/null  
then  
        export PYTHONPATH=$(poetry env info --path)/lib/python3.10/site-packages:$PYTHONPATH  
fi
```

If you were fixing the python path for poetry shell, exit out of the poetry shell (sourcing bash_profile etc wont work), restart your terminal, then return back to the poetry shell.

### Setup

#### Prepare the .env:

Copy the example.env template into .env
```
cp example.env .env
```

Then edit the variables appropriately in the .env file:
```
MODEL_TYPE: supports LlamaCpp or GPT4All
PERSIST_DIRECTORY: is the folder you want your vectorstore in. You can have “db/”. You can create that empty folder to be sure.
MODEL_PATH: Path to your GPT4All or LlamaCpp supported LLM
MODEL_N_CTX: Maximum token limit for the LLM model
MODEL_N_BATCH: Number of tokens in the prompt that are fed into the model at a time. Optimal value differs a lot depending on the model (8 works well for GPT4All, and 1024 is better for LlamaCpp)
EMBEDDINGS_MODEL_NAME: SentenceTransformers embeddings model name (see https://www.sbert.net/docs/pretrained_models.html)
TARGET_SOURCE_CHUNKS: The amount of chunks (sources) that will be used to answer a question
```
Note: because of the way langchain loads the SentenceTransformers embeddings, the first time you run the script it will require internet connection to download the embeddings model itself.

Your env could be, using their recommended GPT4all model:
```
PERSIST_DIRECTORY=db
MODEL_TYPE=GPT4All
MODEL_PATH=models/ggml-gpt4all-j-v1.3-groovy.bin
EMBEDDINGS_MODEL_NAME=all-MiniLM-L6-v2
MODEL_N_CTX=1000
MODEL_N_BATCH=8
TARGET_SOURCE_CHUNKS=4
```

Your env could be, using a more superior model - Llama model (Please adjust model name):
```
PERSIST_DIRECTORY=db
MODEL_TYPE=LlamaCpp
MODEL_PATH=models/Meta-Llama-3.1-XXXXX.bin
EMBEDDINGS_MODEL_NAME=all-MiniLM-L6-v2
MODEL_N_CTX=1000
MODEL_N_BATCH=8
TARGET_SOURCE_CHUNKS=4
```

#### Download models (not included in the repo because of file size)

Their GPT4all model:
```
!wget -P models/ https://gpt4all.io/models/ggml-gpt4all-j-v1.3-groovy.bin  
!wget -P models/ https://huggingface.co/Pi3141/alpaca-native-7B-ggml/resolve/397e872bf4c83f4c642317a5bf65ce84a105786e/ggml-model-q4_0.bin
```

For the more superior Llama model. If you refer to [[Download Model - Llama]], Meta provides the .pth version of the model, which you have to convert to GGML format (.bin). There are .gguf versions which only the newer version of llamaccp supports and our privateGPT is using the older version. So we need to find .bin version (GGML format)

Search HuggingFace for Llama model that ends with .bin. You can download the file directly under tab “Files and versions”

So you’re placing them in the models/ folder at the app root

#### Source Documents (sample txt files)

Put any and all your files into the `source_documents` directory

Run the following command to ingest all the data (while in the poetry shell).
```
python ingest.py
```

**Note if it hangs**, it’s possible because you didn’t have the actual folder for the PERSISTENT_DIRECTORY created, eg. create “db” folder in your app root.

Output should look like this:
```
Creating new vectorstore  
Loading documents from source_documents  
Loading new documents: 100%|██████████████████████| 1/1 [00:01<00:00,  1.73s/it]  
Loaded 1 new documents from source_documents  
Split into 90 chunks of text (max. 500 tokens each)  
Creating embeddings. May take some minutes...  
Using embedded DuckDB with persistence: data will be stored in: db  
Ingestion complete! You can now run privateGPT.py to query your documents
```

It will create a `db` folder containing the local vectorstore. Will take 20-30 seconds per document, depending on the size of the document. You can ingest as many documents as you want, and all will be accumulated in the local embeddings database. If you want to start from an empty database, delete the `db` folder.

Note: during the ingest process no data leaves your local environment. You could ingest without an internet connection, except for the first time you run the ingest script, when the embeddings model is downloaded.

If you placed PDF files (You should definitely place PDF files) and you have PyMuPDF errors, please refer to this help document in order to investigate and tweak futher: [[Rag Troubleshooting - PyMuPDF]]. Txt files should work without any errors on most systems.

### Test Running

#### Ask questions to your documents, locally!

In order to ask a question, run a command like (while in poetry shell):
```
python privateGPT.py
```

And wait for the script to require your input.
```
> Enter a query:
```

Ask about the state of the union 2022 from US President Biden. You can open the txt file in source_documents to figure out what to ask

Hit enter. You'll need to wait a while (Depends on your machine. But 20-30 seconds for a Mac M1 with 16 GB for a simple question) while the LLM model consumes the prompt and prepares the answer. Once done, it will print the answer and the 4 sources it used as context from your documents; you can then ask another question without re-running the script, just wait for the prompt again.

Note: you could turn off your internet connection, and the script inference would still work. No data gets out of your local environment.

Type `exit` to finish the script.

Example:
```
Question:  
How did COVID-19 affect us according to the speaker?  
  
> Answer (took 37.07 s.):  
 The speaker discusses how COVID-19 has impacted every decision in their lives and the life of the nation for over two years with severe cases down to a level not seen since last July, despite progress made. They also mention that they will continue vaccinating the world as we have sent 475 million vaccine doses to 112 countries more than any other nation. The speaker emphasizes how COVID-19 is no longer just a partisan dividing line and sees it for what it is: A God-awful disease.  
  
> source_documents/state_of_the_union.txt:  
For more than two years, COVID-19 has impacted every decision in our lives and the life of the nation.   
  
And I know you’re tired, frustrated, and exhausted.   
  
But I also know this.   
  
Because of the progress we’ve made, because of your resilience and the tools we have, tonight I can say    
we are moving forward safely, back to more normal routines.    
  
We’ve reached a new moment in the fight against COVID-19, with severe cases down to a level not seen since last July.  
  
> source_documents/state_of_the_union.txt:  
Fourth, we will continue vaccinating the world.       
  
We’ve sent 475 Million vaccine doses to 112 countries, more than any other nation.   
  
And we won’t stop.   
  
We have lost so much to COVID-19. Time with one another. And worst of all, so much loss of life.   
  
Let’s use this moment to reset. Let’s stop looking at COVID-19 as a partisan dividing line and see it for what it is: A God-awful disease.  
  
> source_documents/state_of_the_union.txt:  
I know some are talking about “living with COVID-19”. Tonight – I say that we will never just accept living with COVID-19.   
  
We will continue to combat the virus as we do other diseases. And because this is a virus that mutates and spreads, we will stay on guard.   
  
Here are four common sense steps as we move forward safely.  
  
> source_documents/state_of_the_union.txt:  
It fueled our efforts to vaccinate the nation and combat COVID-19. It delivered immediate economic relief for tens of millions of Americans.    
  
Helped put food on their table, keep a roof over their heads, and cut the cost of health insurance.   
  
And as my Dad used to say, it gave people a little breathing room.
```

#### If haven’t, repeat sourcing documents with PDF files to see if it trips a PyMuPDF error
Titled: If haven’t, repeat sourcing documents with PDF files to see if it trips a PyMuPDF error


If you placed PDF files (You should definitely place PDF files) and you have PyMuPDF errors, please refer to this help document in order to investigate and tweak futher: [[Rag Troubleshooting - PyMuPDF]]. Txt files should work without any errors on most systems.

Example asked and answered with PDFs having been ingested:
```
Working in a mental institution, how to de-escalate a patient who isn't an imminent threat to themselves and others?  
  
> Answer (took 47.12 s.):  
 The first step in de-escalating a potentially violent individual is to assess their level of danger. If they are not posing any immediate harm, the next steps involve understanding why they may be upset or agitated. It's important for individuals involved in such situations to communicate with each other and work together towards finding solutions that address both parties' needs.  
  
In this case study, it appears that a patient who is experiencing agitation due to their medication regimen was not an imminent threat but rather had underlying mental health issues which were contributing factors to the situation. The team leader should have assessed the individual's level of danger and worked with them towards finding solutions that addressed both parties' needs while also respecting their autonomy as patients in need of care.  
  
> source_documents/De-Escalation+Training.pdf:  
...
```


---

## Troubleshooting PyMuPDF installation
As discussed under Concepts section, that could be the most problematic installation

Refer to [[Rag Troubleshooting - PyMuPDF]] for a full investigation and tweaking to get PyMuPDF working

---

## For Long Term Use

TOC:
- **Enhance PrivateGPT to take multilines.**
- **Look for better models**
- **CleanMyMac Ignore List**
- **“Eject” Poetry**

If you’ll be using this tool long-term, there are things you may want to do so you get less annoyed in the future

### **Enhance PrivateGPT to take multilines.**

This would fail:
```
how many r's in strawberry?  
  
how many r's in watermelon?
```


The code doesnt let you enter multilines which limits you to small simple prompts. If multiple lines, it would grab the first line only.

We will change how the code receives input from the terminal. Once changed you can copy and paste multiline prompts and also type multiple lines. Press Enter twice to finish the prompt.

At privateGPT.py, replace the while True:  up to and before start = time.time()  that starts measuring the question and answer chain
```
    while True:  
        # query = input("\nEnter a query: ")  
        print("\nEnter your multi-line query (press Enter on an empty line to submit):")  
          
        query_lines = []  # Reset the query for each new input session  
          
        while True:  
            line = input()  # Read a line of input  
            if line.strip().lower() == "exit":  # Check for the exit command  
                return  # Exit the program entirely  
            if line == "":  # If the line is empty (Enter was pressed on an empty line)  
                break  # End multi-line input  
              
            query_lines.append(line)  # Add the non-empty line to the list  
          
        query = "\n".join(query_lines)  # Join all lines with newline characters  
          
        if query.strip() == "":  # Skip processing if the input is just whitespace  
            print("Empty query, please enter something.")  
            continue  
  
        # Process the multi-line query immediately after input  
        print("Processing your query...\n")
```

### Look for better models

Like Llama

### **CleanMyMac Ignore List**

If you have CleanMyMac, it will remove all packages you installed into poetry virtual environments. So if you run CleanMyMac, you’ll have to reinstall the packages again for the poetry shell to work.

While in poetry shell , run pip show pip  and look for the line that says “Location:”. That will be the folder path to pip packages that python can import from.

![](https://i.imgur.com/KhV6eMU.png)

### **“Eject” Poetry**

You could theoretically copy over the packages from poetry so you don’t have to use poetry. You would copy the site-packages contents from the poetry’s pip to your pyenv environment or system’s pip, whichever whose python would run the pythonGPT.py

Or you could export poetry as requirements.txt then install from that requirements.txt:
```
poetry export -f requirements.txt --output requirements.txt  
pip install -r requirements.txt
```