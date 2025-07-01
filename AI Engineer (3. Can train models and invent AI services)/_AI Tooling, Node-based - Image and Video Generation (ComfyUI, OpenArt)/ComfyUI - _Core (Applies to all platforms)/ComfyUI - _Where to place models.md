
### **Where to place models**


There are various types of models:
![[Pasted image 20250701034304.png]]

Here are examples where to place types of models:

| Model Type        | File Name                                  | Folder Path                              |
| ----------------- | ------------------------------------------ | ---------------------------------------- |
| UNet              | `flux1-dev-kontext_fp8_scaled.safetensors` | `path/to/config/of/ComfyUI/models/unet/` |
| VAE               | `ae.safetensors`                           | `path/to/config/of/ComfyUI/models/vae/`  |
| CLIP              | `clip_l.safetensors`                       | `path/to/config/of/ComfyUI/models/clip/` |
| Text Encoder (T5) | `t5xxl_fp8_e4m3fn_scaled.safetensors`      | `path/to/config/of/ComfyUI/models/clip/` |

**To download the model**:

1. Google for `huggingface {modelName}`
	- Eg. `huggingface flux1-dev-kontext_fp8_scaled.safetensors`
2. There is a download link
![[Pasted image 20250701035441.png]]

**To know where to place the models:**

Depending on the form of ComfyUI and your OS and if they changed how ComfyUI stores files, it could be at:
- ~/ComfyUI/models/
- /Users/{USERNAME}/Documents/ComfyUI/models/
- /Users/{USERNAME}/Library/Application Support/ComfyUI/models

To definitely know, you can run `ls` commands in the terminal to see which `ComfyUI` path above exists. If it's an OS software, the model paths are shown at startup - you have to screenshot quickly:
![[Pasted image 20250701044705.png]]

Unfortunately, if it's the python web app, running from terminal doesn't show the model paths. You'll have to resort to the `ls` command trick.

---

### **On Software**

Doesn't apply to: Python web app.

You can actually use Model Manager to download and install models instead of manually performing the steps above:
![[Pasted image 20250701044103.png]]

![[Pasted image 20250701044152.png]]

---
### Restart to apply new models

After placing the model files, you want to restart ComfyUI. If the OS app, going into the ComfyUI Manager, there is a "Restart" button.

![[Pasted image 20250701044407.png]]

---

### **How to tell model missing**

ComfyUI you can select models that are missing on your computer, and there won't be obvious errors on the actual node interface itself. But if you have kept the terminal opened like best practice (per [[ComfyUI - _Best Practice - Open Terminal]]), you'll see that the models are missing:
```
Failed to validate prompt for output 136:  
* VAELoader 39:  
  - Value not in list: vae_name: 'ae.safetensors' not in []  
* DualCLIPLoader 38:  
  - Value not in list: clip_name1: 'clip_l.safetensors' not in []  
  - Value not in list: clip_name2: 't5xxl_fp8_e4m3fn_scaled.safetensors' not in []
* UNETLoader 37:  
  - Value not in list: unet_name: 'flux1-dev-kontext_fp8_scaled.safetensors' not in []
```

which means it's not in your list of installed/founded (therefore empty array [])