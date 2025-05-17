**Autonomous Nodes** in Botpress Cloud let you power entire multi-step conversations using a single AI-driven prompt. Instead of building out complex conversation trees with multiple standard nodes, you define the _intent and flow_ in plain language—and the AI takes care of guiding the user.

### Key Benefits

- **Conversational Intelligence**: Use natural language to instruct the AI on how to handle multi-step tasks.
- **Simplified Logic**: Eliminate the need for mapping out every transition manually.
- **Ideal Use Cases**: Great for onboarding, surveys, lead capture, or any process where structured data is gathered through dialogue.

---

### 💡 Example: Web Design Client Intake

Imagine you're onboarding new clients for your WordPress design service. Your Autonomous Node prompt could be:

> _You're a friendly assistant helping onboard new web design clients. Ask them:_
> 
> 1. _What’s the purpose of their website? (e.g., portfolio, business, blog, e-commerce)_
> 2. _What’s their brand name?_
> 3. _What colors or styles reflect their brand?_
> 4. _Do they have logos or other branding assets?_
> 5. _What features do they want (e.g., contact form, gallery, blog, store)?_  
>     _Guide them through one question at a time and summarize their answers at the end._
>     

This single prompt enables a fluid, dynamic interaction—no need to build separate nodes for each question.

---

### Transitioning to Botpress V12 (Self-Hosted)

If you're using the free self-hosted **Botpress V12**, note that Autonomous Nodes aren't supported. V12 relies on traditional, manual workflows using **Standard Nodes** and conditional transitions.

However, you can:

- Use Autonomous Nodes in Cloud first to **prototype and test your flow**, taking advantage of the fact that Botpress Cloud has a generous amount of AI Spend ($5 every month). 
- Later **break the logic into individual nodes** when migrating to V12.
- Call external AI models (like OpenAI or Claude) via API to simulate AI-like conversations.
- Parse structured responses (e.g., JSON) to set variables (`temp.purpose`, `session.brandColor`, etc.) for transitions.
    

---

### Final Note

While Botpress Cloud’s Autonomous Nodes simplify complex logic and are great for rapid prototyping, you’ll still need to test various user paths and edge cases. This ensures a smooth transition when converting to V12 or scaling beyond the **5,000-message Cloud limit**.

Can read more at:
[https://botpress.com/blog/autonomous-nodes](https://botpress.com/blog/autonomous-nodes)