
## ⚡ Auto-Generated Swagger Docs for Express.js APIs

If you're building a backend with **Express.js**, you don't have to manually maintain API documentation. Just like Python's FastAPI, you can **auto-generate Swagger (OpenAPI) docs** from your code comments and serve them as an interactive interface using Swagger UI.

This setup is fast, maintainable, and developer-friendly.

---

## 🧩 When to Use This

Use Swagger with Express if:
- You want a **live, interactive API explorer** like Swagger UI
- You’re exposing an API to frontend devs or third parties
- You want docs to stay synced with your routes automatically
- You're building REST APIs and want standardized schema validation and introspection

---

## 💰 Free

All tools used are **free and open source**:

|Tool|Purpose|
|---|---|
|**Express**|Web framework|
|**swagger-jsdoc**|Auto-generates OpenAPI JSON from JSDoc|
|**swagger-ui-express**|Serves Swagger UI in your app|

---

## 🧪 Getting Started

### 1. Install dependencies

```bash
npm install express swagger-jsdoc swagger-ui-express
```

---

### 2. Create your Express server

```js
// index.js

const express = require('express');
const swaggerUi = require('swagger-ui-express');
const swaggerJsdoc = require('swagger-jsdoc');

const app = express();
const port = 3000;

// Swagger setup
const swaggerDefinition = {
  openapi: '3.0.0',
  info: {
    title: 'Express API',
    version: '1.0.0',
    description: 'Auto-generated API documentation using Swagger',
  },
  servers: [{ url: 'http://localhost:3000' }],
};

const swaggerOptions = {
  swaggerDefinition,
  apis: ['./routes/*.js'], // Path to files with JSDoc comments
};

const swaggerSpec = swaggerJsdoc(swaggerOptions);
app.use('/api-docs', swaggerUi.serve, swaggerUi.setup(swaggerSpec));

// Example route
app.get('/api/hello', (req, res) => {
  res.json({ message: 'Hello from Express!' });
});

app.listen(port, () => {
  console.log(`API running at http://localhost:${port}`);
  console.log(`Docs at http://localhost:${port}/api-docs`);
});
```

---

### 3. Add a route file with JSDoc annotations

```js
// routes/user.js

/**
 * @swagger
 * /api/users:
 *   get:
 *     summary: Get all users
 *     responses:
 *       200:
 *         description: A list of users
 */
module.exports = function (app) {
  app.get('/api/users', (req, res) => {
    res.json([{ id: 1, name: 'Alice' }]);
  });
};
```

Then import this into your main file:

```js
require('./routes/user')(app);
```

---

## 📘 Result

- ✅ Swagger UI served at: [`/api-docs`](http://localhost:3000/api-docs)
- ✅ OpenAPI JSON available at: [`/api-docs/swagger.json`](http://localhost:3000/api-docs/swagger.json) _(optional export)_
- ✅ Your Express routes are documented automatically from code comments

---

## ⚙️ Customize as Needed

- Change the `apis` path in `swaggerOptions` to match your folder structure
- Add route-level parameters, request body schemas, and more using [Swagger JSDoc syntax](https://swagger.io/specification/)
- Protect `/api-docs` route in production using middleware (auth, IP allowlist, etc.)

---

## 🧠 Final Thoughts

This gives Express developers the best of both worlds:

- ✅ **FastAPI-style documentation**
- ✅ **No extra tooling or hosting required**
- ✅ **Zero manual syncing — docs live next to your routes**
