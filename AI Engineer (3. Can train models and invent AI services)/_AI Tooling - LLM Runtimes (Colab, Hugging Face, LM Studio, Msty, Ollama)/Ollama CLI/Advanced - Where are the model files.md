Got it—here’s the stripped version:

---

## Where Ollama models are stored

Ollama stores models here:

- **macOS / Linux:**
    
    ```bash
    ~/.ollama/models
    ```
    
- **Windows:**
    
    ```bash
    C:\Users\<your-username>\.ollama\models
    ```
    

---

## What you’ll see

Inside:

```
blobs/
manifests/
```

- `blobs/` = actual model data
    
- `manifests/` = mapping info
    

---

## Important

Files are **content-addressed (hashed)** — not named like `llama3.bin`.

👉 You **won’t recognize models by filename**.  
👉 The names are essentially **addresses**, not human-readable labels.