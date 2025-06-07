## 🧱 Using `timestamps: true` in Mongoose

### 🕒 How to Enable Timestamps

To automatically track creation and update times in a Mongoose model, pass `timestamps: true` as the **second argument** to `new mongoose.Schema()`:

```js
new mongoose.Schema({}, { timestamps: true });
```

This adds and maintains two fields:

- `createdAt` – when the document was first created
    
- `updatedAt` – when the document was last updated
    

You can customize the field names:

```js
timestamps: { createdAt: 'created_at', updatedAt: 'updated_at' };
```

---

### 🌍 Are Timestamps in UTC?

Yes — Mongoose (and MongoDB) stores all date values in **UTC** by default.  
When you retrieve timestamps, they’ll be in UTC. It’s up to your app or frontend to convert them into a local timezone or formatted string.

---

### 🔧 Customizing Timestamp Behavior

If you want more control over how timestamps are set or displayed, skip `timestamps: true` and define the fields manually:

```js
createdAt: {
  type: Date,
  default: Date.now, // e.g., stored as ISODate("2025-06-07T09:00:00.000Z") in MongoDB
  // Optional: use a getter to format what the app receives
  // Note: this does NOT affect what's saved to the database
  get: (timestamp) => timestamp.toISOString(), // e.g., "2025-06-07T09:00:00.000Z"
}
```

> ⚠️ `get()` only affects how the value is **returned in queries** (like `.toObject()` or `.toJSON()`), not how it’s **stored** in the database.

---

### 📤 Formatting Timestamps in Your API

#### If You're Using GraphQL:

GraphQL requires you to define the return type of `createdAt`. You can either:

- Declare it as `String` and return a formatted ISO string
    
- Use a custom `DateTime` scalar
    

```graphql
type SomeType {
  _id: ID
  title: String
  createdAt: String
}
```

Then in your resolver:

```js
createdAt: (parent) => parent.createdAt.toISOString()
```

#### If You’re Using REST or JSON APIs:

You don’t need to do anything special — `res.json()` will automatically serialize `Date` fields as ISO 8601 strings:

```js
{
  "createdAt": "2025-06-07T09:00:00.000Z"
}
```

But you can always format it server-side:

```js
res.json({
  ...doc.toObject(),
  createdAt: doc.createdAt.toLocaleString(), // or any custom format
});
```
