# Launch OpenClaw TUI with an Ollama Model

Use this flow to launch OpenClaw TUI with a local Ollama model.

```bash
ollama list
ollama pull qwen2.5-coder: 7b-instruct ollama launch openclaw --model|
```

This opens the TUI, and you can start prompting immediately.

TUI after launch:
![[019dee03-45ab-7255-8121-22210e889305.png]]

You can also switch models inside TUI with `/model`. In some cases, restarting TUI helps apply the change cleanly.
