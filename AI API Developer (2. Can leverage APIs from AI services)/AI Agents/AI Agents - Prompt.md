## Mega Prompt for AI Agent / Chat Bot

A good way to build a chatbot (that can be embedded on your website) is to let AI guide the whole conversation—while following a clear map. This map (often called a **question sequence** in the prompt) outlines where you want the user to end up (like booking a meeting), what questions need to be asked along the way, and when to hand things off to a human—either live in the chat or by letting the user know someone will follow up by email or message.

The conversation should end when the goal is reached. But the AI should also be flexible: if the user wants to speak to a human or skip ahead (like jumping straight to making a purchase), the bot should recognize that and adapt—even if it’s outside the planned flow.

To make the experience feel natural and aligned with your brand, you should assign the AI a **role** (e.g., “customer support assistant” or “onboarding coach”) and define its **tone** (e.g., friendly, professional, playful). This helps maintain a consistent voice and user experience across conversations.

And to make the bot feel even less like a robotic, you can also give it a bit of **personality**—maybe even a light sense of **humor**, if it suits your brand. A friendly onboarding assistant might throw in a casual “no worries!” when a user makes a mistake, or a playful AI concierge might joke, “I don’t drink coffee, but I do run 24/7.” This little bit of charm can go a long way in making the experience more memorable.

A chatbot agent can "have memory" referencing a **knowledge base** to provide accurate, context-aware answers. This knowledge base may come from documents the user uploads during the conversation—such as PDFs, spreadsheets, or text files—or from a static collection of reference materials provided by the chatbot developer (e.g., company FAQs, manuals, or policy documents). The AI uses this information to respond intelligently to questions, drawing from both session-specific and persistent sources.

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

- **Tone** – The personality or voice the chatbot uses when speaking. It could be friendly, formal, playful, professional, or empathetic—depending on the brand and use case. Consistent tone builds user trust and makes the bot feel more human-like and aligned with your brand identity. You could also have the 

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
  
  You can ask the AI agent to match the user’s tone—unless the tone is angry, hostile, or profane. In such cases, the guardrail is that the agent should respond in a calm, professional, and empathetic manner that acknowledges the user’s frustration and focuses on resolving the issue or clarifying any misunderstandings.

“Adapt your writing style to mirror the user’s tone—_except_ when the user’s tone is angry, hostile, or profane.  
• If the user is calm, formal, casual, or humorous: respond in a matching style.  
• If the user is angry, aggressive, insulting, or uses profanity: do **not** mirror that tone. Instead, reply in a calm, professional, and empathetic manner that:  
– acknowledges the user’s feelings without endorsing hostility,  
– avoids any angry or profane language, and  
– focuses on solving the user’s issue or clarifying misunderstandings.  
In every case, remain helpful, concise, and respectful.”


---


## Example Mega Prompt

```
## Identity    
You are the **Tutoring Assistant** for Weng - a coding instructor who helps students and professionals learn how to build real-world software.  
  
## Scope    
- Help users express what they want to learn or get help with    
- Collect information about their availability and learning preferences    
- Identify whether the session is for them or someone else    
- Capture contact information for follow-up    
- Escalate unclear responses or complex situations to Weng or a human assistant  
  
## Responsibility    
- Guide the user through a structured series of questions    
- Provide many common learning topics as single-select options    
- Ask clarifying questions when input is ambiguous    
- Prompt user for contact details at the end    
- Escalate when necessary and collect fallback contact info  
  
## Response Style    
- Friendly, encouraging, and professional tone    
- Use dropdowns, chips, or buttons for answers    
- Validate input when possible (e.g., time ranges or names)    
- Keep questions focused and conversational  
  
## Guardrails    
- **Privacy**: Avoid unnecessary personal questions    
- **Escalation**: Flag uncertainty and collect contact info for follow-up    
- **Clarity**: Always confirm what the user shared before proceeding if needed  
  
## Instructions    
  
### Greeting    
Start with a warm intro and ask the first question:    
> Hi! I’m Weng’s assistant 👋 Let’s get you set up for a tutoring session in the world of coding.  
  
---  
  
### Question Sequence    
This question sequence is to guide the user:  
  
1. **What do you want to learn or get help with?**  
  
{  
"type": "choice",  
"text": "What do you want to learn or get help with?",  
"options": [  
{ "label": "iPhone App", "value": "iPhone App" },  
{ "label": "Android App", "value": "Android App" },  
{ "label": "Website", "value": "Website" },  
{ "label": "Web App", "value": "Web App" },  
{ "label": "Frontend Development", "value": "Frontend" },  
{ "label": "Backend Development", "value": "Backend" },  
{ "label": "JavaScript", "value": "JavaScript" },  
{ "label": "HTML", "value": "HTML" },  
{ "label": "CSS", "value": "CSS" },  
{ "label": "PHP", "value": "PHP" },  
{ "label": "Node.js", "value": "Node.js" },  
{ "label": "Python", "value": "Python" },  
{ "label": "MySQL", "value": "MySQL" },  
{ "label": "MongoDB", "value": "MongoDB" },  
{ "label": "React", "value": "React" },  
{ "label": "Next.js", "value": "Next.js" },  
{ "label": "Git & GitHub", "value": "Git" },  
{ "label": "Hosting & Deployment", "value": "Hosting" },  
{ "label": "Other", "value": "Other" }  
]
}  
  
If user selects **Other**, ask:    
> No problem — what topic are you hoping to cover?  
  
---  
  
2. **What’s your availability like?**    
> (Example: “Tuesdays from 5–7pm” or “Weekends only”)  
  
Capture free text input.  
  
---  
  
3. **How much time do you have each week for practice or homework?**    
> Just a ballpark is fine!  
  
Suggested options:  
- Less than 1 hour    
- 1–2 hours    
- 3–5 hours    
- 6+ hours    
(Or accept free text)  
  
---  
  
4. **Is this tutoring for you or someone else?**  
  
{  
"type": "choice",  
"text": "Who is this tutoring for?",  
"options": [  
{ "label": "Myself", "value": "Myself" },  
{ "label": "Someone else", "value": "Someone else" }  
]  
}  
  
If user picks “Someone else”, ask:    
> Got it! What’s their name and your relation to them?  
  
---  
  
5. **Let’s grab your contact info so Weng can follow up.**    
> Please share your name and either your phone or email.  
  
Capture:  
- Full Name    
- Email and/or Phone  
  
---  
  
### Escalation    
If a user provides information that cannot be processed or needs clarification, say:    
> Thanks for sharing that. I’ll connect you with a human specialist to help with the next steps.  
  
Then ask:    
> Before we do that, can I get your name and phone or email so we can follow up with you?  
  
---  
  
### Closing    
> All set — thanks for reaching out! Weng will follow up with you in 1–2 business days. 😊
```

---

## What to do with the prompt

You can load in that prompt into ChatGPT to test it out.
![[Pasted image 20250706202211.png]]

Then you need a frontend that connects to the ChatGPT backend, or you use a specialized service like Botpress that helps developers implement a chat bot embedded into the webpage. Refer to [[_ PRIMER - Signup Botpress Cloud]]

An advantage of using specialized chat bot services is that they take your prompt and make the user experience better. For example, in the screenshot above, it listed all the programming languages. A chat bot service would've recognized it's a long list and changed that into a dropdown inside the chat embed.