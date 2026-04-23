Let's walk through a hypothetical case of the model mot being accurate. Here's a clue how to fix this:
- If you can adjust:
    - `temperature`: Lower values (0.2–0.5) make responses more focused.
    - `top_p`: Adjusting this can make responses more relevant. Refer to [[Ollama top_p]]
- In **Ollama**, the there is no max tokens parameters as an option like `temperature` or `top_p`. Ollama dynamically manages token limits based on the model's context size.
- There is no way to run parameters on the command line as of 2/2025


Create `Modelfile`:
```
FROM hf.co/QuantFactory/Lite-Oute-1-300M-Instruct-GGUF

PARAMETER temperature 0
PARAMETER top_p 0.9
```

Then create a model you can run from the Modefile:
```
ollama create my-model -f Modelfile
```

Then you can run `ollama run my-model` (And you can later delete with `ollama rm my-model`, and show all runnable models with `ollama list`)

