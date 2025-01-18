There are two main endpoints at OpenAI:
- Chat Completion (Chat thread on newest models)
- Completion (Single prompt and response on older models)

Keep in mind that Chat Completion DOES require you to send back the previous prompt and response with each API call if you want to keep the context for further responses. You can, however, truncate those previous messages. You do need to distinguish if a chat belonged to the code/backend/frontend/user (which is role user) or the OpenAI API (which is role assistant)

---

### **Which One to Use?**

- If your task involves dialogue, role-based communication, or maintaining context across multiple turns, use **Chat Completions**.
- If you just need standalone text generation without structured conversation, use **Completions**.

As of 2025, the **Chat Completions endpoint** is recommended for most use cases, as it supports the latest models like GPT-4 and GPT-3.5, while the Completions endpoint is better for legacy use cases or specific workflows requiring older models.

---

### Roles

|   |   |   |
|---|---|---|
|Feature|Chat Completions|Completions|
|**API Input Format**|`messages` array|Single `prompt` string|
|**Role Management**|Uses `system`, `user`, `assistant` roles|No role separation|
|**Context Handling**|Tailored for multi-turn dialogue|Single-turn or single-output focus|
|**Models**|GPT-4, GPT-3.5|Text-specific models (e.g., `text-davinci-003`)|
|**Flexibility**|Structured, chat-specific|More flexible, but less structured|

---

### Syntax

You can either use LangChain or OpenAI's SDK. Or you can use cURL. For this tutorial, we will use NodeJS and provide examples of Chat Completion and Completion, on LangChain or OpenAI:

Below are some examples showing how to use OpenAI’s Chat Completions (the `chat/completions` endpoint) and traditional Completions (the `completions` endpoint) in Node.js. We’ll walk through both scenarios:

1. **Using LangChain**
2. **Without LangChain** (plain Node.js + official OpenAI client library)

---

#### 1. Using LangChain

LangChain is an abstraction layer that makes it easier to work with various LLM providers (including OpenAI). It provides common helper classes for prompts, chains, memory, etc.

##### 1.1 Chat Completions (OpenAI Chat Models)

```js
// Install the necessary packages:
// npm install langchain openai dotenv

require('dotenv').config();
const { OpenAI } = require('langchain/llms/openai');
const { ChatOpenAI } = require('langchain/chat_models/openai');
const { HumanChatMessage, SystemChatMessage } = require('langchain/schema');

async function runChatCompletion() {
  // Example for Chat Completions endpoint using LangChain
  const chat = new ChatOpenAI({
    openAIApiKey: process.env.OPENAI_API_KEY,
    temperature: 0.7, 
    modelName: 'gpt-3.5-turbo', 
  });

  const messages = [
    new SystemChatMessage("You are a helpful assistant."),
    new HumanChatMessage("Hello! How are you today?")
  ];

  const response = await chat.call(messages);
  console.log("Chat completion:", response.text);
}

runChatCompletion();
```

##### 1.2 Traditional Completions (OpenAI Text Models)

```js
// npm install langchain openai dotenv

require('dotenv').config();
const { OpenAI } = require('langchain/llms/openai');

async function runCompletion() {
  // Example for completions endpoint using LangChain
  const model = new OpenAI({
    openAIApiKey: process.env.OPENAI_API_KEY,
    temperature: 0.7,
    modelName: 'text-davinci-003', // Or any other text-based model
  });

  const prompt = "Write a short poem about the sunrise.";
  const response = await model.call(prompt);
  console.log("Completion:", response);
}

runCompletion();
```

> **Notes (LangChain)**
> 
> - `ChatOpenAI` is a wrapper around OpenAI’s Chat Completions API.
> - `OpenAI` (in `langchain/llms/openai`) is a wrapper around the traditional Completions API.
> - You can also integrate things like “memory” for conversational state, or chain multiple steps with prompts in LangChain.

---

#### 2. Without LangChain

If you don’t need the abstractions and helpers of LangChain, you can directly call OpenAI endpoints using the [official OpenAI Node.js client](https://github.com/openai/openai-node).

### 2.1 Installation

```bash
npm install openai dotenv
```

> We’re using `dotenv` for loading the API key from an `.env` file in these examples.

##### 2.2 Chat Completions

```js
require('dotenv').config();
const { Configuration, OpenAIApi } = require('openai');

async function runChatCompletion() {
  const configuration = new Configuration({
    apiKey: process.env.OPENAI_API_KEY,
  });
  const openai = new OpenAIApi(configuration);

  try {
    const response = await openai.createChatCompletion({
      model: 'gpt-3.5-turbo',
      messages: [
        { role: 'system', content: 'You are a helpful assistant.' },
        { role: 'user', content: 'Hello! How are you today?' },
      ],
      max_tokens: 100,
      temperature: 0.7,
    });

    // The chat response is in response.data.choices[0].message.content
    console.log('Chat completion:', response.data.choices[0].message.content);
  } catch (error) {
    console.error('Error creating chat completion:', error);
  }
}

runChatCompletion();
```

##### 2.3 Traditional Completions

```js
require('dotenv').config();
const { Configuration, OpenAIApi } = require('openai');

async function runCompletion() {
  const configuration = new Configuration({
    apiKey: process.env.OPENAI_API_KEY,
  });
  const openai = new OpenAIApi(configuration);

  try {
    const response = await openai.createCompletion({
      model: 'text-davinci-003',
      prompt: 'Write a short poem about the sunrise.',
      max_tokens: 100,
      temperature: 0.7,
    });

    // The text completion is in response.data.choices[0].text
    console.log('Completion:', response.data.choices[0].text);
  } catch (error) {
    console.error('Error creating completion:', error);
  }
}

runCompletion();
```


- **LangChain** simplifies prompt orchestration, conversation state management, and chaining multiple LLM calls together. It’s useful if you need advanced features like memory, “agents,” or a chain-of-thought workflow.
- **Plain Node.js + openai** is perfectly fine if you only need direct calls to OpenAI’s endpoints without the abstraction layer. It gives you more control but requires writing any additional logic (prompt chaining, memory, etc.) yourself.

Choose the approach that fits your project needs:

- If you want to build complex multi-step LLM applications, consider **LangChain**.
- If you want something minimal, use **openai** directly.