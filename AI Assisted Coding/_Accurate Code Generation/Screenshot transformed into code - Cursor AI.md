## Basic use

Lets say you have a screenshot of a desired webpage code in your clipboard, like:
![](MMTL9BO.png)

In your Cursor AI, open Chat with CMD+L, then paste into it. Then your prompt can be:
```
Create this webpage {with desired css frameworks like tailwind, if applicable} {in Javascript or React, if applicable}
```

So the prompt could be "Create this webpage with tailwind and javascript"

![](9F8i2Ka.png)

The code it generates might not be able to apply to any file, and because it's not Composer (which doesn't take screenshot), it can't create new files for you. Just click copy, then paste into a new html file.

The result will not be 100% fidelity, but it'll be a good starting point!
![](QjwTs81.png)


---

## Advanced use

An advanced use is giving more requirements about the technology you desire in a long format MD file.

https://www.youtube.com/watch?v=wyN3iMhgiFM
^ In this video, he uses the MD file of technology requirements at https://github.com/gopinav/awesome-cursor/blob/main/prompts/screenshot-to-code.md. He downloaded the MD file into the codebase and then tagged the md file. He also tagged the folder src because it will be a React implementation. Note his MD file is inside a folder called prompts:
![](8NtY8t0.png)
