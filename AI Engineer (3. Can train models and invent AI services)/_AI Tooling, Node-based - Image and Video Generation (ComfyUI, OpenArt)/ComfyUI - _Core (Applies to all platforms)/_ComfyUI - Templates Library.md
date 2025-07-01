Browse templates:
![[Pasted image 20250615075426.png]]

There are a lot. Actually notice there's a horizontal scrollbar:
![[Pasted image 20250615075800.png]]

----


Right-click empty part of the canvas -> Node Templates -> Manage:
![[Pasted image 20250615075635.png]]

Select Import:
![[Pasted image 20250615075658.png]]

Select your workflow JSON file from computer storage.

---

Previous method of clicking Import didn't work on a JSON file you downloaded online? Try dragging the JSON file into a blank canvas!


---

People share their workflows (which are flowchart of nodes). They can be referred to as workflows, templates, or JSON.

You should always vet if a template is worth downloading. A template with such low stars is probably not worth checking out:
![[Pasted image 20250615081322.png]]

The workflow can be very permissible what it outputs (letting you prompt it) or it can be a very niche generator.

Here's a niche generator: One click to generate Ultraman funny type pictures
[https://openart.ai/workflows/yangbaiwan/one-click-to-generate-ultraman-funny-type-pictures/X9Hkj8tFheaaP8yXbmCE](https://openart.ai/workflows/yangbaiwan/one-click-to-generate-ultraman-funny-type-pictures/X9Hkj8tFheaaP8yXbmCE)  


---

**⚠️ Big Caveat About Using OpenArt Templates in ComfyUI**

Many OpenArt AI workflow templates are **not designed for ComfyUI**. Remember:

* **OpenArt** is an *online platform*.
* **ComfyUI** is a *local application*.

While you *can* drag and drop a `.json` workflow file from OpenArt’s template library into ComfyUI, you’ll likely run into **missing node errors**. Some nodes can be found and installed, but others aren’t available to be found at all.

> **Bottom line:** If you're using ComfyUI, it’s best to avoid OpenArt templates unless you're ready to manually patch or rebuild the workflow—or just use them **directly on OpenArt** instead.


---

Galleries:
[https://comfyworkflows.com/](https://comfyworkflows.com/)  

  
There are a lot of low quality random beginner's produced templates. For high quality templates, look into the featured creators:
https://comfyworkflows.com/creators

And try to avoid old workflows (like 2 years or older) because likely they will have outdated nodes.

You can quickly import in a template by downloading the JSON then drag and dropping into ComfyUI. However, there could be missing nodes - it might prompt you to install them. And then there may be missing nodes that can't be found that will prevent the workflow from running.

You could choose export instead which is more likely to be error-free:
![[Pasted image 20250615084655.png]]

However it's a little involved. Usually involves setting up a server locally then connecting to it from Comfy UI. However, it has an automatic resolver for missing nodes and dependencies:
![[Pasted image 20250615084844.png]]
