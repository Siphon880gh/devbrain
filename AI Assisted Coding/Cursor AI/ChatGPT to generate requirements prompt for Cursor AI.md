
Prompt ChatGPT 4o:
```
I want to create a stock graph with moving average lines when I toggle them on and other related lines to help with stock analysis. I will use Cursor AI to create the app from a text prompt. Ask me questions to come up with the proper prompt
```


Answer the questions in ChatGPT. It will generate a prompt.

Pass the generated prompt into Cursor AI Composer.

It will create files. Press ALT+Enter to auto accept and save at each code file (they are tabs unsaved).

---


Sometimes it creates a README, sometimes it doesnt. Sometimes it creates package.json and sometimes it doesn't. Check to make sure it's not missing any files, OR, prompt:
`Are we missing any files? If we are, continue to generate them`
OR you can be specific about the missing files: `hey you forgot to create a proper package.json with the packages needed`

The Readme should at least contain instructions on how to install and run. If not, ask it to:
"Please generate {install|run} instructions in the readme"


---

Test the app. If it doesn't run, check DevTools console and inform Cursor AI. If the error is not obvious:
`Are we missing any files? If we are, continue to generate them`
Or: `It's not running. {Describe your steps installing/running}. What are we missing?`