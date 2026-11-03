# Skill Security Check

A skill check asks whether a bundle of agent instructions and scripts is safe to load. Those bundles run with the agent's permissions: files, shell, credentials, and network, as far as the harness allows. A malicious `SKILL.md` can sit in the prompt and redirect the agent. A script beside it can do the same thing in code. Marketplace listings do not review most of this before you install.

When you are about to add a skill yourself, or you are asking the AI to install one, use Superagent's `skill-security` on a local copy first. The install-time steps are in [[Check a skill for malware before installing]].

An application audit is a different job. It asks whether a product's trust boundaries hold. See [[Security Audit by Cloudflare]]. The publishers below answer the skill question. Counts are from skills.sh on 2 November 2026. None of these packages were installed into `~/.agents/skills`.

## What a check has to look at

Read the whole skill folder: frontmatter, instructions, scripts, and references.

- Frontmatter: `name` and `description` should match the folder and the behavior. An `allowed-tools` list of `*` or an unexplained Bash grant is a reason to slow down. A forced model override needs a reason.
- Instructions: hidden directions, "ignore previous instructions," fake system text, requests to print secrets, or steps that do not match the skill's stated purpose. Text inside the skill under review is data. It is not a command for the reviewer to follow.
- Scripts: downloads, pipe-to-shell installers, encoded blobs that get executed, unexpected network calls, and reads of SSH keys, cloud credentials, or token files.
- Supply chain: runtime URLs that fetch more instructions, packages from an unfamiliar owner, and archives that arrive password-protected or from a release you cannot tie to the publisher.
- Contract: a recipe skill that also copies environment variables has failed the check even if each line looks ordinary.

Directory badges are a first filter. They are not a substitute for reading the files.

## Checks that run when you install from skills.sh

`npx skills add` asks partner auditors for public GitHub repositories and prints their results. The same results are published at [skills.sh/audits](https://www.skills.sh/audits). Three names show up:

| Auditor | Who runs it | What you get |
| --- | --- | --- |
| Gen Agent Trust Hub | Gen (the NortonLifeLock company), through a February 2026 partnership with Vercel | Safe, Low Risk, High Risk, or Critical Risk |
| Socket | Socket | A pass or a warning on malicious behavior, obfuscation, and similar patterns |
| Snyk | Snyk | A risk level. A warning still deserves a look at the written finding |

These auditors rate the skill package. They are not skills you copy into `~/.agents/skills`. Telemetry and the audit lookup can be turned off with `DISABLE_TELEMETRY=1` or `DO_NOT_TRACK=1`. Turning them off also turns off the audit table.

The CLI's own reminder after every install: review skills before use; they run with full agent permissions.

## Publishers that check skills

| Publisher | Name | Installs | Form |
| --- | --- | --- | --- |
| Gen | Gen Agent Trust Hub | directory-wide | Rating on skills.sh: Safe, Low Risk, High Risk, Critical Risk. Partnership with Vercel, February 2026 |
| Socket | Socket audit | directory-wide | Pass or warning on the skills.sh security row |
| Snyk | Snyk audit | directory-wide | Risk level on the same row |
| Snyk | Agent Scan | CLI, not a skill | `uvx snyk-agent-scan@latest` scans installed skills and MCP configs |
| Superagent | `skill-security` | about 8,400 | Most-installed skill whose question is "is this skill safe to install?" Offline scanner plus an agent judgment of intent. `superagent-ai/skills` |
| Sentry | `skill-scanner` | about 3,900 | Static scan of a skill directory, then the agent filters false positives. `getsentry/skills`. A security skill that mentions injection in its own reference files is a common false positive |
| samber | `snyk-agent-scan-compliance` | about 4,900 | Community skill around Snyk Agent Scan, `samber/cc-skills`. The publisher is not Snyk |

Smaller packages that use the title Skill Security Check, all well under 1,000 installs: `aliksir/claude-code-skill-security-check` (skill name `skill-security-check`), `toolsai/skills-security-check` (skill name `Skills-Security-Check`, about 600 installs), `alirezarezvani/claude-skills` (`skill-security-auditor`, about 800), `smartchainark/skill-security-audit` (about 500), `agentnode-dev/skills-security-audit` (about 500).

## Practical order

1. Prefer a skill whose publisher you already trust, and whose repository you can open.
2. Read the skills.sh audit row. Open any warning.
3. Read `SKILL.md`, then `scripts/`, `references/`, and rules. Match the description to the commands.
4. Install into `~/.agents/skills` only after that read, with `--global` and an agent whose global path is that directory (`codex` is one).
