Aka Get Started

## Get Ollama

Sign up for account. Is free:
https://ollama.com/

Download Ollama here:
[https://ollama.com/download](https://ollama.com/download)  

It will install both background service (so ollama service is available to help run your AI Engineering tasks) and the CLI command tool (so you can run ollama commands)

- Background task. On Mac, you see at the status menu:
  ![[Pasted image 20250207030225.png]]
- CLI command:
  ![[Pasted image 20250207030352.png]]

---

## Quick orientation how to use

When you run a model that isn't on your computer, it'll start downloading it first, which could take a while because usually models are many gigabytes. 
```
ollama run mistral
```

You can pull models to download ahead of time. Then next time, running the model will run instantly.
```
ollama pull mistral
```

---

## Test works

Mistral and Llama are many gigabytes large, so they're not good models to test with right away because you'll be waiting a bit. We'll test with a much smaller model.

We go on HuggingFace.co to find a model that's a few hundred megabytes large and a GGUF type model (Ollama is compatible with GGUF models). At HuggingFace.co, we search for the terms ".3B" (because the less billion parameters, the smaller the file size) and "GGUF". We found one already for this tutorial so continue reading.

Test with a Hugging Face model that's only a few hundred megabytes large:
```
ollama run hf.co/QuantFactory/Lite-Oute-1-300M-Instruct-GGUF
```

Ask it a question like:
```
How tall is Mt Everest?
```

Response will be:
![[Pasted image 20250207034632.png]]

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


---

## How a successful model run looks

Here we ran a virtual girlfriend and we can ask questions, and it responds:

![[Pasted image 20250207035533.png]]

![[Pasted image 20250207035700.png]]

---

## Long term use

You can quickly see what's available to run on your computer (all pulled or ran):
```
ollama list
```