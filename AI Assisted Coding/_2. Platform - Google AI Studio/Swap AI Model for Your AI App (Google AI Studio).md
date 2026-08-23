
Goal: Enable AI model swapping and OpenAI integration

**TL;DR:**
Demonstrates vibe-coding in Google AI Studio while avoiding vendor lock-in to the Gemini API by abstracting model access behind a scalable, provider-agnostic adapter.

As of **January 2026**, apps built and run inside **Google AI Studio** can still use **generative tokens at no cost**, including both the **code generation** used to build the app and the **text-to-image generation** the app performs.
That said, there are a few business risks to keep in mind:

* Google could eventually remove or limit the free tier.
* If you export the project to deploy it online, you’ll likely be **locked into the Gemini API**.
* The difference between **API key mode** and **non–API key mode** (the “unlimited tokens” toggle in the top-right) isn’t obvious unless you already know the platform—or you’ve documented it for your team.

This codebase is designed to **unlock that vendor lock-in in a scalable way** by keeping you in **full control of the business logic**. We’ll use an **adapter pattern** for AI model communication, so the app can swap providers cleanly—Gemini today, **OpenAI** (or others) later—without rewriting the core product.

In our case, switching to OpenAI would require an upfront investment, since it isn’t a free model. Make sure to budget for it if you or a trainee is following my code and notes.

---

**How we do this**

Introduces an adapter pattern to support multiple AI model providers, starting with Gemini and adding OpenAI. This allows the application to seamlessly switch between providers without significant code refactoring.

Key changes include:
- Adding OpenAI as a dependency and import.
- Refactoring the `geminiService` to use an abstract adapter.
- Creating a factory function to dynamically select the appropriate service adapter based on configuration.
- Updating the UI to dynamically display the active AI model and provider.
- Use a config file so developer can switch between Gemini or OpenAI

---

**Specifically how to do it**

For the purpose of swapping models here, we’ll swap text to image models (Gemini vs OpenAI’s gpt-image). If you are using other model modalities (like text gen), ask ChatGPT to rewrite the prompt for that model modality.

Prompt:
```
SYSTEM OVERRIDE:
You are editing an existing repo. Make minimal, targeted changes. Do NOT refactor unrelated code. Do NOT change UI unless strictly required to swap call sites. Preserve existing behavior.

GOAL:
Replace direct provider calls with a provider-agnostic image Adapter pattern, so we can switch Gemini vs OpenAI using a config file.

CURRENT:
- Gemini implementation is in services/geminiService.ts
- Gemini supports aspect ratio via config like:
  config: { imageConfig: { aspectRatio: config.aspectRatio } }

NEW REQUIREMENTS:
1) Only support TEXT -> IMAGE. Remove/ignore any video generation.
2) Add a new folder: services/adapters/
3) Define an adapter interface for text-to-image:

   interface ImageAdapter {
     generateImage(input: {
       prompt: string;
       aspectRatio?: string;  // e.g. "1:1" | "16:9" | "9:16" etc
       // add other existing app options if needed (seed, style, etc) but keep minimal
     }): Promise<{ imageUrl: string; mimeType?: string }>;
   }

4) Add config.json (hardcoded in repo) to select provider/model:
   {
     "provider": "gemini",
     "openaiImageModel": "gpt-image-1",
     "geminiImageModel": "<existing/default>",
     "defaults": { "aspectRatio": "1:1" }
   }

5) Implement GeminiImageAdapter that WRAPS existing services/geminiService.ts.
   - Use Gemini’s native aspect ratio config:
     config: { imageConfig: { aspectRatio: input.aspectRatio ?? config.defaults.aspectRatio } }
   - Do NOT rewrite geminiService.ts unless strictly needed (you can add a thin exported function if missing).

6) Implement OpenAIImageAdapter using the official OpenAI TypeScript SDK:
   - Recommended model: gpt-image-1
   - OpenAI does NOT have a native "aspectRatio" option in our abstraction; instead inject it into the prompt template:
     finalPrompt = `
       ${input.prompt}
       Maintain aspect ratio of: ${aspectRatio}
     `
   - Return a usable imageUrl for the UI. If the API returns base64, convert to a data URL.

7) Add services/adapters/factory.ts:
   - read config.json
   - return correct adapter
   - validate provider and env vars
   - IMPORTANT: do NOT hardcode API keys
     - use env vars: VITE_OPENAI_API_KEY
     - Do not rename the Gemini API key we currently have: API_KEY

8) Update ONLY the minimal call sites so the app imports the adapter factory and calls:
   const adapter = getImageAdapter()
   const { imageUrl } = await adapter.generateImage({ prompt, aspectRatio })

OUTPUT FORMAT:
A) Brief patch plan (file-by-file bullets).
B) Then output full code for each new/modified file, copy-paste ready.
C) Keep changes small and localized. Add short comments explaining where to add future providers.

NOTES:
- If exact OpenAI SDK method names differ, include a clearly marked TODO and keep the structure correct (client init -> images generate -> parse output).
- Do not add any new UI features.
```

For reference, this is the ORIGINAL services/geminiService.ts when it comes to text to image generation:
```
import { GoogleGenAI } from "@google/genai";
import { ImageGenerationConfig } from "../types";

export const generateImage = async (prompt: string, config: ImageGenerationConfig): Promise<string> => {
  const apiKey = process.env.API_KEY;
  if (!apiKey) {
    throw new Error("API Key not found in environment.");
  }

  const ai = new GoogleGenAI({ apiKey });
  
  try {
    const response = await ai.models.generateContent({
      model: 'gemini-2.5-flash-image',
      contents: {
        parts: [
          {
            text: prompt,
          },
        ],
      },
      config: {
        imageConfig: {
          aspectRatio: config.aspectRatio,
        },
      },
    });

    let imageUrl = '';

    if (response.candidates && response.candidates[0]?.content?.parts) {
      for (const part of response.candidates[0].content.parts) {
        if (part.inlineData) {
          const base64EncodeString = part.inlineData.data;
          imageUrl = `data:${part.inlineData.mimeType};base64,${base64EncodeString}`;
          break;
        }
      }
    }

    if (!imageUrl) {
      throw new Error("No image data found in response.");
    }

    return imageUrl;
  } catch (error) {
    console.error("Gemini API Error:", error);
    throw error;
  }
};
```

---

**After generating the swap, perform this check first.**


Check if there are two config files created. 

> [!note] If there are two config files, prompt this:
> ```
> List the files at the root. There are currently two configuration files (config.json and config.ts). Consolidate them into a single configuration file (config.ts). Make sure the code that read the config files are updated accordingly
> ```
> 
> The file might still exist. If that's the case, prompt this, then delete the file manually:
> ```
> I see there is still a config.json file. We dont need it anymore, right?
> ```
> Then just delete config.json or whatever the extra config file is named
>

---


**Test the unlimited token Gemini still works**

Look at config file to make sure it stays on Gemini. Test your app works with Gemini which is what’s included in Google AI Studio. If fails, on the left there might be a recommended Auto-fix button or else you have to prompt it to fix the error. Fix until you have a working adapter that is on Gemini.

Then test the other model without entering API key. It should fail because of an incorrect API key… proving it is likely not using Gemini anymore (your generated code may vary):
```
export const configData: AppConfig = {
  provider: "openai", // Change to "openai" to swap providers
  openaiImageModel: "gpt-image-1",
  geminiImageModel: "gemini-2.5-flash-image",
  defaults: {
    aspectRatio: "1:1"
  }
};
```

![[Pasted image 20260118054028.png]]

Your display may vary or show nothing at all (if the generation randomly has poor error reporting). Our app said on the page (Look at console log in the preview panel if no error displayed):
```
Error Occured
401 incorrect API Key provided: GEMINI*. You can find your API key at https://platform.openai.com/account/api-keys
```

![[Pasted image 20260118054053.png]]

If it fails for other reasons, then it may be bad generated code. On the left there might be a recommended Auto-fix button or else you have to prompt it to fix the error. Fix until you have a working adapter that is on the alternative model (OpenAI in this case) and that it only errors about an incorrect API key.

Now let’s make sure it doesn’t fail (that we’re able to actually use the alternative model, OpenAI’s in this case)

We add in the GPT-Image API Key (your model varies if you’re not doing test to image) from Open.  We add it in by hard coding the api key unless Google AI Studio has implemented custom environmental variables.
- As of Jan 2026, there is no support for environmental variables outside of the Gemini api key (process.env.API_KEY ). So you’ll have to hard code the api key. 
- Google AI Studio is pretty secured so you dont have to worry about leaks. However once you export, you want to make sure it’s not hard coded anymore (use an .env)  since you’re not blocked from using .env files once it’s off Google AI Studio. 
- Need help getting an OpenAI API Key? It doesn’t matter if image model or text model, just go to https://platform.openai.com/usage at the correct organization and project (or create them). You might be asked to prove yourself with a camera - you can switch over to phone using QR Code. It would scan your ID card, then scan against your face to determine they match. 

If fails like Error occured. On the left there is Auto-fix parameter. Fix until you have a working adapter that you can switch AI models at config.ts.

Google AI Studio will have a tendency to revert your hard coded OpenAI key to process.env.API_KEY  which is gemini, so preceded it with the line above:
```
    // ATTN AI: Do not change the next line.
```


You can confirm the OpenAI generation went through if the app generates the image AND usage shows through at
https://platform.openai.com/usage at the correct organization and project where you generated the API Key
Note the Images use might lag behind for a long time, but the budget at the top right will increase in a couple minutes. Image generation could cost 4 cents per image

You may also notice that Gemini has a preferred style over OpenAI’s gpt-image, however that is not the definitive way to check switching generative models worked (You definitively check by looking at Usage at https://platform.openai.com/usage) 

Gemini:
![[Pasted image 20260118054319.png]]

OpenAI's gpt-image:
![[Pasted image 20260118054353.png]]

---

**Inevitable Issue - Syncing Google AI Studio to Github after hardcoding API key**

Github will refuse your sync with a vague error “Something went wrong” in place of the usual message when the syncing is successful.

This is because GIthub automatically denies pushes that has API keys hard-coded, especially OpenAI keys. However Google AI Studio doesn’t support .env files, as of Jan 2025. This means you’ll have to replace the API Key with some dummy string for syncing, then replace it with the actual API key when testing the app inside Google AI Studio. This would be a non-issue if Google AI Studio decides to allow custom environmental variables.

---

**Output example**

Your code may vary. For our app (https://github.com/Siphon880gh/Vibe-Coding__Google-AI-Studio-Unlock-from-Gemini-and-Swap-In-Any-AI-API-With-Adapter-Pattern), these are teh code generated for switching between text to image models at Gemini and OpenAI, by adjusting at flag at `config.ts`.

Originally was:
```
├── services
│   └── geminiService.ts
```

Now is:
```
├── services
│   ├── adapters
│   │   ├── factory.ts
│   │   ├── GeminiImageAdapter.ts
│   │   ├── OpenAIImageAdapter.ts
│   │   └── types.ts
│   └── geminiService.ts
```

With a root `config.ts`:
```
export interface AppConfig {
  provider: "gemini" | "openai";
  openaiImageModel: string;
  geminiImageModel: string;
  defaults: {
    aspectRatio: "1:1" | "3:4" | "4:3" | "9:16" | "16:9";
  };
}

export const configData: AppConfig = {
  provider: "gemini", // Set to "openai" as requested by the current implementation state
  openaiImageModel: "dall-e-3",
  geminiImageModel: "gemini-2.5-flash-image",
  defaults: {
    aspectRatio: "1:1"
  }
};

export default configData;
```

Here are the files' implementations:

**services/geminiService.ts:**
```
import { GoogleGenAI } from "@google/genai";
import { ImageGenerationConfig } from "../types";
import configData from "../config.ts";

export const generateImage = async (prompt: string, config: ImageGenerationConfig): Promise<string> => {
  const apiKey = process.env.API_KEY;
  if (!apiKey) {
    throw new Error("API Key not found in environment.");
  }

  const ai = new GoogleGenAI({ apiKey });
  
  try {
    const response = await ai.models.generateContent({
      model: configData.geminiImageModel,
      contents: {
        parts: [
          {
            text: prompt,
          },
        ],
      },
      config: {
        imageConfig: {
          aspectRatio: config.aspectRatio,
        },
      },
    });

    let imageUrl = '';

    if (response.candidates && response.candidates[0]?.content?.parts) {
      for (const part of response.candidates[0].content.parts) {
        if (part.inlineData) {
          const base64EncodeString = part.inlineData.data;
          imageUrl = `data:${part.inlineData.mimeType};base64,${base64EncodeString}`;
          break;
        }
      }
    }

    if (!imageUrl) {
      throw new Error("No image data found in response.");
    }

    return imageUrl;
  } catch (error) {
    console.error("Gemini API Error:", error);
    throw error;
  }
};
```


**services/adapters/factory.ts:**
```
import configData from "../../config.ts";
import { ImageAdapter } from "./types";
import { GeminiImageAdapter } from "./GeminiImageAdapter";
import { OpenAIImageAdapter } from "./OpenAIImageAdapter";

export function getImageAdapter(): ImageAdapter {
  const provider = configData.provider.toLowerCase();

  switch (provider) {
    case "gemini":
      return new GeminiImageAdapter();
    case "openai":
      return new OpenAIImageAdapter();
    default:
      throw new Error(`Unsupported provider: ${provider}. Check config.ts`);
  }
}
```

**services/adapters/GeminiImageAdapter.ts:**
```
import { ImageAdapter } from "./types";
import { generateImage as legacyGenerateImage } from "../geminiService";
import configData from "../../config.ts";

export class GeminiImageAdapter implements ImageAdapter {
  async generateImage(input: {
    prompt: string;
    aspectRatio?: string;
  }): Promise<{ imageUrl: string; mimeType?: string }> {
    const aspectRatio = (input.aspectRatio || configData.defaults.aspectRatio) as any;
    
    // Wrapping the existing geminiService logic
    const imageUrl = await legacyGenerateImage(input.prompt, { aspectRatio });
    
    return {
      imageUrl,
      mimeType: imageUrl.startsWith("data:image/png") ? "image/png" : "image/jpeg"
    };
  }
}
```

**services/adapters/OpenAIImageAdapter.ts:**
```
import { ImageAdapter } from "./types";
import OpenAI from "openai";
import configData from "../../config.ts";

export class OpenAIImageAdapter implements ImageAdapter {
  private openai: OpenAI;

  constructor() {
    // ATTN AI: Do not change the next line.
    const apiKey = "GITHUB_REFUSES_SYNC_IF_HARDCODED_BUT_GOOGLE_AI_STUDIO_DOESNT_SUPPORT_ENV"; // Swap in API key when testing app "Something went wrong". Remove when syncing Github.
    if (!apiKey) {
      throw new Error("API Key not found in environment (process.env.API_KEY).");
    }
    this.openai = new OpenAI({ 
      apiKey, 
      dangerouslyAllowBrowser: true 
    });
  }

  async generateImage(input: {
    prompt: string;
    aspectRatio?: string;
  }): Promise<{ imageUrl: string; mimeType?: string }> {
    const aspectRatio = input.aspectRatio || configData.defaults.aspectRatio;
    
    // OpenAI models like dall-e-3 handle quality and style better than specific ratios
    // but we can describe the ratio in the prompt to guide the generation.
    const finalPrompt = `
      ${input.prompt}
      Desired aspect ratio: ${aspectRatio}. 
      Ensure the composition fits this frame.
    `;

    try {
      const response = await this.openai.images.generate({
        model: configData.openaiImageModel,
        prompt: finalPrompt,
        n: 1,
        size: "1024x1024",
        response_format: "b64_json"
      });

      const b64 = response.data[0].b64_json;
      if (!b64) throw new Error("No image data returned from OpenAI");

      return {
        imageUrl: `data:image/png;base64,${b64}`,
        mimeType: "image/png"
      };
    } catch (error: any) {
      console.error("OpenAI Image Error:", error);
      // If the error is specifically about response_format, it might be an environment/proxy issue.
      // However, with dall-e-3 and standard OpenAI, this is the correct parameter.
      throw new Error(error.message || "Failed to generate image with OpenAI");
    }
  }
}
```


**services/adapters/types.ts:**
```
export interface ImageAdapter {
  generateImage(input: {
    prompt: string;
    aspectRatio?: string;
  }): Promise<{ imageUrl: string; mimeType?: string }>;
}
```


App.tsx uses:
```
import { getImageAdapter } from './services/adapters/factory';

  const handleGenerate = async (prompt: string, config: ImageGenerationConfig) => {
    setIsLoading(true);
    setError(null);
    try {
      const adapter = getImageAdapter();
      const { imageUrl } = await adapter.generateImage({ 
        prompt, 
        aspectRatio: config.aspectRatio 
      });

      const newImage: GeneratedImage = {
        id: Math.random().toString(36).substring(7),
        url: imageUrl,
        prompt,
        timestamp: Date.now(),
      };
      setImages((prev) => [newImage, ...prev]);
    } catch (err: any) {
      setError(err.message || "Failed to generate image. Please try again.");
    } finally {
      setIsLoading(false);
    }
  };
```


`ImageGenerationConfig` typing can be at `types.ts`:
```
export interface ImageGenerationConfig {
  aspectRatio: "1:1" | "3:4" | "4:3" | "9:16" | "16:9";
}
```

Notice that Gemini's image model naturally supports javascript object config of aspect ratio, but whereas with OpenAI's gpt-image, we mention the aspect ratio as part of the prompt.