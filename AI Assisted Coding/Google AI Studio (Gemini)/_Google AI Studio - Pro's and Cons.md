### Upsides of Google AI Studio

Google AI Studio is great for fast prototyping because it gives you “unlimited tokens” for code generation and provides an API key through its environment variables so your app can generate text, images, etc. 

It can create very mature apps that are 75%-90% done from one shotting (as long as your prompt is well designed)
### Downsides of Google AI Studio

But it comes with some real downsides.
#### 1) It nudges you into Google’s ecosystem (vendor lock-in)

- **Deployments push you toward Google Cloud Projects**, where the free tier is limited and you can start getting charged for traffic and usage.
    
- **The “unlimited tokens” experience is tied to the Gemini SDK.** Refactoring away from Gemini is possible, but it feels like the platform makes it inconvenient on purpose.
  
- **GitHub sync can break images**

	- You _can_ sync your project to GitHub, but **images synced through GitHub may fail to load** because they appear to get reformatted in a way that works inside AI Studio but not elsewhere.
	    
	- If you **download the project directly from Google AI Studio**, the images usually come through as normal `.jpg` / `.png` files that load correctly. But of course, once you download directly, the unlimited Gemini tokens no longer works (because the API_Key environmental variable wont transfer over and the origin check won't pass).
#### 2) It can be unpredictable when editing code

Google AI Studio often changes things you didn’t ask it to touch. It’s a bit of a dice roll:

- It may “simplify” your UI, finish features it assumes you want, or make broad edits that accidentally delete unrelated code.
- Sometimes it **ignores your project-level system instructions** or “SYSTEM OVERRIDES,” even if you clearly tell it to only make a specific change.
- The best defense is to **watch its reasoning as it works and cancel early** if you see it drifting into unrelated files.

#### 3) Restoring code can be annoying

If it messes up your repo and you need to roll back inside AI Studio, the recovery flow is painful:

- You may need to delete files in the code view, re-upload a zip using the **Plus** button, then it unzips into a nested folder.
- After that, you have to manually move everything back to the project root.