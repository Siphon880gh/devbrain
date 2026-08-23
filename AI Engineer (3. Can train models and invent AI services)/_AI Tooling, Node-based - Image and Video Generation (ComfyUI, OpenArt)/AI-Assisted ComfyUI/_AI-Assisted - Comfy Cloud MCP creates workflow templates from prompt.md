**What this is:**
- You dont have to work with nodes inside ComfyUI to generate images and videos because you can have AI build those nodes for you
- How? You give Codex or ComfyUI access to the online version of ComfyUI via your ComfyUI account. Setup the MCP. Make your image or video prompt. Generates for you.

Requirements:
- ComfyUI Cloud (Web version is fine. Desktop version not needed because as of now, Claude Code and Codex doesn’t control your computer)
- Terminal to open Codex or Claude Code (Run command Codex or Claude)

---

1. Sign up for ComfyUI Cloud. They have a free version
2. Add the Comfyui MCP to your Claude Code or Codex (both on computer).

Install Codex? (OpenAI’s)
```
npm install -g@openai/codex
```

Let’s add the ComfyUI MCP:
```
codex mcp add comfy-cloud-url -url https://cloud.comfy.org/mcp
```
^ Adds the MCP

Authorize the MCP:
```
codex mcp login comfy-cloud
```

Visit the URL terminal prints out:
![[Pasted image 20260823011524.png]]

![[Pasted image 20260823011542.png]]

4. Confirm it’s added and authorized:
```
codex mcp list
```

1.  It may ask you to login / Oauth2
2. Then ask Codex or Claude Code to use the Comfyui MCP
	- Firstly, run the CLI harness: Eg. `codex`
	  ![[Pasted image 20260823012920.png]]
	- You will prompt to save as a workflow I can use, followed by Video Prompt in the same prompt. Tell it don’t generate it yet
	- Why: If you simply tell Codex "generate an image," you may not see a new workflow appear in the Comfy Cloud canvas. Codex can use an MCP generation tool and run a workflow behind the scenes without saving it as one of your editable workflows.
	- Prompt is:
```
Use the Comfy-Cloud MPC. 

Use the Comfy Cloud MCP to create a reusable workflow for me. Save the workflow with an appropriate name instead of only running an ephemeral generation. 

Do not generate anything yet. After saving it, tell me the exact workflow name and URL so I can open it in Comfy Cloud.

Video prompt: 
Create a new workflow that generates a polished 4-10 second animated brand video using the logo from https://example.com/assets/logo.png. The animation should visually communicate our Agency's core business services-Al automation for businesses, SEO, content writing, ADA accessibility, and coding/web development-using smooth, modern transitions, subtle motion graphics, and clear visual symbolism for each service. Keep the logo as the central brand element throughout the animation, with a professional, futuristic, technology-focused aesthetic suitable for a digital agency. The final sequence should feel cohesive rather than like five disconnected scenes, quickly showing how we combine automation, marketing, accessibility, content, and development into one integrated service offering.
```

4. When it says the workflow is created, ask it for the URL. Opening the URL. That will open to your logged in session of ComfyUI Cloud on your computer and asks if you want to import the workflow (The workflow url created is not attached to your logged in account)
   ![[Pasted image 20260823013335.png]]
![[Pasted image 20260823013602.png]]

5. Look at the workflow / Run it to generate the image or video.

Should work smoothly because dependencies are handled on the cloud side. However if you’re on free trial running a premier model, it may require you to actually be on a paid plan - you’ll see this at the Run button.

![[Pasted image 20260823013958.png]]

In this case, the button is a "Subscribe to run". This is because I'm on the free trial on Comfy Cloud

Note: You can also run ComfyUI locally and setup a MCP there. Local ComfyUI supports MCP