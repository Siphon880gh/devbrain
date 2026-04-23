Making Ollama models available for multiple members on your team via a Tailscale network?

Unfortunately Ollama will 403 because it expects certain headers. What you can do is use LiteLLM as the router to Ollama and use LiteLLM's API endpoints for Tailscale network access to the models.