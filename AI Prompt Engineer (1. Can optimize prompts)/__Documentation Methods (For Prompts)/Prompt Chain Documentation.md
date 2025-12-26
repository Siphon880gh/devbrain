When documenting AI prompts and subsequent prompts (either in the same chat thread or on a new chat thread or entirely different platform), you may want to use some conventions like:

-----
1. Initial Prompt:
- Any placeholders to be filled in
- A specific model needed?
  … (Use three backticks as code fence)
  
  Example response
  ... (Use `>` as block quote)


2. Subsequent Prompt ({on same chat thread | on new chat thread})
- (If on a new chat thread: any specific model needed?)
  … (Use three backticks as code fence)
  
  Example response
  ... (Use `>` as block quote)
-----

^ You could have mandatory inputs with {{..}}} and optional inputs with {(…)} just list the legend somewhere in your documentation. And when reading documentation, depending on your note app, leverage ctrl f or cmd f to search and highlight all input placeholders using curly brackets

---

Use code snippet for input, use curly brackets for place holder, use blockquote for response (which can retain formatting). For prompt, use markdown syntax rather than plain text if it's a long input. In the following example, the prompt is short so no need for markdown.

Example prompt and response:
![[Pasted image 20251226003422.png]]

---

And when chaining outputs from prior or prior-prior-prior…: Eg. Prompt:
```
Please create a feasible System Architecture Overview, Critical Logic Refinements, Suggested Technical Stack, and Next Steps, and any additional sections that are applicable. We are inferring what the code and tech might look at (we are not being concrete yet) from Top level description of app and the User Flows  
  
Top level description of app:  
"""  
{^Output from waiting on prompt "Help rewrite with clarity"}  
"""  
  
User Flows:  
"""  
{^Output from waiting on prompt "... Prompt — Document All User Flows From an App Description (No Codebase) ..."}
```
  

Sometimes it could simply be (partial):
```
## Project Manager briefed on:  
"""  
{^Output from waiting on previous prompt}  
"""
```