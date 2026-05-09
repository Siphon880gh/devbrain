
\<<
In markdownIt, I have separate lines in md format. How come they're run-on's when rendered with markdown?

\>>
In Markdown, the way text is rendered can sometimes be counterintuitive, especially when it comes to line breaks and paragraphs. Here's a quick explanation of why your separate lines might be appearing as run-on lines when rendered:

1. **Markdown's Line Break Rules**: In Markdown, simply pressing "Enter" once at the end of a line does not create a new paragraph or line break in the rendered output. Instead, lines directly below each other without an empty line between them are treated as part of the same paragraph and are joined together.

2. **Creating Line Breaks**: If you want to create a line break (i.e., have the text start on a new line directly below), you need to end a line with two or more spaces before pressing "Enter". This will be interpreted as a line break in the rendered Markdown.

3. **Creating New Paragraphs**: To start a new paragraph, you need to insert an empty line (i.e., press "Enter" twice) between the lines of text. This will create a visible space between the paragraphs in the rendered output.

Here's an example to illustrate:

- Markdown Input:
   ```
   This is the first line.  
   This is the second line, separated by two spaces and a newline.

   This is a new paragraph.
   ```

- Rendered Output:
   - This is the first line.  
     This is the second line, separated by two spaces and a newline.

   - This is a new paragraph.

MarkdownIt, like other Markdown parsers, follows these rules. If you're seeing run-on lines, it's likely because you haven't included the two spaces at the end of a line for a line break or an empty line for a new paragraph. Adjusting your Markdown source accordingly should resolve the issue.