**Interactive CLI**: After you've listed the models, you can copy the model name exactly and run:
```
ollama run MODEL_NAME
```

For example `ollama run hf.co/QuantFactory/Lite-Oute-1-300M-Instruct-GGUF:latest` when `ollama list` displayed:
```
NAME                                                        ID              SIZE      MODIFIED      
hf.co/QuantFactory/Lite-Oute-1-300M-Instruct-GGUF:latest    61b5139d5e0a    175 MB    14 months ago    
ALIENTELLIGENCE/sarahv2:latest                              2613a0ac4447    4.7 GB    14 months ago   
```

Creates a chat interface:
![[Pasted image 20260422180357.png]]

---

**Pipe the message directly**?
```
ollama run deepseek-r1 "What's red and blue?"
```

---

**Thinking mode** ONLY if the model supports it:
```
ollama run deepseek-r1 --think
```

