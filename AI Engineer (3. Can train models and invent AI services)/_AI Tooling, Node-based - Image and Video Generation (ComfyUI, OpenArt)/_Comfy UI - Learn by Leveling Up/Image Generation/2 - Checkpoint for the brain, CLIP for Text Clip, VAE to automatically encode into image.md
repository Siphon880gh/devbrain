Here's a **beginner-friendly breakdown** of the other most commonly used nodes in ComfyUI to generate images — covering **how they work, their options, and simple explanations**.

## ✅ **1. `Load Checkpoint`** – Load a Model

This loads a **Stable Diffusion model checkpoint** (`.ckpt` or `.safetensors`) — it’s like choosing which “brain” the AI uses to generate.

### Options:

|Option|Explanation|
|---|---|
|**ckpt_name**|Choose the model file (e.g., `v1-5-pruned.safetensors`, `sd_xl_base_1.0.safetensors`)|
|**vae_name**|Optional: overrides VAE (color and contrast post-processing). If empty, uses the model’s default VAE.|

> [!note] 🔍 What's a Checkpoint?  
> A checkpoint is a trained model. It determines the art style, quality, and what kinds of images it can generate. Think of it as the "artist's personality."

---

## 🧠 **2. `CLIP Text Encode`** – Encode the Prompt

This converts your **text prompt into a vector** that the model understands.

### Options:

|Option|Explanation|
|---|---|
|**Text**|Your prompt (e.g., `"a cute fox in a forest"`)|
|**CLIP**|Connect this from the `Load Checkpoint` node (don’t touch unless using multiple encoders)|

You’ll use **two `CLIP Text Encode` nodes** — one for the prompt, one for the **negative prompt** (what to avoid).

---

## 🌈 **3. `KSampler`** – Generates the Image

(Already explained in [[1 - KSampler for diffusion, Latent Image the canvas]].)

> It combines model + prompt + image size + noise seed to generate your image over time.

---

## 📄 **4. `Empty Latent Image`** – Blank Image Space

(Already explained in [[1 - KSampler for diffusion, Latent Image the canvas]].)

> This sets the width and height of your image before it’s turned into pixels.

---

## 🖼️ **5. `VAE Decode`** – Turns Latent into Visible Image

After the image is generated in a **latent space**, this node converts it into an actual **image you can see and save**.

### Options:

|Option|Explanation|
|---|---|
|**Samples**|Connect from `KSampler`|
|**VAE**|Connect from `Load Checkpoint` or your own VAE file|

> [!note] 🎨 What's a VAE?  
> A VAE (Variational AutoEncoder) is a part of Stable Diffusion that translates the “invisible math image” into something visual. Different VAEs can slightly affect sharpness, color, and contrast.

---

## 💾 **6. `Save Image`** – Save to Disk

This saves the final output to a folder on your system.

### Options:

|Option|Explanation|
|---|---|
|**filename_prefix**|Optional: lets you label the output images (e.g., `fox_`)|
|**images**|Connect this from the `VAE Decode` node|

---

## 🧪 Simple Example Workflow

```
Load Checkpoint
   ↓
CLIP Text Encode (Prompt)
CLIP Text Encode (Negative Prompt)
   ↓
Empty Latent Image → KSampler
   ↓
VAE Decode
   ↓
Save Image
```

This chain creates a fully working text-to-image pipeline.

---

Weng's personal notes:
https://chatgpt.com/c/684ed776-1914-800f-bf1c-7d82238ea592