## JSON syntax, explained from the ground up

### 1) JSON is a system of **keys and values**

At its core, JSON is a way to assign **keys** to **values**.

```json
{
  "name": "Example Studio"
}
```

- `"name"` is the **key**
    
- `"Example Studio"` is the **value**
    

---

### 2) Keys always point to _something_

Every key in JSON must be assigned a value. That value is **one of two broad categories**:

1. A **final value** (data primitive)
    
2. A **container** (which can hold more values)
    

---

### 3) Final values (data primitives)

A value can be a **final destination**, meaning it does not contain anything else.

Common data primitives:

- string → `"text"`
    
- number → `123`, `3.14`
    
- boolean → `true`, `false`
    
- null → `null`
    

Example:

```json
{
  "title": "Studio Session",
  "capacity": 6,
  "active": true,
  "notes": null
}
```

Once a value is a primitive, the structure **ends there**.

---

### 4) Container values: objects and arrays

Instead of a primitive, a value can also be a **container**.

JSON has only **two container types**:

- **Object** → `{}` (key/value pairs)
    
- **Array** → `[]` (ordered list of values)
    

Example with an object:

```json
{
  "location": {
    "city": "Pasadena",
    "state": "CA"
  }
}
```

Example with an array:

```json
{
  "features": [
    "On-site support",
    "Multi-camera video",
    "Livestream add-on"
  ]
}
```

Important idea:

- Containers can hold **primitives**
    
- Containers can hold **other containers**
    
- This nesting can go as deep as needed
    

---

### 5) Keys must always be in double quotes

This is non-negotiable in JSON.

✅ Valid:

```json
{
  "name": "Example Studio"
}
```

❌ Invalid:

```json
{
  name: "Example Studio"
}
```

If you see unquoted keys, one of two things is happening:

- It is **not JSON**, or
    
- You are already looking at a **native object**, such as a JavaScript object
    

---

### 6) Values only use quotes when they are strings

- Strings → **must** use double quotes
    
- Numbers, booleans, and null → **do not**
    

```json
{
  "name": "Example Studio",
  "capacity": 6,
  "active": true
}
```

---

### 7) JSON vs native objects (important distinction)

JSON is **text**.  
Native objects are **in-memory data structures**.

In JavaScript:

- `JSON.stringify()` → converts a native object **into JSON text**
    
- `JSON.parse()` → converts JSON text **into a native object**
    

Example:

```js
const jsonText = JSON.stringify({ name: "Example Studio" })
const object = JSON.parse(jsonText)
```

Other languages have their own equivalents:

- Python: `json.dumps()` / `json.loads()`
    
- PHP: `json_encode()` / `json_decode()`
    
- Go, Java, Rust, etc.: their own JSON libraries
    

The idea is the same everywhere: **serialize to JSON, deserialize from JSON**.

---


### 8) The root of a JSON document (how it’s usually structured)

While JSON **can** technically start as either an object or an array, **most real-world JSON files use a root object**.

That root object typically:

- Acts as the **main container**
    
- Holds top-level configuration keys
    
- Contains nested objects and arrays underneath those keys
    

This makes the file easier to extend over time without breaking structure.

#### Typical example: a configuration file for a hypothetical app

```json
{
  "app": {
    "name": "ExampleApp",
    "environment": "production",
    "debug": false
  },
  "server": {
    "host": "localhost",
    "port": 8080
  },
  "features": {
    "auth": true,
    "analytics": true,
    "betaFlags": [
      "new-dashboard",
      "faster-sync"
    ]
  }
}
```

In this structure:
- The **root is an object**
- Each top-level key (`app`, `server`, `features`) groups related settings
- Nested objects keep configuration logically separated
- Arrays are used where multiple values make sense

This is the most common and practical JSON pattern.

That said, an **array root is still valid** when the data itself is inherently list-based (for example, a list of records), and `JSON.parse()` will work with either as long as the root is a valid container type.

---

### 9) Mental model to remember

- Keys always map to values
    
- Values are either **final (primitives)** or **containers**
    
- Containers are only `{}` or `[]`
    
- Keys are always double-quoted
    
- Strings are double-quoted, other primitives are not
    
- JSON is text; parsing turns it into real data
    

Once this clicks, JSON stops feeling strict and starts feeling predictable.