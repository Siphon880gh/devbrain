
```
{ timestamps: true }
```

When you set `timestamps: true` in a Mongoose schema, Mongoose will automatically add two fields to your schema: `createdAt` and `updatedAt`. These fields store timestamps that indicate when the document was created and last updated, respectively.

---

If you want more control over the timestamp formatting, you may skip `{ timestamps: true }` and implement what happens under the hood:


1. At the model:

```
    createdAt: {
      type: Date,
      default: Date.now,
    //   get: (timestamp) => dateFormat(timestamp),
    }
```

2. At typeDefs, force the createdAt into a string:
   
   Return type is:
   
```
  type SomeReturnType {
    _id: ID
    title: String
    comment: String
    createdAt: String
  }
```