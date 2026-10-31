# Security Audit

Skill name: `security-audit`

Publisher: Cloudflare

Source: [cloudflare/security-audit-skill](https://github.com/cloudflare/security-audit-skill)

Install path used here: `~/.agents/skills/security-audit`

This is a coding-agent skill for reviewing a codebase, API, service, CLI, library, or daemon. It is instructions plus two small Node validators. It does not ship a scanner binary, and loading the skill does not start an audit.

Cloudflare used an early version of this skill as the seed of its internal vulnerability-discovery harness. The public skill is the single-repository form of that workflow. The repository is MIT licensed. When this copy was installed, the default branch HEAD was commit `c1c8a8c` (14 September 2026).

## What you ask it to do

Point an agent at the repository you want reviewed and ask in plain language:

```text
security audit this codebase
find security vulnerabilities in ./src
do a security review, output to ~/audits/my-project
```

A direct audit or pen-test request, or a request for report files, uses full audit mode. A security question, a look at one function, or triage of a known report uses guidance mode. Guidance mode reads the relevant instructions and answers. It does not create an output directory or run all six phases. If the request could mean either mode, the skill tells the agent to ask once before writing files.

## What counts as a finding

A confirmed finding has to cross a real trust boundary. The write-up names the lower-trust actor, the input or action that was accepted, the control that was supposed to hold, the boundary that failed, the person or resource that was affected, and a concrete result. A missing best practice, a guessed deployment setting, a parser crash with no security consequence, or a user hurting only their own session is not a confirmed finding.

Only confirmed records get a severity:

| Severity | Anchor |
| --- | --- |
| critical | Unauthenticated code execution, full data-store access, or takeover of arbitrary accounts |
| high | An explicit control is fully defeated: authentication bypass, cross-tenant read or write, stored script execution affecting other users, authenticated code execution, or an unauthenticated remote stop of a shared service |
| medium | A real boundary violation with a limited blast radius, uncommon preconditions, or a narrow set of affected resources |
| low | Disclosure of non-secret internals, or a lot of effort for very little gain |
| informational | Confirmed, and useful mainly as a step inside a larger finding |

`needs_validation` is not a low-confidence vulnerability and it has no severity. It means one specific fact is still unresolved. `rejected` means a fresh reviewer disproved the claim.

## Full audit, six phases

1. **Reconnaissance.** Map architecture, trust boundaries, input surfaces, local build paths, and any earlier evidence. Write `architecture.md` and a deterministic `coverage-ledger.json`.
2. **Coverage-led hunting.** Assign isolated hunters from ledger units. Hunters record what they checked. Coverage critics look for gaps. Domain companions are pulled in only when the target needs them (web auth, client-side, memory safety, supply chain, cloud deployment, and so on).
3. **Candidate validation.** Each unique candidate goes to a fresh verifier whose job is to disprove it.
4. **Structured output.** Write `confirmed`, `needs_validation`, and `rejected` records to `findings.json`. Check that file with `validate-findings.cjs` and the ledger with `validate-coverage-ledger.cjs`.
5. **Independent record verification.** Fresh agents check the final source claims. A material replacement gets another independent verifier.
6. **Reporting.** Derive `REPORT.md`, `FINDINGS-DETAIL.md`, and `NEEDS-VALIDATION.md` from the verified records. The report does not include instructions for probing a live system.

The parent agent owns the shared files. Hunters and verifiers write only in their own scratch directories. The skill describes a fix. It does not edit the target.

Default output, if you do not name a directory, is `~/security-audit-skill/<repo>/run-<n>`. A path inside the repository is used only when you pick it and version control ignores that whole directory.

Later runs on the same repository are additive. Prior ledgers and findings are read so the next pass can re-check changed source and spend time on gaps. One pass is not treated as proof that everything else is fine.

## How wide a run is

| Profile | When it fits |
| --- | --- |
| `quick` | Small target, a re-run, or a first look. One hunter wave, then one coverage critic. Extra critic findings are deferred. |
| `standard` | Default. The workflow as written. |
| `deep` | Large or high-stakes targets. Finer ledger units, critic waves until a clean pass, and a second look at units already covered on the same source. |

A scoped run can cover named paths, one subsystem, one companion domain, or a diff. Everything outside that scope is recorded as `out_of_scope`, not as covered. You can also set a budget as a maximum number of agent calls. If the budget cannot pay for reconnaissance plus the reserved critic and validation calls, the skill stops and names the shortfall. It leaves the unchecked units recorded as deferred.

## Execution limits

Source inspection is read-only. Builds, tests, browsers, emulators, fuzzers, and fixtures run only inside an operating-system sandbox with all of these:

- no external network (loopback only when a local client and server are required)
- an empty environment, then an explicit allowlist
- a read-only target and toolchain
- writes only in an assigned scratch directory
- low limits on CPU, memory, processes, file size, disk, and time

If that sandbox is missing, the agent does not run the target's code. The lead stays `needs_validation`, with the missing control named. The skill also refuses live endpoints, production identities, shared infrastructure, paid API quota, and tests that try to knock over a real service. Use dummy accounts, fixtures, and secrets.

Node.js is required for the two validators. They have no package dependencies. The agent needs tool use and a way to run sub-agents in parallel. A full audit spends many agent calls. Check the plan limit before you ask for `deep` on a large tree.

## Files in the skill

| File | Role |
| --- | --- |
| `SKILL.md` | Modes, safety rules, planning, severity, workflow |
| `RECONNAISSANCE.md` | Phase 1 |
| `HUNTING.md` | Phase 2 |
| `ATTACK-CLASSES.md` | Core hunt prompts |
| `VALIDATION-AND-REPORTING.md` | Phases 3–6 |
| `report-schema.json` | Shape of `findings.json` |
| `validate-findings.cjs` | Checks findings |
| `validate-coverage-ledger.cjs` | Checks the coverage ledger |
| Companion `.md` files | AI/LLM, HTTP and auth, client-side, memory and binaries, supply chain and release, cloud and deployment, RPC and messaging, resource exhaustion, data isolation, desktop/mobile/local IPC |

## How this copy was installed

From a user-level install so every harness that reads `~/.agents/skills` can see it:

```bash
npx skills add https://github.com/cloudflare/security-audit-skill \
  --skill security-audit \
  --global \
  --agent codex \
  --yes
```

Codex's global skills directory is `~/.agents/skills`. Cursor's own global directory is `~/.cursor/skills`. This copy was placed in `~/.agents/skills/security-audit` on purpose, as the shared user namespace. The skills CLI recorded it in `~/.agents/.skill-lock.json` under the key `security-audit`, source `cloudflare/security-audit-skill`, folder hash `ccbc33ed119b28c3ef7b44a7e2081ab191ad63af`.

Review the skill before you rely on it. A skill runs with the agent's permissions. This one tells the agent to read source, launch sub-agents, and, in a full audit, write a report directory outside the repository.

## Other publishers

Only Cloudflare's `security-audit` was installed. The names below are the other security-audit skills, and the security skills with a real coder audience, on skills.sh as of 2 November 2026. Install counts move. A high count means people install it. It does not mean the skill audits a general codebase the way `security-audit` does. Several are limited to one product (Firebase rules, Azure compliance, Better Auth).

| Publisher | Skill name | Installs | What it is |
| --- | --- | --- | --- |
| Cloudflare | `security-audit` | about 76,000 | General codebase audit. This is the installed one. |
| Firebase (Google) | `firebase-security-rules-auditor` | 142,800 | Firebase security rules |
| Firebase (Google) | `firestore-security-rules-auditor` | 20,400 | Firestore rules |
| Microsoft | `azure-compliance` | 574,000 | Azure compliance, from `microsoft/azure-skills`. Popular, and narrower than a code audit |
| Addy Osmani | `security-and-hardening` | 76,600 | Hardening guidance for agents |
| Better Auth | `better-auth-security-best-practices` | 49,700 | Practices for that auth library |
| Sentry | `security-review` | 22,200 | Code security review, `getsentry/skills` |
| ECC (affaan-m) | `security-review` | 19,400 | Security review from a widely installed agent pack |
| ECC (affaan-m) | `security-scan` | 11,900 | Scan variant from the same pack |
| Strix | `owasp-top-10-testing` | 14,700 | OWASP Top 10 checks, `usestrix/strix` |
| Strix | `find-security-vulnerabilities-in-code` | 14,600 | Vulnerability hunt in code |
| OpenAI | `security-best-practices` | 11,700 | Secure-coding practices, `openai/skills` |
| Trail of Bits | `semgrep` | 9,900 | Run Semgrep the way that lab does |
| Trail of Bits | `differential-review` | 9,500 | Review a diff for security changes |
| Superagent | `skill-security` | 8,400 | Checks a skill before install. See [[Skill Security Check]] |
| Jeff Allan | `security-reviewer` | 6,300 | `jeffallan/claude-skills` |
| GitHub | `security-review` | 5,700 | `github/awesome-copilot` |
| GitHub | `mcp-security-audit` | 1,100 | MCP server audit, same repo |
| Ghost Security | `ghost-scan-code` | 5,400 | Code scan |
| Sentry | `gha-security-review` | 4,900 | GitHub Actions security review |
| Sentry | `skill-scanner` | 3,900 | Checks a skill folder. See [[Skill Security Check]] |
| Semgrep | `code-security` | 2,700 | Official Semgrep code-security skill |
| Semgrep | `semgrep` | 2,300 | Official Semgrep skill |
| Semgrep | `llm-security` | 1,700 | LLM application security |
| OWASP | `web-security-review` | 670 | `owasp/secure-agent-playbook`. Known publisher, smaller install count |

Community copies with the same job and under about 1,000 installs (not installed): `sickn33/agentic-awesome-skills` (`security-audit`, `security-auditor`), `ruvnet/ruflo` (`security-audit`), `netresearch/security-audit-skill` (`security-audit`), `waynesutton/builder-skills` (`convex-security-audit`), `alirezarezvani/claude-skills` (`skill-security-auditor`). OWASP is listed above despite a lower count because the publisher is the web-security project itself.
