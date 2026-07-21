## OpenClaw Default Model: Choose a Model That Can Use Tools

The OpenClaw default model should be chosen for **tool-use reliability**, not just raw intelligence or low cost.

In an agent system, the model is not only writing text. It may need to read files, call tools, edit configs, create scripts, check logs, run commands, and interpret tool results.

That means the default model must understand:

```text
When to use a tool.
Which tool to use.
What arguments to pass.
What to do with the result.
```

## Example Models That Can Use Tools

Good candidates for OpenClaw-style agent workflows include:

- **Claude Sonnet** — probably the most common “serious agent worker” choice. Anthropic’s Claude Code GitHub Actions default to Sonnet, which is a strong signal that Sonnet is treated as the practical default for coding-agent workflows. Anthropic has also described Sonnet as strong for building complex agents and computer use. ([Claude](https://code.claude.com/docs/en/github-actions?utm_source=chatgpt.com "Claude Code GitHub Actions - Claude Code Docs"))
    
- **Claude Haiku** — better for cheaper, faster routine work when the task is simple and low-risk. Anthropic describes Haiku as its fastest and most cost-efficient model. ([Anthropic](https://www.anthropic.com/claude/haiku?utm_source=chatgpt.com "Claude Haiku 4.5"))
    
- **Claude Opus** — better for hard reasoning, complex debugging, planning, large refactors, and high-risk decisions. Anthropic describes Opus as its most capable generally available model for complex reasoning and agentic coding. ([Claude](https://platform.claude.com/docs/en/about-claude/models/choosing-a-model?utm_source=chatgpt.com "Choosing the right model - Claude API Docs"))
    
- **OpenAI GPT-5.5 / GPT-5.4+** — strong for tool-based agents, especially when using function calling, built-in tools, MCP servers, code execution, file search, or tool search. OpenAI’s docs describe function calling as a way for models to interface with external systems, and note that `gpt-5.4` and later support tool search. ([OpenAI Developers](https://developers.openai.com/api/docs/guides/function-calling "Function calling | OpenAI API"))
    
- **Gemini 2.5 Flash / Pro** — useful when you want Google’s ecosystem, function calling, and a price/performance split between routine and harder work. Google describes Gemini function calling as a way for the model to choose functions and provide parameters for real-world actions. ([Google AI for Developers](https://ai.google.dev/gemini-api/docs/function-calling?utm_source=chatgpt.com "Function calling with the Gemini API - Google AI for Developers"))
    
- **Gemma 4** — useful for local or open-weight-style routine workflows, especially when you want cheaper execution for simple summaries, health checks, briefs, and predictable tasks. Google’s Gemini API documentation lists supported Gemma 4 models such as `gemma-4-31b-it` and `gemma-4-26b-a4b-it`. ([Google AI for Developers](https://ai.google.dev/gemma/docs/core/gemma_on_gemini_api?utm_source=chatgpt.com "Run Gemma with the Gemini API | Google AI for Developers"))
    
- **FunctionGemma** — a specialized lightweight option for function calling, especially if you want to fine-tune a narrow local agent around a specific set of tools. Google describes FunctionGemma as a lightweight open model built for specialized function-calling models, not as a general direct dialogue model. ([Google AI for Developers](https://ai.google.dev/gemma/docs/functiongemma/model_card?utm_source=chatgpt.com "FunctionGemma model card | Google AI for Developers"))
    

## The Model Most People Reach For

For OpenClaw, the safest default recommendation is:

```text
Default model: Claude Sonnet
Routine model: Gemma 4, Gemini Flash, Claude Haiku, or FunctionGemma
Hard model: Claude Opus or GPT-5.5
```

Claude Sonnet is the practical agent-workhorse: not the cheapest, not always the smartest, but usually strong enough to read context, call tools, edit files, and complete multi-step workflows without constant supervision.

The key rule:

```text
Do not make the default model the cheapest model.
Make the default model the most reliable tool user.
```

## Case Study: Qwen2.5-Coder 7B

`qwen2.5-coder:7b-instruct` is a good example of why model routing matters.

It is strong for **coding-related OpenClaw tasks**. Qwen’s model card describes Qwen2.5-Coder as a code-specific model series with improvements in code generation, code reasoning, and code fixing. ([Hugging Face](https://huggingface.co/Qwen/Qwen2.5-Coder-7B-Instruct?utm_source=chatgpt.com "Qwen/Qwen2.5-Coder-7B-Instruct"))

That makes it useful for:

- editing code
    
- updating code files
    
- generating scripts
    
- fixing small bugs
    
- writing shell commands
    
- creating config examples
    
- summarizing code-related logs
    

But it is not automatically the best **broad default OpenClaw model**.

The reason is simple:

```text
Qwen2.5-Coder 7B is good for code-shaped tool use.
It is not necessarily the best for broad tool orchestration.
```

So if you mainly use OpenClaw for coding tasks, `qwen2.5-coder:7b-instruct` can make sense as a default or local worker model.

But if your OpenClaw setup includes many different kinds of tools — calendars, CRMs, email, monitoring systems, file systems, shell commands, web tasks, browser tools, business workflows, approvals, and API actions — then Claude Sonnet is usually the safer default.

A practical routing setup:

```text
Routine code/file/script tasks → qwen2.5-coder:7b-instruct
General agent workflows → Claude Sonnet
Simple routine briefs/checks → Gemma 4 / Gemini Flash / Haiku
Complex debugging or risky decisions → Claude Opus / GPT-5.5
```

## Where to Set the OpenClaw Default Model

You can set the default model in:

```bash
vi ~/.openclaw/openclaw.json
```

Partial example:

```json
{
  "agents": {
    "defaults": {
      "model": {
        "primary": "ollama/qwen2.5-coder:7b-instruct"
      },
      "workspace": "/Users/wengffung/.openclaw/workspace"
    },
    "list": [
      {
        "id": "main"
      },
      {
        "id": "project-a",
        "name": "project-a",
        "workspace": "/Users/wengffung/.openclaw/workspace/project-a",
        "agentDir": "/Users/wengffung/.openclaw/agents/project-a/agent"
      },
      {
        "id": "project-b",
        "name": "project-b",
        "workspace": "/Users/wengffung/.openclaw/workspace/project-b",
        "agentDir": "/Users/wengffung/.openclaw/agents/project-b/agent"
      }
    ]
  },
  "auth": {
    "profiles": {
      "ollama:default": {
        "mode": "api_key",
        "provider": "ollama"
      }
    }
  }
}
```

That makes `qwen2.5-coder:7b-instruct` the primary default model for agents using the shared defaults.

The final takeaway:

```text
Use Qwen2.5-Coder 7B if OpenClaw is mostly coding.
Use Sonnet if OpenClaw is operating many different tools.
Use Opus or GPT-5.5 when the task is hard, risky, or strategic.
```

OpenClaw should not be one model for everything. It should be a routing system: cheap models for routine tasks, coding models for code-shaped work, and stronger agent models for broad tool use.