
Have team members test out the chat bot that you publish or share with a private url then have them report what they like or dont like. They can report back the conversation ID then you can analyze the conversation.

In order to have access the conversation ID, the way to make it easy for the non-technical users is to have a Text Card that reports the variable `{{event.conversationId}}`:
- Workflow with the `event.conversationId`:
  ![[Pasted image 20250521222212.png]]
- Event.conversationId in the Text Card:
  ![[Pasted image 20250521222244.png]]

You could publish a new iteration of the chat bot (if you're 100% sure or there isn't much traffic anyways):
![[Pasted image 20250521221240.png]]

Or you could share the chat bot (you can share with others who don't need to login into Botpress Cloud):
- Click Copy on the URL
![[Pasted image 20250521221313.png]]

If you need more logging information while the user is chatting, share this instead:
- Click Configure
  ![[Pasted image 20250521221313.png]]
- Then at this screen: ![[Pasted image 20250521221817.png]]
- Clicked Open Demo:
  ![[Pasted image 20250521221907.png]]
  - Then click the chat bubble:
    ![[Pasted image 20250521221925.png]]
- Notice bottom left logs the events and their payloads. It will grow as you chat with the chatbot. This Events log may be shared with your developer with a copy and paste. Also notice the conversation ID is at the top of the logs.

---

If you find that the published or shared conversation bot is out of date (like an older version of your workflow), refer to [[Cache Busting Botpress Cloud]]

---

Analyzing the conversation briefly from the conversation ID at Studio:
![[Pasted image 20250521215555.png]]

---

Analyzing the conversation more in-depth including original conversation at Dashboard:
![[Pasted image 20250521221026.png]]
^ You can filter by ID. By clicking into the conversation ID, you can see the entire conversation:

![[Pasted image 20250521221137.png]]