
## 1. Why Codex CLI or Codex App Can Produce Robotic Writing

Codex CLI is an excellent tool for software development (or automation), but it can sometimes produce robotic or formulaic writing when generating content that users will read inside an application.

This is especially noticeable when generating large amounts of content, such as:
- Case studies and real-world scenarios
- Educational quizzes and explanations
- In-app tutorials and onboarding instructions
- Narratives and other user-facing text
- Database seed content

One possible explanation is that **Codex CLI is configured primarily as a coding agent**, with default instructions emphasizing concise, direct, and task-oriented communication.

According to [OpenAI's Codex base instructions](https://github.com/openai/codex/blob/main/codex-rs/protocol/src/prompts/base_instructions/default.md), its communication style is designed largely around software development tasks.

This approach works well for coding, debugging, and technical explanations, but it may also encourage repetitive sentence structures, overly concise explanations, and mechanical phrasing when generating educational or narrative content.

However, this doesn't mean Codex CLI is incapable of natural writing. Its output also depends on the model, prompts, context, and examples provided.

## 2. Is Codex App Better at Writing Than Codex CLI?

Not necessarily.

**Codex CLI and Codex App can use the same underlying AI models.** Selecting a highly capable model with maximum reasoning effort does not automatically guarantee more natural-sounding writing.

|Feature|Codex CLI|Codex App|
|---|---|---|
|Primary purpose|Coding through the terminal|Coding through a graphical interface|
|Underlying models|Can share models with Codex App|Can share models with CLI|
|Code generation|Excellent|Excellent|
|Natural-language generation|Capable, but may be influenced by coding-oriented instructions|Capable, but not inherently better|
|User-facing content generation|Requires appropriate prompting and guidance|Also benefits from appropriate prompting|
|Project instructions|Supports `AGENTS.md`|Supports `AGENTS.md`|

The distinction isn't necessarily which interface produces better writing, but **how the model is instructed and what context it receives**.

Both environments are designed around software development, so neither should automatically be treated as a dedicated content-writing tool.

## 3. Can You Instruct Codex CLI to Write More Naturally?

Yes. You can improve its writing by explicitly telling Codex to adopt a different style when generating user-facing application content.

For example:
> When generating text that users will read in the application, act as an experienced human writer and subject-matter expert, not just a software engineer.

This can help Codex distinguish between technical communication intended for developers and natural-language content intended for end users.

However, there's an important limitation: **your instructions can influence Codex's writing style, but they cannot necessarily override higher-priority built-in instructions.**

Codex follows an instruction hierarchy. Project instructions and user prompts can customize its behavior, provided they don't conflict with higher-priority requirements.

Therefore, this approach can improve writing quality, but it isn't guaranteed to eliminate robotic language.

## 4. Using AGENTS.md as a Safeguard

You can add writing instructions to your project's `AGENTS.md` file so Codex automatically receives them when working within that project.

For example:
```
## Try your best to write like a human when...

When generating text that users will read within the application, act as an experienced human writer and subject-matter expert, not merely a software engineer.

Distinguish between two writing contexts:

- **Developer communication:** Use concise, technical, task-oriented language.
    
- **User-facing application content:** Use natural, engaging, human-sounding language appropriate for the audience.
    

When generating case studies, quizzes, educational explanations, tutorials, or database seed content:

- Write with natural sentence structure and varied phrasing.
    
- Avoid robotic, generic, repetitive, or formulaic language.
    
- Use conversational language when appropriate without sacrificing accuracy.
    
- Adapt vocabulary, complexity, and tone to the intended audience.
    
- Prioritize clarity, readability, and educational value over excessive brevity.
    
- Review the generated content for unnatural phrasing before saving it.
    

These requirements also apply to user-visible text embedded in source code, JSON, database seed scripts, and other application files.
```


### Why AGENTS.md Is Only a Backup

Adding these instructions is useful, particularly if you forget to switch tools (like to ChatGPT App) and accidentally ask Codex to generate substantial user-facing content.

However, **AGENTS.md is a safeguard, not a guaranteed solution**.

General instructions alone may not consistently produce the writing quality you want. Codex can still generate formulaic content, especially across large batches of similar material.

For a higher chance of success, provide examples of the writing style you expect.

Ideally, these examples should demonstrate:

- What a well-written case study looks like
    
- How quiz questions should sound
    
- How technical explanations should be presented to your audience
    
- The appropriate tone and depth for the application
    

The examples should also change depending on the application and its users. A medical education app for experienced nurses requires a different writing style from a language-learning app for beginners or a consumer productivity app.

In other words, there is no single writing instruction or example set that works equally well for every application.

## 5. Recommended Workflow: Separate Development From Content Writing

Suppose you're converting an existing application into a new one according to a development plan.

**Codex CLI is well suited for implementing the conversion.** It can modify the application's structure, build features, update database schemas, and implement the necessary logic.

However, when it comes to generating substantial amounts of text that users will read, consider using ChatGPT or another general-purpose conversational AI.

A practical workflow would be:

1. **Use Codex CLI or Codex App for development.** Implement the architecture, features, database schemas, and content-seeding infrastructure.
    
2. **Use ChatGPT for content generation.** Create case studies, quizzes, explanations, tutorials, and other user-facing text, with appropriate examples and audience-specific instructions.
    
3. **Use Codex to integrate the content.** Insert the finished content into database seed files or application code without unnecessarily rewriting it.
    

If the development plan already contains finalized seed content, Codex can simply incorporate it.

This division of work reduces the chances of technical coding instructions unintentionally influencing the style of content intended for users.

## 6. ChatGPT Can Also Help With Coding

Choosing ChatGPT for content writing doesn't mean you must give up coding assistance.

The ChatGPT desktop experience and available coding workflows can work with local project folders, depending on the features and permissions available.

This means you may be able to work on your application through ChatGPT rather than always returning to a terminal-based Codex session.

For example, you could use ChatGPT to develop educational content, refine its writing, and then use an available project-editing workflow to integrate that content into the application.

The important distinction is between **ChatGPT's general-purpose conversational experience and Codex's coding-agent experience**, rather than simply whether an AI tool can access source files.

## 7. Key Takeaway: Use the Right AI Tool for the Job

**Use Codex for coding and ChatGPT for writing content that users will read.**

Codex CLI and Codex App are optimized for software engineering. They're excellent at implementing features, refactoring code, debugging, and working with application files.

ChatGPT's general-purpose conversational experience is a sensible first choice when you need natural, engaging writing, particularly for educational materials, case studies, quizzes, and narrative content.

You can configure Codex's `AGENTS.md` to encourage more natural writing in case you forget to switch tools. But those instructions aren't 100% reliable. Providing high-quality, audience-specific examples can improve consistency, although the examples may need to change for each application.

And since ChatGPT also offers coding capabilities and workflows for working with local project files, you don't always need to choose between writing assistance and software development.

**The goal isn't to force one AI tool to do everything. It's to choose the tool and workflow best suited to each task, so you spend less time correcting its output.**