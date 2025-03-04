Note returning LangFlow veterans:
"Chat Memory" won't be found in the components anymore. It's been replaced by "Message History" since 11/2024.

---

With a basic prompting template:
![[Pasted image 20250210020543.png]]

Go ahead and open the Playground, then ask one question, then ask it to recall your conversation
![[Pasted image 20250210015950.png]]

Even though the subsequent prompt and response is on the same screen, the AI does not recall what was talked about.

**What's going on**
	Under the hood of ChatGPT or any AI Chat Bot, the previous conversations are actually saved somewhere and then re-fed to the AI model each time the user submits a prompt. So the System Message gets longer and longer as it accrues older chat messages. When there are too much chat history, the older history is deleted.

---

Let's add a prompt with prompt variables (therefore rendering a control field):
```
You are a helpful assistant named Sam that answer questions.

Use markdown to format your answer, properly embedding images and urls.

History: 

{memory}
```

As you can see, this starts imitating the "What's going on" of AI chatbots and how they retain memory. The memory variable will be multiline string of our previous chats and it will grow longer the more we chat.

The canvas' Prompt component has a control field "Memory"
![[Pasted image 20250210020739.png]]

Do not type into "memory". Instead let's connect a "Message History" component (found inside the category "Helpers")
![[Pasted image 20250210020950.png]]

The Message History will automatically feed in your previous chats (the previous 100s) and shifts off the oldest messages if you've reached pass 100 chats.

Now let's ask Playground (Start asking your question all over again, because it didn't track the previous messages):
![[Pasted image 20250210021214.png]]
