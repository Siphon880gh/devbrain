  
Doesn’t work in Google AI Studio as of Jan 2026

Fails with Google AI Studio

It would go ahead and still one-shot all the code.
![[Pasted image 20260327025053.png]]

---

  

This converts a milestone-based approach into a one-shot execution for Google Al Studio. You might choose a one-shot approach if you don't want to spend time validating each milestone on every generation, or if you want to leverage Google Al Studio's unlimited-token setup (as of January 2026)-either to build the app with unlimited prompts, or to use Al generation as a feature inside the app itself.

Google Al Studio will generate all in ONE SHOT even if you have multiple milestone plans concatenated into one prompt

Prompt is:
```
Generate a "Prompt Google AI Studio.md" that would have all the app plans and milestones in one large prompt for generating code at Google AI Studio.
```

This:
![[Pasted image 20260327030117.png]]

-> Converts into a MD file that you place into Google AI Studio. Then ask Google AI Studio to run the prompt at the MD file.