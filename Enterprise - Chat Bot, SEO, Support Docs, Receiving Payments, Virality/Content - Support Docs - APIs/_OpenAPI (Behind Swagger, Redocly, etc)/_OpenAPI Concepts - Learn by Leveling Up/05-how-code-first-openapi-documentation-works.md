## How Code-First OpenAPI Documentation Works

Code-first OpenAPI documentation means the backend code is written first, and the OpenAPI specification is generated from that code.

Instead of manually writing an `openapi.yaml` file first, the developer defines routes, models, validation rules, and annotations in the backend application. Then the framework or library generates the OpenAPI spec automatically.

That generated spec can then be rendered by tools like Swagger UI, ReDoc, Redocly, Stoplight Elements, or Scalar.

---

### The Core Idea

The core idea of code-first API documentation is:

```txt
Write backend code first.
Generate the OpenAPI specification from the code.
Render documentation from the generated specification.
```

A simple workflow looks like this:

```txt
Write routes and models
        ↓
Framework generates OpenAPI spec
        ↓
Documentation tool renders API docs
```

In this workflow, the backend code is the source of truth.

---

### Example: Code-First with FastAPI

FastAPI is a clear example of code-first OpenAPI generation.

You write Python code like this:

```python
from fastapi import FastAPI
from pydantic import BaseModel

app = FastAPI()

class User(BaseModel):
    id: str
    name: str
    email: str

@app.get("/users/{user_id}", response_model=User)
def get_user(user_id: str):
    return {
        "id": user_id,
        "name": "Jane Doe",
        "email": "jane@example.com"
    }
```

From this code, FastAPI can generate an OpenAPI specification.

It can infer:

- The path: `/users/{user_id}`
- The method: `GET`
- The path parameter: `user_id`
- The response model: `User`
- The response fields: `id`, `name`, and `email`
- The field types: strings

Then FastAPI can expose interactive documentation automatically.

---

### What the Framework Reads from Code

A code-first framework may inspect several parts of the backend code.

It may read:

- Route definitions
- Controller methods
- Function parameters
- Request body models
- Response models
- Type annotations
- Validation rules
- Decorators
- Comments or docstrings
- Authentication metadata
- Status code declarations

The framework uses this information to build the OpenAPI file.

---

### Example: What Code Becomes in OpenAPI

A route like this:

```txt
GET /users/{user_id}
```

with a response model like this:

```json
{
  "id": "123",
  "name": "Jane Doe",
  "email": "jane@example.com"
}
```

may become OpenAPI documentation showing:

```txt
GET /users/{user_id}

Path parameters:
- user_id: string

Response:
200 OK
{
  "id": "string",
  "name": "string",
  "email": "string"
}
```

The developer writes code. The tool turns that code into a contract and documentation page.

---

### Common Code-First Frameworks and Libraries

Many backend ecosystems support code-first OpenAPI generation.

Examples include:

| Ecosystem | Common Approach |
|---|---|
| Python / FastAPI | Generates OpenAPI from routes and Pydantic models |
| Node.js / NestJS | Generates OpenAPI from decorators and DTOs |
| Java / Spring Boot | Generates OpenAPI from controllers and annotations |
| .NET / ASP.NET | Generates OpenAPI from controllers, endpoints, and metadata |
| Express | Uses libraries, annotations, schemas, or route metadata |
| Laravel | Uses packages and annotations to generate docs |
| Rails | Uses gems or schema-based tooling |

The exact details vary by framework, but the idea is the same: the backend code produces the OpenAPI spec.

---

### Benefits of Code-First API Documentation

Code-first documentation is popular because it is fast and practical.

Benefits include:

- Developers can start building quickly.
- Less manual YAML writing is required.
- Documentation stays close to the actual implementation.
- Type definitions can become API schemas.
- Validation models can become documentation models.
- Small teams can move faster.
- Frameworks can expose docs automatically.
- Generated docs update as code changes.

For internal APIs, admin APIs, startup projects, and small teams, code-first can be a very efficient workflow.

---

### Weaknesses of Code-First API Documentation

Code-first documentation can also create problems.

Common weaknesses include:

- The API design may be shaped too much by backend internals.
- The generated OpenAPI spec may be messy.
- Public API design may not get enough review before implementation.
- Frontend teams may need to wait for backend routes to exist.
- Important examples may be missing unless added manually.
- Error responses may be under-documented.
- Authentication behavior may not be described clearly.
- The generated spec may need cleanup before publishing externally.

Code-first is convenient, but convenience does not automatically produce great API documentation.

---

### Code-First Can Still Have Good Design

Code-first does not mean careless design.

A code-first team can still design the API carefully.

Good code-first teams still think about:

- Resource naming
- Endpoint consistency
- Request and response shapes
- Error formats
- Status codes
- Authentication
- Versioning
- Backward compatibility
- Developer experience

The difference is that the API contract is represented through code first, rather than a hand-written OpenAPI file first.

---

### Improving Code-First Documentation

To make code-first API docs better, teams should add extra details.

For example:

- Add route descriptions.
- Add request examples.
- Add response examples.
- Document error responses.
- Define status codes explicitly.
- Use clear request and response models.
- Avoid exposing internal database models directly.
- Group endpoints with tags.
- Add authentication metadata.
- Review the generated OpenAPI file before publishing.

A generated spec is a starting point. It may still need human review.

---

### Avoid Exposing Internal Models Directly

One common mistake in code-first APIs is using internal database models as public API models.

For example, a database user model may contain fields like:

```txt
password_hash
internal_notes
deleted_at
admin_flags
```

These fields should not automatically become part of a public API response.

A better approach is to define separate models:

- Database model
- Request DTO
- Response DTO
- Public API schema

This keeps the API contract clean and safe.

---

### Code-First with Generated Documentation

Once the backend generates the OpenAPI specification, documentation tools can render it.

For example:

```txt
Backend code
        ↓
Generated OpenAPI JSON
        ↓
Swagger UI / ReDoc / Scalar / Stoplight Elements
        ↓
Readable API documentation
```

The documentation UI is not inventing the API contract. It is reading the generated OpenAPI file.

---

### Code-First vs Specification-First

| Approach | Source of Truth | OpenAPI Created By |
|---|---|---|
| Code-first | Backend code | Framework or library |
| Specification-first | OpenAPI file | API designer or design tool |

In code-first, the backend comes first.

In specification-first, the contract comes first.

Both can produce the same final output: an OpenAPI specification that can be rendered into documentation.

---

### When Code-First Works Best

Code-first is often a good fit when:

- The team is small.
- The API is internal.
- The backend framework has strong OpenAPI support.
- Speed matters more than formal API governance.
- The API changes often.
- The same developers own the backend and API documentation.
- The API is not heavily partner-facing or public.

For many practical applications, this is enough.

---

### When Code-First May Not Be Enough

Code-first may be less ideal when:

- The API is public.
- External developers depend on the contract.
- Multiple teams need to agree before implementation.
- Frontend and backend teams need to work in parallel before routes exist.
- API changes need formal review.
- SDKs and mocks are needed before backend implementation.
- API governance is important.

In those cases, specification-first or a hybrid workflow may be better.

---

### Hybrid Code-First Workflow

Many teams use a hybrid approach.

They may design important endpoints first, then implement them in code and generate the OpenAPI spec from the backend.

A hybrid flow might look like this:

```txt
Sketch important API contracts
        ↓
Build backend routes and models
        ↓
Generate OpenAPI from code
        ↓
Review generated spec
        ↓
Publish documentation
```

This gives the team some upfront design while still keeping documentation close to the code.

---

### Final Summary

Code-first OpenAPI documentation starts with backend code.

The developer writes routes, models, validation rules, and metadata. The framework generates an OpenAPI specification from that code. Then documentation tools render the generated spec.

The simple mental model is:

```txt
Code-first = backend code is the source of truth
```

This approach is fast and practical, especially for small teams and internal APIs.

However, code-first documentation should still be reviewed carefully. A generated spec can be accurate but still incomplete, messy, or hard for outside developers to use.

Good code-first documentation requires clean models, clear endpoint design, examples, status codes, error responses, and authentication details.