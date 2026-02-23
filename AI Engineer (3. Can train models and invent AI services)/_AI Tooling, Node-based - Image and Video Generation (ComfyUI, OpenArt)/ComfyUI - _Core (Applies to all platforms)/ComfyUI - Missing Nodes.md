Let's say you open a Workflow downloaded from a Youtuber:
![[Pasted image 20260222031930.png]]

Or you tried to install missing nodes automatically on the ComfyUI Manager:
![[Pasted image 20260222032013.png]]

Those are two ways ComfyUI could let you know nodes are missing

---

You can install missing nodes automatically:
![[Pasted image 20260222031829.png]]
![[Pasted image 20260222033648.png]]

![[Pasted image 20260222033657.png]]

---

Some models and nodes are not detected by the automatic installation. You'd have to install manually. 

- Download to the appropriate custom_nodes or models/* folder and run pip install requirements if necessary.
- You can install via Github with ComfyUI Manager. This is if there's a whole repo for it (instead of a file you have to download). To get the Github, you can look up google: `site:github.com "_model_or_node_name_"`. 
  ![[Pasted image 20260222233840.png]]
  ![[Pasted image 20260222031801.png]]

- But if the download is a specific file that's inside a git repo or a huggingface repo, search for `site:github.com OR site:huggingface.co "_model_or_node_filename_"` 
	- You are given the missing model/node filename in an error message. You might have a hard time copying the filename in the error depending on how ComfyUI presents it
		- You can either type as exact or if you prefer to copy and paste still, you can export: Icon -> File -> Export. Open the json file, and search partial value of the filename, then copy the entire value:
		  ![[Pasted image 20260222233024.png]]
		  ![[Pasted image 20260222234145.png]]
		  ![[Pasted image 20260222233350.png]]

	- Download and place into the `correct modes/*` or `custom_nodes/*` path. If you are on a cloud comfyui platform like RunComfy, there's a terminal mode, and you can cd into the correct path, and then run the `wget` command with the URL to download the file into that path. If you know the ComfyUI app path, then the models and custom_nodes folder is in there, however if you dont know what specific models subfolder or custom_nodes subfolder, you can ask ChatGPT:
	```
	Which Comfyui path to install this file: ____
	```
	- Do I need to run pip install requirements afterwards? Likely if it's an entire folder with a requirements.txt. Definitely not if it's just one file you're downloading.

After installing the missing nodes or models, restart ComfyUI. Press R to refresh node definitions