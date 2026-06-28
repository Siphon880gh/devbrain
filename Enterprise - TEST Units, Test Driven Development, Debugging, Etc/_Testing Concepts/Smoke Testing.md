Smoke testing is a **quick, broad check** to confirm that the most important parts of an app still work after a change.

The goal is not to test everything deeply. The goal is to answer a simple question:

**“Does the app still basically work?”**

For example, after a deployment or code change, a smoke test might check that:

- the app starts
    
- the homepage loads
    
- login works
    
- the main dashboard opens
    
- core API requests respond
    
- the database connection works
    

If any of those fail, the build is considered unstable and needs attention before deeper testing continues.

## Why it matters

Smoke testing helps teams catch **major breakages early**. Instead of spending time doing full QA on an app that is already broken, the team finds out right away whether the build is even worth testing further.

It is especially useful after:

- new deployments
    
- major merges
    
- environment changes
    
- dependency upgrades
    
- infrastructure updates
    

## Is it meant to prevent a full app rewrite?

Not exactly.

Smoke testing is **not mainly about preventing a full app rewrite**. It is more about preventing teams from moving forward with a broken build.

That said, it can indirectly help avoid messy situations that lead to larger rework. When teams keep making changes without basic validation, small breakages can pile up. Over time, that can create confusion, unstable code, and costly cleanup. Smoke testing reduces that risk by forcing a quick stability check first.

So the better way to think about it is:

**Smoke testing helps prevent major breakage, wasted debugging time, and unstable releases — not necessarily a full rewrite.**

## Simple example

Imagine a developer updates authentication code. Before the team does full testing, they run a smoke test:

- app boots successfully
    
- login page loads
    
- user can sign in
    
- dashboard appears
    
- logout works
    

If login fails, there is no point testing the rest yet. The build failed the smoke test.

## In short

Smoke testing is a **basic health check** for software. It verifies that the core parts of the application still function after a change. It is fast, practical, and useful for catching serious issues early before deeper testing begins.

If you want, I can also turn this into:

- a more technical version for developers
    
- a beginner-friendly version with a real-world analogy


## Leverage AI

You can ask AI to write/automate smoke testing for your app.