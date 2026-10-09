## What It Means to Be an Agent-First App

In an agent-first app, anything a user can do through the interface can also be done by an agent.

### Two synchronized ways to use the app

Users can interact with the app through either its visual interface or an agent. Both operate on the same persistent data, whether it is stored in local storage, a database, or another system.

Changes remain available in future sessions and synchronize in real time:

- When a user updates something through the UI, the agent immediately knows about it.
    
- When the agent performs an action, the result appears instantly in the UI.
    

The agent and the interface are always working with the same state.

### The app’s interface can appear inside the conversation

The entire app can be operated through chat, but users are not limited to text responses. The agent can bring interactive parts of the app directly into the conversation.

For example, if I say, “Show me my to-dos,” the agent can display the complete, fully interactive to-do interface inline in the chat.

The agent can also navigate and control the larger app. I could ask it to open the to-do page, and the layout could respond by moving the conversation into a side panel while making the to-do interface the primary focus.

### The app can connect to external agents

Agent-Native apps are not limited to their built-in chat. By adding `/mcp` to an Agent-Native app’s URL, users can connect its capabilities to compatible external agents, such as ChatGPT or Claude.

These apps can also support agent-to-agent communication, or A2A. Specialized agents can discover one another, exchange information, coordinate tasks, and update the same underlying application state.

The UI, built-in agent, and external agents are not separate products. They are different ways of accessing the same application and capabilities.

### Everything is powered by actions

Under the hood, the Agent-Native framework organizes application behavior into reusable actions. The same action can power the UI, agent tools, HTTP endpoints, MCP connections, A2A communication, and command-line interfaces.

Because the interface and agents share the same actions, a feature added to the app can become available to both without implementing its business logic twice.

### Building an agent-first app

The open-source, MIT-licensed Agent-Native framework provides a starting point for building this type of application:

```bash
npx @agent-native/core@latest create todo-app --template chat
```

In short, an agent-first app gives users the full capabilities of an agent and the precision of a traditional interface. At any moment, they can choose to click, type, speak, or let another agent take action—and every interaction remains synchronized.

_Summarized and adapted from [“How (and why) to build agent-first apps” by Builder.io](https://www.builder.io/blog/agent-first-apps)._
https://www.builder.io/blog/agent-first-apps