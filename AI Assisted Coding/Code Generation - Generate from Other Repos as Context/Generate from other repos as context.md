Let's just say you're creating a LeetCode coach/trainer app.

Prompt this:
- Adjust desired repos
```
Add a /context folder that git clones repositories that have leetcode and leetcode type problems with solutions and explanations already

Make sure to gitignore those git clones in order to save space. But create a README.md and clone.sh in /context folder in case I need to manually clone them. README.md will describe what those repos are.
```

Then you can prompt later:
- Adjust goal
```
Use the context/ repos to create coaching sessions on LeetCode in our app
```