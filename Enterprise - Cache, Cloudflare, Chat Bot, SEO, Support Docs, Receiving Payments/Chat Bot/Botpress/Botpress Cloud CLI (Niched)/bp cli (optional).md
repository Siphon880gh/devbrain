You don’t need to use the `bp` CLI — you can manage your bots directly at [https://app.botpress.cloud/](https://app.botpress.cloud/).

That said, the `bp` CLI offers a streamlined experience from the terminal. It lets you open the Cloud Studio in your browser directly from your terminal and provides features for those who prefer an interactive CLI workflow alongside the web platform.

---

## Install bp cli

Install bp cli globally:
```
npm install -g @botpress/cli  
```


---

## Initiate

Run:
```
bp init
```

It'll ask what you want to create:
![[Pasted image 20250517065806.png]]

### The three types

The `bp init` command is part of the [Botpress CLI](https://botpress.com/docs/latest/build/cli/), and the prompt you're seeing is asking you what type of project you want to initialize.

Here's what each option means:

---

### ❯ **bot**
- Creates a **full chatbot project**.
- Includes conversational flows, natural language understanding (NLU), Q&A, and more.
- Ideal if you're building a standalone chatbot application or interface.

### **integration**
- Initializes a project to build a **custom integration**, such as a connection to a third-party platform (Slack, Twilio, CRM, etc.).
- Used when extending Botpress to interact with other tools or services.

### **plugin**
- Sets up a **plugin project** to extend Botpress functionality with reusable logic (e.g., custom code, hooks, or modules).
- Ideal for shared features across multiple bots.
    

---

### Recommendation

If you're building a chatbot from scratch that will converse with users, choose:

```
❯ bot  
```

If you're enhancing Botpress by adding connections or reusable features, choose: 
- `integration` for external services
- `plugin` for reusable logic across bots

---

If asks you to login (`bp login`) refer to [[bp login]]