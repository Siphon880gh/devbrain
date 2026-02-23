
Enable ComfyUI Developer Mode or API Save by going to Icon -> Settings -> Comfy -> Dev Mode
![[Pasted image 20260222030559.png]]

Export a workflow as an API Workflow json file:
![[Pasted image 20260223010228.png]]

This workflow json file will be much smaller than a normal workflow json file (that you can import in). The API workflow json file will be submitted to a ComfyUI API server to create the workflow  and run it immediately. Hot tip - Name your workflow as an API Workflow especially if you have a lot of json files.

---

Let's say you export the API workflow from:
You can simplify the workflow so it's easier to follow along:
![[Pasted image 20260223001526.png]]

The exported API JSON file could look like:
```
{
  "3": {
    "inputs": {
      "seed": 769579582383980,
      "steps": 20,
      "cfg": 8,
      "sampler_name": "euler",
      "scheduler": "normal",
      "denoise": 1,
      "model": [
        "4",
        0
      ],
      "positive": [
        "6",
        0
      ],
      "negative": [
        "7",
        0
      ],
      "latent_image": [
        "5",
        0
      ]
    },
    "class_type": "KSampler",
    "_meta": {
      "title": "KSampler"
    }
  },
  "4": {
    "inputs": {
      "ckpt_name": "v1-5-pruned-emaonly-fp16.safetensors"
    },
    "class_type": "CheckpointLoaderSimple",
    "_meta": {
      "title": "Load Checkpoint"
    }
  },
  "5": {
    "inputs": {
      "width": 512,
      "height": 512,
      "batch_size": 1
    },
    "class_type": "EmptyLatentImage",
    "_meta": {
      "title": "Empty Latent Image"
    }
  },
  "6": {
    "inputs": {
      "text": "beautiful scenery nature glass bottle landscape, , purple galaxy bottle,",
      "clip": [
        "4",
        1
      ]
    },
    "class_type": "CLIPTextEncode",
    "_meta": {
      "title": "CLIP Text Encode (Prompt)"
    }
  },
  "7": {
    "inputs": {
      "text": "text, watermark",
      "clip": [
        "4",
        1
      ]
    },
    "class_type": "CLIPTextEncode",
    "_meta": {
      "title": "CLIP Text Encode (Prompt)"
    }
  },
  "8": {
    "inputs": {
      "samples": [
        "3",
        0
      ],
      "vae": [
        "4",
        2
      ]
    },
    "class_type": "VAEDecode",
    "_meta": {
      "title": "VAE Decode"
    }
  },
  "9": {
    "inputs": {
      "filename_prefix": "ComfyUI",
      "images": [
        "8",
        0
      ]
    },
    "class_type": "SaveImage",
    "_meta": {
      "title": "Save Image"
    }
  }
}
```

Notice in the screenshot, the workflow has generated an image. That would be discarded in the API workflow export because it's not necessary.

Notice the text prompt is part of the JSON, so in practice when submitting an API workflow JSON to the API server, that JSON has built in the text prompt already. Therefore you likely programmatically have to do some text manipulation to build out the final API workflow json.

For example, in python, you submit to the API server:
- POST /prompt
```
import requests
import json

with open("workflow.json", "r") as f:
    prompt = json.load(f)

res = requests.post(
    "http://127.0.0.1:8188/prompt",
    json={"prompt": prompt}
)

print(res.json())
```

And you get back a `{prompt_id: "abc123}` and the asset is created and saved to ComfyUI/output path

You typically find out if the queued job is done by looking for the new file or checking the history:
- GET /history/{prompt_id}
```
import time

pid = res.json()["prompt_id"]

while True:
    r = requests.get(f"http://127.0.0.1:8188/history/{pid}")
    data = r.json()
    if pid in data:
        print("Done!")
        break
    time.sleep(1)
```


---

# ComfyUI API Workflow Guide — How It Works, How to Use It, and What “Expires”

---

## ⚠️ Important Note Before You Start (Reliability Reality Check)

Your exported workflow JSON is **portable**, but it is **not guaranteed to run anywhere by default**.

For a workflow to run successfully on any ComfyUI server, that server must already have:

- the same **models** (same filenames)
    
- the same **custom nodes**
    
- the same **dependencies**
    

Most online servers **do NOT automatically install missing nodes or models at runtime**.  
That’s intentional for:

- security
    
- stability
    
- speed
    
- cost control
    

So think of it like:

> The workflow file is the recipe — but the kitchen still needs the same ingredients and tools.

If the server isn’t pre-configured to match your workflow, the job will fail.

---

# 1) What You Exported from ComfyUI (Conceptual Overview)

When you export **API format JSON**, you did **not** export an image.

You exported a **graph recipe** that tells a ComfyUI server:

> “Load this model → encode this prompt → sample → decode → save”

Your JSON is essentially:

```
graph instructions
+ parameters
+ node wiring
```

It is **not runnable by itself** — it must be sent to a ComfyUI server.

That server can be:

- local ComfyUI
    
- your own GPU server
    
- a cloud ComfyUI provider
    
- a serverless ComfyUI API
    

Think of it like:

|File Type|Analogy|
|---|---|
|workflow.json|Photoshop PSD instructions|
|image output|exported PNG|

---

# 2) How the Execution Pipeline Works

High level pipeline:

```
You → send JSON → ComfyUI server → queue job → execute graph → save result
```

Your exported JSON is what the frontend normally sends internally when you click **Queue Prompt** in the UI.

You’re just doing it manually now.

---

# 3) Running Your Workflow via API

Start ComfyUI:

```bash
python main.py
```

Default server:

```
http://127.0.0.1:8188
```

Send workflow:

```python
import requests, json

prompt = json.load(open("workflow.json"))

res = requests.post(
    "http://127.0.0.1:8188/prompt",
    json={"prompt": prompt}
)

print(res.json())
```

Response:

```json
{ "prompt_id": "abc123" }
```

That means the job is queued.

---

## Wait for completion

```python
import time

pid = res.json()["prompt_id"]

while True:
    r = requests.get(f"http://127.0.0.1:8188/history/{pid}")
    data = r.json()
    if pid in data:
        break
    time.sleep(1)
```

---

## Where output goes

Because your workflow contains a **SaveImage node**, results save automatically to:

```
ComfyUI/output/
```

---

# 4) What Each Node in Your Workflow Does

Your graph is equivalent to:

```
CheckpointLoader
        ↓
Prompt encode
        ↓
Empty latent image
        ↓
Sampler
        ↓
VAE decode
        ↓
Save image
```

Key nodes:

|Node|Role|
|---|---|
|4|loads model|
|6|positive prompt|
|7|negative prompt|
|3|sampler|
|8|decode|
|9|save image|

---

# 5) How Prompting Works in API Mode

You **don’t regenerate JSON each time.**

You keep a template and only modify fields:

```python
prompt["6"]["inputs"]["text"] = "a dragon made of fire"
prompt["3"]["inputs"]["seed"] = 12345
```

That’s how production AI image APIs work.

---

# 6) Can You Send This JSON to Any ComfyUI Cloud?

**Usually yes — but only if 3 requirements match**

### Requirement 1 — Platform supports API workflows

Some platforms accept raw workflow JSON. Others require you to deploy it first.

---

### Requirement 2 — Same models must exist

Your JSON references:

```
v1-5-pruned-emaonly-fp16.safetensors
```

If the server doesn’t have that file:

→ generation fails.

---

### Requirement 3 — Same custom nodes installed

If your graph used custom nodes, the remote server must also have them installed.

---

# 7) What “Expires” vs What Doesn’t

This is where most people get confused.

---

## Your exported workflow JSON

**Never expires.**

It’s just a file.

---

## A job (`prompt_id`)

Depends on server:

|Server Type|Expiration|
|---|---|
|Local|none|
|Self-hosted|none|
|Cloud|platform dependent|

---

## Generated images

Depends on provider storage policy.

Typical behavior:

|Platform Type|Storage|
|---|---|
|Local|permanent|
|Cloud|temporary|
|Serverless|temporary|

Important distinction:

```
file expiration ≠ link expiration
```

Often:

- file still exists
    
- download link expired
    

---

# 8) Production Architecture Pattern

Real SaaS image generators use this architecture:

```
base_workflow.json
        ↓
server receives request
        ↓
edit prompt fields
        ↓
send to ComfyUI
        ↓
store result
        ↓
return URL
```

They do **NOT** rebuild workflows per request.

---

# 9) Why ComfyUI Uses This Graph JSON Format

Because it supports things linear pipelines can’t:

- branching flows
    
- multiple outputs
    
- video pipelines
    
- ControlNet stacks
    
- LoRAs
    
- conditioning merges
    
- multi-model graphs
    

This makes it much closer to:

```
node execution engine
```

than a simple “generate image” API.

---

# 10) Mental Model (Most Important Section)

Understand this and everything clicks:

```
Workflow JSON = recipe
Prompt text = ingredient
Server = kitchen
Output = dish
```

You can:

- reuse recipe
    
- change ingredients
    
- run in any kitchen
    

as long as the kitchen has the same tools.

---

# 11) Where You Are in the Skill Stack

Exporting API JSON means you’ve moved beyond beginner ComfyUI usage.

You’re now at:

```
Automation / Integration Level
```

This is the level people use when they’re:

- building AI SaaS
    
- creating generation APIs
    
- running batch pipelines
    
- building internal tools
    
- scaling image/video generation
    

---

# 12) What You Can Build From Here

With your workflow you can easily build:

- image generation REST API
    
- Discord bot generator
    
- batch generator
    
- SaaS product
    
- internal automation pipeline
    
- prompt marketplace
    
- content generation system
    

---

# Final Summary

**Your exported JSON is a portable execution graph.**

It:

✔ defines the workflow  
✔ can be reused infinitely  
✔ works locally or in cloud  
✔ can be edited dynamically

It does **NOT expire.**

Only these expire:
- jobs
- storage
- download links  
    (depending on platform)
