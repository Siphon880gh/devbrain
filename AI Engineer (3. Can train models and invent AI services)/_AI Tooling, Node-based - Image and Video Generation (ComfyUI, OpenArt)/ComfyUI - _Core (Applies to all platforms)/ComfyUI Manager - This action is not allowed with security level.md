You're trying to install missing nodes for the current workflow by clicking the button to automatically install missing nodes at ComfyUI Manager. You get hit with a security blocking error:
![[Pasted image 20260222033610.png]]

---

Your user flow was this:
![[Pasted image 20260222031829.png]]
![[Pasted image 20260222033648.png]]

![[Pasted image 20260222033657.png]]

---

Pathing and syntax changed way too much for permissions (along with other ComfyUI)

In 2026 lowest setting is `unsafe`  (NOT permissive anymore),  they want it adjusted in the config file inside default profile rather than in the custom nodes themselves or in environmental variables

The security setting used to be inside ComfyUI interface but it has been removed. ChatGPT might take you down that route.

Config file is at (relative to comfyui installation folder) >=v3.0, the official documentations might say:
./user/default/ComfyUI-Manager/config.ini ??? NOPE

Actually in Feb 2026, the path has changed again and their documentation is not updated. It’s at:
`./user/default/user/__manager/config.ini`

![[Pasted image 20260222033823.png]]
![[Pasted image 20260222033924.png]]

<v3.0
Your version number is actually here in the custom node where ComfyUI was installed:
./custom_nodes/ComfyUI-Manager/config.ini

---

Now restart ComfyUI

Try installing the missing nodes again

After successful installation of any nodes you might want to press R to reload node definitions inside ComfyUI
![[Pasted image 20260222025342.png]]

THEN (You’re not done yet!), you want to return to the missing nodes and see if any failed:
![[Pasted image 20260222034030.png]]

Click the “Import Failed”
![[Pasted image 20260222034042.png]]

A larger error message appears:
![[Pasted image 20260222034058.png]]

Then troubleshoot on Google first (minding date of solution), and ChatGPT next (ChatGPT often outdated on these issues)
![[Pasted image 20260222034114.png]]