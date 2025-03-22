
In explaining Chrome Extension sendMessage, we can learn about Relay:
- chrome.runtime.sendMessage**: Sends one-time messages between different parts of the extension (e.g., options page → content script).
- chrome.runtime.onMessage**: Listens for incoming messages in content scripts, background scripts, or other contexts and acts on them.
- Background Scripts for Relay (Optional)**: If needed, a background script can act as a middleman to forward runtime messages to multiple content scripts
	- ^ Relay: In general programming, a "relay" is any component that passes messages or data between two other components that don’t talk to each other directly.
