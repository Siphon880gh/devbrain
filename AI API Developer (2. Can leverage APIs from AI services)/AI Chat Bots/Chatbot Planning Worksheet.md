### 1. **Define Your Goal**

|Question|Your Answer|
|---|---|
|What is the **primary purpose** of the chatbot?|(e.g., answer FAQs, qualify leads, take orders)|
|What are the **key actions** users should be able to perform through the chatbot?|(e.g., book appointment, get pricing, troubleshoot issue)|
|What is the **ideal end result** of a conversation?|(e.g., schedule call, provide answer, escalate to human)|

---

### 2. **Identify User Entry Points**

|User Scenario|Expected Entry Message or Trigger|
|---|---|
|Homepage visitor|“Hi, I’m here to help. What are you looking for?”|
|Logged-in user|“Need help with your account or a feature?”|
|After business hours|“We’re currently offline, but I can help with common questions.”|
|Product page|“Want to know more about this product?”|

---

### 3. **List User Intents (Things Users Want to Do)**

|Intent Name|Example User Message|Response Goal|
|---|---|---|
|Ask a question|“What’s your pricing?”|Provide direct link or summary|
|Book a call|“Can I talk to someone?”|Offer scheduling calendar|
|Technical help|“It won’t load”|Begin troubleshooting flow|
|Track order|“Where’s my order?”|Ask for order ID, look it up|
|Leave feedback|“I have a suggestion”|Collect comment and email|

---

### 4. **Map Out Each Chat Flow**

Use this format per intent:

#### 🔄 Example: “Track Order” Flow

```
User: Where’s my order?
→ Bot: I can help with that. Can you provide your order number?
→ User: 12345
→ Bot: Got it. Looks like it shipped on May 10. Expected delivery: May 15.
→ User: Thanks
→ Bot: Happy to help! Anything else?
```

**Tips:**

- Include quick reply options: e.g., [Track Order], [Talk to Support], [View FAQs]
    
- Define fallbacks: "Sorry, I didn’t understand. Want to try again or talk to support?"
    

---

### 5. **Design Error Handling & Escalations**

|Scenario|Fallback Message|Escalation Path|
|---|---|---|
|Unrecognized message|“I didn’t catch that. Want to see FAQs or talk to a team member?”|Offer live agent|
|User frustrated|“I’m here to help. Let me connect you with support.”|Human handoff|
|Too many steps|“Let’s skip ahead. Would you like to speak to someone directly?”|Escalate|

---

### 6. **Team Review Checklist**

✅ Have we covered all top user intents?  
✅ Are there fallback messages for confusion?  
✅ Does the tone match our brand?  
✅ Is there a way to escalate to a human?  
✅ Is there data we need to collect (e.g., email, order #)?

---

### **Example Flowchart**

![[Pasted image 20250518213158.png]]

^ Above from: https://dribbble.com/shots/3448105-Facebook-Messenger-Chatbot-Conversation-Flow-Chart