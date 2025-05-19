
A good way to build a chatbot (that can be embedded on your website) is to let AI guide the whole conversation, but with a clear map in mind. This map shows where we want the user to end up (like booking a meeting), what questions need to be asked along the way, and when to hand things off to a human—either live in the chat or by letting the user know someone will follow up by email or message.

The conversation should end when the goal is reached. But the AI should also be flexible. If the user wants to speak to a human or skip ahead (like jumping straight to making a purchase), the bot should recognize that and respond accordingly—even if it’s outside the planned flow.

The AI chatbot should work more like an agent. It should be able to connect to tools like a calendar for booking or a calculator for quick estimates. It should also be able to collect and store useful info from the user, like their name, phone number, or email.

---

**Common Terms When Programming an AI Chatbot Agent:**

- **Intent** – What the user wants to do. For example, “book a meeting” or “talk to support.” The AI listens for signals in the user’s message and maps them to these known intents.
    
- **Trigger** – What the bot does after detecting an intent. A trigger might send a specific message, start a form, or launch an API call.
    
- **Capture** – When the bot collects a piece of information from the user, like their name, email, or phone number, and saves it for later use.
	- And if you define these variables in your Chat Bot interface for AI to use, then you can look up these variables when looking back at logged conversations; The AI would have access to `global.variableName` or whatever syntax your Chat Bot platform uses to give variable access to the AI Agent.
    
- **Escalation** – When the bot hands the conversation over to a human, either live or by collecting contact info for follow-up.
    
- **Goal** – The final outcome the bot is designed to reach, such as a booked appointment, completed form, or successful purchase.
    

---

Botpress has this AI Agent feature that lets you instruct all of the above in one mega prompt. The AI Agent takes over the entire conversation flow in only one node - known as the Autonomous Node, only available on Botpress Cloud free and higher tiers.