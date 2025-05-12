
> **Next.js makes it surprisingly difficult to access environment variables that are set _at runtime_ (e.g., from Kubernetes or a container platform), instead of being set at _build time_ via `.env` files or hardcoded in `next.config.js`.**

---
### Why Runtime Env Variables Are Tricky in Next.js

Next.js doesn't treat `process.env` like plain Node.js does. In traditional Node.js apps (e.g., Express), environment variables are read **at runtime**, directly from the running process. But in Next.js, especially with the **App Router** and **static optimization**, most code is **evaluated at build time**.

---

### 🔒 What This Means

- Accessing `process.env.MY_SECRET` outside of server-only functions (e.g., in top-level imports or shared modules) causes its value to be **baked into the build**.
- If the variable wasn’t defined during build, it becomes `undefined` — even if set in the live container (like Kubernetes) later.
- This breaks dynamic, runtime configuration unless handled carefully.

---

### ⚠️ Common Mistakes — Even by Experienced Devs

- Reading env vars in top-level constants or shared modules
- Using `next.config.js` to pass secrets
- Expecting dynamic behavior in statically generated pages
- Using secrets in middleware or client components

---

### Why `.env` Appears to Work

- `.env` files are loaded **before** the build, so values are available at build time — and get embedded.
    
- That’s fine for static config, but not for runtime secrets like API keys or DB credentials set by Kubernetes or Docker.

---

### ✅ When Runtime Access _Does_ Work (Safely)

If you need to access environment variables that are only available at **runtime** (e.g., injected by Kubernetes), you must read them inside **server-only logic** — never at the top level of your modules.

>[!note]  Top-level means code that runs immediately when a file is imported.
> 
> ❌ Avoid top-level access (unsafe in Next.js):
> ```
> const secret = process.env.MY_SECRET;
> ``` 
> 
> ✅ Do this instead (runtime-safe):
> ```
> // lib/config.ts
> export function getRuntimeConfig() {
 >  const secret = process.env.MY_SECRET;
  >  if (!secret) throw new Error("Missing MY_SECRET");
  >   return { secret };
> }
> ```
> 
> ✅ Only call from server-only logic (e.g., API routes, Server Actions).


These execution contexts safely read fresh values from `process.env` at runtime:

|✅ Context|Runs at runtime?|Safe to use secrets?|
|---|---|---|
|**API Routes**|Yes|✅ Yes|
|**getServerSideProps**|Yes|✅ Yes|
|**Server Actions**|Yes|✅ Yes|
|**Server Components** (function body only)|Yes|✅ Yes|
|**Middleware / Edge Functions**|Sometimes (Edge)|⚠️ Limited support|

---

### 📦 Best Practice

Use a wrapper function like `getRuntimeConfig()` to:
- Keep `process.env` access centralized
- Avoid accidental build-time access
- Add validation or fallback logic

```ts
// lib/config.ts
export function getRuntimeConfig() {
  const secret = process.env.MY_SECRET;
  if (!secret) throw new Error("Missing MY_SECRET");
  return { secret };
}
```

Call this **only inside server functions**.

---

##  📃 Detailed

To truly access runtime env vars in Next.js (especially in **App Router**), you must do one of these:
#### ✅ 1. API Routes

These run on the server at request time, so you can access environment variables safely:

```ts
// app/api/hello/route.ts
export async function GET() {
  const secret = process.env.MY_SECRET; // ✅ Runtime access
  return Response.json({ secret });
}
```

---

#### ✅ 2. `getServerSideProps` (for Pages Router)

Runs on the server on each request:

```ts
export async function getServerSideProps() {
  const key = process.env.MY_SECRET;
  return { props: { key } };
}
```

---

#### ✅ 3. Server Actions (App Router)

Declared with `'use server'`, these execute on the server:

```ts
'use server';

export async function doSecureThing() {
  const key = process.env.MY_SECRET;
  // Secure logic here
}
```

---

#### ✅ 4. Server Components (App Router)

You can access `process.env` **only inside the function body**, not at the module top level:

```ts
// ✅ Safe
export default async function Page() {
  const key = process.env.MY_SECRET;
  return <div>{key}</div>;
}

// ❌ Unsafe (value baked into the build)
const key = process.env.MY_SECRET;
```

---

#### ✅ 5. Middleware / Edge Functions _(with care)_

These run in Edge runtime, not Node.js, so:

- Only certain env vars work (`NEXT_PUBLIC_*`, or explicitly defined in middleware config).
    
- Not recommended for secrets unless handled carefully.
    

---
#### ✅ 6. Use a wrapper function on the server side

- Wrapper function is recommended because it's DRY, safer for avoiding build-time baking, and a good place for runtime validation and logic.

```ts
// lib/config.ts
export function getRuntimeConfig() {
  const key = process.env.STRIPE_SECRET_KEY;
  if (!key) throw new Error("STRIPE_SECRET_KEY not set");
  return { stripeKey: key };
}
```

---

## 💬 Discussion
[https://www.reddit.com/r/nextjs/comments/19d8li7/serverside_runtime_environment_variables_without/](https://www.reddit.com/r/nextjs/comments/19d8li7/serverside_runtime_environment_variables_without/)