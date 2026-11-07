What you can do:
- Use local machine for computer
- Control local machine computer remotely to start or manage coding agent

---

You leverage these features by enabling them at Cursor Settings

![[Pasted image 20261106185007.png]]

## Cursor Settings

|Setting|What it does|FAQ|Who needs it?|
|---|---|---|---|
|Enable Self-hosted Machines|Allows Cursor Cloud Agents to execute coding tasks on infrastructure you control instead of Cursor's cloud machines.|Q: Are these OpenAI machines? A: No. These are machines you or your organization provide, such as private servers or workstations.|Teams or developers managing their own infrastructure.|
|Enable My Machines|Connects your personal computers to Cursor so agents launched from web, mobile, Slack, or API can work on them.|Q: Can I use my phone to start an agent on my home laptop? A: Yes. Your laptop must be powered on, connected to the internet, and running the Cursor worker.|Individual developers who want remote access to their coding environment.|
|View My Machines|Displays your connected computers and provides CLI commands to connect additional ones.|Q: Can I manage multiple computers? A: Yes. You can register and manage multiple supported machines.|Anyone using My Machines.|

My Machines refers to your own computers, such as your home MacBook or desktop PC—not computers hosted by OpenAI or Cursor.

For example, you can use your phone to launch a Cursor agent that works on a project stored on your home MacBook, provided the MacBook is running and its Cursor worker is connected.


## Example: Starting an agent from your phone

![[Pasted image 20261106184843.png]]

The model runs remotely, while commands, file changes, and tests run on your computer.

Important distinction: Cursor's My Machines is not a feature for managing OpenAI servers, and it doesn't turn your laptop into a locally hosted AI model. It's a way to let Cursor's remotely launched agents work in your own development environment.

Also, My Machines is not full remote desktop access. You're giving an AI agent access to coding tools on your machine, not controlling the entire graphical desktop as you would with Chrome Remote Desktop.