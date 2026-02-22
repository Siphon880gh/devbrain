*EF = Easily forgotten, especially after a long time*

**Pathing and syntax changed way too much.**

For example permissions had env variables you can set at python command as a prefix or thorugh your zshrc or through your system but not anymore. Permissions lowest was permissive but now it’s unsafe. They want you to edit in config.ini which has changed path between different versions (`<v3` or `>v3`) and different OS and different tech stack (ComfyUI has different versions)!

**Their documentation might be months out of date on latest syntax changes.**

**AI will get it outdated when asking to solve problems.** The easiest solution is to find the most recent articles and youtube videos or to use online comfyui platforms that have cloud (Perhaps that’s comfyui’s inspiration for making the app unstable from version to change)

**Custom nodes** path may be confused. You’d see a lot of **_comfy_extra_** in the terminal when running up comfyui. Those are actually the core nodes (beyond the core core nodes) that ComfyUI uses. You might not see any if at all custom_node/ loaded if this is a new Comfyui installation. But additional custom nodes goes to custom_nodes/.

![[Pasted image 20260222025150.png]]

  

**Refresh node definitions**

After successful installation of any nodes you might want to press R to reload node definitions inside ComfyUI
![[Pasted image 20260222025342.png]]

**ComfyUI Manager no longer part of ComfyUI installation out of the box**. You have to install manually. To install, refer to [[ComfyUI - _Installation Additional - ComfyUI Manager]]
