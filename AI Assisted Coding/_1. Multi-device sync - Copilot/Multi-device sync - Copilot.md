Reminder: Copilot often associated with Microsoft, Github, and VS Code

Start your CLI sessions on your computer. Then when you're walking away from the computer, control your CLI sessions from the web
![[Pasted image 20260822234327.png]]
What GitHub has done now is unify a lot of Copilot **agent sessions** under the repo’s **Agents** tab. In particular, local sessions originating from **VS Code, Copilot CLI, JetBrains, or the Copilot app** can be synced with your GitHub account. GitHub says local sessions are **unshared by default**, while cloud-agent sessions are visible to collaborators with repo access.

---

For VS Code specifically, the workflow can be:
**VS Code Copilot → agent/CLI session → GitHub repo → Agents**

If you enable remote control from VS Code, you can run `/remote on`; GitHub then creates a linked task/session page, and that session appears in the repository's **Agents** tab.

---

The **local Copilot CLI/agent sessions that can be viewed or controlled through GitHub** is made possible with the command `copilot --remote`