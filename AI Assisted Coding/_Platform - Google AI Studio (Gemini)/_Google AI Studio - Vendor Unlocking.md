 Google’s ecosystem is generous but they do shady things to encourage vendor lock-in:

- **Deployments push you toward Google Cloud Projects**, where the free tier is limited and you can start getting charged for traffic and usage. To resolve that, refer to [[Convert project to html-js-css self contained and deployable minimum files (Google AI Studio, Lovable)]]
  
- **GitHub sync can break images**

	- You _can_ sync your project to GitHub, but **images synced through GitHub may fail to load** because they appear to get reformatted in a way that works inside AI Studio but not elsewhere.
	    
	- If you **download the project directly from Google AI Studio**, the images usually come through as normal `.jpg` / `.png` files that load correctly. But of course, once you download directly, the unlimited Gemini tokens no longer works (because the API_Key environmental variable wont transfer over and the origin check won't pass).
	  
	- To resolve that, refer to [[Google AI Studio self-host website and images (Vendor Unlocking)]]

- **The “unlimited tokens” experience of your AI app is tied to the Gemini SDK.** 
	- Refactoring away from Gemini is possible, but it feels like the platform makes it inconvenient on purpose. On first glance, it's either you stick with Gemini if you want to test the app in Google AI Studio or you permanently nuke Gemini in place of another AI model if that's your business requirement when deployed.
	- To resolve that, add an adapter pattern that lets you switch between Gemini (when testing in Google AI Studio) to OpenAI (if the preferred AI). Refer to [[Swap AI Model for Your AI App (Google AI Studio)]]