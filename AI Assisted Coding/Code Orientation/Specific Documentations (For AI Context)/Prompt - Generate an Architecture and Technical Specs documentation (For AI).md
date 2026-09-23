This creates Architecture/Technical Specifications documentations.

Note this prompt also generates a BEHAVIOR.md which is necessary. It's more tied to the architecture than it does acting from a user perspective.

Prompt:
```
Inspect this codebase and create or update two documents in the project root: `ARCHITECTURE.md` and `BEHAVIOR.md`.

Together, these documents must give an engineer enough information to reimplement this application's existing engineering, backend, data, and application logic, potentially using a different technology stack, without guessing its business rules or observable behavior. Exclude visual design specifications. Include frontend interaction and state logic wherever they affect functionality.

Use the current code as the source of truth. Describe implemented behavior and architecture supported by the codebase, identifying configuration-only evidence as such. Do not present inferred product requirements as existing architecture or behavior. Do not invent features, services, routes, storage, safeguards, or intended behavior. This is a documentation task; do not modify application code or implement improvements.

## Investigation and evidence

- Read .git CI/CD (if any), dependency manifests and lockfiles, application entry points, routes, configuration, domain modules, storage code, schemas, migrations, client state, background tasks, and relevant tests and fixtures. Follow actual dependencies through important workflows; do not rely solely on filenames, comments, or the README.
- Identify active implementations, distinguishing them from unused code, placeholders, mocks, demos, and disabled or conditional features.
- Record the inspected revision when available, plus any relevant uncommitted changes and inspection limitations.
- Support consequential claims with codebase-relative file paths and relevant function, class, component, or configuration names. Use existing tests and fixtures as supporting evidence.
- Distinguish directly supported implementation details, behavior verified by execution, inferences, and unknowns. Do not describe code inspection as runtime verification.
- If tests, documentation, and implementation disagree, explain the discrepancy. Flag suspected bugs separately without silently correcting them or treating them as intended requirements.
- Apply the requirements below only where relevant. State when a capability is absent, not found in the inspected scope, or unverifiable from this codebase. Do not confuse those categories.
- For external systems, document the contract this code expects and identify unavailable implementation details. Do not claim that deployment configuration proves how production is currently deployed.
- Include environment variable names and purposes, but never copy secret values or private production data.

## ARCHITECTURE.md

### 1. Purpose and boundaries

Write one short paragraph explaining what the app does and who it serves, grounded in the implementation. Identify its major capabilities, execution environments, and external dependencies.

### 2. Technology stack

Provide a table covering the runtime, framework, language, UI and styling technologies, authentication, APIs, databases, file/object storage, caches, queues, testing, build tooling, and deployment configuration actually used.

Name versions only when manifests, lockfiles, or configuration provide them; otherwise mark them unverified. Do not guess versions. Distinguish declared version ranges from resolved versions. Identify each technology's role and source evidence, and distinguish confirmed absence from unverified stack categories.

### 3. Codebase layout

List important directories and files and their responsibilities. Identify entry points and implementation locations for major capabilities. Skip generated folders such as `node_modules`, `.next`, and `dist`.

### 4. Runtime architecture and lifecycle

Explain how requests, sessions, and background operations move through the app: browser versus server responsibilities, routing, middleware, key modules, integrations, startup, initialization, and shutdown where relevant.

Describe consequential environment variables, feature flags, required configuration, build/runtime constraints, scheduled jobs, and deployment assumptions supported by the codebase. Explain behavioral effects rather than writing a setup tutorial.

Use a compact Mermaid diagram or a structured list when it clarifies boundaries or execution order.

### 5. Domain model

Document the main entities, field types, required/optional fields, defaults, identifiers and their generation, relationships, ownership, and lifecycle states. Identify derived values and invariants. Distinguish transient in-memory state from persisted data.

Include serialization formats, units, precision or rounding, and date/time-zone semantics wherever they affect behavior.

### 6. Persistence, asset lifecycle, and data integrity

Inventory every store, including browser storage, cookies, databases, files, blobs, caches, and process memory. For each, document:

- Exact names, paths, keys or key patterns, schemas or record shapes, and source of truth.
- Read/write entry points, callers, and data ownership or scope.
- Initialization, seed data, schema versions, migrations, and compatibility behavior.
- Constraints, indexes where consequential, relationships, transactions or atomicity, and consistency guarantees actually implemented.
- Retention, expiration, invalidation, deletion, cascading cleanup, and recovery behavior.
- What survives refresh, process restart, logout, reinstall, or clearing site/app data, as applicable.

Treat images, uploads, and other binary assets explicitly: where bytes and metadata live; ingestion and validation; MIME handling; compression, resizing, naming, and deduplication; display or download mechanisms such as object URLs, public paths, or CDNs; implemented quotas and limits; and cleanup when assets or parent records are deleted.

For each quota or limit, identify whether application code enforces it or whether it depends on the platform. Report a concrete platform limit only when codebase evidence establishes it; otherwise mark the value unverified. Explicitly state when asset processing, cleanup behavior, or limits are absent or cannot be established from the inspected codebase.

### 7. Interfaces, integrations, and access control

Inventory existing routes, API endpoints, webhooks, events, commands, and important module boundaries. Document their contracts: methods or triggers, inputs, required fields, validation, outputs, errors/status codes, side effects, and authentication requirements. Include pagination, filtering, ordering, versioning, timeouts, and rate limits where implemented. Use representative sanitized payloads when helpful.

Explain authentication, session creation/expiration, roles, permissions, ownership checks, and enforcement locations. Distinguish UI restrictions from server or storage enforcement. Describe relevant trust boundaries and implemented protections without assuming safeguards exist.

### 8. Absent capabilities and unresolved dependencies

Explicitly identify capabilities a reader might incorrectly assume exist, such as authentication, a backend server, remote APIs, database persistence, offline support, synchronization, or queues.

List consequential unknowns, inaccessible dependencies, and architectural inconsistencies with their evidence and implications for reimplementation.

## BEHAVIOR.md

### 1. Feature and workflow inventory

Inventory implemented capabilities, their actors, entry points, and relevant permissions or feature conditions. Include user-facing workflows and consequential automated processes. Cross-reference implementation locations and architecture sections.

### 2. Workflow specifications

For each important workflow, document:

- Trigger and actor.
- Preconditions, required data, permissions, and initial state.
- Inputs, defaults, validation, and rejection conditions.
- Processing steps and business decisions.
- State transitions, outputs, persistence changes, and other side effects.
- Observable success, empty, loading, and failure behavior.
- Alternative paths, cancellation, interruption, and recovery where applicable.

Cover all implemented operations, including creation, reading, editing, deletion, upload, import/export, searching, filtering, ordering, and navigation where present. Describe shared rules once and cross-reference them.

For each major workflow, provide a numbered end-to-end execution trace through every layer actually involved, from the initiating user action or automated event to the final observable outcome. At each handoff, identify the relevant codebase-relative file and function, the data passed or transformed, validation and business decisions, state or persistence changes, and any asynchronous side effects. Trace the response or completion back to the caller and frontend where applicable. Cover the successful path and consequential failure paths, including error propagation and partial completion. Cross-reference architectural details rather than duplicating them.

Keep each trace connected and in execution order. Do not substitute separate descriptions of the frontend, backend, and storage for a complete walkthrough. Include only layers and handoffs supported by the implementation; stop at unavailable external implementations and document their expected contracts. Distinguish traces derived from code inspection from traces verified by execution. Use a compact sequence diagram when branching or asynchronous interactions would otherwise be difficult to follow.

### 3. Business rules and state transitions

Specify calculations, eligibility rules, limits, uniqueness, ordering and tie-breakers, defaults, allowed and forbidden transitions, and cross-entity effects. Include consequential edge cases such as missing/null values, empty collections, duplicates, boundary values, and date boundaries where supported by code.

Use decision tables, formulas, pseudocode, or state diagrams when prose would leave the rule ambiguous. State where each rule is enforced and whether enforcement differs across entry points.

### 4. Frontend application logic

Explain state ownership, derived state, form submission and validation, enabled/disabled actions, navigation guards, URL/history state, and effects of refresh, back navigation, and unsaved changes where implemented.

Specify observable interaction behavior without prescribing colors, typography, spacing, or other visual styling.

### 5. Asynchronous, concurrent, and offline behavior

Where implemented, document background work, event ordering, debouncing, cancellation, retries, backoff, timeouts, optimistic updates and rollback, duplicate requests, idempotency, races, multi-tab behavior, and concurrent edits.

For offline or PWA functionality, explain service-worker and cache lifecycles, available offline operations, queued changes, reconnect behavior, synchronization, conflict resolution, and update behavior. Identify limitations and missing guarantees explicitly.

### 6. Failure handling and observability

Describe behavior for invalid input, missing records, denied access, unavailable dependencies, interrupted operations, corrupt or incompatible data, quota exhaustion, and partial writes where relevant.

Explain error propagation, user-visible outcomes, rollback, cleanup, retry or recovery paths, and implemented logs, metrics, or audit records useful for debugging. State when recovery or instrumentation is absent.

### 7. Reimplementation verification

Provide a compact scenario table covering each major capability and its consequential boundary and failure cases:

|Capability / scenario|Initial state and prerequisites|Input or action|Expected output, state changes, and side effects|Evidence / verification status|
|---|---|---|---|---|

Reference existing tests and fixtures. Identify coverage gaps and unresolved expectations. Clearly separate scenarios inferred from code from those actually executed; report any verification performed and its limitations.

### 8. Known discrepancies and open questions

List suspected defects, contradictions, ambiguous behavior, and external unknowns that could affect functional equivalence. Separate current observable behavior from any documented intended behavior. Do not introduce redesign recommendations as requirements.

## Writing and completion rules

- Be concise but complete. Prefer exact storage keys, database/store names, paths, environment variable names, and relevant function names over generic wording. Use concrete schemas, contracts, rules, and examples.
- Describe externally observable requirements separately from implementation mechanisms so an engineer can preserve functionality with a different stack. Link both to evidence.
- Keep architectural facts in `ARCHITECTURE.md` and behavioral specifications in `BEHAVIOR.md`; cross-reference rather than duplicate.
- Do not add a setup tutorial, visual design guide, speculative services, or proposed features.
- Before finishing, reconcile the documents against discovered routes, features, stores, jobs, and integrations. Ensure each consequential item is documented or explicitly marked unresolved.
- Finish with a brief summary naming the files created or updated, material gaps or blockers, and verification performed. Do not claim complete reconstructability when important behavior remains unknown.
```