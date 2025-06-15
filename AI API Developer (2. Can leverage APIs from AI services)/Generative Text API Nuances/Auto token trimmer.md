Here’s a ready-to-use **Auto Token Trimmer** system using `tiktoken`, designed to:

- Take a long input (article, transcript, etc.)
    
- Automatically trim it to fit a desired token limit
    
- Optionally leave room for the model’s response
    

---

## 🧩 Auto Token Trimmer with `tiktoken` (Python)

### 🔧 Use Case:

Trim your input to **stay under context window or input token budget** (e.g., 100k tokens).

---

### ✅ Code: `auto_token_trimmer.py`

```
import tiktoken  
  
def trim_to_token_limit(text: str, max_tokens: int, model: str = "gpt-4o") -> str:  
    """Trims input text to the max token limit using the model's tokenizer."""  
    enc = tiktoken.encoding_for_model(model)  
    tokens = enc.encode(text)  
  
    if len(tokens) <= max_tokens:  
        return text  # Already under limit  
  
    print(f"⚠️ Input exceeds {max_tokens} tokens. Trimming...")  
  
    # Trim the token list and decode back to string  
    trimmed_tokens = tokens[:max_tokens]  
    trimmed_text = enc.decode(trimmed_tokens)  
    return trimmed_text
```

---

### 🧪 Example Usage

```
if __name__ == "__main__":  
    # Load or define your long input  
    with open("long_article.txt", "r") as f:  
        long_input = f.read()  
  
    # Target: Keep under 100k tokens (leave room for model reply)  
    max_input_tokens = 90000  
  
    safe_input = trim_to_token_limit(long_input, max_input_tokens)  
      
    print("🧾 Trimmed input:")  
    print(safe_input[:1000], "...")  # Preview first 1000 chars
```

---

### 📦 Optional Enhancements

| Feature                     | How to Add                                                                    |
| --------------------------- | ----------------------------------------------------------------------------- |
| **Reserve room for output** | Subtract desired reply tokens from your context limit (e.g. `200000 - 50000`) |
| **Chunking mode**           | Instead of trimming, split into 2–3 chunks and send incrementally             |
| **Token count feedback**    | Add `print(f"{len(tokens)} tokens used")` for insights                        |
| **Streaming large files**   | Read and tokenize line-by-line or paragraph-by-paragraph                      |
