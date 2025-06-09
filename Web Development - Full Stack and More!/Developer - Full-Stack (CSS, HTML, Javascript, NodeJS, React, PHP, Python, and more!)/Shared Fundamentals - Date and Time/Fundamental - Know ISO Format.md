**ISO** stands for **International Organization for Standardization**.

When working with dates in JavaScript/NodeJS, the standard ISO format looks like this (See comment):

```js
date.toISOString() // → "2025-06-03T08:15:00.000Z"
```

It’s important to get familiar with this format, especially since you'll often work with dates and times in the frontend or databases. For example, in MongoDB, enabling Mongoose’s `timestamps: true` automatically stores `createdAt` and `updatedAt` fields as ISO strings.