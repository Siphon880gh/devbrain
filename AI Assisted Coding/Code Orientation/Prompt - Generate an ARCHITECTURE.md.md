Prompt:
```
Create ARCHITECTURE.md in the project root from the code as it exists today. Do not invent services, routes, or storage that are not in the repo.

Cover:

1. Purpose — one short paragraph: what the app does and who it is for.
2. Tech stack — a table of what is actually used (runtime, framework, language, UI, styling, auth, APIs, databases, queues, deploy). Name versions from package.json / lockfiles / config when they are present.
3. Codebase layout — the important directories and files, and what each is for. Skip generated folders (node_modules, .next, dist).
4. Runtime shape — how a request or session moves through the app (browser vs server, routes, key modules). Include a small ASCII or bullet diagram if it helps.
5. Domain model — the main entities, ids, and how they relate. Call out anything that stays in memory only vs what is persisted.
6. Persistence — every store, with names/keys, record shape, and write/read path. Treat images, uploads, blobs, and caches explicitly: where bytes live (disk, IndexedDB, S3, etc.), how they are ingested (compress, resize, mime), how they are shown (object URL, CDN, public path), quotas/limits, and what happens when a parent record is deleted or the user clears site/app data.
7. What is not in this app — auth, APIs, sync, servers, or storage that a reader might assume and that the code does not have.

Rules:
- Read the repo first (package.json, app entry, storage modules, routes).
- Prefer concrete names (storage keys, DB names, env vars, function names) over generic wording.
- Write for someone who will implement or debug a different app of the same kind.
- Keep it factual and short. No setup tutorial (that belongs in README).
```