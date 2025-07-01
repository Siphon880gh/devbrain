For example, you see a similar screen to this when running a workflow:
![[Pasted image 20250616022507.png]]

Paste the screenshot into ChatGPT and ask it for help on how to fix ComfyUI not running the workflow because of this error.

If you had opened to http://127.0.0.1:8000/ which you find from the terminal ([[ComfyUI - _Best Practice - Open Terminal]])
![[Pasted image 20250617030226.png]]

Then you see it renders without that popup as an error
![[Pasted image 20250617030305.png]]

Although there's no popup error, in actuality, the errors show up on the web app's terminal.
- How to open the terminal at the web app? Same instructions at ([[ComfyUI - _Best Practice - Open Terminal]]) except you click the terminal icon in the web browser rather than the ComfyUI app.
![[Pasted image 20250617030516.png]]

Notice the same errors reading at the top of the terminal.

---

Let's revisit the errors and see where the files may correlate on your system

![[Pasted image 20250616022507.png]]

Actually, when you launch the ComfyUI App, you see their own app terminal listing you the directories of interest:
![[Pasted image 20250617030715.png]]

Every computer is different but it looks like for me, most the ComfyUI files are regarding Documents/ComfyUI and /Applications/ComfyUI.app/Contents.

To access the /Applications contents, you right click the ComfyUI and "Show Package":
![[Pasted image 20250617030848.png]]

The error `"CheckpointLoaderSimple: Value not in list: ckpt_name: 'dreamshaper_8.safetensors' not in ['v1-5-pruned-emaonly-fp16.safetensors']."` correlates to my file `/Users/wengffung/Documents/ComfyUI/models/checkpoints/v1-5-pruned-emaonly-fp16.safetensors`

Also helpful in the in-app terminal (not the startup terminal):
![[Pasted image 20250617031650.png]]

That tells you JSON files that are loaded in, like:
https://raw.githubusercontent.com/ltdrdata/ComfyUI-Manager/main/alter-list.json

And for the repo's browsable URL, you change the URL into this format:
https://github.com/ltdrdata/ComfyUI-Manager/

Paste your error (either the error popup or the error text in the terminal) into ChatGPT for help:
![[Pasted image 20250617031937.png]]

It will suggest directories to look into, what files to rename, and what files to manually download online and place into paths. Tell ChatGPT your directories by also pasting your ComfyUI startup terminal that outputted all your pertinent paths. ChatGPT likely will get the paths incorrectly if you skip this step.