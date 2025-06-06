## What are multidimensional arrays

A multidimensional array (or tensor) can be represented as a matrix in linear algebra, especially in the context of spatial data points. In machine learning and data analysis, this allows us to map similarities and differences between different sets of data by performing operations on these matrices or higher-dimensional tensors.

In linear algebra, a matrix is essentially a two-dimensional array of numbers that can represent data points in various dimensions, such as rows and columns. When working with spatial data (e.g., images, 3D points, or even time-series data), we can extend this concept to tensors, which can hold multiple dimensions (e.g., height, width, depth, and time). For example:

1. **Matrix (2D Tensor)**: Represents data like a grayscale image (height × width) or a table of data (rows × columns).
2. **3D Tensor**: Can represent an RGB image (height × width × color channels) or spatial-temporal data (latitude × longitude × time).
3. **Higher-Dimensional Tensor**: Used in more complex scenarios, like modeling physical phenomena or video data (frames × height × width × color channels).

Once data is represented in these forms, mathematical operations such as dot products, matrix multiplications, and other linear transformations allow us to analyze and compare data. By doing so, we can:

- **Map similarities**: Calculate similarity metrics (e.g., cosine similarity, Euclidean distance) to see how close two data points or sets are in their respective feature spaces.
- **Map differences**: Use subtraction, element-wise operations, or more complex methods like singular value decomposition (SVD) or principal component analysis (PCA) to highlight differences between data sets.

These operations are foundational in fields like **machine learning**, where the goal is often to find patterns, classify, or cluster data. For example:

- **Clustering**: By mapping spatial data points, you can group similar data together based on their proximity in the multidimensional space.
- **Classification**: You can map data points into different categories by finding patterns in the spatial relationships within the data.
- **Dimensionality reduction**: Techniques like PCA reduce the complexity of the data while preserving its most important features, making it easier to visualize and analyze.

So, representing multidimensional arrays (tensors) as matrices and performing operations on them allows us to map the similarities and differences between datasets, which is a key process in machine learning, data science, and other mathematical applications.

To see how the vectors are represented in programming, see [[Python - Pytorch vs Tensorflow]]

---

### Document Ingestion and Embedding

When you ingest documents into an AI or maching learning system that uses **embedding models**, the system converts the text (or other forms of data) into **vector embeddings** to represent the documents in a numerical form that machine learning models can work with. 

Note some AI engineers call it indexing instead of ingestion.
- Indexing term used:  https://github.com/wombyz/MBAGPT/blob/main/docs/branson/Richard%20Branson%20-%20Way%20-%2010%20Secrets%20og%20the%20Worlds's%20Greatest%20Brand%20Builder%20%5BEnglishOnlineClub.com%5D.pdf
-  Ingestion term used: https://github.com/zylon-ai/private-gpt?tab=readme-ov-file#-privategpt-

Here’s how the process works in more detail:

1. **Document Ingestion**: 
   - When you ingest (upload or input) documents into an AI or machine learning system, the raw text from these documents is first preprocessed. This often involves tokenizing the text (breaking it down into individual words or subwords) using a tokenizer model.
   
2. **Tokenization**:
   - The tokenizer breaks text into smaller units called **tokens**. Depending on the tokenizer, a token can be a word, part of a word (subword), or even a character.. For instance, a document containing "Natural Language Processing is fascinating!" might be tokenized into ["Natural", "Language", "Processing", "is", "fascinating", "!"].
   - Depending on the token model used, a user input plus the LLM's output response could cost more tokens or less tokens. Furthermore, because a token could represent words or subwords, some languages are more expensive to run, eg. Spanish is more expensive than English.
   - To approximate how many tokens for a word, sentence, or paragraph, refer to: [[AI - Tokens to words, sentences, paragraphs]]
   
3. **Embedding Creation**:
   - Once tokenized, an **embedding model** (such as BERT, GPT, or Word2Vec) processes these tokens and transforms them into **vector embeddings**. These are fixed-size vectors (often with hundreds of dimensions) that capture the semantic meaning and context of the words or phrases in the document.
   - For example, words like "king" and "queen" might be embedded as vectors in such a way that they are close together in the embedding space because of their similar meanings. Similarly, entire sentences or paragraphs can be embedded as vectors that represent the meaning of the text.
   - Name-sake: The reason they are called **embeddings** is that they "embed" the semantic meaning of the text into this vector space, allowing for numerical operations like distance and similarity calculations.

4. **Storing in a Vector Embedding Database**:
   - After generating embeddings for the document, these vectors are stored in a **vector embedding database**. This specialized database allows for efficient searching, querying, and similarity comparisons between documents or text.
   - These embeddings enable tasks like document retrieval, semantic search, or clustering similar documents together based on their vector representations.
   - These databases are optimized for operations like **nearest neighbor search**, where the goal is to find embeddings (vectors) that are close to a given input vector. This is useful in many applications, like searching for similar documents, images, or even semantic search in NLP. Popular examples of such databases include **Pinecone** or **FAISS** (Facebook AI Similarity Search). ChromaDB is another vector embedding database and it's used in the popular PrivateGPT primordial branch used to run a local LLM and leverage RAG with documents.

**Word Embedding Models**:

- **Pre-trained Embedding Models** (such as Word2Vec, GloVe, or FastText) map tokens to vectors before training a language model. These embeddings are learned from large amounts of text data. Then the embeddings are saved to a vector embedding database like ChromaDB. Once trained, the embeddings are fixed—meaning each word (e.g., "bank") always gets the same vector, regardless of context. These pre-trained embeddings can be saved to a vector database like ChromaDB. This allows you to store and retrieve them for various tasks such as semantic search, information retrieval, or similarity matching.
- **Contextualized Embeddings** (from models like BERT, GPT) create vectors that are contextualized, meaning the same word (e.g., "bank") will have different embeddings depending on its context (financial institution vs. riverbank). Your code reads the vector embeds from the database then adds them to the LLM. Therefore, the LLM generates new embeddings in real-time based on the input text. You wouldn’t typically store contextualized embeddings for use later unless you are doing some kind of information retrieval where you want to keep track of vector representations of documents for querying.

---

## As represented by files and code

### Ingestion

For example, PrivateGPT's primordial branch (CLI branch; they have moved onto a UI solution). They have an `ingest.py` script where you feed it PDF files for prompting later.

The `ingest.py` reads from `.env` for the `source_documents/` where PDFs, txt, etc are at. The persist_directory, which could be `db/` is where to store those embeddings, and in the case of PrivateGPT, it's stored as chromadb format. 

In the `.env` file that `ingest.py` reads is `EMBEDDINGS_MODEL_NAME`.  That is the filepath to the  pre-trained model that convert words or phrases into fixed-length vectors that capture their semantic meaning, allowing for tasks like sentiment analysis, language translation, and text generation. 
- Eg. MiniLM (`all-MiniLM-L6-v2`)**: A lightweight transformer model used primarily for **sentence embeddings** and tasks like semantic similarity, text clustering, and search. It’s focused on encoding sentences into fixed-size vectors.

https://github.com/zylon-ai/private-gpt/tree/primordial

### Tokenize and Embed

For example, when you download a meta llama model, you may see files such as tokenizer.model, params.json, and conslidated.00.pth

Introducing LLaMA: A foundational, 65-billion-parameter large language model

1. **`tokenizer.model`**: This file is used to handle the **tokenization** process. The tokenizer converts input text into tokens (like words or subwords), which the model can then process. The `.model` file is typically a binary representation of the tokenizer, which could be based on algorithms like byte-pair encoding (BPE) or sentencepiece, commonly used with large language models (LLMs) like Meta's LLaMA.
    
2. **`consolidated.00.pth`**: This file likely contains the **weights of the large language model (LLM)** in PyTorch format. It's a serialized PyTorch model file (`.pth` is a common extension for PyTorch models). This file holds the trained parameters (weights and biases) of the LLaMA model, which are essential for running inference or further fine-tuning.
    
3. **`params.json`**: This file usually contains **metadata about the model**. It could include:
    
    - Hyperparameters used during training, such as learning rate, batch size, number of layers, etc. These are important during training with datasets so it doesn't overfit or overshoot.
    - Information about the architecture of the model, like the number of layers, heads in the attention mechanism, hidden size, etc.
    - Any other configuration settings that may be needed to initialize the model properly or interpret its output.


----

## Next Reading

The next suggested reading is [[Concept Primer - 3. How to choose a model and download]]

