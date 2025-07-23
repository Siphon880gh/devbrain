
## What are checkpoints

**In AI, a checkpoint refers to a saved snapshot of a machine learning model during training.** It typically includes the model’s parameters (weights and biases), and often the state of the optimizer. Checkpoints allow training to be resumed from that point if interrupted, and they provide a way to evaluate performance or revert to a previous state.

They are essential for:

- **Fault recovery** – so training can continue after crashes or hardware issues.
- **Experimentation** – enabling comparisons between different stages of training.
- **Fine-tuning** – allowing developers to adjust or adapt a model starting from a partially trained version rather than from scratch.

## Sharing of checkpoints

**The AI engineering and research community frequently shares model checkpoints**, and it's a major part of how progress in machine learning is accelerated.

### Why Checkpoints Are Shared:

- **Transfer learning**: Others can fine-tune the model on new data without retraining from scratch.
    
- **Reproducibility**: Researchers can verify and build on published results.
    
- **Community collaboration**: Developers can explore variations, fix issues, or extend capabilities.
    

### Where Checkpoints Are Shared:

- **Hugging Face 🤗 Hub** – Most popular repository for NLP, vision, and general-purpose models.
    
- **GitHub + Google Drive/Dropbox** – Often used in academic papers.
    
- **Model zoos** (framework-specific):
    
    - PyTorch Hub
        
    - TensorFlow Hub
        
    - OpenMMLab, Detectron2 Model Zoo, etc.
        
- **Papers with Code** – Links to checkpoints alongside research papers.
    

### Examples:

- OpenAI’s CLIP and Whisper models
    
- Meta’s LLaMA (though under research license)
    
- Stability AI’s Stable Diffusion checkpoints
    
- Google’s BERT or T5 models
    
- Many community-trained LoRAs and fine-tunes
    

### Licensing Caveats:

Not all checkpoints are open-source. Many have **research-only** or **non-commercial** restrictions, so usage terms vary.

---

## Sharing of checkpoints in ComfyUI

Many workflows depend on the successful training up to a certain point to produce the quality of output that's acceptable. So many workflows require you to download and then load specific checkpoints.