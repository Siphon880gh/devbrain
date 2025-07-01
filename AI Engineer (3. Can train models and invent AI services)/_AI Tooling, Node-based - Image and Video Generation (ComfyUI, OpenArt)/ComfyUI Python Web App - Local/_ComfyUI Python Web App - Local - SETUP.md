## ⚠️ Mac User? Maybe can proceed

If you're on a Mac, cloud-based ComfyUI services are generally the recommended path due to the limitations of Apple Silicon (MPS) when compared to NVIDIA’s CUDA. That said, if cloud GPU usage isn't feasible—whether for budget reasons or because your workflow is relatively simple—you can attempt to run the ComfyUI Python web app locally.

**Important caveat:** running locally on macOS often requires **manual, case-by-case configuration for each workflow**, and even with extensive tweaking, **some workflows may simply not be possible**. This is because certain models or nodes don’t yet have MPS-compatible versions. In practice, this often means combing through GitHub issues, forums, and scattered community fixes—and even then, tools like ChatGPT may suggest configurations that won’t work for your setup.

That said, the local Python web app still offers **more flexibility and customization options** than the official ComfyUI Mac App, which is more restricted and supports fewer workflows. While the Mac App is listed as officially supported on comfy.com, it’s worth noting that its real-world usefulness is limited—and this isn’t clearly communicated on the official site.

---
# 🧠 Setup

These instructions set up **ComfyUI v0.3.43** using **Python 3.10** inside its own folder, **without affecting other Python projects**.

---

## ✅ Prerequisites

- Install pyenv in the way that's appropriate for your OS. For example, if on Mac, you use homebrew's `brew`:
```bash
brew install pyenv
```

---

## 🛠 Step-by-Step Installation

### 1. 🧬 Clone ComfyUI

In your terminal:

```bash
git clone https://github.com/comfyanonymous/ComfyUI.git
cd ComfyUI
```

This keeps everything self-contained in the `ComfyUI/` folder.

---

### 2. 🐍 Set Up Python 3.10 (Scoped to ComfyUI Folder)

Install Python 3.10.x (required for ComfyUI v0.3.43):

```bash
pyenv install 3.10.13
```

Then inside the `ComfyUI/` folder:

```bash
pyenv local 3.10.13
```

Verify the right version is active:

```bash
python --version
# Should show: Python 3.10.13
```

Your directory should now look like:
![[Pasted image 20250701050348.png]]

---

### 3. 📦 **Optional**: Create Virtual Environment

Still inside the `ComfyUI` folder:

```bash
python -m venv venv
source venv/bin/activate
```

Then install dependencies:

```bash
pip install -r requirements.txt
```

---

### 4. 🍏 (Optional but Recommended for M1/M2 Macs)

Enable fallback in case a PyTorch op isn’t implemented on MPS:

```bash
export PYTORCH_ENABLE_MPS_FALLBACK=1
```

To make this permanent, add it to your shell config (e.g., `~/.zshrc` or `~/.bash_profile`):

```bash
echo 'export PYTORCH_ENABLE_MPS_FALLBACK=1' >> ~/.zshrc
```

Then reload:

```bash
source ~/.zshrc
```

---

### 5. 📁 Download & Place Model Files

Put your `.safetensors` and model files inside these folders under `ComfyUI/models/`:

```
models/
├── checkpoints/    → .safetensors model files
├── clip/           → clip_l.safetensors etc.
├── vae/            → ae.safetensors etc.
├── unet/           → flux1-dev-kontext_fp8_scaled.safetensors etc.
└── ...
```

> ⚠️ If using a template like `flux_kontext`, make sure you download **exact** filenames used by the workflow (`.json`) or you'll get missing model errors.

---

### 6. 🚀 Launch ComfyUI

From inside the `ComfyUI` folder and with the venv activated:

```bash
python main.py
```

You’ll see something like:

```
...go to: http://127.0.0.1:8188
```

![[Pasted image 20250701050113.png]]

Then open: [http://localhost:8188](http://localhost:8188/)

---

## 🧼 To Run Again Later

Anytime you want to run it again:

```bash
cd ComfyUI
source venv/bin/activate
python main.py
```

---

## 💡 Notes

- You're using **ComfyUI v0.3.43**, which works with Python 3.10.
- Using `pyenv local` keeps your Python scoped to this folder only.


----

## Mac?

Recommend you create a Shortcut. Then you can click an icon in the Dock to automatically run the launch command. Refer to [[Shell commands in Mac Dock - Okay with approximate custom icons]]

The Shortcut script would be:
- Adjust the path to the locally cloned git repo
```
osascript -e 'tell application "Terminal"
    activate
    do script "cd /Users/wengffung/dev/web/comfyui && PYTORCH_ENABLE_MPS_FALLBACK=1 python3 main.py --verbose"
end tell'
```