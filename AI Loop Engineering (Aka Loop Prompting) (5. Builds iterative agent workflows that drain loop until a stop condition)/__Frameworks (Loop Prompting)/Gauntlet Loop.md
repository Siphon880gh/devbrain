The Gauntlet Loop is a method for coding agents, and it's the prompt behind *Claude of Duty*, the FPS game that Claude Code built mostly by itself. The core idea is that the agent that builds something is never the one that decides it's finished. Here's how it works:

1. **Set a real bar.** Pick something concrete the agent can actually open and compare against, like a named site, repo, benchmark, or test suite. "Make it amazing" doesn't count.
2. **Split the work.** A lead agent breaks the goal into the smallest pieces that can be judged on their own. Tightly coupled parts, like shared state, schemas, or styling, stay together and get done in order.
3. **Pair each piece with a builder and a critic.** The builder changes the real artifact. Then a critic starts with a clean slate and gets only the goal, the bar, and the output, never the builder's notes or reasoning.
4. **Have the critic pick a winner.** Ideally it compares your output and the reference side by side without knowing which is which, then just says which one is better. Scores out of 10 tend to creep up every round, so they're avoided. If the reference wins, the critic names the single biggest gap, the builder fixes it, and a new critic judges again.
5. **Stop only when there's evidence.** The loop ends when your output wins, when you stop it, or when it runs out of budget. It doesn't stop after a set number of rounds. At the end, one more fresh critic checks the whole assembled product.

To use it, you run it inside a coding agent that can run code, take screenshots, and start subagents, like Claude Code, Codex, or Cursor. There are ready-made versions too: [mintuz's gauntlet-loop skill](https://github.com/mintuz/skills/blob/main/src/core/skills/gauntlet-loop/SKILL.md), a fuller one in [Yash-1511/gauntlet-loop](https://github.com/Yash-1511/gauntlet-loop/blob/main/README.md), and Shumer's own write-up at [The Gauntlet Loop](https://somethingbig.ai/gauntlet-loop).

[Watch video](https://www.youtube.com/watch?v=BNjzXcEXmg4) on the Gauntlet Loop

---

Skill:
```
# Gauntlet Loop

A build-and-judge loop (Matt Shumer's method). The builder never grades its own work. A fresh critic compares the real artifact against a concrete bar, names the single biggest gap, and the loop repeats until the artifact wins or a stop condition fires.

## 1. Capture the request
- Write the user's goal down word for word (for example `gauntlet/request.md` in the project).
- Map the project: stack, how to run it, how to test it, how to render or screenshot it. Note what can actually be executed and inspected. If the work can't be inspected yet (no run command, no test, no screenshot path), fix that first.

## 2. Set the bar
- Prefer a bar the user supplied. Otherwise propose 2 or 3 concrete, fetchable references (a named site, page, repo, benchmark, test suite, latency target) and let the user pick one.
- Reject vague bars like "make it great". A self-written rubric can support a real reference but can't replace it.
- Write a contract (`gauntlet/contract.md`) that lists the goal, the reference, the required gates (each must pass on its own, with no averaging), the evidence each gate needs, hard boundaries (for example local only, no deploys), and the stop conditions: win, the user stops it, a resource or time budget runs out, or the remaining gaps are too small to matter.

## 3. Split the work
- The lead agent breaks the goal into the smallest pieces that can be built and judged independently, and records them with their dependencies (`gauntlet/workstreams.md`).
- Keep coupled parts (shared schemas, state, rendering, styling, budgets) together and build them in order. Run only truly independent pieces in parallel.
- If splitting adds nothing, run a single loop.

## 4. Build
For each piece, start a builder subagent with the goal, the relevant bar and rules, and the real inputs. It picks the implementation, changes the real artifact, and runs the smallest checks needed to make the result inspectable (build, tests, screenshot).

## 5. Judge with a fresh critic
- Every round, start a NEW critic with fresh context. Give it only the goal, the bar, the rules, and the artifact. Never give it the builder's history, reasoning, summaries, or claims about quality.
- The critic inspects the actual output (runs it, opens it, screenshots it). Where possible it does a blind A/B comparison: labels stripped, ours vs. the reference, and it picks the better one. No scores out of 10.
- The critic returns one of:
  - `WIN`: ours is better and every gate passes, with the evidence.
  - `LOSE`: the single biggest meaningful gap, plus the one proof that would show it's closed.
  - `UNJUDGEABLE`: it couldn't inspect properly. Fix the inspection path or sharpen the bar before touching the artifact.

## 6. Loop
- On `LOSE`, send just that gap to the builder, fix it, then judge again with another fresh critic.
- Freeze a piece only on `WIN` or an explicit stop condition. There's no fixed number of rounds.
- Keep progress in a state file (`gauntlet/state.json`): rounds, verdicts, open gaps, budget used.

## 7. Integrate and run the final gauntlet
- Combine the finished pieces and run whole-product checks.
- If separately improved pieces conflict, run one smoothing pass that fixes only the integration issues.
- Give a fresh integration critic the complete artifact and the original bar. Its verdict decides whether the run succeeded.

## 8. Report honestly
- Report the outcome (won, or stopped and why), the evidence for each gate, the files changed, and any open gaps.
- Running out of budget can stop the work, but it never turns missing evidence into success.

## Portable prompt (when the user wants to paste this into another agent)
"Goal: <goal>. Bar: <concrete reference>. Divide the goal into the smallest pieces that can be improved and judged independently, keeping coupled parts together. For each piece, use a builder subagent and a separate harsh critic subagent with fresh context. The critic inspects the real output, never the builder's explanation, compares it blind against the bar, picks which is better, and if ours loses, names the single biggest gap. Fix it and judge again with a new critic. Keep looping until ours wins or I stop the run. Then run one fresh critic over the whole integrated product. Boundaries: <rules>."
```

---

How it compares to [[_Semi-Autonomous Development Mode]] (which uses epics and milestone tracking, automatic verification, and drains the loops till the end):

Spoken from the perspective of Yours or You owning the semi-autonomous development mode:

They solve different problems, so they fit together well. Your system handles staying on track over a long build: what to build next, where it left off, how much code to read, and when to commit. The Gauntlet Loop handles how good each piece gets. It decides when something is actually finished, which is a separate question from whether it runs.

**Where yours is stronger**

- **Long-running continuity.** The epic and milestone plan plus the state file let it pick up after "continue" across many sessions. The Gauntlet Loop has no plan for a whole product, just a goal and a bar.
- **Context discipline.** Reading the codebase maps before source code helps on a growing repo, because it keeps the agent from reading too much or too little. Gauntlet doesn't cover this at all.
- **Git hygiene.** It finds commit points, writes commit names, and updates the maps right before each commit.
- **Upfront plan review.** The council of 12 critiques the plan from different angles before any code exists.

**Where Gauntlet is stronger**

- **Who decides it's done.** In your flow, the agent that writes the code also verifies it. That's the weak spot if you want to walk away. An agent checking its own work tends to accept "it runs and Puppeteer clicked through" as success. Gauntlet always uses a fresh critic that never sees the builder's reasoning.
- **A quality bar, not just correctness.** Your verification checks that things work. Gauntlet compares the result against a real reference (a named app, site, or benchmark) and keeps going until ours wins. Without a bar, an unattended run tends to stop at "pretty good."
- **One gap per round.** The critic names the single biggest problem, so fixes stay focused instead of piling up.

**For unattended builds specifically**  
Yours still has human checkpoints built in: manual QA steps, commit approval, and "continue" prompts. To truly walk away, it needs Gauntlet's piece, a critic that can say no. Otherwise nothing stops it from marking milestones done when they're only half right.

**How I'd combine them**  
Keep your system as the outer loop: plan, state, maps, and commits. Then run each milestone as a small Gauntlet:

1. When a milestone is planned, write its bar and gates into the story: a reference to match plus the tests or Puppeteer checks that must pass.
2. The builder implements it, reading the maps first.
3. A fresh critic gets only the milestone goal, the bar, and the running app, then returns WIN, LOSE with the biggest gap, or UNJUDGEABLE.
4. On LOSE, loop. Only on WIN do you update the maps, commit, and move the state forward.
5. At the end of each epic, run a fresh integration critic over the whole app so pieces that were each "done" don't quietly break each other.
6. Add a stop condition per milestone, like a round or token budget. When it hits, the agent logs the open gap and moves on instead of spinning or faking a pass.
7. When a check truly needs a human, the agent queues the manual QA steps in a file and keeps working on other milestones instead of stopping to wait for you.

That way you get your system's memory and structure plus Gauntlet's refusal to grade its own homework. If you share the attachment files (`AGENTS.md` and the INIT and TURNS files), I can write a version of `AGENTS.md` with this critic loop built in.