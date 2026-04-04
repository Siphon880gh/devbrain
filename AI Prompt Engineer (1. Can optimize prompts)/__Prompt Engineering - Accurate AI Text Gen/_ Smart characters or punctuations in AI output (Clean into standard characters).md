Use this as a quick reference for cleaning up smart characters before publishing or coding. 

This is a common issue with AI-generated articles and text, where curly quotes, em dashes, and other Unicode punctuation can make the writing look obviously AI-written or create formatting problems. 

It can also happen when a markdown renderer, CMS, or JavaScript library displays **odd replacement characters** where smart punctuation should be. 

It is also a common coding problem when your OS, especially macOS, automatically changes straight single or double quotes into curly versions while you are drafting code, and then the code fails after you paste it into your IDE / code editor.

---

Recommended replacements:
- Smart single quotes `‘` and `’` → straight apostrophe `'`
- Smart double quotes `“` and `”` → straight double quote `"`
- Em dash `—` → double hyphen `--` or regular hyphen `-`, depending on context
- Bullet point or inline item separator `·` → hyphen `-`

---

Regex Find and Replace:

Find's are:
```
[—·]
[‘’]
[“”]
```

---

Leverage AI:
You can prompt AI to replace smart punctuation with standard ASCII characters. This is often much faster than manually using Find and Replace for each symbol, since you don’t need to look up every smart character or remember the keyboard shortcuts to type them.

Prompt:
```
Normalize smart characters across the file by converting Unicode punctuation to plain ASCII. Replace curly single quotes with straight apostrophes, curly double quotes with straight quotation marks, bullet separators like `·` with standard hyphens, and em dashes with either `--` or `-` depending on context.
```