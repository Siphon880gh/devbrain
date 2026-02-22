Why recommended:
More ways to customize

Read about it:
[https://www.comfy.org/](https://www.comfy.org/)  

Go to a folder where you want to install web apps or related AI apps.

Then git clone the ComfyUI folder there:
```
git clone https://github.com/Comfy-Org/ComfyUI.git
```

Follow the rest of installation instructions at
https://github.com/Comfy-Org/ComfyUI

After installation, launching looks like:

![[Pasted image 20260222031144.png]]
^ Yes there are errors - we will cover this

The terminal then opens your web browser to this URL (If it doesn't, visit directly https://127.0.0.1:8188)

![[Pasted image 20260222031112.png]]

---


Record keeping and auditing successful installation

Perform these steps after an apparently successful installation. The pathing is different from different tech stack versions of ComfyUI as well as on different OS. ComfyUI may also appear to run when some things failed to load.

Copy the terminal output when ComfyUI launches:
![[Pasted image 20260222031144.png]]

Then ask ChatGPT if there was any problem from the ComfyUI launch terminal output such as nodes failing to load. Is the python environment problematic (eg. coda)

Ask Chat where ComfyUI is located, what are the core node path, and what are the custom node paths. Write these down somewhere.

Consulting ChatGPT, fix issues it brings up and write down somewhere key paths etc. You may need them later for manual installation and tweaking of ComfyUI (happens often).

---


In the future a script to launch is:
```
osascript -e 'tell application "Terminal"
    activate
    do script "cd /Users/wengffung/dev/web/comfyui && PYTORCH_ENABLE_MPS_FALLBACK=1 python3 main.py --verbose"
end tell'
```

If using Mac, you can create custom icons at the Docker Bar that runs terminal scripts. Here's creating a Dock Bar icon to launch the ComfyUI Local Web App using Mac's app **Shortcuts**:
![[Pasted image 20260222030138.png]]

---


**INSTALLATION MUST - ComfyUI Manager**

Note: ComfyUI Manager no longer part of ComfyUI installation out of the box. You have to install manually.

You should install **ComfyUI Manager**. It helps you install custom nodes you may need—along with their model dependencies—either by pasting a GitHub link or by clicking an automatic install button that downloads any missing nodes for you.

Often when you open a workflow from a YouTuber or shared file, you’ll see an error saying some nodes are missing. ComfyUI Manager can detect those and install them quickly so the workflow runs properly.

To install, refer to [[ComfyUI - _Installation Additional - ComfyUI Manager]]