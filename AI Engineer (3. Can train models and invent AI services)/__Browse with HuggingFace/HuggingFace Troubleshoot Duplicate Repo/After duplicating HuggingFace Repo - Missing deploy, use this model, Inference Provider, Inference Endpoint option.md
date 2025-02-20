
**After duplicating HuggingFace Repo - Missing deploy / use this model / Inference Provider / Inference Endpoint option**

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

