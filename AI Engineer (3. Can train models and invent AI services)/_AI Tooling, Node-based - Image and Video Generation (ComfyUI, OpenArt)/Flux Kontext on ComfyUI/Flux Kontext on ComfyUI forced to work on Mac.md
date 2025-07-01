
⚠️ Warning: This approach loses the “Flux magic,” but you’ll get something stylistically close. If you want the updated look of Flux, then do not perform this workaround on Mac. Instead, setup Cloud server that has Nvidia CUDA support or buy a Windows computer with Nvidia CUDA support.

## 🧊 ComfyUI Freezes at 80% on Mac? Here’s Why — and What to Do (Flux Kontext Fixes for Apple Silicon)

If you're running **ComfyUI v0.3.43** on a **Mac** (M1, M2, M3), and try using a template like `flux_kontext_dev_basic` to stylize an image (e.g., turning a swan into a Simpsons-style image), you’ve likely run into this issue:

> ✅ The workflow loads successfully  
> 🔁 The tab shows 80%...  
> ❌ But it **never finishes**

In your terminal logs, you’ll see something like this:

```
Prompt executed in 0.78 seconds  
Using split attention in VAE  
Using scaled fp8: fp8 matrix mult: False, scale input: True  
model_type FLUX  
loaded completely ...  
  0%|                 
```

This is a **known limitation** when running Flux Kontext templates on Mac. Let’s break down **why it happens**, and more importantly, **how you can work around it**.

---

## ❌ Why the Workflow Freezes at 80% on Mac

### 1. **Flux Models Use FP8 (Float8) — Not Supported on Mac**

Flux Kontext templates depend on model weights like:

- `flux1-dev-kontext_fp8_scaled.safetensors`
    
- `t5xxl_fp8_e4m3fn_scaled.safetensors`
    

These models rely on **FP8 (Float8)** tensor operations, which are:

- ⚠️ **Only supported on newer NVIDIA GPUs** (A100, H100, L4)
    
- ❌ **Not available on CPU**
    
- ❌ **Not supported on Apple’s MPS (Metal Performance Shaders)**
    

Even though the models technically "load," the inference step stalls forever — usually at 80% — because the core math **can’t run**.

---

### 2. **Split Attention and Custom Model Layers**

Flux models also use:

- Split attention mechanisms
    
- Custom VAE/CLIP layers
    
- Large-scale tensors incompatible with CPU fallback
    

Apple’s MPS backend doesn’t support these, and PyTorch will silently drop to CPU — where these operations either break or become unusably slow.

---

### 3. **Setting `PYTORCH_ENABLE_MPS_FALLBACK=1` Won’t Help**

Even if you try to force fallback:

```bash
export PYTORCH_ENABLE_MPS_FALLBACK=1
```

You’ll still hit a wall because **MPS doesn't support FP8**. PyTorch can’t auto-convert these weights into something your Mac GPU can understand.

---

## ✅ What You Can Do Instead

### 🔄 Option 1: Use Quantized Alternatives (GGUF or FP16)

Some users have success running modified versions of Flux models by converting them to **FP16** or **GGUF** quantized formats:

#### 🧰 What you'll need:

- **GGUF-format Flux models** (e.g. Q4.1 quantization)
    
- The **[ComfyUI-GGUF plugin](https://github.com/pythongosssss/ComfyUI-GGUF)** (adds support for GGUF models in ComfyUI)
    
- A modified workflow that loads these formats instead of the default FP8 models
    

> ⚠️ Performance will still be slow on Mac, but **it will run** and complete.

---

### 🧱 Option 2: Manually Replace Flux Nodes

If you know your way around ComfyUI:

- Replace `FluxUNet` → `UNETLoader`
    
- Replace `FluxCLIPModel_` → `CLIPTextEncode`
    
- Replace `FluxVAE` → `VAELoader`
    
- Swap out `t5xxl_fp8` encoders with SD-compatible CLIP models
    

Then rewire the graph and load SD1.5-compatible weights. This approach loses the “Flux magic,” but you’ll get something stylistically close.

---

### ☁️ Option 3: Run Flux Workflows on a Cloud GPU

Flux templates were built for CUDA GPUs. The most reliable way to run them is via cloud services like:

- [RunPod.io](https://runpod.io/)
    
- [Vast.ai](https://vast.ai/)
    
- [Google Colab](https://colab.research.google.com/)
    
- [Paperspace](https://www.paperspace.com/)
    

Pick an A100 or L4 machine to ensure full FP8 support.

---

## 🧠 TL;DR

|Feature|Mac Support|
|---|---|
|Loading FP8 models|✅ Loads, but inference hangs|
|Running inference (Flux)|❌ Hangs at 80%|
|CPU fallback|❌ Too slow or unsupported|
|Apple MPS (Metal)|⚠️ No FP8 support|
|Quantized GGUF/FP16 models|✅ Work, with setup and performance tradeoffs|
|Best solution|✅ Use SD1.5 workflows or Cloud GPU for Flux|
