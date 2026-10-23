Let's just say you're creating a LeetCode coach/trainer app. You chose **not** to hunt down the repos yourself and saving it into a context/ folder for AI to generate your app from. AI can hunt them down for you. In this example, you ask AI to look for Leetcode question banks and solutions at Github, then pull them into your context/ 

Prompt this:
- Adjust desired repos
```
Add a /context/apps folder that git clones repositories that have leetcode and leetcode type problems with solutions and explanations already

Make sure to gitignore those git clones in order to save space. But create a README.md and clone.sh in /context folder in case I need to manually clone them or I'm pulling a fresh copy of my repo (which would not have /context/apps/*). That context folder's README.md will describe what those repos are.
```

Then you can prompt later:
- Adjust goal
```
Use the context/ repos to create coaching sessions on LeetCode in our app
```