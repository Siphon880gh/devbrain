If you’re running Ollama locally, models can easily take **multiple GB each**. Here’s how to see what’s taking space and safely remove it.

---

## 1. See which models are using space

```bash
ollama list
```

Example output:

```
NAME              SIZE     MODIFIED
llama3:8b         4.7 GB   2 days ago
mistral           4.1 GB   1 week ago
codellama:13b     7.3 GB   3 weeks ago
```

👉 This is your **main decision table**

- **SIZE** = biggest impact on disk
    
- **MODIFIED** = last time used (older = safer to delete)
    

---

## 2. Identify what to delete

Prioritize removing:

- Large models you don’t use anymore (e.g. 13B, 34B)
    
- Older models you haven’t touched in weeks
    
- Duplicate-purpose models (e.g. multiple chat models)
    

Quick rule:

- Keep **1–2 core models**
    
- Delete everything else
    

---

## 3. Delete a model

```bash
ollama rm codellama:13b
```

- Frees space immediately
    
- Safe — you can always re-pull later
    

---

## 4. Check total disk usage (optional)

```bash
du -sh ~/.ollama/models
```

Want to see the biggest files:

```bash
du -sh ~/.ollama/models/* | sort -h
```

---

## 5. Important (how storage actually works)

Models are stored as **shared blobs**:

- Deleting one model may **not free full space** if others share layers
    
- Space is reclaimed only when unused blobs are fully removed
    

👉 So if space doesn’t drop much:

- You likely have overlapping models (same base weights)
    

---

## 6. Fast cleanup strategy

If you're tight on space:

1. Run:
    
    ```bash
    ollama list
    ```
    
2. Delete everything except:
    
    - your main chat model (e.g. `llama3`)
        
    - one specialty model (optional)
        
3. Re-download later only when needed
    

---

## 7. Pro tip

If you're experimenting a lot:

- Periodically clean unused models
    
- Don’t keep multiple large variants unless necessary