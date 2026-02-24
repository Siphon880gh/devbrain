## 🔢 Model Checkpoint Ranking (Light → Heavy)

| Rank            | Model Type                            | Example Checkpoints                    | VRAM Needed (GPU) | CPU-Only Feasible?        | Who It’s For              |
| --------------- | ------------------------------------- | -------------------------------------- | ----------------- | ------------------------- | ------------------------- |
| 🟢 1 (Lightest) | **SD 1.5 (fp16)**                     | `v1-5-pruned-emaonly-fp16.safetensors` | 4–6 GB            | ⚠️ Very slow but possible | Most laptops w/ basic GPU |
| 🟢 2            | **SD 1.5 (fp32)**                     | `v1-5-pruned-emaonly.safetensors`      | 6–8 GB            | ❌ Not practical           | Older GPUs                |
| 🟡 3            | **SD 2.1**                            | `v2-1_768-ema-pruned.safetensors`      | 6–8 GB            | ❌ Not practical           | Mid-range GPUs            |
| 🟡 4            | **SDXL Base**                         | `sd_xl_base_1.0.safetensors`           | 8–12 GB           | ❌ No                      | Modern GPUs (3060+)       |
| 🟡 5            | **SDXL + Refiner**                    | `sd_xl_refiner_1.0.safetensors`        | 12–16 GB          | ❌ No                      | 12GB+ cards               |
| 🔴 6            | **Flux Dev**                          | `flux-dev.safetensors`                 | 16–24 GB          | ❌ No                      | 3090 / 4090               |
| 🔴 7 (Heaviest) | **Flux Pro / Large Diffusion Models** | `flux-pro`, 20B+ models                | 24GB+             | ❌ No                      | Enterprise GPUs           |

**TLDR:**
SD 1.5 is lighter than SDXL/Flux-style workflows, so it’s more realistic for average local machines (especially older GPUs / lower VRAM / Macs).

---

## 💻 What This Means Practically

### 🟢 SD 1.5 (Best for Most Computers)

- Fastest startup
    
- Lowest VRAM use
    
- Works on:
    
    - 6GB GPUs (GTX 1660, 2060)
        
    - Many 8GB GPUs
        
    - M1/M2 Macs (with patience)
        
- Best for stable local ComfyUI learning
    

---

### 🟡 SDXL

- Much heavier
    
- Needs:
    
    - 8GB minimum (tight)
        
    - 12GB recommended
        
- Slower on Macs
    
- Better realism but more crashes on low VRAM
    

---

### 🔴 Flux Models

- Extremely heavy transformer architecture
    
- Designed for:
    
    - 16GB+ GPUs minimum
        
    - 24GB ideal
        
- Not beginner-friendly locally
    
- Often better suited for cloud GPUs
    

---

## 🧠 CPU-Only Reality Check

|Model|Precision|CPU Feasible?|Realistic Experience|
|---|---|---|---|
|**SD 1.5**|**fp16**|⚠️ Yes (limited)|3–15 min per 512×512 image. Some CPUs don’t benefit from fp16 and may auto-cast to fp32 internally. Slightly lower RAM use.|
|**SD 1.5**|**fp32**|⚠️ Yes|5–25+ min per 512×512 image. Higher RAM usage. More stable across CPU types.|
|SD 2.1|fp16/fp32|⚠️ Barely|15–40+ min per image. Often not worth it.|
|SDXL Base|fp16|❌ Not practical|Extremely slow (30–90+ min). Likely memory errors.|
|SDXL Base|fp32|❌ No|Will likely crash on RAM before finishing.|
|Flux (Dev/Pro)|mixed precision|❌ No|Not realistic on CPU.|

If you are CPU-only:  
👉 **Stick to SD 1.5 at 512x512**

---

## 🏆 Most Compatible Overall

If your goal is:

> “Works on the most computers with least drama”

Choose:

- ✅ SD 1.5 fp16
- ✅ 512x512 resolution
- ✅ No ControlNet
- ✅ No refiner
- ✅ No custom nodes

---

## 🟢 Best CPU Setup for SD 1.5 (CPU-Only)

If running **without a GPU**, use:

- ✅ **Resolution:** 512×512
- ✅ **Steps:** 20 or fewer
- ✅ **Sampler:** Euler or Euler a
- ✅ **Batch size:** 1
- ✅ Disable extra nodes
- ✅ Avoid ControlNet
- ✅ Avoid SDXL

---

# ⚙️ fp16 vs fp32 on CPU (Important)

On CPU:

- **fp16 does NOT usually speed things up**
    
- Many CPUs internally convert fp16 → fp32
    
- fp16 may reduce RAM slightly
    
- fp32 is often more stable
    

So performance difference is usually small — but here’s realistic timing:

---

# ⏱ Expected Time Per Image (512×512, 20 steps)

## 🧠 Modern i7 / Ryzen 7 (8–16 threads)

|Precision|Time Per Image|Notes|
|---|---|---|
|**fp16**|3–8 min|Slightly lower RAM. May not be faster.|
|**fp32**|4–10 min|Slightly more RAM. Very stable.|

---

## 🧠 Older i5 (4–6 threads)

|Precision|Time Per Image|Notes|
|---|---|---|
|**fp16**|8–20 min|Sometimes equal to fp32 speed.|
|**fp32**|10–25+ min|More RAM usage. Stable.|

---

## 🧠 Low-Power Laptop CPU (U-series / thin notebooks)

|Precision|Time Per Image|Notes|
|---|---|---|
|**fp16**|15–35 min|May thermal throttle.|
|**fp32**|20–40+ min|Higher RAM pressure.|

---

# 🧩 RAM Expectations

|Precision|System RAM Needed|
|---|---|
|fp16|8GB minimum (16GB recommended)|
|fp32|16GB recommended|

---

## 🎯 Leverage AI

Tell AI:

- GPU model
- VRAM amount
- Mac or Windows
- RAM amount

And as it for ComfyUI, what are the:
- safe tier
- stretch tier
- "Don’t even try locally" tier

---

*Weng's personal ChatGPT thread on developing these notes: https://chatgpt.com/c/699c3c27-9274-8328-828b-6bac8716ffff*