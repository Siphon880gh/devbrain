Note: Screenshots are from these two videos https://www.youtube.com/watch?v=EiThSVZ8pME and https://www.youtube.com/watch?v=LDn7rQKIFro

Claude Mods were released on October 1, 2026

---

## Add panes, commands, and tool call rules to Claude Code OR Claude CLI with a mod

The following screenshots show what's possible:

![[Pasted image 20261005190414.png]]

![[Pasted image 20261005190524.png]]

It's installed via plugins.

---

Under the hood how it works is:
It hooks listening for events right before displaying to the terminal or app, then it changes or handles it before reaching to the terminal or app.
![[Pasted image 20261005190601.png]]

---

## Common Use Case - Hiding Technical Details

For non-developers that are vibe coding, an use case for mod is to hide any technical lines:

![[Pasted image 20261005190814.png]]

![[Pasted image 20261005190809.png]]

---

## Common Use Case - Higgsfield Token Verification Before Generating

Using Higgsfield MCP with Claude, you can create a mod that warns you how many credits are going to be used up versus how many credits you have - before proceeding to consuming those tokens to generate the image/video:

![[Pasted image 20261005191021.png]]

---

## Tips
### Creating and customizing Mods

1. **Describe the Mod you want.** Claude’s built-in `plugin-authoring` skill can write the code, install it in your session, and help test it. You can invoke the skill explicitly with `/plugin-authoring`.

2. **You don’t need to know TypeScript.** For example, ask: “Make a Mod that displays the current Git branch above the prompt.” Claude can generate the necessary files and configuration.

3. **Check whether you need a Mod first.** An existing setting, Skill, standard hook, status line, or MCP server may be simpler. Mods are especially useful for custom interface elements or for intercepting Claude Code behavior.

4. **Intercept tool calls.** A Mod can inspect a tool call before it executes, change its arguments, block it, or request confirmation. Anthropic’s Blast Radius Mod demonstrates this for potentially destructive commands.

5. **Customize the interface.** Mods can add side panels, buttons, input fields, and indicators above the prompt. They can also change existing elements, such as a spinner or tool result.

6. **React to events automatically.** A Mod can respond when you submit a prompt, a tool runs, a turn finishes, or a UI component renders. You don’t have to invoke it each time.

7. **Iterate by talking to Claude.** Once a Mod exists, ask for changes such as “Only show this indicator when context usage exceeds 60%” or “Move the display above the prompt.” Claude can edit the existing Mod.

8. **Use hot reloading during development.** With your approval, Mods changed during a session can reload without restarting Claude Code.

9. **Preserve Mods you want to reuse.** Claude-created development Mods initially belong to one session and are stored under `~/.claude/dev-mods//`. To use one in other sessions, copy it to a permanent directory and load or package it as a plugin.

10. **Share Mods as plugins.** You can put a Mod in a GitHub repository, publish it through a marketplace, or install it through Claude Code’s ordinary plugin workflow.

### Testing, safety, and compatibility

1. **Validate and test each Mod.** Run `claude plugin validate ` to check its configuration and recognized hooks, then `claude plugin test ` to run automated tests. Tests must be written; a Mod loading successfully does not prove every event works.

2. **Ask Claude to debug it.** Try: “Validate this Mod, write tests for its hooks, cover failure cases, and fix any errors.” If the UI fails to render, Claude can inspect the debug log with `claude --debug`.

3. **Use the API definitions from your installed version.** Claude Code generates TypeScript declarations in `.claude-plugin/types/`. These are preferable to examples written for earlier versions because the Mods API can change.

4. **Keep Mods narrowly focused.** Intercept only the events needed for the feature, and leave unrelated operations unchanged.

5. **Don’t rely on a Mod as your only security protection.** A safety Mod may miss commands hidden behind scripts, aliases, or shell substitutions. Use built-in permission rules for critical restrictions. Third-party Mods also run with your user permissions and may access files, secrets, and processes.

6. **Check shortcut support.** Mods can attach hotkeys to buttons in their UI, but a custom global shortcut is not automatically possible. Global bindings depend on supported keybinding actions and UI behavior.

7. **Know where custom interfaces appear.** Mod panels and visual elements work in Claude Code’s terminal interface and supported Claude Desktop Code sessions. Mod hooks can run in the VS Code extension chat panel, but custom Mod UI does not render there.

8. **Check your version.** Terminal Mods require Claude Code 2.1.287 or newer; run `claude --version`. Desktop Mod support begins with the bundled Claude Code version 2.1.286.

