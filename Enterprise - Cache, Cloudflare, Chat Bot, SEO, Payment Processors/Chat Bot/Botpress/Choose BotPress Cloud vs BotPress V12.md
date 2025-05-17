### TL;DR:
* **Botpress Cloud**:
  * Actively maintained with new features and integrations
  * Freemium model with usage limits (e.g. 2,000 messages/month)
  * Supports **Autonomous Nodes** — AI can dynamically generate conversation flows on the fly
* **Botpress v12 (Self-Hosted)**:
  * No longer receiving feature updates
  * Fully free with **unlimited usage**
  * Requires manual creation of each step and transition in the conversation flow

---

## Choosing Your Botpress Version: Cloud vs Self-Hosted

### 🚀 Cloud-First with Botpress v12+

Starting with version 12, **Botpress has shifted to a SaaS-first model**. The CLI now requires `bp login` to link your project with the cloud, directing users to **Cloud Studio**—the primary interface for building, deploying, and managing bots.

This approach mirrors platforms like Voiceflow or ChatGPT's Custom GPTs, emphasizing ease of use via a centralized cloud experience.

If you're okay with the free tier—or may consider upgrading later—here are your options:

#### Use the CLI:

```bash
bp init
bp deploy
```

These commands initialize and deploy your bot to the cloud.

#### Or work directly in the Cloud Studio:

👉 [https://app.botpress.cloud](https://app.botpress.cloud/)

#### Cloud Free Plan Includes:

- Up to **2,000 messages/month**
- Optional paid plans for more messages or advanced features  
    [Discord source](https://discord.botpress.com/t/16721340/quick-question-is-botpress-completely-free-if-you-self-host-)

---

### 🛠 Prefer Completely Free? Go Self-Hosted

If you want a **completely free** setup, you can self-host Botpress v12 in one of these ways:

- Build from source: https://v12.botpress.com/going-to-production/deploy/
	- You will need the GitHub repo: [https://github.com/botpress/v12](https://github.com/botpress/v12)
- Build from Docker image: https://v12.botpress.com/going-to-production/deploy/docker-compose
	- You will need the image name from Docker Hub which is `botpress/server`
	- You can read about it at their Docker Hub page https://hub.docker.com/r/botpress/server

This version gives you **unlimited usage** but requires more hands-on setup and infrastructure management.

Still, **Cloud Studio could be the right choice** if your project requires features only available in the cloud version.

#### ⚠️ Self-Hosted Limitations

- ❌ **No Autonomous Nodes**  
    Cloud-only feature that lets AI handle multi-step conversations in one prompt-driven node. Without this, you’ll need to manually build each step and transition of the chat conversation.
    
- ❌ **Limited Ongoing Support**  
    Botpress is focusing new features, integrations, and messaging platform support exclusively on the **Cloud version**. The self-hosted version receives limited updates.

Note: When asking ChatGPT as of 5/2025, it will erroneously say that Botpress v12 does have Autonomous nodes.