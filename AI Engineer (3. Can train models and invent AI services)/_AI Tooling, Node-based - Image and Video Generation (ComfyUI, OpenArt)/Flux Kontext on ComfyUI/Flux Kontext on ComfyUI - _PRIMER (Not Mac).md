
## What is

Im using ComfyUI. It's using flux_kontext_dev_basic template which allows me to prompt about an image to regenerate it to my prompt's instructions, in effect modify the image by text prompt. 

It's available at Workflows → Browse Templates here:
![[Pasted image 20250701053119.png]]

This video is on Flux Kontext on local comfyui. Assumes you are using Windows though because it didn't mention running into problems (which you would on Mac):
[https://www.youtube.com/watch?v=enOlq9bEtUM&feature=youtu.be](https://www.youtube.com/watch?v=enOlq9bEtUM&feature=youtu.be)

## Preparation

Where to download swan input for playing with:

Search for the words "Download the following files and drag them into ComfyUI to load the corresponding workflow" at this comfy documentation on flux-1-kontext-dev
[https://docs.comfy.org/tutorials/flux/flux-1-kontext-dev#about-flux-1-kontext-dev](https://docs.comfy.org/tutorials/flux/flux-1-kontext-dev#about-flux-1-kontext-dev)

Or download image here:
![[Pasted image 20250701053143.png]]

How it looks in Comfy UI:
![[Pasted image 20250701053156.png]]

---

## Test Run

Hit "Run" and cross your fingers. If on Mac, you may run into some trouble

---

## Gotcha's

### Gotcha 1 - Missing Models

You may be missing models and you won't get obvious errors about it in the node canvas.

But if you open terminal, here's how the terminal errors look and how to fix them by downloading the models:
![[Pasted image 20250701053257.png]]

Expanded, the errors are:
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

On how to fix these errors by downloading and placing the models, refer to [[Troubleshooting, Terminal - Value not in list]]

### Gotcha 2 - Clip model text projection weight missing

Got error in the terminal `clip missing: ['text_projection.weight']` . You just need to select a weight - change "default" to one of the fp8 options in the comfy gui and this message will go away. Refer to [[Troubleshooting - Trying to convert Float8 to the MPS backend but it does not have support for that dtype]]

### Gotcha 3 - Float8 problem

Got this error?  
`Trying to convert Float8... to the MPS backend but it does not have support for that dtype.`

![[Pasted image 20250701015259.png]]

If on Mac App, switch to installing local python web app where you have more configuration options, or just go cloud.

The local python web app launch options are:
```
PYTORCH_ENABLE_MPS_FALLBACK=1 python3 main.py --force-fp16 --use-split-cross-attention --cpu
```

For more details, refer to [[Troubleshooting - Trying to convert Float8 to the MPS backend but it does not have support for that dtype]]

---

## Mac?

Forcing Kontex to work on Mac by downgrading the models .

Note that the results of modifying an image into a new image with text wouldn't be as realistic or modern as the Flux Kontext demo's by doing this. Your other solutions is to use a Cloud server solution that has Nvidia CUDA, referring to [[_Choosing the correct form of ComfyUI - Mac User]]



