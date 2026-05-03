
## ✅ Use Case: Store & Search Embeddings in AstraDB via n8n

### 🛠 Prerequisites
- [✔️] An **AstraDB** database with Vector Search enabled
- [✔️] Your AstraDB **Application Token (ASTRA_DB_APPLICATION_TOKEN)**
- [✔️] A **collection** in a keyspace that supports vector fields
- [✔️] n8n running (local, cloud, or Heroku)
    

---

## 🔁 Example Workflow

### **1. Generate Embedding (OpenAI Embedding Node or HTTP Request)**

```http
POST https://api.openai.com/v1/embeddings
Headers:
  Authorization: Bearer YOUR_OPENAI_KEY
  Content-Type: application/json
Body:
{
  "input": "Your text to vectorize",
  "model": "text-embedding-ada-002"
}
```

Get the `.data[0].embedding` field from the response.

---

### **2. Store Embedding in AstraDB (HTTP Request Node)**

Set up Astra REST API:

**Endpoint**:

```
POST https://<your-db-id>-<region>.apps.astra.datastax.com/api/rest/v2/namespaces/<keyspace>/collections/<collection>
```

**Headers**:

```
X-Cassandra-Token: YOUR_ASTRA_DB_APPLICATION_TOKEN
Content-Type: application/json
```

**Body Example**:

```json
{
  "documentId": "text_001",
  "text": "Your text to store",
  "embedding": [0.123, 0.456, ..., 0.789]  // from OpenAI
}
```

✅ Make sure your collection has `embedding` defined as a `vector<float, N>`.

---

### **3. Query AstraDB with Similarity Search**

**Endpoint**:

```
POST https://<your-db-id>-<region>.apps.astra.datastax.com/api/rest/v2/namespaces/<keyspace>/collections/<collection>/vector
```

**Body**:

```json
{
  "vector": [0.123, 0.456, ..., 0.789],
  "topK": 5
}
```

You’ll receive the top matching documents with their metadata and similarity scores.

---

## 🔄 Chain It Back to AI Agent

Take the top match results (e.g., `text` field), and include them in your prompt like this:

```js
const docs = items[0].json.documents.map(doc => doc.text).join("\n\n");
return [{ json: { context: docs } }];
```

Then pass `context` into the prompt for your `AI Agent`.

---

### 🧠 Tip: Use a Code Node to Build Astra-Compatible Payloads

AstraDB requires vector length consistency and clean JSON — a `Code` node is great for formatting.

---

## 📦 Summary

|Step|Node|Purpose|
|---|---|---|
|1|HTTP Request|Get OpenAI embedding|
|2|HTTP Request|Store vector in AstraDB|
|3|HTTP Request|Search with query vector|
|4|Code / Merge|Format response into context|
|5|AI Agent|Use retrieved docs as memory|
