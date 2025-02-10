We will make the Chatbot more specialized. We will do this by adding system instruction using Prompt component. We will cover Prompt variables as well, but will keep them optional for you. For the chat bot's specialization, let's make it a historian in US affairs and events.

---

Start a Basic Prompt template, but this time we won't remove Prompt

Lv 1 challenge had us delete Prompt in order to focus on a general chatbot:
![[Pasted image 20250209214202.png]]

Here at lv2, let's NOT delete the prompt card:
![[Pasted image 20250209215118.png]]

**Required knowledge**
- What is System Message? Whether LangFlow or not, system message is instructing the model how to behave. It often means giving the model a name, so that the user can have a more humanized chatting experience. It could mean limiting the model to specific knowledge domain (Eg. You are an expert historian) if your intention is to have more accurate responses in certain fields of knowledge and also limit the user from asking unrelated questions in your app that this chatbot or langflow is connected with. The user DOES NOT see the system message.
	- Eg. You are a {ROLE/EXPERTISE}... 
	- Eg. respond only to questions about... 
	- Eg. respond only in json...

**Self-Orientation:**
- We've covered Chat Input and Chat Output components at Lv 1 challenge.
- Prompt could either be the Input or the System Message depending on where it's connected to. Looking at the above screenshot, we see the Prompt is connected to System Message
- Prompt could either have prompt variables or not.

> [!note] Prompt variables?
> That’s optional  
  > You are an expert historian in {Country} affairs and events and cultures.  
  > It just makes future iterations with slightly different system instructions easier in your workflow, because it creates a field for you to configure the component. Let's say you want to test different Chatbots for US history, UK history, etc because you will be localizing your history website's chatbot:
  > ![[Pasted image 20250209202420.png]]
  


1. Let’s have prompt in the Prompt component say:
	```
	You are an expert historian in US affairs and events and cultures.
	```

Challenge: You may choose to variabalize the prompt: `You are an expert historian in {Country} affairs and events and cultures.` This would create an editable text field in the canvas mode at the Prompt component, which is pretty neat - make sure to type "US" into that field.

2. For the User Input component, let's try:
	```
	Give me summary of what happened on 12/31/2012
	```

Here's what we have so far (Prompt variables optional):
![[Pasted image 20250209202536.png]]
^The Country field (aka prompt variable) is optional. You could choose to hard code the country "US" inside the Template field instead of creating variables/fields.


Then click the play button at the Chat Output (farthest right):
![[Pasted image 20250209202631.png]]

---

## Seeing the Response

To review the chat outputs in this round and all previous rounds, at the Chat Output components, click “Message”
![[Pasted image 20250209202642.png]]

You get a table from opening "Message" at "Chat Output". Notice the response is in that field. Double click the field to expand:
![[Pasted image 20250209202835.png]]


![[Pasted image 20250209202845.png]]


---

## Another way to run the flow is through Playground

You also could have chatted with your “bot” by going into Playground instead of clicking Play on the farthest right component:
![[Pasted image 20250209202925.png]]

![[Pasted image 20250209202932.png]]