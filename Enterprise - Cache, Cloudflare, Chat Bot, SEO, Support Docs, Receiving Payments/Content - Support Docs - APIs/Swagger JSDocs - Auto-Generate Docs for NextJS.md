## ⚡ FastAPI-Style Swagger Docs in Next.js — No Express Needed

Want **interactive Swagger documentation** for your Next.js API routes — like you get in Python’s FastAPI? You don’t need Express. With a simple setup, you can **auto-generate OpenAPI specs** and serve a **Swagger UI** page using just Next.js.

This approach is **fully native**, works with **App Router or Pages Router**, and requires no custom server.

---

## 🧩 When to Use This

Use this setup if:
- You’re using **Next.js API routes** (App Router or Pages Router)
- You want to expose a **Swagger UI at `/api-docs`**
- You want OpenAPI docs auto-generated from your route files
- You want to keep everything inside **Next.js with no custom server**

---

## 💰 Free

This setup is 100% free and open source:

- **Next.js** (MIT)
- **swagger-jsdoc** – Generates OpenAPI from annotations
- **swagger-ui-react** – Embeds Swagger UI in your app

---

## 🧪 Getting Started

### 1. Install dependencies

```bash
npm install swagger-jsdoc swagger-ui-react
```

> Optional (for TypeScript users):

```bash
npm install --save-dev @types/swagger-jsdoc
```

---

### 2. Generate Swagger JSON at `/api/swagger`

> For **App Router**:

```ts
// app/api/swagger/route.ts

import swaggerJsdoc from 'swagger-jsdoc';
import { NextResponse } from 'next/server';

const swaggerDefinition = {
  openapi: '3.0.0',
  info: {
    title: 'My API',
    version: '1.0.0',
    description: 'Auto-generated Swagger docs for Next.js',
  },
  servers: [{ url: 'http://localhost:3000' }],
};

const options = {
  swaggerDefinition,
  apis: ['app/api/**/*.ts'], // Adjust if using Pages Router
};

export function GET() {
  const spec = swaggerJsdoc(options);
  return NextResponse.json(spec);
}
```

---

### 3. Create Swagger UI page at `/api-docs`

> For **App Router**:

```tsx
// app/api-docs/page.tsx

'use client';

import SwaggerUI from 'swagger-ui-react';
import 'swagger-ui-react/swagger-ui.css';

export default function ApiDocs() {
  return (
    <main className="min-h-screen p-8 bg-white">
      <SwaggerUI url="/api/swagger" />
    </main>
  );
}
```

This creates a full-page Swagger UI that fetches your spec from `/api/swagger`.

---

### 4. Add JSDoc annotations to your API routes

```ts
// app/api/hello/route.ts

import { NextResponse } from 'next/server';

/**
 * @swagger
 * /api/hello:
 *   get:
 *     summary: Returns a greeting
 *     responses:
 *       200:
 *         description: A hello message
 */
export function GET() {
  return NextResponse.json({ message: 'Hello from Next.js!' });
}
```

These comments are picked up by `swagger-jsdoc` when scanning files, just like FastAPI generates docs from function signatures.

---

## 📘 Result

- **Docs available at**: [`/api-docs`](http://localhost:3000/api-docs)
    
- **OpenAPI schema** at: [`/api/swagger`](http://localhost:3000/api/swagger)
    
- Fully interactive Swagger UI — no Express or custom server required
    

---

## ⚙️ Customize as Needed

- Update `swaggerDefinition` in `route.ts` to reflect your brand, version, etc.
    
- Secure your docs with an `auth()` middleware if needed
    
- Replace `apis: [...]` with the appropriate folder path for Pages Router (e.g. `'pages/api/**/*.ts'`)
    

---

## 🧠 Final Thoughts

This setup gives you:

- ✅ **FastAPI-style API docs** with almost no setup
    
- ✅ **Type-safe, file-based routing** with the Next.js App Router
    
- ✅ **No need for a custom Express server**
    
- ✅ Ready to deploy on **Vercel** or any platform
    

---

## **Challenges** 

Want to take it further?
- Add **Zod validation** and convert schemas to OpenAPI
- Add **JWT auth** to secure docs in production
- Switch to **tRPC** for fully typed end-to-end APIs (fetch and api code type hints)