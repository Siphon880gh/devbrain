## What Is an OpenAPI Specification?

An **OpenAPI specification** is a structured description of how an HTTP API works.

It is usually written in YAML or JSON and stored in a file such as:

```txt
openapi.yaml
```

or:

```txt
openapi.json
```

The OpenAPI specification describes the API contract. It tells developers and tools what endpoints exist, what requests are allowed, what responses look like, and how authentication works.

---

### OpenAPI Is an API Contract

The most important way to understand OpenAPI is this:

```txt
OpenAPI is not just documentation.
OpenAPI is an API contract.
```

The contract defines what the API promises to accept and return.

For example, if an API has this endpoint:

```txt
POST /users
```

the OpenAPI specification can define:

- What fields the request body must include
- What fields are optional
- What response comes back when the user is created
- What errors can happen
- Whether authentication is required
- What status codes are possible

This gives frontend developers, backend developers, QA, and external users a shared understanding of the API.

---

### What an OpenAPI File Usually Contains

An OpenAPI specification commonly includes:

- API title
- API version
- API description
- Server URLs
- Authentication schemes
- Endpoint paths
- HTTP methods
- Path parameters
- Query parameters
- Headers
- Request bodies
- Response bodies
- Status codes
- Data schemas
- Example payloads
- Error formats
- Tags and grouping

A small OpenAPI example may look like this:

```yaml
openapi: 3.1.0
info:
  title: Example API
  version: 1.0.0

paths:
  /users:
    get:
      summary: Get all users
      responses:
        "200":
          description: A list of users
```

This says the API has a `GET /users` endpoint and that a successful response returns a list of users.

---

### The Main Parts of an OpenAPI Specification

#### `openapi`

This defines the OpenAPI version being used.

Example:

```yaml
openapi: 3.1.0
```

This tells tools how to interpret the rest of the file.

---

#### `info`

The `info` section describes the API itself.

Example:

```yaml
info:
  title: Customer API
  version: 1.0.0
  description: API for managing customer records.
```

This is usually displayed at the top of the generated documentation.

---

#### `servers`

The `servers` section defines where the API is hosted.

Example:

```yaml
servers:
  - url: https://api.example.com/v1
```

This tells documentation tools and API clients where requests should be sent.

Some specs include multiple servers:

```yaml
servers:
  - url: https://api.example.com/v1
    description: Production
  - url: https://staging-api.example.com/v1
    description: Staging
```

---

#### `paths`

The `paths` section defines the API endpoints.

Example:

```yaml
paths:
  /users:
    get:
      summary: Get users
    post:
      summary: Create a user
```

Each path can contain HTTP methods such as:

- `get`
- `post`
- `put`
- `patch`
- `delete`

This is where the main API behavior is described.

---

#### Parameters

Parameters describe values passed through the URL path, query string, or headers.

Example path parameter:

```yaml
/users/{userId}
```

The spec can define `userId` like this:

```yaml
parameters:
  - name: userId
    in: path
    required: true
    schema:
      type: string
```

Common parameter locations include:

| Location | Example |
|---|---|
| Path | `/users/{id}` |
| Query | `/users?status=active` |
| Header | `Authorization: Bearer token` |
| Cookie | Session or tracking values |

---

#### Request Bodies

A request body describes data sent to the API.

Example:

```yaml
requestBody:
  required: true
  content:
    application/json:
      schema:
        $ref: "#/components/schemas/CreateUserRequest"
```

This tells the API consumer that the endpoint expects a JSON body matching the `CreateUserRequest` schema.

---

#### Responses

Responses describe what the API returns.

Example:

```yaml
responses:
  "201":
    description: User created
  "400":
    description: Invalid request
  "401":
    description: Unauthorized
```

A good OpenAPI spec should describe both successful responses and error responses.

---

#### Components and Schemas

The `components` section stores reusable definitions.

Example:

```yaml
components:
  schemas:
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

This avoids repeating the same schema across multiple endpoints.

For example, the `User` schema can be reused in:

- `GET /users`
- `GET /users/{id}`
- `POST /users`
- `PATCH /users/{id}`

---

#### Security Schemes

OpenAPI can describe authentication methods.

Example:

```yaml
components:
  securitySchemes:
    bearerAuth:
      type: http
      scheme: bearer
      bearerFormat: JWT
```

Then an endpoint can require it:

```yaml
security:
  - bearerAuth: []
```

Common authentication patterns include:

- API keys
- Bearer tokens
- JWT authentication
- OAuth2
- Basic authentication
- Cookie authentication

---

### What OpenAPI Can Generate

Once an OpenAPI specification exists, tools can generate many things from it:

- API documentation
- API reference websites
- Mock servers
- Client SDKs
- Server stubs
- Test cases
- Type definitions
- Request validation
- Response validation
- Developer portal pages

This is why OpenAPI is so useful. It is not only a document. It is a machine-readable contract that can power other tools.

---

### YAML vs JSON

OpenAPI can be written in YAML or JSON.

YAML is common because it is easier for humans to read:

```yaml
name:
  type: string
```

JSON is more verbose but works well for machines:

```json
{
  "name": {
    "type": "string"
  }
}
```

Most teams use YAML for hand-written specs and JSON when the spec is generated by tools.

---

### OpenAPI Is Mostly for HTTP APIs

OpenAPI is mainly used for HTTP APIs, especially REST-style APIs.

It works well for APIs like:

```txt
GET /users
POST /orders
PATCH /products/{id}
DELETE /sessions/{id}
```

However, OpenAPI is not the main specification format for every API style.

For example:

| API Style | Common Specification |
|---|---|
| REST / HTTP APIs | OpenAPI |
| GraphQL APIs | GraphQL schema |
| gRPC APIs | Protocol Buffers |
| Event-driven APIs | AsyncAPI |
| SOAP APIs | WSDL |

OpenAPI is extremely common, but it is not universal.

---

### Final Summary

An OpenAPI specification is a structured file that describes an HTTP API.

It defines endpoints, methods, parameters, request bodies, response bodies, schemas, authentication, and examples.

The OpenAPI file can be used to generate documentation, mocks, SDKs, tests, and validation rules.

The simple mental model is:

```txt
OpenAPI specification = the API contract
```

Documentation tools like Swagger UI, ReDoc, Redocly, Stoplight Elements, and Scalar read that contract and turn it into human-friendly API documentation.