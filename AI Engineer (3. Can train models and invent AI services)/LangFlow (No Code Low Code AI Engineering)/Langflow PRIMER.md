Aka Get Started

Langflow. No code low code rapid development of AI apps with AI and DevOps and Agents workflow!!! Drag and drop connections and set the options at each card. The code is implemented behind cards and connections. This means you dont have to manually code RAG, usually in python.

This tutorial will cover the use case of RAG which is the loading of documents then asking AI questions that it can answer using your documents. Typically you would upload MD, PDF, or docx files

There are three requirements: langflow account (free), astradb account (free), openai api account (not free but you load in funds).

> [!note] Curious of Langflow’s Business?
> Langflow is open-source. The project was created by a small team based in Brazil and is now owned by DataStax, but it remains free and open-source. The founders have explicitly committed to keeping Langflow open-source, with one of the co-founders stating, "Langflow will forever be free, open-source, and agnostic". The news of the acquisition and the new founders’ commitment here: https://news.ycombinator.com/item?id=39933342

> [!note] Curious of AstraDb’s Business?
> DataStax offers AstraDB, a cloud-native, serverless database service built on Apache Cassandra. 
> Apache Cassandra is an open-source, distributed NoSQL database management system designed to handle large amounts of data across multiple servers14. It was initially developed at Facebook and combines elements of Amazon's Dynamo and Google's Bigtable to create a highly scalable and reliable database solution. Most importantly, Apache Cassandra supports vectors which is important for AI to understand language and different contexts.


---


Signup langflow
You can easily signup with github oauth
https://www.datastax.com/langflow

Choose the Rag starter template
![](KxjigDH.png)


Know these shortcuts to make your life easier:  
- drag to pan
- cmd+drag to zoom

Use the cards’ controls for setup/use.

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

---

OpenAI:
Get api key (not free) for text embedding model
https://platform.openai.com/settings/organization/api-keys

