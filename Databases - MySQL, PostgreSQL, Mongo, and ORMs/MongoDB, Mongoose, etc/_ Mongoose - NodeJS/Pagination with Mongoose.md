## 📘 Tutorial: Implementing Pagination with Limit and Offset in Express

In many APIs, you want to serve data in chunks—especially when there could be hundreds or thousands of records. `limit` and `offset` are common query parameters used for pagination.

This tutorial walks you through how to implement pagination using `limit` and `offset` in an Express route handler.

---

### ✅ 1. Parse Query Parameters

First, check if both `limit` and `offset` are provided in the request query:

```js
if (req.query.limit && req.query.offset) {
  const limit = parseInt(req.query.limit);
  const offset = parseInt(req.query.offset);
```

- `limit` defines how many results to return.
    
- `offset` defines how many results to skip (i.e., where to start in the result set).
    

---

### ⚙️ 2. Run the Query (With Optional Caching)

Now, run the query using Mongoose’s `.skip()` and `.limit()` methods.

If your application uses caching (e.g., Redis or in-memory cache), we’ll check if caching is enabled in your config and wrap the query in a `cacheQuery` function.

```js
try {
  let deals = [];

  if (config.cache.enabled) {
    deals = await cacheQuery({
      key: `deals:limit:${limit}:offset:${offset}`,
      queryFn: () =>
        Deal.find({ active: true })
            .skip(offset)
            .limit(limit)
            .lean()
    });
  } else {
    deals = await Deal.find({ active: true })
                      .skip(offset)
                      .limit(limit)
                      .lean();
  }
```

- `Deal.find({ active: true })` retrieves only active deals.
    
- `.skip(offset)` skips a number of documents.
    
- `.limit(limit)` restricts how many documents to return.
    
- `.lean()` improves performance by returning plain JavaScript objects instead of full Mongoose documents.
    

---

### 📤 3. Return the Response

Return the paginated results to the client:

```js
  return res.json({ deals, pagination: null });
```

You can replace `pagination: null` later with actual metadata (e.g. total count, current page) if needed.

---

### ❌ 4. Handle Errors

Catch and handle any errors that occur during the query:

```js
} catch (err) {
  console.error('Error fetching deals with limit/offset:', err);
  return res.status(400).json({
    error: 'Failed to fetch deals',
    message: err.message
  });
}
```

---

## ✅ Summary

This pattern lets you support paginated API responses using `limit` and `offset`, with optional support for caching:

- Use `.skip()` and `.limit()` for efficient pagination.
    
- Include a caching layer if desired to reduce database load.
    
- Wrap logic in a `try/catch` to handle errors gracefully.
    

---
---

## 📈 Optional: Add Pagination Metadata to Your API Response

For a better frontend experience, it’s useful to include pagination metadata—so the client knows how many total results exist, what page they’re on, and how many pages there are.

### 🧩 How to Add It

After parsing `limit` and `offset`, enhance your logic like this:

```js
const limit = parseInt(req.query.limit);
const offset = parseInt(req.query.offset);

try {
  const [total, deals] = await Promise.all([
    Deal.countDocuments({ active: true }),
    config.cache.enabled
      ? cacheQuery({
          key: `deals:limit:${limit}:offset:${offset}`,
          queryFn: () => Deal.find({ active: true }).skip(offset).limit(limit).lean()
        })
      : Deal.find({ active: true }).skip(offset).limit(limit).lean()
  ]);

  const pagination = {
    total,
    limit,
    offset,
    currentPage: Math.floor(offset / limit) + 1,
    totalPages: Math.ceil(total / limit)
  };

  return res.json({ deals, pagination });
} catch (err) {
  console.error('Error fetching deals with pagination:', err);
  return res.status(400).json({
    error: 'Failed to fetch deals',
    message: err.message
  });
}
```

### 🧾 Example Output

```json
{
  "deals": [/* paginated deal objects */],
  "pagination": {
    "total": 125,
    "limit": 25,
    "offset": 50,
    "currentPage": 3,
    "totalPages": 5
  }
}
```

### ✅ Summary

This approach adds:

- `total`: how many items match the filter
    
- `limit` & `offset`: echoing the request values
    
- `currentPage`: based on offset
    
- `totalPages`: to help render pagination UI
    

It’s a small addition that makes your API much more user-friendly for frontend apps.

---

Let me know if you want to add support for default values or input validation next.