## 🔴 What is Redocly?

[Redocly](https://redocly.com/) is a powerful API documentation platform built specifically for teams working with **OpenAPI specifications**. It's used to create beautiful, interactive, and accurate developer documentation that automatically stays in sync with your API definitions.

If you're building APIs and want top-tier docs that feel effortless to maintain, Redocly is a top choice.

---

## 📖 What’s OpenAPI?

**OpenAPI** (formerly Swagger) is a standardized way to describe RESTful APIs in a machine-readable format — typically written in YAML or JSON.

An OpenAPI file defines:

- Available endpoints and methods (`GET /users`, `POST /login`, etc.)
- Parameters, request bodies, and responses
- Authentication methods
- Error codes and examples

Example OpenAPI (YAML):

```yaml
openapi: 3.0.0
info:
  title: My API
  version: 1.0.0
paths:
  /users:
    get:
      summary: Get all users
      responses:
        '200':
          description: A list of users
```

This file becomes the **single source of truth** for your API — and tools like Redocly use it to auto-generate accurate docs.

---

## 🚀 Why Use Redocly?

Redocly helps teams:

- Automatically generate **developer-friendly documentation** from OpenAPI specs
    
- Keep API docs in sync with source code using Git-based workflows
    
- Preview and lint OpenAPI specs before publishing
    
- Add guides, changelogs, and reference docs in one platform
    

It’s trusted by companies like Dropbox, DocuSign, and Tyk.

### Example features:

- 🌐 Hosted or self-managed documentation portals
    
- 🧪 Built-in OpenAPI linting & CI/CD integration
    
- 🛠️ Multiple OpenAPI file support with modular composition
    
- 📚 Easy-to-navigate reference UI (Redoc)
    

---

## 💰 Pricing (as of 2025)

Redocly offers:

- **Free tier** – For small projects or static Redoc usage
    
- **Pro plan** – Starts at ~$60/month for hosted portals with custom branding
    
- **Enterprise** – Advanced features, access control, analytics, and SLA-backed support
    

---

## 🧩 How to Get Started with OpenAPI + Redocly

### 1. **Install the CLI**

```bash
npm install -g @redocly/cli
```

### 2. **Create your OpenAPI file**

Start from scratch or convert from Postman or Swagger:

```bash
redocly init
```

### 3. **Lint it**

```bash
redocly lint openapi.yaml
```

### 4. **Preview it**

```bash
redocly preview-docs openapi.yaml
```

### 5. **Publish (optional)**

Use Redocly’s hosted portal or self-host your documentation.

---

## 🧠 When to Use Redocly

Choose Redocly if:

- You already use OpenAPI or want to standardize API design
    
- You want **low-maintenance**, **high-quality** API documentation
    
- You need CI/CD and multi-spec support for complex systems
    
- You work in an enterprise or team environment where docs need review, versioning, and polish
    

If you’re not using OpenAPI yet, Redocly is also a great way to **start documenting APIs properly** from day one.