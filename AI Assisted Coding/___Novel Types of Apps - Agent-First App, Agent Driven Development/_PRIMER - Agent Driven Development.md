Summarized from [“Prototyping for Agent-First Apps”](https://dev.to/fl4tlin3/prototyping-for-agent-first-apps-54j7).
Note their definition of Agent-First is completely different from [[_PRIMER - Agent-First Apps - Two Modes of Use]], so I am renaming it to Agent Driven Development, which aligns with TDD and BDD industry practices.

---

Perstack is a toolkit for building and testing AI agents before developing the surrounding application. You can begin with a broad description of the app or workflow you want to create. Perstack’s `create-expert` CLI then generates a working agent that you can run and interact with from the command line.

As you test the agent, the intended user flow becomes clearer. You can iteratively improve it by:

- Describing new behaviors or changes in plain language.
    
- Testing it with realistic scenarios and sample inputs.
    
- Identifying where its instructions or tools fail.
    
- Reviewing execution logs, tool calls, and errors.
    
- Refining the agent until its behavior becomes reliable.
    
- Letting other users test the CLI experience before investing in a graphical interface.
    

This process keeps the agent’s logic separate from the application interface. It allows you to validate what the product should do before committing time to building the full app.

Once the CLI experience is working well, ask an AI coding agent to examine the Perstack project and turn it into a web application. The coding agent should determine:

- Which tasks require AI reasoning.
    
- Which operations can be handled with deterministic code.
    
- Which actions should be exposed through conventional interface controls.
    
- Where users should interact conversationally with the agent.

The resulting web interface should present the workflow in a natural, user-friendly way while preserving the tested agent behavior. Build the web application inside an `app/` directory and give it its own `.env.example` documenting all required environment variables.

Here's a prompt to take the perstack project and turn it into a web app for non-cli users:

Prompt:
```
Use the Perstack project in this repository as the behavioral specification for a production-ready web application.

First, inspect the entire Perstack implementation, including:
- `perstack.toml`
- Expert definitions and instructions
- Available tools and integrations
- Test cases and sample inputs
- Execution logs or checkpoints, if available
- Environment variables and external services
    
Determine the intended workflow and identify:
1. Which steps require AI reasoning or generation.
2. Which steps should use deterministic application code.
3. Which actions should be represented by forms, buttons, menus, tables, or other standard UI components.
4. Which interactions benefit from a conversational interface.
5. What information and state must persist between sessions.

Then build the web application inside a new `app/` directory.

Requirements:
- Preserve the behavior and capabilities established by the Perstack prototype.
- Design a natural graphical workflow rather than merely placing the CLI inside a browser.
- Use deterministic code for validation, calculations, navigation, state management, and other predictable operations.
- Use the Perstack Expert only where AI reasoning, interpretation, or generation is genuinely needed.
- Provide clear loading, progress, success, empty, and error states.
- Keep API keys and sensitive operations on the server.
- Create `app/.env.example` containing every required environment variable, using placeholder values only.
- Add an `app/README.md` with installation, configuration, development, testing, and production build instructions.
- Include appropriate tests for the main user flow and deterministic business logic.
- Do not remove or rewrite the original Perstack prototype unless integration requires a clearly justified change.

Before implementing, provide a short plan that explains:
- The workflow you inferred from the Perstack project.
- The proposed screens and user journey.
- The boundary between AI-powered and deterministic behavior.
- The selected architecture and technology stack.

After presenting the plan, proceed with the implementation. Make reasonable decisions independently and ask questions when a missing requirement would substantially change the product.
```