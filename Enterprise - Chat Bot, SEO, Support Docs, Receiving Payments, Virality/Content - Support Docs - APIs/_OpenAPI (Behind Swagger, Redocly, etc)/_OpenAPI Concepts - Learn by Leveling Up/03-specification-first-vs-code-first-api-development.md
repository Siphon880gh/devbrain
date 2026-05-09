## Specification-First vs Code-First API Development

When building an API, teams usually follow one of two main workflows:

- **Specification-first**
- **Code-first**

Both approaches can produce OpenAPI documentation, but they start from different places.

In a **specification-first** workflow, the API contract is designed before the backend is fully built.

In a **code-first** workflow, the backend code is written first, and the OpenAPI specification is generated from the code.

The difference matters because it affects how teams design, review, test, document, and build APIs.

---

### What Is an API Specification?

An API specification is a structured description of how an API should work.

For HTTP and REST-style APIs, this is often written using the **OpenAPI Specification**.

The spec usually lives in a file like:

```txt
openapi.yaml
```

or:

```txt
openapi.json
```

That file defines the API contract.

It describes things like:

- Endpoints
- HTTP methods
- Request parameters
- Request bodies
- Response bodies
- Error responses
- Authentication
- Data schemas
- Example payloads

For example:

```yaml
paths:
  /users:
    get:
      summary: Get all users
      responses:
        "200":
          description: A list of users
```

This tells people and tools that the API has a `GET /users` endpoint.

---

### What Is Specification-First API Development?

**Specification-first API development** means the team designs the API contract before writing the full backend implementation.

The OpenAPI file comes first.

The backend code comes later.

A simple specification-first flow looks like this:

```txt
Design the API contract
        ↓
Write the OpenAPI specification
        ↓
Review the API with the team
        ↓
Generate docs, mocks, tests, or SDKs
        ↓
Build the backend to match the contract
```

In this workflow, the OpenAPI spec is treated like a blueprint.

Just like an architect creates a blueprint before construction starts, an API team creates the API specification before the backend is fully implemented.

---

### In Specification-First API, Do You Define the Contract in Code?

Usually, in a true specification-first workflow, you do **not** start by defining the API contract inside backend application code.

Instead, you define the contract in an OpenAPI file.

That file is usually written in:

```txt
YAML
```

or:

```txt
JSON
```

For example:

```yaml
openapi: 3.1.0
info:
  title: Example API
  version: 1.0.0

paths:
  /users:
    post:
      summary: Create a user
      requestBody:
        required: true
        content:
          application/json:
            schema:
              $ref: "#/components/schemas/CreateUserRequest"
      responses:
        "201":
          description: User created
          content:
            application/json:
              schema:
                $ref: "#/components/schemas/User"

components:
  schemas:
    CreateUserRequest:
      type: object
      required:
        - name
        - email
      properties:
        name:
          type: string
        email:
          type: string

    User:
      type: object
      properties:
        id:
          type: string
        name:
          type: string
        email:
          type: string
```

This is not backend logic.

It does not create users in a database.

It only defines the expected API contract.

The actual backend implementation still has to be written later.

---

### How Do Teams Design Specification-First APIs?

In a specification-first workflow, teams usually design the API by answering questions like:

- What resources does the API expose?
- What endpoints should exist?
- What HTTP methods should each endpoint use?
- What does the request body look like?
- What does the response body look like?
- What status codes should be returned?
- What errors can happen?
- What authentication is required?
- What fields are required?
- What fields are optional?
- What naming conventions should be used?

For example, before writing backend code, the team may agree on endpoints like:

```txt
GET /users
POST /users
GET /users/{id}
PATCH /users/{id}
DELETE /users/{id}
```

Then they define the expected request and response shapes.

That becomes the API contract.

---

### What Is Code-First API Development?

**Code-first API development** means the backend code is written first.

The OpenAPI specification is generated from the code.

A code-first flow looks like this:

```txt
Write backend routes and models
        ↓
Generate OpenAPI spec from code
        ↓
Render docs from the generated spec
```

For example, in a framework like FastAPI, you might write Python code like this:

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

FastAPI can use that code to generate the OpenAPI spec automatically.

So instead of manually writing `openapi.yaml`, the framework creates it from your routes, models, and type definitions.

---

### Specification-First vs Code-First

| Approach | Starts With | OpenAPI Spec Is | Best For |
|---|---|---|---|
| Specification-first | API contract | Written before implementation | Larger teams, public APIs, formal API design |
| Code-first | Backend code | Generated from implementation | Fast development, smaller teams, framework-driven apps |

Neither approach is automatically better.

They solve different problems.

---

### Benefits of Specification-First

Specification-first is useful when the API needs to be carefully designed before implementation.

Benefits include:

- Better upfront API planning
- Easier team alignment
- Frontend and backend can work in parallel
- Mock APIs can be created before backend code exists
- API reviews happen before implementation
- Public API changes can be controlled more carefully
- SDKs and docs can be generated early
- The API contract is not buried inside backend code

This works especially well for public APIs, partner APIs, enterprise APIs, and teams where many people depend on the API.

---

### Weaknesses of Specification-First

Specification-first can also add overhead.

Possible downsides include:

- The spec has to be maintained
- Developers need to learn OpenAPI syntax
- The spec and backend can drift apart
- It can feel slower for small teams
- Generated server stubs may still need heavy customization
- Poorly designed specs can still produce poor APIs

Specification-first only works well if the team treats the spec as a living contract, not as a document that gets abandoned.

---

### Benefits of Code-First

Code-first is popular because it is fast and practical.

Benefits include:

- Faster to start building
- Less duplicate work
- Documentation stays close to actual code
- Great framework support
- Easier for small teams
- Less manual YAML writing
- Works well with typed models and validation libraries

This is why frameworks like FastAPI, NestJS, Spring Boot, ASP.NET, and others often fit naturally into code-first API documentation workflows.

---

### Weaknesses of Code-First

Code-first can also create problems.

Possible downsides include:

- The API design may be shaped too much by backend internals
- Documentation may be generated after decisions are already made
- Frontend teams may have to wait for backend routes to exist
- Public API design may not get enough review
- The generated spec may be messy or inconsistent
- It can be harder to use the spec as a planning document

Code-first is great for speed, but it can make the API contract feel like a byproduct instead of the main design artifact.

---

### Hybrid Approach

Many teams use a hybrid approach.

For example:

```txt
Design important API contracts first
        ↓
Implement them in backend code
        ↓
Generate or validate OpenAPI from code
        ↓
Compare implementation against the intended spec
```

In this model, the team may design major endpoints first, but still use framework tooling to keep documentation close to the code.

A hybrid workflow can work well because it gives you both:

- Upfront API design
- Practical code-based automation

---

### Which One Should You Use?

Use **specification-first** when:

- Multiple teams depend on the API
- The API is public or partner-facing
- You need formal API reviews
- Frontend and backend need to work in parallel
- You want mock APIs before implementation
- You want the API contract to be the source of truth

Use **code-first** when:

- You are building quickly
- The team is small
- The API is internal
- The framework can generate good OpenAPI docs
- The backend models are already well-typed
- You want less manual documentation work

Use a **hybrid approach** when:

- You want upfront design for important endpoints
- You still want framework-generated documentation
- You want to avoid maintaining too much YAML manually
- You need a balance between speed and structure

---

### Final Summary

Specification-first and code-first are two different ways to create API contracts and documentation.

In **specification-first development**, the team designs the OpenAPI specification before building the backend. The spec acts as the API contract and can be used to generate docs, mocks, tests, SDKs, and server stubs.

In **code-first development**, the team writes backend routes and models first. Then the OpenAPI specification is generated from the code.

The key difference is where the source of truth starts:

```txt
Specification-first = OpenAPI file is the source of truth

Code-first = backend code is the source of truth
```

For small projects, code-first is often faster.

For larger teams, public APIs, and serious API governance, specification-first gives more control.

For many real-world teams, the best answer is a hybrid approach: design the important API contract first, then use code and tooling to keep the implementation and documentation aligned.