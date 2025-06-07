

#### 🔹 Step 1: Generate Embeddings

Use an embedding model (OpenAI, Cohere, Hugging Face, etc.)

**Example (OpenAI Embedding via HTTP Request node):**

```json
POST https://api.openai.com/v1/embeddings
Headers: Authorization: Bearer YOUR_API_KEY
Body:
{
  "input": "Your text here",
  "model": "text-embedding-ada-002"
}
```

#### 🔹 Step 2: Store in a Vector Database

Send the resulting vector and metadata to your vector DB (e.g., Pinecone, Chroma, Weaviate, FAISS).

**Example with Pinecone (via HTTP Request):**

```json
POST https://your-project-id.svc.pinecone.io/vectors/upsert
Body:
{
  "vectors": [
    {
      "id": "unique-id",
      "values": [0.123, 0.456, ..., 0.789],
      "metadata": { "source": "note", "tag": "sales" }
    }
  ]
}
```

#### 🔹 Step 3: Search by Similarity

When needed, create a new embedding for the query, then query the vector DB for similar entries.

**Example query:**

```json
POST https://your-project-id.svc.pinecone.io/query
Body:
{
  "vector": [embedding_array],
  "topK": 3,
  "includeMetadata": true
}
```
