
When code too complex, asking AI to implement a new feature, it is likely going to mess up. So you ask AI to provide context in the current chat.

Use this prompt:
```
We’re about to implement a new feature, but the codebase is complex and I want to avoid mistakes caused by shallow context or overlooking the true entry point.

A related feature to analyze is: ___

Please respond by doing all of the following:

1. **Trace the full code path** for the related feature
    
    - For example: from user action → event → handlers → downstream function calls.
        
2. **Identify the true entry point** where the behavior actually starts.
    
3. **Analyze all related functions and modules** that participate in this flow.
    
4. **Explicitly map the call chain** and clearly state any assumptions you rely on.
    
5. **Confirm how data, dependencies, and navigation** move through the system along this path.
```

Then in the same chat thread:
```
{request_your_feature}
```