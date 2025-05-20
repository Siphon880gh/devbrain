Managing AI costs effectively is crucial for businesses that want to leverage AI technology without overspending. Botpress helps users maximize value while keeping AI-related expenses under control. This guide outlines both built-in features and actionable tips you can use to reduce AI Spend.

---

## 🔍 Our Approach to Reducing AI Costs

### **1. Transparent Pricing**

We don’t add any markup on AI usage. You only pay for what the AI provider charges — no hidden Botpress fees. Use the AI Spend Calculator (https://botpress.com/ai-spend-calculator) to estimate your costs.

### **2. Smart Caching of AI Responses**

Caching is one of the most powerful tools for cost savings. When enabled, Botpress stores AI responses to avoid repeated calls to the LLM, reducing costs by up to **30%**—with no loss in response quality.

---

## 💡 Bot-Building Tips to Lower AI Spend

### **Optimize Knowledge Base (KB) Usage**

KBs are typically the largest driver of AI costs. Here’s how to optimize them:

#### **Tip 1: Choose the Right AI Model**

Start with **GPT-3.5 Turbo**, which is faster and ~20x cheaper than GPT-4 Turbo. Use GPT-4 Turbo only if necessary.  
Botpress KB Agents can use a **hybrid mode**, starting with GPT-3.5 and escalating to GPT-4 if no answer is found.

#### **Tip 2: Use ‘Shielding’ for FAQs**

Use a **Find Records** card to handle repetitive questions (e.g., common FAQs) without triggering the KB. Only fallback to the KB if no match is found in your table.

#### **Tip 3: Scope KBs Precisely**

Break down large KBs into **smaller, topic-specific KBs**, and use workflows to direct users to the right one. This lowers token usage and increases answer accuracy.

#### **Tip 4: Avoid Website KB If Not Needed**

If your source website doesn’t change often, consider switching from **Website KB** to **Search the Web KB**. This can be more cost-efficient without sacrificing answer quality.

#### **Tip 5: Query Tables with Logic**

Instead of putting Tables in your KB, use a **Find Records** card or an **Execute Code** card to search the table. This avoids AI calls altogether.

#### **Tip 6: Control the Number of Chunks**

Limit how many chunks are retrieved from the KB. More chunks = more tokens = higher cost. Find the minimum that still gives accurate results.

---

## 🧠 Reduce AI Use with the Execute Code Card

### **Replace AI Cards for Simple Tasks**

Use the **Execute Code** card when:

- Reformatting or validating structured data
    
- Fetching random preset messages (e.g., greetings)
    
- Tracking conversation history without a Summary Agent
    

Example: Instead of using AI to generate a greeting, define an array of greeting messages and randomly select one.

### **Build Custom Summaries or Context**

Track messages using a custom array via Execute Code, then pass that into your KB for context — a great alternative to the Summary Agent.

### **Simplify Feedback Collection**

Need user feedback? A **star rating + comment box** is cheaper and just as effective as an AI-driven feedback collector.

---

## 🧩 AI Task, AI Generate Text, and Translations

### **Choose the Right Card for the Job**

- Use **AI Task** when analyzing or parsing user input.
- Use **AI Generate Text** for generating content or rephrasing text.

### **Control Output Length**

Reduce token limits in AI Task cards to save cost — but make sure your prompt and response fit within the limit, or content may be cut off.

### **Translation Alternatives**

If your bot handles heavy multilingual traffic, consider **external translation APIs via hooks** as a cheaper option than LLM-based translations.

---

## 🚫 Bypass AI Caching (When Needed)

Sometimes, you want **fresh AI responses every time** — especially in testing or creative tasks. Here’s how:

- **Permanent bypass**: Add `And discard: {{Date.now()}}` in AI card prompts (e.g., AI Task or KB context).
    
- **Temporary bypass**: Test the bot in an incognito browser window after publishing.
    

---

## ✅ Final Thoughts

By combining built-in cost-saving features with smarter design choices, you can significantly reduce AI-related costs in Botpress without sacrificing quality or performance.

Need help or want to explore more strategies?  
👉 Visit our [Pricing Page](https://chatgpt.com/c/682c5d4e-5b7c-800f-9244-6f52a6eda3cd#) or join the [Botpress Discord community](https://chatgpt.com/c/682c5d4e-5b7c-800f-9244-6f52a6eda3cd#) for support.