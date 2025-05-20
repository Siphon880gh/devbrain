
## Mega Prompt for AI Agent Acting as Chat Bot

A good way to build a chatbot (that can be embedded on your website) is to let AI guide the whole conversation—while following a clear map. This map (often called a **question sequence** in the prompt) outlines where you want the user to end up (like booking a meeting), what questions need to be asked along the way, and when to hand things off to a human—either live in the chat or by letting the user know someone will follow up by email or message.

The conversation should end when the goal is reached. But the AI should also be flexible: if the user wants to speak to a human or skip ahead (like jumping straight to making a purchase), the bot should recognize that and adapt—even if it’s outside the planned flow.

To make the experience feel natural and aligned with your brand, you should assign the AI a **role** (e.g., “customer support assistant” or “onboarding coach”) and define its **tone** (e.g., friendly, professional, playful). This helps maintain a consistent voice and user experience across conversations.

A chatbot agent can reference a **knowledge base** to provide accurate, context-aware answers. This knowledge base may come from documents the user uploads during the conversation—such as PDFs, spreadsheets, or text files—or from a static collection of reference materials provided by the chatbot developer (e.g., company FAQs, manuals, or policy documents). The AI uses this information to respond intelligently to questions, drawing from both session-specific and persistent sources.

In addition to referencing information, the chatbot can take action using **skills** or **tools**. These are external functions connected to the bot, such as a calendar for scheduling, a calculator for estimates, a database lookup, or a **webhook** that triggers an **API call**. Skills let the AI agent do more than just answer questions—they allow it to complete tasks, drive outcomes, and deliver a more interactive and productive user experience.

It should also be able to collect and store relevant user information—such as name, email, or phone number—into variables (like `global.name`) that the chatbot can reference later in the conversation or pass along to a human agent during handoff or when reviewing chat logs.

To keep the conversation focused, the chatbot should be aware of its **scope**—the specific topics or tasks it is designed to handle. The AI should politely deflect off-topic or unrelated questions (e.g., “What’s the capital of France?” in a product support bot) and guide the user back to the intended flow. This ensures the experience stays productive and on-brand, rather than becoming a curiosity test for the user.

Similar to defining scope, you may also want to specify whether the AI agent is allowed to **search the web**. Web access is treated as another tool or skill—one the AI has been trained to use, depending on the underlying model (e.g., ChatGPT or similar). You can guide the AI by setting boundaries on acceptable sources, such as favoring official documentation, trusted websites, or even specific domains. This helps ensure that responses pulled from the web remain accurate and aligned with your standards.

Finally, your chatbot should follow important **guardrails** to ensure trust and safety:
- Not asking overly personal or sensitive questions (e.g., personal ID numbers or financial info).
- Avoiding sensitive or invasive question
- Always allowing users to request a human agent at any point
- Clearly stating when they’re interacting with AI. In other words: Informing the user when automation is in use and when humans are stepping in.
- Being respectful and de-escalating in moments of user frustration

These design principles help your AI agent stay helpful, respectful, and outcome-focused—while still being flexible and smart.

---

## **Common Terms When Programming an AI Chatbot Agent**


- **Role** – The defined persona or function the AI represents in the conversation. Examples include “customer support assistant,” “technical onboarding coach,” or “billing help agent.” Giving the AI a clear role helps set user expectations and keeps responses focused and relevant.
  
- **Scope** – The defined boundaries of what the chatbot is designed to handle. A clear scope prevents the AI from attempting to answer unrelated or out-of-domain questions (e.g., trivia in a billing assistant). The bot should recognize when a question is outside its scope and politely steer the user back to the intended topic or escalate if needed.

- **Tone** – The personality or voice the chatbot uses when speaking. It could be friendly, formal, playful, professional, or empathetic—depending on the brand and use case. Consistent tone builds user trust and makes the bot feel more human-like and aligned with your brand identity.

- **Question Sequence (Flow Map)** – A predefined path of questions the bot uses to guide users toward the goal. Also called a “question sequence,” this ensures the bot collects the necessary context step-by-step, while still allowing flexibility to skip or jump ahead when needed.

- **Goal** – The target outcome of the conversation, such as scheduling a meeting, completing a sign-up, or answering a support question. Once the goal is reached, the conversation can end or shift to a new intent.

- **Intent** – What the user wants to do. For example, “book a meeting,” “reset my password,” or “talk to support.” The AI listens for clues in the user’s message and maps them to these predefined actions.

- **Trigger** – What the bot does in response to a detected intent. A trigger might send a message, start a form, call an external **API** or **webhook**, or reroute the flow of the conversation. Triggers are how intents translate into action.

- **Capture** – When the bot asks for and stores specific information from the user (e.g., name, email, phone number). Captured data is typically saved into variables like `global.name` or `session.email`, which can be used later by the AI or accessed by a human during escalation or review.

- **Knowledge Base** – External content the AI can reference to answer user questions accurately. This can include user-uploaded documents during the session (PDFs, spreadsheets, etc.) and developer-provided materials like help articles or internal documentation. The AI draws from these sources in real-time.

- **Skills / Tools** – External functions the AI can use to complete tasks, such as booking appointments via a calendar, calculating estimates, querying a database, or submitting forms. These are often called “skills” or “tools” depending on the chatbot platform and can include deeper integrations beyond messaging.
  
- **Search the web** - A skill you can tell the AI whether it's enabled or not. Through prompting, you can set boundaries on acceptable sources.

- **Escalation** – When the bot determines that a human should take over. This can happen based on user input (e.g., "I need to speak to someone") or bot limitations. Escalation can be live (in the same chat) or delayed (by collecting contact details for follow-up).
    
- **Guardrails** – Built-in constraints that ensure ethical and user-friendly behavior. These include not asking sensitive or private questions, always offering a human fallback, making it clear when the user is speaking to AI, and maintaining a respectful, appropriate tone throughout the conversation.

---

## Botpress' Autonomous Node

Botpress has this AI Agent feature that lets you instruct all of the above in one mega prompt. The AI Agent takes over the entire conversation flow in only one node - known as the Autonomous Node, only available on Botpress Cloud free and higher tiers.