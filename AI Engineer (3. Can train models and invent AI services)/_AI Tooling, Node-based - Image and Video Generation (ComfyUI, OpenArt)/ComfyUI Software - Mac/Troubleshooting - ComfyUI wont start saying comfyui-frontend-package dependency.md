Problem: ComfyUI wont start saying comfyui-frontend-package dependency

![[Pasted image 20250830183752.png]]


2025 Feb - comfyui-frontend-package now ships with pip rather than comes included with built in comfyui download. This was to make the ComfyUI developers' job easier, but it comes at a cost of a more complex setup for end users.
https://github.com/comfyanonymous/ComfyUI/issues/7025

- Scoegrams: "Well this took me hours to setup the other day"
- Weng - Took 1 hour to fix.

---

The trick is figuring out which python environment ComfyUI is using in order to install the package with pip. The problem is ComfyUI builds differently in many ways.

On the same computer, when I reinstalled ComfyUI, the locations changed!

Old location in Documents:
![[Pasted image 20250830184415.png]]

Newer location at User:
![[Pasted image 20250830184616.png]]

And not to mention the locations are different if you installed it via their git repo vs their prebuilt Mac download vs their prebuilt Windows download

Some guides suggest running `pip install` inside a `python_embedded` folder - that only applies to Windows.

ChatGPT often mixes up instructions between different builds and platforms, and the guidance isn’t always accurate—even if you specify your setup (e.g., the Mac prebuilt ComfyUI app).

So pay close attention.

---

Cd into your folder. Eg.
```
cd /Users/wengffung/Documents/ComfyUI
```

Enter the venv in the shell session:
```
source .venv/bin/activate
```

Then install with pip3 the frontend package:
```
pip3 install --upgrade comfyui-frontend-package
```

It will appear to freeze for a long time. Just wait it out
```
(ComfyUI) (base) wengffung@Wengs-MacBook-Pro-New ComfyUI % pip3 install --upgrade comfyui-frontend-package  
Collecting comfyui-frontend-package  
  Downloading comfyui_frontend_package-1.26.7-py3-none-any.whl.metadata (117 bytes)  
Downloading comfyui_frontend_package-1.26.7-py3-none-any.whl (10.0 MB)  
   ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ 10.0/10.0 MB 11.1 MB/s eta 0:00:00  
Installing collected packages: comfyui-frontend-package  
Successfully installed comfyui-frontend-package-1.26.7
```


Restart ComfyUI app