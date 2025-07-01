There are several forms of ComfyUI, although the interface are all similar. This is why we have a folder called `ComfyUI - _Core (Applies to all platforms)`

## Mac User?

You should **avoid the Mac App**. Although it is officially supported, Comfy.com is a bit misleading. Refer to [[ComfyUI Software - Mac - _Avoid unless you like pain or chance it not working]]

Stick to either **python web app** or a cloud version that allows you to run on a **cloud gpu** that supports nvida cuda. No, you cannot from a **local python web app** switch over to cloud gpu.

But you can run a **cloud python web app** instance like you SSH root access into the terminal. That does require much setup and you do have to keep mindful how to turn on and off the server to prevent unnecessary hourly charges (unless 24 hours-on fits a business use case).

Alternately, some platforms are designed to run tasks on-demand and charge only for the time you use. They significantly reduce setup time by handling many AI engineering dependencies—like PyTorch—for you. Even better, services like RunPod and Vast.ai offer pre-configured ComfyUI templates labeled "Ready to Use." These come with all the ComfyUI nodes' dependencies installed and are fully integrated with the server’s CUDA-enabled GPUs, so you can get started right away without compatibility issues.

---

## Mac User - In more details


### ⚠️ Why the ComfyUI Mac App Isn’t Ideal (And What to Use Instead)

If you’re on a Mac, you might notice ComfyUI offers an official Mac app. But don’t be fooled — while technically supported, it falls short for real-world use.

### 🚫 Why You Should Avoid the Mac App

ComfyUI's Mac app only works well for **very simple workflows**. Beyond that, you're likely to run into major limitations:

- ❌ **No NVIDIA GPU/CUDA support** — Apple’s MPS backend is much slower and less compatible.
    
- 🔄 **Limited model compatibility** — You’ll need to manually find and replace standard models with CPU/MPS-compatible alternatives, if they even exist.
    
- ⚙️ **No advanced config access** — You can’t pass in flags or environment variables for tuning performance.
    
- 🧪 **MPS support is experimental** — Even with tweaks like `PYTORCH_ENABLE_MPS_FALLBACK=1`, results can be unstable.

### 💬 Real-World User Struggles

Here are examples of users hitting roadblocks with ComfyUI on Mac:
- [🔗 Reddit – Faster workflows on Mac](https://www.reddit.com/r/comfyui/comments/1fzrcti/faster_workflows_for_comfyui_users_on_mac_with/)

- [🔗 GitHub Issue #4165 – Mac setup headaches](https://github.com/comfyanonymous/ComfyUI/issues/4165)

### ✅ Your Better Options (Beyond the Mac App)

Depending on your comfort level and performance needs, there are **three practical ways to run ComfyUI**:

### 1. **Local Python Web App (DIY on Your Machine)**

Run ComfyUI’s full-featured Python web app locally on your Mac or PC.

- 🛠️ Full access to settings, flags, and custom models
- ✅ Required for anything that needs CLI flags or advanced workflows
- 🚫 Still limited by your Mac’s lack of NVIDIA GPU (you’ll rely on CPU or Apple’s MPS)
    
**Best for:** Local testing or workflows that don’t need high-speed GPU acceleration.

### 2. **Cloud-Hosted Python Web App (GPU on Demand)**

Set up your own cloud server with GPU support (e.g. on AWS, GCP, LambdaLabs, etc.), install ComfyUI, and access it from your Mac browser.

- 💻 Complete control over installation and models
    
- 🚀 Access to powerful GPUs like A100 or 4090
    
- 💰 Turn servers on/off as needed to save money
    

**Best for:** Tech-savvy users who want flexibility and power, but don’t mind setup time.

### 3. **Cloud GPU Rental Platforms with ComfyUI Templates**

Use services like RunPod, Vast.ai, or Paperspace that offer ready-to-use ComfyUI templates with GPU access.

- ⚡ No setup required — one-click deploy
    
- 📁 Upload your models, workflows, and start working
    
- 💤 Stop the instance when idle to avoid charges
    

**Best for:** Anyone who wants powerful ComfyUI performance with zero installation overhead.