The solution is to update torch per
[https://github.com/huggingface/transformers/issues/32185](https://github.com/huggingface/transformers/issues/32185)

Torch needs to be 2.2.0

That means two approaches
Either you change the container type to something that has the same library and torch version, which takes some research (asking ChatGPT produced a bad result as of 2/2025) - furthermore you can't update the container of an already failed Inference Endpoint (you have to start over creating a new Inference Endpoint):
![[Pasted image 20250219184418.png]]

**Or** you edit/create requirements.txt on a forked copy of the repo

This document covers the latter (forked copy)

----

See if there's a requirements.txt in the "Files and versions" that need to be modified. If not, you will be creating that requirements.txt. You will either request a PR but you likely will prefer to fork the code, then change the requirements.txt on your own repo.

Refer to how to duplicate a repo: [[HuggingFace - Duplicate Repo]]

Let's say I am user Siphon880hf, then I can go edit the requirements.txt:
![[Pasted image 20250219184143.png]]

Then I changed `torch==2.0.0` --> to `torch=2.2.0`

Then I re-attempt launching HF Inference Endpoint if the option is available. If the option disappeared, go to the next section
![[Pasted image 20250219184624.png]]

---

**Missing deploy / use this model / Inference Endpoint option**

Options missing?
![[Pasted image 20250219185318.png]]

The culprit is the duplicator missing some important information when duplicating over. You'll need to add the library tag.

Under Model card tab, click "Edit model card", which shows YAML above the Readme.md. That YAML is the model card where you will place the library tag:
![[Pasted image 20250219185006.png]]

You may have to do research on the original repo to figure out what the values will be. For instance, you may open the Transformers code (Use this model -> Transformers). In our case here, we need to insert at the root level of the YAML:
```
library_name: transformers
pipeline_tag: font-identifier
```

So the fixed YAML / card could look like:
```
---
license: mit
base_model: microsoft/resnet-18
tags:
- generated_from_trainer
datasets:
- gaborcselle/font-examples
metrics:
- accuracy
model-index:
- name: font-identifier
  results:
  - task:
      name: Image Classification
      type: image-classification
    dataset:
      name: imagefolder
      type: imagefolder
      config: default
      split: test
      args: default
    metrics:
    - name: Accuracy
      type: accuracy
      value: 0.963265306122449
library_name: transformers
pipeline_tag: font-identifier
widget:
- src: hf_samples/ArchitectsDaughter-Regular_1.png
  example_title: Architects Daughter
- src: main/hf_samples/Courier_28.png
  example_title: Courier
- src: main/hf_samples/Helvetica_3.png
  example_title: Helvetica
- src: hf_samples/IBMPlexSans-Regular_25.png
  example_title: IBM Plex Sans
- src: hf_samples/Inter-Regular_43.png
  example_title: Inter
- src: hf_samples/Lobster-Regular_25.png
  example_title: Lobster
- src: hf_samples/Trebuchet_MS_11.png
  example_title: Trebuchet MS
- src: hf_samples/Verdana_Bold_43.png
  example_title: Verdana Bold
language:
- en
---

Rest of Readme...
```

It's recommended you edit the Readme to provide context about your forking, eg.:
```
# Forked

This is forked by Weng from gaborcselle/font-identifier because of failed Inference Endpoint deployment due to `module torch has no attribute 'float8_e4m3fn' error. I had to fork so I could edit requirements.txt to update torch to 2.2.0 which fixed the issue. Doesn't look like an active repo so I did not request PR.
- Weng Fei Fung.
```