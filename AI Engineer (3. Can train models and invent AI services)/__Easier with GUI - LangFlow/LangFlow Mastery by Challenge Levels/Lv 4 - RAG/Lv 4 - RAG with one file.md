Status: 75% done. Please come back later. This is a very long tutorial. - Weng.

GOAL: RAG test with a small text file first. We use small text embedding model from OpenAI. This is to limit cost and so we can quickly see that the RAG works. After working, you can adapt it for multiple PDF files (Hint: Use "Directory" component instead of "File" component)

---


Open the RAG starter template. You'll be presented with a "1. Load Data Flow" and "2. Retrieve Flow":
- Btw the "Parse Data" component is now renamed to "Data to Message" component in Lang Flow's library. 
![](KxjigDH.png)

Sneak peak:
- We will load in you PDFs or text files at "1. Load Data Flow"
- Then at "2. Retrieve Flow", we can query the PDFs or text files about anything

The external connections needed:
- You'd need an external text embedding model - OpenAI offers one.
- You also need a vector database. DataStax offers a free 10gb AstraDB.

These are the credentials and database/collection details missing:
- At Loading (aka Load file): Missing API key at OpenAI text embedding model, missing token / database name / collection name at AstraDB vector database.
- At Retrieval (aka Query): Same missing items, plus missing API key for OpenAI LLM chat model.

**Quick Orientation:**
- At loading data, your file is chunked over to a text embedding model that knows how to vectorize your words into a queryable vector database. It saves the vectors to your queryable vector database.
- At retrieval (aka prompting), your Chat Input will search for the relevant answers in the queryable vector database, using the same text embedding model to do so. The relevant answer (aka variable `context` ) and your Chat Input (aka variable `question` ) gets passed into ChatGPT model, then it rewords the combined text into a prompt response. The only generative part was from AstraDB, and ChatGPT was use for transformation (rewording). Here’s ChatGPT’s transformation work:
```
{context}

---

Given the context above, answer the question as best as possible.

Question: {question}

Answer: 
```

---

**API Key for Text embedding model and ChatGPT**

Get your API key for your project at platform.openai.com

Make sure to enable the text embedding models as well as the ChatGPT model you'll be using. For our example, we will use a small text embedding model:
[https://platform.openai.com/settings](https://platform.openai.com/settings)
![[Pasted image 20250210234531.png]]


**Enter** your API key at the LangFlow canvas, specifically at:
- Load flow's text embedding model
- Retrieval flow's text embedding model and ChatGPT model

---

**AstraDB connection**

https://astra.datastax.com/
Get Free.
What free means
- for the first 10GB
- when inactive, it takes minutes to warm up the database again (meanwhile, will fail)

**Create database** at astradb web dashboard. You can name it something like "test" or something more distinguishable for your RAG use case. It will pend finish initializing. Wait for it to finish. Could take minutes.

Get **application token** under the database:
![[Pasted image 20250210234939.png]]

**DO NOT** create the collection at AstraDB web dashboard. We will create the collection through LangFlow (LangFlow will properly structure your collection at an api call to AstraDB under the hood). 
- FYI: If you do create the collection manually at AstralDB web dashboard, you have to structure the collection correctly including having a content field and including selecting it to be structured for the same text embedding model (default is Nvidia instead of OpenAI text embeddings) and you may need to use their CQL console to do so.

**Enter** your token and database name at the LangFlow canvas, specifically at:
- Load flow's AstraDB component
- Retrieval flow's AstraDB component
- **LEAVE ALONE** collection name

---

**Have Langflow create the AstraDB collection**

At Loading and Retrieval, your AstraDB component should be filled in at the token and database name fields. For this tutorial, I've named the database name "test":
![[Pasted image 20250210235509.png]]

^FYI: Note that not ALL of the inputs need to be connected. Regardless of Load flow or Retrieval flow, the same inputs are available because there is only one version of the AstraDB component. What mattered is which inputs are connected to and then empty fields are ignored

Let's go into Collection to type in a collection name. We will name it "name" or you can name it for your RAG use case:
![[Pasted image 20250210235651.png]]

This will have LangFlow automatically create the collection for you at AstraDB because the collection doesn't exist there. That is fine.





There are two important features here:
- Ingest Data **(Do this step first)**
  ![](oUqhvYl.png)

	AstraDB used to store your document's embeddings (after using OpenAI text embeddings model) is very generous even at free version - 10GB.

- Retrieve
  ![](MkHC2x2.png)
  
  Remember you must first ingest the data (which enhances the AI with your documents, usually by you loading documents in), before you can retrieve (aka prompt the model!). That is RAG - Retrieval-augmented generation.

---

Sign up with astradb 
[https://astra.datastax.com/signup](https://astra.datastax.com/signup)  


> [!note] AstraDB free  
> Yes, AstraDB offers a free tier with limited resources. Here are the key details:
> 
> 1. AstraDB provides a free tier with 10 GB of storage, allowing users to get started without any upfront cost
> 2. On AWS Marketplace, there's a free trial option for AstraDB
> 3. Microsoft Azure offers a 3-month free trial for AstraDB, which includes up to 80GB of storage and 20 million read/write operations per month
> 4. AstraDB uses a "Pay as you go" model, where you only pay for what you use beyond the free tier limits
> 5. The free tier includes one 'Standard' support ticket at no additional cost
> 
>   

Example astradb dashboard url:
[https://astra.datastax.com/langflow/3b168471-973e-43bc-a4cd-2d0e3fbb9ba2/flows](https://astra.datastax.com/langflow/3b168471-973e-43bc-a4cd-2d0e3fbb9ba2/flows)