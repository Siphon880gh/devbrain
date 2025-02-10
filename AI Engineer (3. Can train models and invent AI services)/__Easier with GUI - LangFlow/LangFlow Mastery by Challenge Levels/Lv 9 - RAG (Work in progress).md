Status: Work in progress. Please come back later



Rag starter template
![](KxjigDH.png)



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