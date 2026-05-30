To learn code base, list all the features of the app.

Then prompt about a feature:
```
I'm learning the codebase of this app. To aid my understanding, let's analyze one of its features

Feature to analyze: ___

Please respond by doing all of the following:

1. **Trace the full code path** for the related feature
    
    - For example: from user action → event → handlers → downstream function calls.
        
2. **Identify the true entry point** where the behavior actually starts.
    
3. **Analyze all related functions and modules** that participate in this flow.
    
4. **Explicitly map the call chain** and clearly state any assumptions you rely on.
    
5. **Confirm how data, dependencies, and navigation** move through the system along this path.
```

Prompt for all the features in their own chat threads until you feel like you sufficiently understand the codebase.
