
## 🛑 Mac User - STOP

Avoid using the ComfyUI Mac app unless your use case is extremely simple and doesn’t require NVIDIA, CUDA, or GPU acceleration. If you do need more advanced features, you’ll have to manually replace models with CPU/MPS-compatible versions developed by other AI engineers — and only if such models even exist for your use case.

> What's a very simple use case?
> "Image Generation" under "Basics" that you can find in Workflows -> Browse Templates. It can generate images from text prompt. It's far basic with the output's realism compared to more modern image generation models. So it should be able to work right out of the box on Mac.
> 

Even then, Mac setups often require additional configuration tweaks (like setting environment variables or passing specific flags such as `PYTORCH_ENABLE_MPS_FALLBACK=1 python3 main.py --force-fp16 --use-split-cross-attention --cpu`). These kinds of customizations are only possible in the Python web app version of ComfyUI — not the Mac app.

Here are some examples of users running into limitations with the Mac app and talk about solutions that only can be applied to the Python web app version:
- [Reddit: Faster workflows for ComfyUI users on Mac](https://www.reddit.com/r/comfyui/comments/1fzrcti/faster_workflows_for_comfyui_users_on_mac_with/)
- [GitHub Issue #4165 – Mac compatibility and configuration problems](https://github.com/comfyanonymous/ComfyUI/issues/4165)

Yes, ComfyUI at comfy.com does officially offer a Mac app — but their presentation of Mac support can be misleading.