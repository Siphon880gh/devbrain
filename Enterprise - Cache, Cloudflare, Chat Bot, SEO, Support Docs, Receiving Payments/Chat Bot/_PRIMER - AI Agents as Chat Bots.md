
## Mega Prompt for AI Agent Acting as Chat Bot

A good way to build a chatbot (that can be embedded on your website) is to let AI guide the whole conversation—while following a clear map. This map (often called a **question sequence** in the prompt) outlines where you want the user to end up (like booking a meeting), what questions need to be asked along the way, and when to hand things off to a human—either live in the chat or by letting the user know someone will follow up by email or message.

The conversation should end when the goal is reached. But the AI should also be flexible: if the user wants to speak to a human or skip ahead (like jumping straight to making a purchase), the bot should recognize that and adapt—even if it’s outside the planned flow.

To make the experience feel natural and aligned with your brand, you should assign the AI a **role** (e.g., “customer support assistant” or “onboarding coach”) and define its **tone** (e.g., friendly, professional, playful). This helps maintain a consistent voice and user experience across conversations.

The AI chatbot should function more like an **agent** than a simple question-and-answer tool. It can use external **tools or skills**, such as:

- A **calendar** for scheduling
- A **calculator** for price or estimate calculations
- A **knowledge base**, such as uploaded **PDFs, spreadsheets, or documents** the user has shared through the chat interface

It should also be able to collect and store relevant user information—such as name, email, or phone number—into variables (like `global.name`) that the chatbot can reference later in the conversation or pass along to a human agent during handoff or when reviewing chat logs.

Finally, your chatbot should follow important **guardrails** to ensure trust and safety:
- Not asking overly personal or sensitive questions (e.g., personal ID numbers or financial info).
- Avoiding sensitive or invasive question
- Always allowing users to request a human agent at any point
- Clearly stating when they’re interacting with AI. In other words: Informing the user when automation is in use and when humans are stepping in.
- Being respectful and de-escalating in moments of user frustration

These design principles help your AI agent stay helpful, respectful, and outcome-focused—while still being flexible and smart.

---

## **Common Terms When Programming an AI Chatbot Agent**

- **Intent** – What the user wants to do. For example, “book a meeting,” “reset my password,” or “talk to support.” The AI listens for clues in the user’s message and maps them to these predefined actions.
    
- **Trigger** – What the bot does in response to a detected intent. This could be sending a specific message, starting a structured form, running an API call, or changing the flow of the conversation.
    
- **Capture** – When the bot asks for and stores a specific piece of information from the user (e.g., name, email, phone number). If your chatbot platform supports it, captured data is often saved to variables like `global.name` or `session.email`, which can be referenced later by the bot or accessed by human agents during handoff or in chat logs.
    
- **Escalation** – When the bot recognizes that a human should take over. This can happen automatically based on certain inputs or when the user requests help. Escalation may happen live (within the same chat) or by collecting contact info for follow-up.
    
- **Goal** – The target outcome of the conversation, such as scheduling a meeting, completing a sign-up, or answering a support question. Once the goal is reached, the conversation can end or shift to a new intent.
    
- **Question Sequence (Flow Map)** – A predefined path of questions the bot uses to guide users toward the goal. Also called a “question sequence,” this ensures the bot collects the necessary context step-by-step, while still allowing flexibility to skip or jump ahead when needed.
    
- **Guardrails** – Boundaries and ethical constraints placed on the bot. These include avoiding overly personal or sensitive questions, allowing users to request a human at any time, clearly identifying when AI is responding, and maintaining a respectful tone throughout the conversation.
    
- **Knowledge Base** – External content the AI can refer to in real-time, such as uploaded PDFs, spreadsheets, documents, or help articles. These sources are often provided through the chatbot interface and help the AI answer questions based on your business-specific information.
    
- **Skills / Tools** – External functions the AI can use to perform actions, like booking a meeting through a calendar integration, generating a quote with a calculator, or submitting a form. These are often referred to as “skills” or “tools” depending on the chatbot platform.

---

## Botpress' Autonomous Node

Botpress has this AI Agent feature that lets you instruct all of the above in one mega prompt. The AI Agent takes over the entire conversation flow in only one node - known as the Autonomous Node, only available on Botpress Cloud free and higher tiers.