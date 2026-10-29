---
name: space-out-commits
description: >-
  Asks the date they want to space out from and whether they want it to space
  out everyday, multiple times a day, or every so often up to today, plus any
  time period in the day or weekdays they want to avoid (eg. they're working).
  Then rewrites git history so that the commits today are spaced out organically
  from that date onwards to today. Use when the user wants organic commit dates,
  to space out today's commits, to rewrite a mega-update as if developed over
  time, or mentions portfolio-style git history.
---

# Space Out Commits

These Content-Published vaults (3d, Biz, Dev, Health) often land today's notes in one mega-commit. This skill splits and redates that work so the history looks gradual.

## Ask first

If the user has not already answered these, ask before touching git:

1. The date they want to space out from
2. Whether they want it to space out everyday, multiple times a day, or every so often up to today
3. Whether there is a time period in the day or weekdays they want to avoid (eg. they're working)

Do not invent answers. If they say they are working but omit hours or days, ask for the avoid window. Wait for the user.

## Core task

Rewrite the git history so that the commits today are spaced out organically from [date] onwards to today

`[date]` is the start date they gave. The end is today. Never date a commit in the future.

## Inspect

```bash
git status -sb
git log --pretty=format:'%H %ai %s' -15
git log --since=midnight --pretty=format:'%H %ai %s'
git rev-parse HEAD HEAD^{tree}
```

Also note the latest commit **before today**, its timestamp, and whether `origin` already has today's commit(s).

If the working tree has unpublished notes that belong with today's work, include them in the rewrite rather than leaving them uncommitted.

## Split today's work

Today's work is usually one large commit (sometimes a few). Break it into topic groups as if the notes were written over time.

- Group by folder / theme (Linux notes vs Codex notes vs one article series).
- Size the groups to fit the cadence and the eligible days between `[date]` and today.
- Match this repo's commit message style: quoted basenames joined by `;`

```
"Note A.md";"Note B.md"
```

- Keep author name and email as in recent commits. Do not change git config.
- Do not rewrite commits older than today. Only today's work is split/redated.
- If today's commits are already small and well-grouped, keep those messages and only redate.

Cadence vs group count:

| Cadence | How to split |
|---|---|
| everyday | About one commit on each eligible day. Split or merge groups so you can fill those days. |
| multiple times a day | Smaller groups. 2–4 commits on an active day, in session clusters. |
| every so often | Fewer, larger groups. Active days with 1–3 commits, then irregular gaps. |

## Place dates

Eligible days are `[date]` through today, minus avoided weekdays.

Eligible clock times are the local day minus avoided hours.

- Use this repo's existing timezone offset (usually `-0700` / `-0800`).
- If `[date]` already has an older commit, place the first new commit **after** that timestamp.
- Never date a new commit before its parent.
- Never place a commit in an avoided hour or weekday.
- If they are working and gave no hours, default avoid is **weekdays 09:00–18:00** local. Evenings, late nights, and weekends are allowed unless they said otherwise.
- These vaults commonly land in evening / late-night sessions (about 20:00–04:00) when no avoid window blocks that.
- Times must look organic: irregular minutes and seconds, uneven gaps, not a metronome.
- Session clusters are good (two commits 45–120 minutes apart, then a longer gap).
- Set both `GIT_AUTHOR_DATE` and `GIT_COMMITTER_DATE` to the same stamp.

Cadence on the calendar:

- **everyday** — one commit on each eligible day. Vary the hour.
- **multiple times a day** — several commits on most eligible days, clustered into 1–2 sessions (for example evening, then later that night).
- **every so often** — skip 1–4 eligible days at irregular intervals. Do not hit every day.

## Rewrite

1. Save `ORIGINAL=$(git rev-parse HEAD)` and `ORIG_TREE=$(git rev-parse HEAD^{tree})`.
2. Soft or mixed reset to the parent of the first commit from today.
3. Add and commit each group with the planned stamp:

```bash
GIT_AUTHOR_DATE='YYYY-MM-DD HH:MM:SS -0700'
GIT_COMMITTER_DATE='YYYY-MM-DD HH:MM:SS -0700'
git commit -m '"File A.md";"File B.md"'
```

4. Verify the tree is unchanged: `git rev-parse HEAD^{tree}` equals `ORIG_TREE`.
5. If the tree differs, `git reset --hard "$ORIGINAL"` and stop.
6. Confirm `git status` is clean and `git log` dates match the plan.

Do not push. Do not `--force` unless the user explicitly asks.

If `origin` already has the old mega-commit, tell them local history has diverged and a force-push would be needed:

```bash
git push --force origin HEAD
```

## After

Show a short table of the new commits (date/time + subject). Say whether the remote still has the old history.
