Use this prompt when another app contains a feature you want to reproduce in your current app. Place the reference app inside `context/`, then describe the desired feature below. The implementation should preserve the feature’s intended behavior while adapting it to the architecture, design system, and conventions of the current app.

Prompt:
```
Inside `context/` is an app containing a feature I’d like to add to our app.

The feature is:
[Describe the feature here.]

Review how the feature is implemented in the context app, then adapt and implement it in our app. If differences in architecture, behavior, or user interface require a decision, ask me a clarifying question before proceeding.
```