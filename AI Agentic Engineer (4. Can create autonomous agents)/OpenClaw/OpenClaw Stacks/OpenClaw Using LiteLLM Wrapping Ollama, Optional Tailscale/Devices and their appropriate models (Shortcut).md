
Refer to [[Devices and their appropriate models - config.yaml]]
which lets you choose the right models based on your device and available RAM. Then pull those models onto your machine using Ollama (You can use AI to read config.yaml and assure Ollama has these models). After that, set up LiteLLM to route requests to the Ollama models.

You can then expand Openclaw's models to include more litellm models — see [[Wire OpenClaw to LiteLLM provider - models.json and openclaw.json]].
