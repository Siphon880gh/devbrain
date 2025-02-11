We will explore the "Combine text" component/node

Just like before, we have a Basic Prompting. Setup the prompt as:
```
Answer the user as if you were a Geography and History expert.
```


Then as for the text that goes into the model, it'll be a combination of Chat Input and Text Input:
![[Pasted image 20250210004147.png]]
^ Notice something off? You’re only allowed One Chat Input max.

The Chat Input will be:
```
Give me a summary of Putin
```

The Text Input will be:
```
Give me a summary of Kim Jong Un
```

The text is successfully combined if the AI response answers both text's questions.

When ran successfully:
![[Pasted image 20250210004242.png]]

Don't worry if yours is slightly different format. There's a randomness to the AI generation, especially since we didn't provide an example of how we want the answer to look in the System Message's prompt.

---

**MORE**

Now let's open Playground and ask:
```
Give me a summary of George Washington
```

Notice the Playground response contains both George Washington and Kim Jong Un. That's because Kim Jong Un is hard coded as the Text input on the Canvas. Even though we've hard coded Putin into Chat Input for Canvas, when we run the flow in Playground (instead of running in Canvas mode), then the Chat Input is overwritten by what you actually type into the Playground chat, and that's because the node is described as "Chat Input."
![[Pasted image 20250210005444.png]]