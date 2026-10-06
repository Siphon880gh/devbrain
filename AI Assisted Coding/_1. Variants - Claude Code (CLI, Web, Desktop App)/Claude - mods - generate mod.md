## Reusable prompt

> I want a Claude Code Mod that [describe behavior]. Before building it, check whether an existing setting, Skill, hook, or plugin already accomplishes this. If a Mod is appropriate, use the built-in `plugin-authoring` skill to create the smallest implementation. Use the API declarations from my installed Claude Code version. Validate the Mod, write and run automated tests covering normal and failure conditions, and enable hot reload with my approval. Explain what events the Mod intercepts, what permissions it needs, and how to keep it available across sessions.

You can ask Claude to build and refine a Mod without learning the API. Validate and test it, and preserve it explicitly if you want to use it across sessions.