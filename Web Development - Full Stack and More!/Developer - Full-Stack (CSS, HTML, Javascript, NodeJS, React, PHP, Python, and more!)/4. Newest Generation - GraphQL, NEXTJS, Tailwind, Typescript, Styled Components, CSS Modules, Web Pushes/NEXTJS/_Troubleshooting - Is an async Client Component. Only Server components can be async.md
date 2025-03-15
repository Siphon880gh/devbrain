Errors:
- `<Signup>` is an async Client Component. Only Server Components can be async at the moment. This error is often caused by accidentally adding `'use client'` to a module that was originally written for the server.intercept-console-error.ts:41
- A component was suspended by an uncached promise. Creating promises inside a Client Component or hook is not yet supported, except via a Suspense-compatible library or framework.

Solution is to remove async :
```
export default async function Signup() {
```

-->

```
export default function Signup() {
```