In an AutoGen-style workflow, the reviewer AI should not just say, “This looks good.”

It needs a clear **stop rule**.

The reviewer should know:

```text
What counts as finished?
What counts as not finished?
How many times should we retry before stopping?
What should happen if the task is still not perfect?
```

A good reviewer prompt should include **completion criteria**.

## Simple Version

Tell the reviewer:

```text
Review the work against the original request.

If the work fully satisfies the request, respond with:

APPROVED

If the work does not satisfy the request, respond with:

NEEDS_REVISION

Then list the exact changes needed.

Stop approving only when the main requirements are met. Do not request endless minor improvements.
```

This gives the system a clear signal.

The loop can continue while the reviewer says:

```text
NEEDS_REVISION
```

And stop when the reviewer says:

```text
APPROVED
```

## Better Version With Max Attempts

The best setup uses both:

- a quality gate
    
- a max-attempt limit
    

Example:

```text
Reviewer instructions:

You are the quality-control reviewer.

Your job is to decide whether the Builder’s output meets the original task.

Approve only when:
1. The original request is fully answered.
2. No major requirement is missing.
3. The answer is clear and usable.
4. The output matches the requested format.
5. There are no obvious errors, contradictions, or unsafe actions.

Respond with one of these labels:

APPROVED
- Use this only when the work is good enough to finalize.

NEEDS_REVISION
- Use this when important requirements are missing or incorrect.
- Include a short list of required fixes.

STOP_MAX_ATTEMPTS
- Use this if the workflow has already reached the maximum number of revision attempts.
- Return the best current version.
- Explain what may still be incomplete.
```

## Example Loop

```text
User:
Write an article about AutoGen.

Builder AI:
Creates the first draft.

Reviewer AI:
NEEDS_REVISION
The article needs a clearer explanation of Microsoft AutoGen and completion criteria.

Builder AI:
Rewrites the article.

Reviewer AI:
APPROVED
The article now explains the concept, Microsoft’s framework, and stopping rules clearly.
```

Once the reviewer says `APPROVED`, the system stops.

## Code-Level Pattern

In code, the reviewer’s response becomes the stop signal.

```python
max_attempts = 5
attempts = 0

while attempts < max_attempts:
    draft = builder.run(task)

    review = reviewer.run(f"""
    Original task:
    {task}

    Draft:
    {draft}

    Review the draft.

    Respond with:
    APPROVED
    or
    NEEDS_REVISION with required fixes.
    """)

    if review.startswith("APPROVED"):
        break

    task = f"""
    Revise the draft based on this reviewer feedback:

    {review}
    """

    attempts += 1

if attempts == max_attempts:
    final = f"""
    Max attempts reached.
    Return the best current version and explain any remaining issues.

    Latest draft:
    {draft}
    """
```

The important part is this:

```python
if review.startswith("APPROVED"):
    break
```

That is how the reviewer tells the system to stop.

## Recommended Reviewer Output Format

To make this reliable, force the reviewer to use a strict format.

```text
STATUS: APPROVED | NEEDS_REVISION | STOP_MAX_ATTEMPTS

REASON:
Short explanation.

REQUIRED_FIXES:
- Fix 1
- Fix 2
- Fix 3

FINAL_READY:
yes | no
```

Example:

```text
STATUS: NEEDS_REVISION

REASON:
The article explains AutoGen, but it does not clearly explain how the reviewer knows when to stop.

REQUIRED_FIXES:
- Add completion criteria.
- Add max-attempt logic.
- Show the APPROVED stop signal.

FINAL_READY:
no
```

Approved example:

```text
STATUS: APPROVED

REASON:
The article fully answers the request, explains the stopping rule, and includes a max-attempt safety limit.

REQUIRED_FIXES:
- None

FINAL_READY:
yes
```

## Best Practice

The reviewer AI should not be told:

```text
Keep improving this.
```

That can cause endless loops.

Instead, tell it:

```text
Approve when the work is good enough for the original goal.
Only request revisions for important missing pieces, errors, or format problems.
Do not keep requesting small style improvements once the work is usable.
```

That last sentence matters.

Without it, the reviewer may keep asking for tiny improvements forever.

## Short Prompt You Can Reuse

```text
You are the Reviewer AI.

Your job is to decide whether the Builder AI’s output is ready.

Review the output against the original task.

Approve only if:
- The original request is fully answered.
- No major requirement is missing.
- The answer is accurate enough for the task.
- The format matches the user’s request.
- The result is clear and usable.

Do not request endless minor improvements.
If the work is good enough, approve it.

Use this exact format:

STATUS: APPROVED or NEEDS_REVISION

REASON:
Briefly explain your decision.

REQUIRED_FIXES:
List only important fixes. If approved, write “None.”

FINAL_READY:
yes or no
```

## Simple Mental Model

The reviewer AI is the **quality gate**.

It should stop the loop when the work is good enough.

It should continue the loop only when something important is missing or wrong.

The best stopping system is:

```text
Stop when Reviewer says APPROVED
or
stop when max attempts are reached.
```

That gives you both quality control and safety.