Prompt:
```
In Langflow, I have this custom component that {DESCRIBE PURPOSE} and it does this by {DESCRIBE HOW IT WORKS}
```

Subsequent prompt if need control fields for easier configuring at the canvas (without having to go back into the code):
Eg.
```
Works great, but notice 'Im hard coding the string that input_text gets tested against, and I'm hard coding the two possible output_text values based on the condition. I would like to have controls for these:  
- the text we are matching against  
- the override message A if true  
- the override message B if false
```