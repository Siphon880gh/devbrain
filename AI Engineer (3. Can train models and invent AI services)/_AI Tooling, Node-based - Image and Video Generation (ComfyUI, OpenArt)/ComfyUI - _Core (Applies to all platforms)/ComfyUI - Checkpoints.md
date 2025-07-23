## Sharing of checkpoints in ComfyUI

Many workflows depend on the successful training up to a certain point to produce the quality of output that's acceptable. So many workflows require you to download and then load specific checkpoints.

Quick review on what checkpoints are:
- In AI, a checkpoint refers to a saved snapshot of a machine learning model during training. It typically includes the model’s parameters (weights and biases), and often the state of the optimizer. Checkpoints allow training to be resumed from that point if interrupted, and they provide a way to evaluate performance or revert to a previous state.
- For a deeper dive, refer to [[Checkpoints]]

### ✅ Why Checkpoints Matter in ComfyUI:

ComfyUI is a **modular, node-based interface** for Stable Diffusion and similar models. In this ecosystem:

- **Checkpoints = trained models** (e.g., Stable Diffusion 1.5, SDXL, DreamShaper, etc.)
    
- They define the **core capability and "style"** of the output.
    
- Many workflows (i.e., templates or node graphs) are **designed to work with specific checkpoints**, and will:
    - Fail to run properly,
    - Or produce **incomplete, blurry, or distorted outputs**  
        — if the expected checkpoint is not loaded.
        
### 🔄 Typical Required Files in a ComfyUI Workflow:

- A **checkpoint** `.safetensors` or `.ckpt` file (e.g., `dreamshaper_8.safetensors`)
    
- Optional: **VAE**, **LoRA**, **ControlNet**, **CLIP** model, or **embedding**
    
- Sometimes even specific **sampler settings or latent size** are hard-coded for that checkpoint's architecture

### 📝 Summary:

> **Yes**, most ComfyUI workflows are **not universal** — they rely on **specific checkpoints** and model files that must be downloaded and loaded as instructed. If the required checkpoint is missing or wrong, quality degrades or the graph fails entirely.