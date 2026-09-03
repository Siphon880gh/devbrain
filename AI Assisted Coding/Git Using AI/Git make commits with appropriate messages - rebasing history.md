Git can make multiple git commits at a current point in the codebase, especially if you haven't been making commits for many changes. It will selectively add files and relevant lines of code for different git commits

However, you can also ask that the commits will be spaced out in a way that looks like you've been organically developing the code over a certain date range. Perhaps this is for portfolio reasons

Prompt:
- Adjust the date range
```
Create or modify an AGENTS.md that plans on how to make the git commits as if we developed the code organically over time.

Make sure to tell it that we will space out the git commit time. I'd like the git commit dates to be between 1/1/26 to 2/1/26

Do not make the git commits yet. I'll run that with you later to make those git commits.
```

Then when you're ready, prompt:
```
Let's make the git commits per AGENTS.md
```