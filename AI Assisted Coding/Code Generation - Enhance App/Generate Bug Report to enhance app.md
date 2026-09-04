Note this assumes you are at **your codebase**. If you need to critique a **competitor's website** or for some reason you don't have the codebase on you, you can provide the URL to the website - just make sure you're on a powerful enough harness that can browse the internet, eg. Cursor, and that at the prompt you will **precede** with a message what the url is, eg. `For this report, the website we are focusing on is: https://domain.com.`

---

## Human-Led and Agentic Bug Testing in Cursor AI

The community-maintained [`petrkindlmann/qa-skills`](https://github.com/petrkindlmann/qa-skills) repository provides two complementary approaches to finding bugs:

|Approach|Primary skill|Who operates the application?|Best use|
|---|---|---|---|
|Human-led testing|[`exploratory-testing`](https://github.com/petrkindlmann/qa-skills/blob/main/skills/exploratory-testing/SKILL.md)|A human tester|Deep investigation, subjective judgment, unusual edge cases, and discovering unknown problems|
|Agentic testing|[`agentic-browser-testing`](https://github.com/petrkindlmann/qa-skills/blob/main/skills/agentic-browser-testing/SKILL.md)|Cursor’s AI agent|Autonomous testing of defined user goals, repeatable flow coverage, screenshots, and technical evidence|

These skills belong to the same repository, but they assign different responsibilities to the human and the AI.

### Option 1: Human-Led Exploratory Testing

The `exploratory-testing` skill supports structured human testing through Session-Based Test Management, test charters, heuristics, timestamped notes, and debriefs.

The human tester remains responsible for:
- choosing which risks deserve investigation
- operating the application
- following unexpected leads
- deciding whether observed behavior is actually a bug
- evaluating confusing, frustrating, or inconsistent experiences
- recording specific contextual details

Cursor assists by:
- identifying potential risk areas
- helping create focused testing charters
- suggesting boundaries, state transitions, and failure scenarios
- organizing observations and evidence
- reviewing bug reports for clarity
- identifying coverage gaps during the debrief

Install the human-led testing skill:

```bash
npx skills@latest add petrkindlmann/qa-skills \
  --skill exploratory-testing \
  --agent cursor
```

#### Human-Tester Prompt

```text
Use the exploratory-testing skill.

Help me conduct a structured, human-led exploratory bug-testing session.
I will operate the application and decide what counts as a bug. Your role is
to help plan the sessions, suggest test ideas, organize my observations, and
identify coverage gaps.

Do not autonomously operate the browser unless I explicitly ask.
Do not perform an ADA, WCAG, ARIA, or general accessibility audit.

First inspect the available application documentation, routes, user stories,
existing tests, and source structure. Then help me identify:

- major user types and permission levels
- each user type’s primary goals
- critical end-to-end flows
- recent or technically risky areas
- important integrations and state transitions
- areas not adequately covered by automated tests

Propose a prioritized set of testing charters using this format:

Explore [specific feature or flow]
with [user role, data, platform, and relevant conditions]
to discover [risks, inconsistencies, or unexpected behavior].

Do not use a charter as broad as “explore the entire application.”
Each charter should be suitable for one focused 45–90 minute session.

For every charter, provide:

1. Purpose and user risk
2. Required starting state and test data
3. Relevant user roles
4. Suggested desktop, tablet, and mobile coverage
5. Important boundaries and state transitions
6. Error and interruption scenarios
7. Questions whose expected behavior may need clarification
8. Observable evidence I should capture

Use applicable exploratory-testing heuristics, including:

- zero, one, many, minimum, maximum, and boundary values
- empty, malformed, duplicated, expired, and unusually large inputs
- going backward, refreshing, reopening, and repeating steps
- skipping required steps
- interrupted or partially completed flows
- duplicate tabs and simultaneous sessions
- rapid clicking and duplicate submission
- session expiration and permission changes
- failed, delayed, or unavailable dependencies
- different screen sizes, orientations, locales, and time zones
- differences between product claims and actual behavior
- inconsistencies with comparable parts of the application

After I select a charter, create a session log with these columns:

- Time
- Action or test condition
- Observation
- Tag: BUG, QUESTION, IDEA, RISK, or NOTE
- Evidence
- Follow-up

As I provide observations, help me maintain the log. Do not convert an
observation into a confirmed bug unless I confirm that classification.

At the end of each session, help me debrief:

- charter areas covered
- areas only partially covered
- areas not tested
- confirmed bugs
- suspected issues
- unanswered product questions
- follow-up charters
- candidates for automated regression tests

Create or update `Bug-Testing-Report.md`, but preserve the specific facts and
context from my testing rather than replacing them with generic AI wording.
```

### Option 2: Autonomous Agentic Testing

The `agentic-browser-testing` skill is the automated counterpart. Cursor receives a natural-language testing goal, operates the application, verifies observable outcomes, and gathers evidence.

Install it for Cursor:

```bash
npx skills@latest add petrkindlmann/qa-skills \
  --skill agentic-browser-testing \
  --agent cursor
```

You can also install both approaches:

```bash
npx skills@latest add petrkindlmann/qa-skills \
  --skill exploratory-testing \
  --skill agentic-browser-testing \
  --agent cursor
```

Cursor’s [native Browser](https://cursor.com/docs/agent/tools/browser) can navigate applications, interact with controls, capture screenshots, read console output, and inspect network traffic. Therefore, Playwright CLI is not required for an initial autonomous bug hunt.

#### Agentic-Tester Prompt

```text
@browser Use the agentic-browser-testing skill and Cursor’s native Browser.

Perform a systematic, source-code-read-only bug-testing session. If you're testing against local website, do not modify or fix application code during testing.

This is a functional and responsive bug test—not an ADA, WCAG, ARIA,
or general accessibility audit. Do not report accessibility-only findings
unless they directly prevent a user from completing a functional task.

PLANNING

Inspect the application structure, routes, documentation, user stories,
existing tests, and relevant source code only as needed to identify:

- major user types and permission levels
- each user type’s primary goals
- important features
- critical end-to-end flows
- high-risk state transitions
- external integrations
- likely areas of incomplete test coverage

Do not stop after creating a test plan. Continue into browser execution.

Break the application into bounded testing charters. Prefer one major user
goal or flow per charter instead of attempting to explore the entire
application as one unstructured session.

For each charter, define:

- starting URL and application state
- required user role and test data
- goal to accomplish
- observable success criteria
- forbidden failure states
- applicable viewports
- maximum reasonable number of browser steps

A successful result must be directly observable. Examples include:

- expected destination URL
- specific confirmation text
- correctly saved or displayed record
- expected total, status, or counter
- corresponding successful network request
- absence of a specific forbidden error state

“No visible error” or “the page loaded” is not sufficient proof of success.

RESPONSIVE COVERAGE

Run each critical flow first on desktop and then verify it at:

- Desktop: 1440 × 900
- Tablet portrait: 834 × 1194
- Tablet landscape: 1194 × 834
- Mobile: 393 × 852
- Mobile Android: 412 × 915

Use exact viewport sizes when supported. Otherwise, record the dimensions
actually tested.

Treat these as viewport simulations. Do not claim real-device, Safari,
Chrome, Firefox, or cross-browser coverage unless those environments were
actually used.

BUG-HUNTING AREAS

Actively search for:

- broken buttons, links, menus, dialogs, forms, and navigation
- incorrect redirects, routes, deep links, and browser-history behavior
- incorrect or missing validation
- silent submission failures
- incorrect success and error messages
- missing, duplicated, stale, or incorrectly persisted state
- refresh, back, forward, logout, and expired-session problems
- interrupted or partially completed flows
- rapid clicking, duplicate submission, and duplicate records
- race conditions and operations completing out of order
- empty, loading, timeout, offline, and failed-request states
- uncaught console exceptions
- failed, duplicated, or unexpectedly repeated network requests
- clipped, overlapping, hidden, or unreachable interface elements
- horizontal scrolling and breakpoint failures
- state corruption after resizing or changing orientation
- incorrect totals, counters, dates, time zones, permissions, or data
- unauthorized functionality exposed to the wrong user role
- UI states that indicate success even though data was not saved
- inconsistent behavior between similar parts of the application

TEST INTEGRITY

- Do not modify production code.
- Do not patch the DOM or inject JavaScript to bypass normal product behavior.
- Do not directly modify cookies, local storage, session storage, the database,
  or application state merely to make a flow pass.
- Do not change or mock a network response merely to manufacture a successful
  outcome.
- Controlled failure injection is allowed only in a local or staging
  environment, when supported, and must be documented.
- Never weaken success criteria after observing a failure.
- Base expected behavior on product copy, documentation, existing tests, source
  code, or an explicit user requirement.
- If intended behavior is unclear, classify the finding as a suspicion or
  product question rather than a confirmed bug.
- Reproduce every suspected bug at least twice before confirming it.
- Where possible, reproduce from a clean or reset starting state.
- Capture screenshots for every confirmed bug.
- Record relevant console and network evidence.
- Do not claim unavailable states, roles, integrations, browsers, or devices
  were tested.
- Do not perform real purchases, send real messages, delete non-test data, or
  take other consequential production actions without approval.

SEVERITY

Classify confirmed bugs according to user impact:

- Critical: security exposure, unrecoverable data loss, or application-wide
  failure with no practical workaround
- High: a primary user goal is blocked or produces seriously incorrect results
- Medium: important behavior is impaired, but a reasonable workaround exists
- Low: limited-impact visual, consistency, or usability defect that does not
  block the primary flow

REPORT

Create `Bug-Testing-Report.md` containing:

1. Executive summary
2. Test environment, application version, and test data
3. Tested user types and user goals
4. Viewport and actual browser coverage
5. Testing charters
6. Flow-coverage matrix
7. Confirmed bugs ranked Critical, High, Medium, or Low
8. Required starting state and exact reproduction steps
9. Expected versus actual behavior
10. Screenshot evidence
11. Console and network evidence
12. Likely affected source files, with confidence level
13. Suspected issues that could not be confirmed
14. Untested or blocked areas and why they were blocked
15. Recommended follow-up testing

Do not fix bugs or create regression tests until I approve the report.
```

## Reproducing Bugs and Creating Regression Tests

Once either the human tester or agentic tester discovers a bug, the repository’s [`bug-reproduction`](https://github.com/petrkindlmann/qa-skills/blob/main/skills/bug-reproduction/SKILL.md) skill can help:

- reproduce the failure consistently
- determine the minimum required conditions
- remove irrelevant reproduction steps
- isolate the likely component or integration
- collect deterministic evidence
- create a failing automated regression test
- verify that the test fails before any fix is applied

Install it separately:

```bash
npx skills@latest add petrkindlmann/qa-skills \
  --skill bug-reproduction \
  --agent cursor
```

Use it after reviewing the initial bug report:

```text
Use the bug-reproduction skill.

Take confirmed bug [BUG ID] from `Bug-Testing-Report.md`.

Reproduce it from a clean starting state, minimize the reproduction steps,
identify the smallest relevant input and state, and determine whether the
failure is deterministic or intermittent.

Create a regression test that fails against the current buggy behavior.
Run it and verify that it fails for the expected reason.

Do not fix the underlying application code.
Do not weaken the test or change the expected result to make it pass.
```

## When Playwright CLI Is Still Useful

Microsoft’s official [`playwright-cli`](https://github.com/microsoft/playwright-cli) remains useful when you need
- Playwright traces
- repeatable scripted regression tests
- explicit Chromium, Firefox, or WebKit execution
- named device emulation
- isolated browser sessions
- CI integration
- automated test generation
- persistent authentication state
- request interception or controlled failure simulation

Install it with:

```bash
npm install -g @playwright/cli@latest
playwright-cli install --skills
```

For an initial Cursor bug hunt, however, the simpler arrangement is usually sufficient
- Use `exploratory-testing` when a human will operate the application.
- Use `agentic-browser-testing` when Cursor will operate it autonomously.
- Use Cursor’s native Browser as the browser driver.
- Add `bug-reproduction` after discovering a specific defect.
- Add Playwright CLI when the findings need to become traces, scripted tests, or CI regression coverage.

Anthropic’s [`webapp-testing`](https://github.com/anthropics/skills/tree/main/skills/webapp-testing) is another official skill option, but it primarily instructs the agent to test local applications by writing Python Playwright scripts. It is better suited to scripted local verification than to human-led exploratory testing or autonomous unknown-bug discovery.

---

Note if the report is hard to read because of short phrases, having to read inbetween the lines, etc, the AI may have written it for AI. Just prompt subsequently to make it easier to read for humans.

Prompt:
```
This report seems difficult to comprehend. Rewrite it for a human reader, preferably at 8th grade reader level where you can, without dropping important vocabulary.
```