Aka: Getting Started

Many authoring tools—like **Obsidian**, or documentation generators like **Docusaurus**—support a feature called **frontmatter**. Frontmatter is an optional block of **YAML** placed at the top of a document. It allows you to define metadata or configuration settings that control how the document behaves or appears.

The syntax looks like this:

```
---
prop1: value1
prop2: value2
---
```

This block must appear at the very top of the file. The `---` markers define the beginning and end of the frontmatter section.

For example, a property might set the layout or title:

```
---
title: Getting Started
layout: center
---
```

These values can then be interpreted by the tool you're using to adjust rendering or behavior.