
## Guide to ChatGPT Codex CLI Usage Limits


Codex CLI can be used either through the **OpenAI API** or through an eligible **ChatGPT subscription**, but the limits work differently depending on which route you use. If you use Codex heavily, understanding those limits—and managing context properly—can make a major difference in how long your quota lasts.

## 1. API Limits Can Be Tight for New Accounts

If you start by using Codex CLI with an OpenAI API key, your account may initially be placed on a relatively low API usage tier.

That means you can run into limits such as:

- **TPM — Tokens Per Minute**
   
- RPM — Requests Per Minute
   
- Other account-level rate limits
   

In my case, I purchased API credits specifically to test Codex CLI and hit the **TPM limit within my first or second message**.

The frustrating part is that having API credit does not necessarily mean you can spend it as quickly as you want. Your available balance and your rate limits are separate things.

So before buying a large amount of API credit specifically for Codex, check your API account's current limits.

## 2. ChatGPT Plus and Pro Have Separate Codex Usage Limits

Instead of using API billing, you can sign into Codex CLI with your ChatGPT account if your subscription supports it.

For example:

- ChatGPT Plus
   
- ChatGPT Pro
   
- Certain Workspace/Business plans
   

This avoids API per-token billing for the included Codex usage, but it introduces **subscription usage quotas** instead.

I switched to Plus after running into API limits. I even set my Codex reasoning effort to **Low** to reduce unnecessary usage, but I still hit my weekly limit after roughly two days of fairly heavy use.

You can monitor your current Codex allowance here:

[https://chatgpt.com/codex/settings/usage](https://chatgpt.com/codex/settings/usage)

That page is worth checking regularly if you're using Codex for long coding sessions.

## 3. Context Management Can Dramatically Affect Usage

One of the biggest variables appears to be **how much context Codex is processing on each request**.

A long-running session can accumulate:

- Previous prompts and responses
   
- Source code
   
- Terminal output
   
- Error logs
   
- Build output
   
- Repository context
   
- Tool results
   
- Documentation
   

As the context grows, later requests can become much more expensive than earlier ones.

This may explain why two people with the same subscription can report radically different experiences.

For example, one Pro user reported:

> “I have Pro and run 2 instances on GPT-5 High from 8am to 10pm 7 days straight without hitting limit, but I do try to manage my context well.”

Another user reported running **four Codex instances**.

Meanwhile, other users can exhaust their allowance within only a couple of days.

### Ways to reduce context consumption

A few habits may help:

- Start a **new Codex session** when moving to a different task.
   
- Avoid carrying giant terminal logs forward unnecessarily.
   
- Keep repository instructions concise.
   
- Don't repeatedly feed Codex files it doesn't need.
   
- Split large projects into focused tasks.
   
- Use lower reasoning effort when the task doesn't require deep reasoning.
   
- Periodically reset bloated conversations instead of maintaining one enormous session.
   

For heavy Codex users, context management may be just as important as the subscription tier itself.

## 4. Reasoning Effort Also Matters

Codex allows different reasoning-effort settings.

Higher reasoning levels may be useful for:

- Difficult debugging
   
- Architecture decisions
   
- Complex refactoring
   
- Large unfamiliar codebases
   
- Multi-step implementation work
   

But using maximum reasoning for routine tasks can consume more of your available capacity than necessary.

For simpler work—such as small edits, commands, formatting, or straightforward implementation—**Low or Medium reasoning** may be sufficient.

A practical approach is to start low and increase reasoning only when Codex is struggling with the problem.

## 5. Weekly Limits Can Be More Annoying Than Short Rolling Limits

One of the biggest complaints about Codex's subscription limits is what happens after you exhaust them.

You may receive a message resembling:

> “Upgrade to Pro or try again in 4 days, 5 hours, 31 minutes.”

That means heavy usage early in the quota window can potentially leave you without included Codex access for several days.

This differs from systems such as Claude Code, where users commonly describe limits that reset over much shorter rolling windows.

One user summarized the tradeoff:

> “It's more than what Claude is providing for the same price and the quality is on par with it. But one good thing about Claude is that your token limit resets after every 3–4 hours, while 4 days is too much.”

The important distinction isn't just **how much usage you receive**. It's also **how quickly access returns after you hit the limit**.

## 6. Plus vs. Pro May Not Scale Exactly How You Expect

If you're considering upgrading purely for additional Codex capacity, compare the plans carefully.

Some heavy users have concluded that purchasing additional subscription capacity can provide better practical throughput than simply moving to the highest individual tier.

For example, one user reported:

> “Upgraded to Workspace subscription with 2 users and hit 5 days timeout after 2 days. Now I'm working on the second user account, probably for the next 2 days.”

Another commented:

> “It's cheaper to have 3 Plus subscriptions to cover weekly limit than 1 Pro subscription.”

That doesn't necessarily mean this is the best strategy for everyone, but it illustrates an important point:

**Price does not always scale linearly with usable Codex capacity.**

If Codex is part of your daily development workflow, evaluate the subscription based on your actual workload rather than assuming that Pro automatically eliminates usage-limit problems.

## 7. API and Subscription Usage Solve Different Problems

A useful way to think about the two options:

|Method|Main Limitation|Best For|
|---|---|---|
|OpenAI API|Rate limits + token billing|Flexible programmatic usage|
|ChatGPT Plus|Included usage quota|Moderate Codex CLI usage|
|ChatGPT Pro|Larger included quota|Heavy interactive Codex usage|
|Workspace plans|Plan/user-dependent quotas|Teams or multiple developers|

The API gives you more of a **pay-for-what-you-use model**, but account rate limits can initially restrict throughput.

ChatGPT subscriptions provide **included Codex usage**, but once that allowance is exhausted, you may have to wait for the quota window to reset.

## 8. Practical Strategy for Making Codex Limits Last Longer

If you're using Codex CLI heavily, a reasonable strategy is:

1. **Monitor your usage**
   
    - Check [https://chatgpt.com/codex/settings/usage](https://chatgpt.com/codex/settings/usage).
       
2. **Keep contexts focused**
   
    - Don't use one Codex session for an entire week's worth of unrelated development.
       
3. **Use Low reasoning by default**
   
    - Increase it only for difficult tasks.
       
4. **Start fresh sessions regularly**
   
    - Especially after completing a major feature or debugging session.
       
5. **Avoid dumping huge logs**
   
    - Give Codex only the relevant error sections.
       
6. **Keep project instruction files concise**
   
    - Large instruction files get repeatedly added to context.
       
7. **Use separate sessions for separate agents/tasks**
   
    - This can prevent one massive context from growing indefinitely.
       
8. **Watch your quota before beginning large jobs**
   
    - You don't want to start a major refactor with only a small amount of weekly usage remaining.
       

## Bottom Line

The biggest thing to understand about Codex CLI limits is that **raw hours of usage don't tell the whole story**.

Two developers can use Codex for the same number of hours and consume dramatically different amounts of quota depending on:

- Context size
   
- Reasoning effort
   
- Repository size
   
- Number of agents
   
- Length of sessions
   
- Amount of terminal output
   
- Complexity of the tasks
   

That's why you'll see one person report hitting the limit in two days while another claims to run multiple Codex instances all week.

If you're regularly hitting Codex limits, upgrading your subscription is one option—but **better context management should probably be the first thing you optimize.**