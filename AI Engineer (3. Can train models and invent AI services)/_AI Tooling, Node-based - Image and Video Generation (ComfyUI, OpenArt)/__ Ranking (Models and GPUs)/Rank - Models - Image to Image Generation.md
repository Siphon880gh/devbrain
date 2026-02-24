## Image-to-Image in ComfyUI: Model Ranking + fp16 vs fp32 Explained

First, the key clarification:

> ✅ **Yes — the same Stable Diffusion checkpoints used for text-to-image (SD 1.5, SDXL, etc.) also work for image-to-image.** We ranked text-to-image at [[Rank - Models - Image Generation]]

You do **not** need a separate model file.

Image-to-image simply:

1. Encodes your input image into latent space
    
2. Adds noise (based on denoise strength)
    
3. Runs the same diffusion model (UNet)
    
4. Decodes back into an image
    

So the model is the same — the workflow changes.

---

## Important Difference: Why Image-to-Image Can Feel Heavier

Even though it uses the same model:

- It must encode the input image first
    
- Larger input resolution = higher memory use
    
- High denoise strength ≈ similar cost to text-to-image
    
- Using ControlNet increases memory significantly
    

Resolution drives memory usage more than most people realize.

---

## SD 1.5 for Image-to-Image (Most Compatible Model)

This is still the safest choice for most local machines.

### Typical Safe Settings

- Resolution: 512×512
    
- Steps: 20 or fewer
    
- Sampler: Euler or Euler a
    
- Batch size: 1
    
- Denoise strength: 0.4–0.7
    
- No ControlNet
    
- No refiner
    

---

## SD 1.5 fp16 vs fp32 for Image-to-Image

Both versions exist:

- `v1-5-pruned-emaonly.safetensors` → fp32
    
- `v1-5-pruned-emaonly-fp16.safetensors` → fp16
    

Now let’s break down what actually happens.

---

### 🔍 What fp16 Means

- Half precision (16-bit floats)
    
- Designed to reduce VRAM
    
- Often faster on GPUs
    
- Smaller memory footprint
    

---

### 🔍 What fp32 Means

- Full precision (32-bit floats)
    
- More stable
    
- Uses more memory
    
- Standard CPU precision
    

---

## ⚠️ Critical Caveat About fp16

On **GPU**:

- fp16 usually reduces VRAM
    
- Often improves speed
    

On **CPU**:

- Many CPUs do NOT accelerate fp16 math
    
- PyTorch may internally convert fp16 → fp32
    
- So you may see:
    
    - ❌ No speed boost
        
    - ⚠️ Slight instability
        
    - ⚠️ Occasional errors on some devices
        

On some Macs or older systems:

- fp16 can cause weird runtime errors
    
- fp32 is safer
    

So:

> fp16 does NOT guarantee speed improvement — especially on CPU.

---

## CPU-Only Image-to-Image: Realistic Expectations

Assuming:

- 512×512
    
- 20 steps
    
- Moderate denoise
    

---

### Modern i7 / Ryzen 7 (8–16 threads)

|Precision|Time Per Image|Notes|
|---|---|---|
|fp16|3–8 min|May not be faster than fp32|
|fp32|4–10 min|Very stable|

---

### Older i5 (4–6 threads)

|Precision|Time Per Image|Notes|
|---|---|---|
|fp16|8–20 min|Sometimes same speed as fp32|
|fp32|10–25+ min|More RAM use|

---

### Low-Power Laptop CPU

|Precision|Time Per Image|Notes|
|---|---|---|
|fp16|15–35 min|Possible throttling|
|fp32|20–40+ min|Higher RAM pressure|

---

## RAM Considerations

|Precision|Recommended RAM|
|---|---|
|fp16|8GB minimum (16GB better)|
|fp32|16GB recommended|

If you only have 8GB RAM:  
→ fp16 is safer.

If you have 16GB+ RAM:  
→ fp32 may be more stable.

---

## GPU Requirements for SD 1.5 Image-to-Image

|GPU VRAM|Experience|
|---|---|
|4GB|Tight but usable at 512×512|
|6GB|Comfortable|
|8GB|Very stable|
|12GB+|Easily handles higher resolution|

At 768×768:

- 6GB cards may start to struggle
    
- 8GB+ recommended
    

---

## Image-to-Image Model Ranking (Light → Heavy)

Assuming standard 512×512 img2img.

---

### 🟢 1. SD 1.5 (fp16 or fp32)

- VRAM: 4–6GB
    
- CPU: Yes (slow but works)
    
- Most compatible
    
- Best for beginners
    

---

### 🟡 2. SD 2.1

- VRAM: 6–8GB
    
- CPU: Barely
    
- Slightly heavier than SD 1.5
    
- Not dramatically better quality
    

---

### 🟡 3. SDXL Base

- VRAM: 8–12GB
    
- CPU: Not realistic
    
- Much heavier memory footprint
    
- Input resolution strongly impacts stability
    

---

### 🔴 4. SDXL + Refiner

- VRAM: 12–16GB
    
- CPU: No
    
- Doubles memory pressure
    
- For 3090 / 4080 / 4090 class GPUs
    

---

### 🔴 5. Flux (Dev / Pro)

- VRAM: 16–24GB+
    
- CPU: No
    
- Transformer-heavy architecture
    
- Best suited for cloud GPUs
    

---

## Hidden Truth About Image-to-Image Stability

Most crashes are caused by:

- High resolution
    
- Batch size > 1
    
- ControlNet
    
- Refiner
    
- High denoise with large input image
    

Not the checkpoint itself.

---

## Final Practical Recommendation

If your goal is:

> “Works locally on the most computers without drama”

Use:

- ✅ SD 1.5
    
- ✅ 512×512
    
- ✅ 15–20 steps
    
- ✅ Batch size 1
    
- ✅ Moderate denoise
    
- ✅ No ControlNet
    
- ⚠️ fp16 if low RAM
    
- ⚠️ fp32 if stability matters more
    

---

## Bottom Line

- Yes, SD 1.5 fp16 and fp32 both work for image-to-image.
    
- fp16 may reduce memory usage.
    
- fp16 does NOT guarantee speed improvement.
    
- fp16 may cause errors on some CPUs or Macs.
    
- fp32 is safer but uses more RAM.
    
- Resolution affects performance more than precision.
    

---

##  🎯 Leverage AI

Tell AI:
- Your exact GPU (or CPU if no GPU)
- VRAM amount
- RAM amount
- Mac or Windows

And as it for:
- Safe tier
- Stretch tier
- “Don’t even try locally” tier

---

*Weng's personal ChatGPT thread on developing these notes: https://chatgpt.com/c/699c3c27-9274-8328-828b-6bac8716ffff*