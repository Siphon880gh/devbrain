Run a model

Usage:
```
ollama run MODEL [PROMPT] [flags]
```

Flags:
      --dimensions int           Truncate output embeddings to specified dimension (embedding models only)
      --experimental             Enable experimental agent loop with tools
      --experimental-websearch   Enable web search tool in experimental mode
      --experimental-yolo        Skip all tool approval prompts (use with caution)
      --format string            Response format (e.g. json)
  -h, --help                     help for run
      --hidethinking             Hide thinking output (if provided)
      --insecure                 Use an insecure registry
      --keepalive string         Duration to keep a model loaded (e.g. 5m)
      --nowordwrap               Don't wrap words to the next line automatically
      --think string[="true"]    Enable thinking mode: true/false or high/medium/low for supported models
      --truncate                 For embedding models: truncate inputs exceeding context length (default: true). Set --truncate=false to error instead
      --verbose                  Show timings for response

Image Generation Flags (experimental):
      --width int      Image width
      --height int     Image height
      --steps int      Denoising steps
      --seed int       Random seed
      --negative str   Negative prompt

Environment Variables:
      OLLAMA_EDITOR              Path to editor for interactive prompt editing (Ctrl+G)
      OLLAMA_HOST                IP Address for the ollama server (default 127.0.0.1:11434)
      OLLAMA_NOHISTORY           Do not preserve readline history