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

Some models and nodes are not detected by the automatic installation. You'd have to install manually. There are a few methods to install manually and it depends if it's ONE FILE or a FOLDER of files that you have to download:

- File type
	- Model checkpoints one file you download like a .safetensors file
	- ComfyUI Manager (yes it's a node, despite not something you add to the graph, but it becomes another option) is an entire folder. You typically install via Github or git clone (and run pip install)

- Download file to the appropriate custom_nodes or models/* folder
- Download folder or git clone the folder to the appropriate folder and then run pip install requirements if necessary (if there's a requirements.txt file). Even easier, grab the Github repo link then use ComfyUI Manager's "Install via Git URL"

 - For a file, to download a specific file that's inside a git repo or a huggingface repo, search for `site:github.com OR site:huggingface.co "_model_or_node_filename_"`
![[Pasted image 20260222233350.png]]

- For a folder, to get the Github URL or to access Github to get the git clone command, you can look up google: `site:github.com "_model_or_node_name_"`. 
  ![[Pasted image 20260222233840.png]]
  ![[Pasted image 20260222031801.png]]

---

You are given the missing model/node filename in an error message. You might have a hard time copying the filename in the error depending on how ComfyUI presents it
		- You want to get the exact filename or name so you can google for it to download. 
		- You can't just copy and paste from a node field in the graph view. Here are ways to copy text values from nodes: [[ComfyUI - Copying text values from a node]]

---

Where to download into or git clone into? You want to be at the correct `models/___` or `custom_nodes/___` path. Some intermediate computer skills may be required.
- If on your own computer you need to know the ComfyUI app path, then the custom_nodes folder and models folder are there.
- You need to know the subfolder in the case of `models/_subfolder_/` or `custom_nodes/_subfolder_` that is the actual destination (you don't just clone/install/download into `models/` or `custom_nodes/`).
	- If you dont know what specific models subfolder or custom_nodes subfolder, you can ask ChatGPT:
	```
	Which Comfyui path to install this file: ____
	```

- If you are on your own computer, you can just browse to the folder and downloaded file there. 
- If you are git cloning (either locally or ssh or on a ComfyUI cloud platform), you want to cd into that folder before git cloning, so the destination can be `custom_nodes/__/_repo_name_`.
- If you are on a ComfyUI cloud platform like RunComfy, there's usually a terminal mode in the web app, and you can cd into the correct path, and then run the `wget` or `cURL` command with the URL to download the file into that path / or you run the git clone command there. 
	

- Do I need to run pip install requirements afterwards? If your final destination resulted in a new folder (not a new file), then check if it has a requirements.txt in it. If there's a requirements.txt, then make sure to pip install the requirements.txt, so that your python environment that ComfyUI depends on has access to the python packages needed to make the node run.

- After installing the missing nodes or models, restart ComfyUI. Press R to refresh node definitions