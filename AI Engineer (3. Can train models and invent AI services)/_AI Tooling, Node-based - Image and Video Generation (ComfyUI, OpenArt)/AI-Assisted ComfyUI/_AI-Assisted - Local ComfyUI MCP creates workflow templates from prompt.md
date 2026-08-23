Open Extensions on local ComfyUI app:
![[Pasted image 20260823032330.png]]


Install plugin ComfyUI MCP by artokun
![[Pasted image 20260823032420.png]]


Open the left side Chat (aka comfyui-mcp or ComfyUI Agent Panel, not to be confused with the npx command):
![[Pasted image 20260823032641.png]]


Click the disconnected status:
![[Pasted image 20260823032747.png]]

Copy that npx command into terminal:
```
npx -y comfyui-mcp@latest launcher install
```


Back at local Comfy Desktop, let’s try to connect again:
![[Pasted image 20260823033131.png]]

It detects any local llm servers and frontier model desktop apps (Claude, ChatGPT etc). Select preferred method:
![[Pasted image 20260823061225.png]]

---

Check will work at the MCP console listening
![[Pasted image 20260823061253.png]]
->
![[Pasted image 20260823061305.png]]

---

Open connected status → Advanced to get ws url. That’s one of the things confirming it’ll work. Check it matches the console’s ui-bridge:
![[Pasted image 20260823061325.png]]
->
![[Pasted image 20260823061332.png]]

---

Make sure blank canvas before prompting (Otherwise it’ll take a long time to respond because it’ll be confused)

Here we write prompt: `Build a Flux txt2img graph and run it`
You can see it's building nodes and installing dependencies.

![[Pasted image 20260823061406.png]]

![[Pasted image 20260823061417.png]]

![[Pasted image 20260823061424.png]]