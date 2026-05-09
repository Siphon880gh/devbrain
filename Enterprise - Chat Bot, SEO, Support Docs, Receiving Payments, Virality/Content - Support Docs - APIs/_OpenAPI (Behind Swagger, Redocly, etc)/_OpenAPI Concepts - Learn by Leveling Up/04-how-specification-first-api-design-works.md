## How Specification-First API Design Works

Specification-first API design means the API contract is designed before the backend implementation is fully built.

Instead of starting with backend routes and database logic, the team starts by defining how the API should behave from the outside.

The result is usually an **OpenAPI specification** file, such as:

```txt
openapi.yaml
```

That file becomes the API contract.

---

### The Core Idea

The core idea of specification-first design is simple:

```txt
Design the API contract first.
Build the backend to match it later.
```

The OpenAPI specification describes the API from the consumer's point of view.

It defines:

- What endpoints exist
- What methods are allowed
- What data the API accepts
- What data the API returns
- What errors can happen
- What authentication is required
- What examples should look like

The backend implementation comes after the contract is agreed on.

---

### Why Teams Use Specification-First Design

Specification-first design is useful when multiple people or systems depend on the API.

For example:

- Frontend developers need to start building screens.
- Mobile developers need to integrate the API.
- QA needs to write tests.
- Backend developers need clear requirements.
- External partners need stable documentation.
- Product teams need to review behavior before implementation.

If the API contract is written early, all of these groups can work from the same source of truth.

---

### Step 1: Identify the API Resources

The first step is deciding what resources the API exposes.

A resource is usually a noun.

Examples:

- Users
- Orders
- Products
- Properties
- Videos
- Invoices
- Appointments
- Messages

For example, a real estate API may expose:

```txt
properties
agents
photos
videos
leads
```

This step is not about code yet.

It is about modeling the domain.

---

### Step 2: Define the Main Endpoints

After identifying resources, the team defines the main endpoints.

For example:

```txt
GET /properties
POST /properties
GET /properties/{id}
PATCH /properties/{id}
DELETE /properties/{id}
```

These endpoints define the basic actions available for a property resource.

A common pattern is:

| Action | Endpoint |
|---|---|
| List records | `GET /resources` |
| Create record | `POST /resources` |
| Get one record | `GET /resources/{id}` |
| Update record | `PATCH /resources/{id}` |
| Delete record | `DELETE /resources/{id}` |

Not every API needs all of these. The team should only define the actions the product actually supports.

---

### Step 3: Define Request Bodies

Next, the team defines what data each endpoint accepts.

For example, a `POST /properties` endpoint may accept:

```json
{
  "address": "123 Main St",
  "price": 650000,
  "bedrooms": 3,
  "bathrooms": 2
}
```

In OpenAPI, this can be described as a schema:

```yaml
CreatePropertyRequest:
  type: object
  required:
    - address
    - price
  properties:
    address:
      type: string
    price:
      type: number
    bedrooms:
      type: integer
    bathrooms:
      type: number
```

This tells consumers which fields are required and what type each field should be.

---

### Step 4: Define Response Bodies

After defining requests, the team defines responses.

For example, when a property is created, the API may return:

```json
{
  "id": "prop_123",
  "address": "123 Main St",
  "price": 650000,
  "bedrooms": 3,
  "bathrooms": 2,
  "status": "active"
}
```

In OpenAPI, this can be described as:

```yaml
Property:
  type: object
  properties:
    id:
      type: string
    address:
      type: string
    price:
      type: number
    bedrooms:
      type: integer
    bathrooms:
      type: number
    status:
      type: string
      enum:
        - active
        - pending
        - sold
```

This response schema becomes part of the API contract.

---

### Step 5: Define Status Codes

A good API spec should define more than successful responses.

For example:

```txt
201 Created
400 Bad Request
401 Unauthorized
403 Forbidden
404 Not Found
422 Validation Error
500 Server Error
```

Each endpoint should make it clear what can happen.

For example, `GET /properties/{id}` may return:

| Status Code | Meaning |
|---|---|
| `200` | Property found |
| `401` | Missing or invalid authentication |
| `404` | Property not found |
| `500` | Unexpected server error |

This helps frontend developers and QA know how to handle different outcomes.

---

### Step 6: Define Error Shapes

It is also helpful to define a standard error response.

Example:

```json
{
  "error": {
    "code": "PROPERTY_NOT_FOUND",
    "message": "The requested property does not exist."
  }
}
```

In OpenAPI, this can become a reusable schema:

```yaml
ErrorResponse:
  type: object
  properties:
    error:
      type: object
      properties:
        code:
          type: string
        message:
          type: string
```

A consistent error format makes an API easier to consume.

---

### Step 7: Define Authentication

The spec should describe how authentication works.

For example, if the API uses a bearer token:

```yaml
components:
  securitySchemes:
    bearerAuth:
      type: http
      scheme: bearer
      bearerFormat: JWT
```

Then endpoints can require it:

```yaml
security:
  - bearerAuth: []
```

This tells developers that requests need an authorization header like:

```txt
Authorization: Bearer <token>
```

---

### Step 8: Add Examples

Examples make API documentation much easier to understand.

A schema tells developers what is allowed.

An example shows what the data actually looks like.

Example request:

```json
{
  "address": "123 Main St",
  "price": 650000,
  "bedrooms": 3,
  "bathrooms": 2
}
```

Example response:

```json
{
  "id": "prop_123",
  "address": "123 Main St",
  "price": 650000,
  "bedrooms": 3,
  "bathrooms": 2,
  "status": "active"
}
```

Examples are especially helpful for public APIs and developer portals.

---

### Step 9: Review the Contract

Before backend implementation, the team should review the API contract.

Common review questions include:

- Are endpoint names clear?
- Are resources named consistently?
- Are request and response fields easy to understand?
- Are required fields truly required?
- Are error responses consistent?
- Are status codes correct?
- Is authentication described clearly?
- Will this API be easy for frontend and external developers to use?

This review step is one of the biggest benefits of specification-first design.

The team can fix the contract before backend code is written.

---

### Step 10: Generate Mocks, Docs, SDKs, or Stubs

Once the specification exists, tools can generate useful assets.

The team may generate:

- API documentation
- Mock servers
- Client SDKs
- Server stubs
- Test cases
- Type definitions
- Validation rules

For example, a frontend team can use a mock server before the backend is ready.

A QA team can start writing tests against the expected contract.

A backend team can generate server stubs and then fill in the business logic.

---

### Step 11: Implement the Backend

After the contract is approved, backend developers build the real API.

The backend implementation should match the OpenAPI specification.

That means:

- Routes should match the spec.
- Request validation should match the spec.
- Response shapes should match the spec.
- Status codes should match the spec.
- Authentication behavior should match the spec.

The specification is not just a planning document. It is the standard the implementation should follow.

---

### Step 12: Prevent Spec Drift

One risk of specification-first design is **spec drift**.

Spec drift happens when the OpenAPI file says one thing, but the backend does another.

For example:

- The spec says a field is required, but the backend treats it as optional.
- The spec says an endpoint returns `201`, but the backend returns `200`.
- The spec says a response includes `email`, but the backend no longer returns it.
- The backend adds a new field, but the spec is not updated.

To prevent this, teams can use:

- Contract tests
- Request validation
- Response validation
- OpenAPI linters
- CI checks
- API review processes
- Automated documentation builds

The spec must stay alive as the API evolves.

---

### Specification-First Does Not Mean No Code Is Generated

Specification-first does not mean everything is manually implemented from scratch.

After the OpenAPI file exists, teams may generate:

- Server stubs
- Client SDKs
- Type definitions
- Documentation
- Mock servers

However, the key idea remains the same:

```txt
The contract comes before the backend implementation.
```

Generated code is downstream from the specification.

The specification is still the source of truth.

---

### Final Summary

Specification-first API design starts with the API contract.

The team defines resources, endpoints, request bodies, response bodies, status codes, error formats, authentication, and examples before the backend is fully built.

The result is usually an OpenAPI file such as:

```txt
openapi.yaml
```

That file can then be used to generate docs, mocks, SDKs, tests, validation rules, and server stubs.

The simple mental model is:

```txt
Specification-first = design the API blueprint first, then build the backend to match it.
```

This approach is especially useful for larger teams, public APIs, partner APIs, and projects where frontend, backend, QA, and external users need a clear contract early.