Note: ComfyUI Manager no longer part of ComfyUI installation out of the box. You have to install manually.

You should install **ComfyUI Manager**. It helps you install custom nodes you may need—along with their model dependencies—either by pasting a GitHub link or by clicking an automatic install button that downloads any missing nodes for you.

Often when you open a workflow from a YouTuber or shared file, you’ll see an error saying some nodes are missing. ComfyUI Manager can detect those and install them quickly so the workflow runs properly.

After installation appears at the top right:
![[Pasted image 20260222030425.png]]

NOT anymore appears near run
![[Pasted image 20260222030444.png]]


---


It's super helpful especially with opening workflows from youtubers. It lets you install missing nodes from git URL (may be found on Youtube description or from Google search of the node name):
![[Pasted image 20260222031801.png]]

And it can install missing nodes automatically:
![[Pasted image 20260222031829.png]]

---

**How to install ComfyUI Manager**

Cd into the custom nodes directory then git clone the ComfyUI Manager:
```
git clone https://github.com/Comfy-Org/ComfyUI-Manager.git
```

Then make sure to install the python dependencies. Say you're still in the custom nodes folder, then run:
```
pip install -r ComfyUI-Manager/requirements.txt
```

Restart ComfyUI. You should find that it installed successfully

---

**Troubleshooting - Failed to install**

Here are some example failures:
![[Pasted image 20260222033024.png]]

![[Pasted image 20260222033116.png]]

For these types of errors, you can update ComfyUI Manager with a git pull then a pip install requirements. And you can update ComfyUI app the same way.

At the comfyui root folder (where the python app is at):
```
git pull
pip install -r requirements.txt
```

---

After successful installation of any nodes (such as the ComfyUI Manager) you might want to press R to reload node definitions inside ComfyUI
![[Pasted image 20260222025342.png]]

Remember that this custom node doesn't appear as a node on the graph. It appears as an extension of the options - Look for "Manager" at the top right:
![[Pasted image 20260222030425.png]]
