**Prompts Subsequently:**
1. {Describe problem}. We should print debugging information to console log {or terminal if NodeJS, etc}. I will provide you what's printed in order to help debug the problem. {Describe type of print}
	- If the code is during loading, describe the type of printing as:
	  "Print debug information as the code is {E.G. Initiating the image gallery to be drag and droppable}"
	- If the error occurs when the user performs a task:
	  "The problem occurs when the user performs {DESCRIBE TASK}. Give me a function I can call in DevTools console when it’s the appropriate time, and it’ll give me the debug information I can give to you so you can help debug the problem.**"
2. Here is the debug information I've gotten:
   {Paste the debug information}

Next, if this doesn't seem to fix the problem, you may ask for more debugging information. **Prompt:**
1. I don't think that’s enough information for you to help debug. Let's add more debugging information to console log {or terminal if NodeJS, etc}.

