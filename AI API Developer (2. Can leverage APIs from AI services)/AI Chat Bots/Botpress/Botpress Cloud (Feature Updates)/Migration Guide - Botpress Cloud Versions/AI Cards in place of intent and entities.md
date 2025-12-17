
**Library tab is deprecated as of 2025:**

The Library tab is deprecated. Only bots that have already created intents and entities will be able to use it. Be sure to migrate your NLU items before 4/2025.

These were managed in the Library tab, but that’s being phased out:
- NLU (Natural Language Understanding) helps your bot understand what users mean
- Intent = What the user wants
    - Example: “I want to book a hotel” → Intent: `book_hotel`
- Entity = Key details
    - Example: “in Paris for next weekend” → Entities:
        - `city = Paris`
        - `date = next weekend`

---

### ⚠️ Don’t Confuse This with Intents in AI Prompts

This is **not** the same as talking about "intents" in your AI prompt at the **Autonomous Node** (if you prompt the AI using intents). That still works — because that part uses **ChatGPT**.

The deprecated **intents** refer to a feature in the **Botpress Cloud interface**, which was part of the old system for detecting user intent — it’s a different thing entirely.