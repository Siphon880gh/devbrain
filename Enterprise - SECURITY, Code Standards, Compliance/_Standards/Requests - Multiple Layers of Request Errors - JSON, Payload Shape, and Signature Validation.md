When an API route fails, the failure is not always the same kind of problem.

A request can fail because the body is broken, because the data is missing required fields, or because the request cannot be trusted. These are different layers of validation, and it helps a lot to separate them clearly.

That is why it is useful to think in terms of **multiple layers of request errors**.

---

## Why this matters

When all bad requests get treated as the same error, debugging gets messy.

A developer may ask:

- Did the sender send malformed JSON?
    
- Did the JSON parse correctly, but the payload fields were wrong?
    
- Did the payload look correct, but the signature fail?
    

Those are three different failure modes. If they all collapse into one vague error, it becomes harder to troubleshoot integrations, write tests, and understand logs.

A layered approach makes the route easier to reason about.

---

## The three layers

A webhook or API endpoint often has at least these three checks:

### 1. JSON parsing

First, the server must determine whether the request body is even valid JSON.

If the body cannot be parsed, then nothing deeper should happen yet. The server does not have a usable data structure to inspect.

Example failure:

- missing comma
    
- broken quote
    
- truncated body
    
- invalid JSON syntax
    

This is usually a:

- `400 Bad Request`
    
- error code such as `invalid_json`
    

Example meaning:

> “I could not parse your request body into valid JSON.”

---

### 2. Payload shape validation

Once the JSON parses successfully, the next question is whether the data has the **right shape**.

This is where “shape” becomes important.

The **shape of a payload** means the structure and expected fields of the data. For example:

- does it contain the required keys?
    
- are the values the right types?
    
- are nested objects where they should be?
    
- are important fields missing or null?
    
- does the payload match the schema the route expects?
    

So when people say “wrong shape,” they usually mean:

- the JSON is valid
    
- but it does not match the expected structure
    

Example:

```json
{
  "event": 123,
  "payload": "wrong"
}
```

This may be valid JSON, but it may not match the route’s expected schema.

This is usually also a:

- `400 Bad Request`
    
- error code such as `invalid_payload`
    

Example meaning:

> “Your JSON is valid, but it does not match the structure this endpoint expects.”

---

### 3. Signature validation

After the request body is readable and shaped correctly, the route may need to verify that the request is authentic.

This is a different category of failure.

A signature check answers questions like:

- Did this really come from the trusted sender?
    
- Was the body changed in transit?
    
- Is the signature header missing?
    
- Does the HMAC or signing check match?
    

If the payload shape is fine but the signature fails, then the problem is not formatting. The problem is trust.

This is usually a:

- `401 Unauthorized` or sometimes `403 Forbidden`, depending on the design
    
- error code such as `invalid_signature`
    

Example meaning:

> “The request body is understandable, but I cannot verify that it is authentic.”

---

## What “shape” means in practice

The word **shape** is informal, but very useful.

It usually refers to the structure of the parsed data.

For example, suppose your route expects:

```json
{
  "type": "booking.updated",
  "data": {
    "id": "abc123",
    "status": "confirmed"
  }
}
```

Then these would be **shape problems**:

- `type` is missing
    
- `data` is missing
    
- `data.id` is missing
    
- `data` is a string instead of an object
    
- `status` is a number instead of a string
    

All of those are payload shape issues.

So “shape” is closely related to:

- schema
    
- structure
    
- expected fields
    
- type validation
    
- request contract
    

If you want a more formal term in docs, “**payload schema validation**” is often better than “shape validation.” But in developer conversation, “shape” is common and understandable.

---

## A clean validation order

A route often becomes easier to debug when it validates in this order:

1. **invalid JSON** → `400 invalid_json`
    
2. **valid JSON but wrong payload shape** → `400 invalid_payload`
    
3. **valid shape but bad or missing signature** → `401 invalid_signature`
    

That gives a very clear pipeline:

- Can I parse it?
    
- Does it match what I expect?
    
- Can I trust it?
    

This creates cleaner logs, clearer tests, and more helpful error responses.

---

## Example explanation of the updated behavior

You could describe the route like this:

> The route now validates requests in layers. It first checks whether the body is valid JSON. If the JSON parses, it then checks whether the payload matches the expected structure. If the structure is valid, it finally checks whether the signature is present and correct.

Or more concretely:

> The route now returns:
> 
> - `400 invalid_json` for malformed JSON
>     
> - `400 invalid_payload` for valid JSON with the wrong structure
>     
> - `401 invalid_signature` for payloads that are structurally valid but fail signature verification
>     

That is much clearer than saying everything failed at “signature validation.”

---

## Why layered errors are better

### Better debugging

If an integration breaks, the sender can immediately tell what kind of mistake happened.

That saves time because the fix is different for each error:

- malformed JSON → fix serialization
    
- invalid payload → fix fields or schema
    
- invalid signature → fix signing secret, header, or signing process
    

---

### Better logs

Your logs become more useful when each stage has its own error code.

Instead of seeing a general failure, you can see whether the problem is mostly:

- parsing
    
- schema mismatch
    
- authentication
    

That helps spot patterns quickly.

---

### Better tests

A layered system makes test cases cleaner.

You can write separate tests for:

- malformed request bodies
    
- valid JSON with missing fields
    
- valid payloads with incorrect signatures
    
- fully valid requests
    

Each test proves one specific contract.

---

### Better API design

A clear validation flow makes the route easier to maintain.

Future developers can see that the endpoint has separate responsibilities:

- parse input
    
- validate structure
    
- verify trust
    

That is easier to understand than one large block that throws a generic error.

---

## One important nuance with webhooks

There is one subtle detail with webhook signature validation.

In many webhook systems, the signature is calculated from the **raw request body**, not from the parsed JSON object. That means the raw bytes matter.

Because of that, some implementations verify the signature very early, sometimes before doing deeper semantic validation of the parsed payload.

Why?

Because the receiver wants to verify the exact body as sent.

So while this layered order is great for clarity, the implementation must still preserve the raw body correctly if signature verification depends on it.

In other words:

- **conceptually**, parsing, shape validation, and signature validation are separate layers
    
- **technically**, signature checks may depend on the raw body and may need careful handling
    

So the goal is not just “reorder everything blindly.” The goal is to produce clearer error handling without breaking the signing model.

---

## “Shape of error” vs “error type”

It helps to use the right terms.

“Shape of error” is a little unclear.

Better phrases are:

- **payload shape**
    
- **payload schema**
    
- **request validation layer**
    
- **error category**
    
- **failure mode**
    

For example:

- not “shape of error”
    
- but “payload shape validation”
    
- or “this error belongs to the payload validation layer”
    

That wording is more precise.

---

## Simple mental model

A good mental model is:

### Layer 1: Can I read it?

- JSON parsing
    

### Layer 2: Does it look right?

- payload shape or schema validation
    

### Layer 3: Can I trust it?

- signature validation
    

That sequence explains the whole system in a simple way.

---

## Example wording for engineering notes

Here is a polished version you could use in docs or a PR note:

```md
## Request validation layers

The route now validates webhook requests in separate layers so errors are easier to diagnose:

- malformed JSON → `400 invalid_json`
- valid JSON but invalid payload structure → `400 invalid_payload`
- valid payload structure but missing or invalid signature → `401 invalid_signature`

This separates parsing errors, payload schema errors, and signature/authentication errors.

A payload “shape” error means the JSON parsed successfully, but the resulting object does not match the fields, nesting, or value types expected by the endpoint.
```

---

## Final takeaway

These are not all the same error.

They are separate validation layers:

- **JSON errors** are about whether the body can be parsed
    
- **payload shape errors** are about whether the parsed data matches the expected structure
    
- **signature errors** are about whether the request is authentic
    

Thinking in layers makes the route easier to debug, test, document, and maintain.

And when talking about “shape,” the clearest meaning is:

> the structure of the payload after parsing, including required fields, nesting, and expected value types

If you want, I can turn this into a more polished internal engineering article with headings like “Problem,” “Old Behavior,” “New Behavior,” and “Why the Change Improves Reliability.”