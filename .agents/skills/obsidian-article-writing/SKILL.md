---
name: obsidian-article-writing
description: >-
  Creates, authors, rewrites, names, organizes, or places a new article in this
  published Obsidian vault. Use whenever the user asks to write a new article or
  note, turn supplied material into an article, or decide where a new article
  belongs in the vault.
---

# Obsidian Article Writing

Use this skill whenever the task creates a new article in this Obsidian vault.

## Place and name the article

1. Treat the repository root containing this skill and `AGENTS.md` as the Obsidian vault root.
2. Inspect the live folder structure and nearby notes before choosing a location or filename.
3. Prefer an existing, specific folder whose subject matches the article. Create a new subfolder only when the existing taxonomy has no clear fit.
4. Give the Markdown file a descriptive, reader-friendly name consistent with neighboring notes.
5. Preserve the user's meaning while improving structure, clarity, factual nuance, and scanability as needed.

## Verify the result

Before reporting completion:

1. Confirm that the new Markdown file exists at the intended location.
2. Re-open the file and verify its title, body, formatting, and internal links.
3. Check that no unintended staging or duplicate file remains elsewhere in the vault.

## Required final response

Whenever a new article is created, the final response must include both of the following:

1. The article's full absolute filesystem path. Prefer a clickable local-file Markdown link.
2. A human-readable path formatted as a nested list, beginning with the Obsidian vault root and showing every folder and subfolder down to the article's filename.

Example:

```markdown
Full path: [Article Name.md](/absolute/path/to/Vault/Folder/Article Name.md)

- Vault
  - Folder
    - Subfolder
      - Article Name.md
```

Do not omit either path representation, even if the article's location was already mentioned earlier in the conversation.
