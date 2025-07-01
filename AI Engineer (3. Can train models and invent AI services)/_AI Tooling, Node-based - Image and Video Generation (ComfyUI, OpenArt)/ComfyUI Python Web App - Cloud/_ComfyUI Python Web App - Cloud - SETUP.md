# 🧠 Setup

These instructions set up **ComfyUI v0.3.43** using **Python 3.10** inside its own folder, **without affecting other Python projects**.

---

## ✅ Prerequisites

Install `pyenv` per your Linux OS. Refer to [[Pyenv - _How to install]] for your Linux OS' instructions.

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
![[Pasted image 20250701050534.png]]

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

Then open an url that's reverse proxied to [http://localhost:8188](http://localhost:8188/) or visit http://example.com:81811 directly if you do not have UFW etc firewall (in that case, you'd have to open the port).

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