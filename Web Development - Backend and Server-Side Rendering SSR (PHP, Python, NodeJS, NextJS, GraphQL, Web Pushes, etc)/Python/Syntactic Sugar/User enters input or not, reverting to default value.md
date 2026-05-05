```
user_input = input("Name: ")
name = user_input or 'N/A'
print(name)
```

That's shortcircuiting with an OR operator. If first operand (user_input) is falsy, it continues evaluating second operand 'N/A', which is truthy (for having characters in a string), and the shortcircuiting returns the truth value

https://www.youtube.com/shorts/-VuLJVt-FXw