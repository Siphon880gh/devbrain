## OpenAPI Documentation Tools

OpenAPI documentation tools are tools used to generate, render, publish, and manage API documentation from an **OpenAPI specification**.

Tools like **Swagger UI**, **ReDoc**, **Redocly**, **Stoplight Elements**, **Scalar**, and similar platforms turn a machine-readable API definition into human-readable documentation.

Instead of manually writing every endpoint, parameter, request body, and response example by hand, teams describe the API in a structured specification file. The documentation tool reads that file and displays it as an interactive API reference.

---

### The Main Category Name

These tools are commonly described as:

**OpenAPI documentation tools**

They may also be called:

- API documentation generators
- API reference documentation tools
- OpenAPI rendering tools
- OpenAPI spec viewers
- API docs publishing tools
- Developer portal tools

The best name depends on what the tool does.

If the tool only displays an OpenAPI file in a web UI, then **OpenAPI renderer** or **OpenAPI documentation viewer** is accurate.

If the tool helps create, version, host, publish, and govern API docs, then **API documentation platform** or **developer portal platform** may be more accurate.

---

### What These Tools Do

An OpenAPI documentation tool takes a file such as:

```txt
openapi.yaml
```

or:

```txt
openapi.json
```

and turns it into readable documentation.

That documentation may include:

- Endpoint lists
- HTTP methods such as `GET`, `POST`, `PUT`, `PATCH`, and `DELETE`
- Path parameters
- Query parameters
- Header requirements
- Authentication rules
- Request body schemas
- Response body schemas
- Status codes
- Example requests
- Example responses
- Interactive API consoles
- Schema models
- Search and navigation

For example, a documentation page might show:

```txt
POST /users

Creates a new user.

Request body:
{
  "name": "Jane Doe",
  "email": "jane@example.com"
}

Responses:
201 Created
400 Validation Error
401 Unauthorized
```

The OpenAPI file defines the structure. The documentation tool renders it in a readable format.

---

### Common OpenAPI Documentation Tools

#### Swagger UI

**Swagger UI** is one of the most recognized OpenAPI documentation tools.

It renders an OpenAPI specification as an interactive web page. Developers can browse endpoints, inspect schemas, view request and response formats, and often make test API calls directly from the browser.

Swagger UI is especially common in backend frameworks because many frameworks can automatically expose it.

For example, a project using FastAPI, NestJS, Spring Boot, Express, or ASP.NET may generate or serve Swagger UI from the backend application.

---

#### ReDoc and Redocly

**ReDoc** is a popular OpenAPI documentation renderer known for clean API reference documentation.

It typically presents documentation with a polished layout that makes endpoints, descriptions, request formats, and schemas easier to scan.

**Redocly** is the broader platform around this ecosystem. Redocly can help teams lint OpenAPI specs, publish documentation, build developer portals, manage versions, and enforce API standards.

A simple distinction:

- **ReDoc** is the renderer.
- **Redocly** is the broader API documentation and governance platform.

---

#### Stoplight Elements

**Stoplight Elements** is a documentation component library for rendering API documentation from OpenAPI specs.

Stoplight also offers broader API design and governance tooling. Teams use it to design APIs, review API contracts, enforce style rules, create documentation, and collaborate around API specifications.

Stoplight is useful when documentation is part of a larger API design workflow.

---

#### Scalar

**Scalar** is a modern OpenAPI documentation tool focused on clean, interactive API references.

It is often used by teams that want a modern-looking documentation experience with an API client style interface.

Scalar is part of the newer generation of OpenAPI documentation tools that focus heavily on developer experience.

---

### These Tools Usually Do Not Define the API

A key point: tools like Swagger UI, ReDoc, Stoplight Elements, and Scalar usually do not define the API by themselves.

They read a specification.

The API contract normally comes from an OpenAPI file, such as:

```txt
openapi.yaml
```

or it is generated from backend code.

For example:

- FastAPI can generate OpenAPI from Python route definitions.
- NestJS can generate OpenAPI from decorators.
- Spring Boot can generate OpenAPI from Java annotations.
- ASP.NET can generate OpenAPI from controllers and metadata.
- Express can generate OpenAPI with additional libraries and annotations.

Once the OpenAPI spec exists, documentation tools can render it.

---

### OpenAPI Documentation Tools vs API Design Tools

Not every API tool does the same job.

Some tools mainly render documentation.

Some tools help write or design the specification.

Some tools help publish developer portals.

Some tools validate and lint API contracts.

Some tools generate code.

For example:

| Tool Type | Purpose |
|---|---|
| Documentation renderer | Turns OpenAPI into readable docs |
| API design tool | Helps design and edit the API contract |
| API linter | Checks the spec for errors and style issues |
| Mock server | Simulates the API before the backend is built |
| SDK generator | Generates client libraries from the spec |
| Developer portal | Publishes docs, guides, auth help, and examples |

Many products combine several of these features.

---

### Why These Tools Matter

API documentation tools matter because API documentation is part of the developer experience.

Bad API docs slow developers down.

Good API docs make it easier to:

- Understand endpoints
- Test requests
- See required fields
- Understand authentication
- Debug response errors
- Onboard frontend developers
- Support external developers
- Coordinate between backend, frontend, QA, and product teams

When documentation is generated from a structured specification, it is easier to keep the documentation aligned with the API contract.

---

### Simple Mental Model

The simplest way to understand these tools is:

```txt
OpenAPI specification = the API contract

Swagger UI, ReDoc, Redocly, Stoplight Elements, Scalar = tools that display or publish the contract
```

The specification describes the API.

The documentation tool presents it.

The developer portal publishes it for people to use.

---

### Final Summary

Swagger UI, ReDoc, Redocly, Stoplight Elements, Scalar, and similar tools are best described as **OpenAPI documentation tools** or **API documentation generators**.

They render and publish API documentation from an **OpenAPI specification**.

The important distinction is:

```txt
OpenAPI = the specification

Documentation tools = the presentation layer
```

The OpenAPI file is the source of truth. The documentation tool turns that source of truth into a readable API reference.