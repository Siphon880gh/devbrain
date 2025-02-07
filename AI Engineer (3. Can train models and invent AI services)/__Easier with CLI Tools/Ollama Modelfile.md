
Using Modelfile to run GGUF model?
Ollama streamlined the process of running GGUF files without the need to create model files (Modelfile) in December 2024. This improvement allowed users to import GGUF models directly into Ollama using a simplified syntax in the Modelfile[1](https://www.restack.io/p/ollama-answer-locally-gguf-cat-ai). The update made it easier for users to leverage existing models efficiently without extensive modifications

---

However, Modelfile allows you to bring in another model as base, then add options of how random, etc:
```
FROM hf.co/mradermacher/YuisekinAI-mistral-0.3B-GGUF

PARAMETER temperature 0
PARAMETER top_p 0.9
```

Then create a model you can run from the Modefile:
```
ollama create my-model -f Modelfile
```

Then you can run `ollama run my-model` (And you can later delete with `ollama rm my-model`, and show all runnable models with `ollama list`)

It's still the base model, but you've set how random and accurate it is.