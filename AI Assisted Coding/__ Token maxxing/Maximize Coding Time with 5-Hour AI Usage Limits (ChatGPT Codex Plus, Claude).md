For **Codex, ChatGPT models or features with 5-hour limits, and Claude plans with 5-hour session limits**, usage windows generally begin when you send your first prompt and reset five hours later—not at midnight or at a fixed time of day.

Not every ChatGPT model or subscription follows this schedule. However, if your AI tool uses a 5-hour window, you may be able to take advantage of its reset timing to reduce interruptions during intensive coding sessions.

We'll first review how the 5-hour window works, then explore a scheduling technique called the **"Good Morning" strategy**.

## How the 5-Hour Window Works

- **Start Time:** The window begins when you send your first prompt after a new usage period becomes available. Simply opening the application does not necessarily start the clock.
- **Reset Time:** Your allowance refreshes five hours after the window begins, regardless of whether you've exhausted it.
- **Usage During the Window:** You can continue sending prompts until you reach your allowance or the window expires.
- **Separate Limits:** Weekly limits may also apply. A 5-hour reset does not restore an exhausted weekly allowance.
  
## The "Good Morning" Strategy
### Example

| Event                            | Time     |
| -------------------------------- | -------- |
| First prompt sent                | 9:00 AM  |
| Usage window begins              | 9:00 AM  |
| You exhaust your allowance early | 11:00 AM |
| Allowance resets                 | 12:00 PM |
| Next prompt starts a new window  | 12:01 PM |
| Next reset                       | 5:01 PM  |

Here we have a downtime of 1 hour. We will review how we can maximize time coding with this example.

 Remember that the reset depends on when the window started, not when you exhausted your allowance.

The "Good Morning" strategy involves sending a quick prompt early in the morning to intentionally start the 5-hour window before your main coding session. We want to shift the 5 hour reset so that it triggers right around when your allowance ends.

Create a scheduled prompt to run at 6am. It can be something as simple as "Say Good morning".

### When Is This Strategy Most Useful?

The strategy is most useful when you meet three conditions:

1. **Your normal reset occurs later than you'd prefer.** Starting your window earlier moves the reset closer to the time when you'll need a fresh allowance.
2. **You expect substantial usage before the earlier reset.** Ideally, you would consume much of your first allowance before the new reset time. If you have the busiest coding session at the start of the workday, this is ideal.
3. **You have enough work remaining after the reset to benefit from the refreshed allowance.** You don't need to exhaust the second window, but there should be a practical reason to make more capacity available sooner (such as you do your busiest work at the start of the day).

In short, the strategy is especially useful for developers who regularly exhaust their 5-hour allowance during the workday and would benefit from receiving a fresh allowance earlier.

## Which Apps and Plans Does This Apply To?

|Platform|5-hour window|Where to check usage|
|---|---|---|
|Codex CLI / App|Plus and Business Standard|Usage settings or CLI `/usage`|
|ChatGPT|Applicable models/features and plans only|Model-specific limits or Usage settings|
|Claude Chat / Desktop|Most paid plans, including Pro and Max|Settings → Usage|
|Claude Code|Shares applicable Claude subscription limits|`/usage` or Settings → Usage|

**Important:** Codex CLI and Codex App share the same account-based Codex allowance. Similarly, Claude Chat, Desktop, and Claude Code share their subscription usage allowance.

Switching between these interfaces does not create another independent 5-hour window.