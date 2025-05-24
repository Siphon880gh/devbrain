## 🧠 Redis Caching for Mongoose Queries

### ✅ Requirements:
- Your stack includes **Express with React server**
- **Redis must be installed** locally or on your server  
- ![[_Redis Install]]
    

---

### 🚀 Quick Start with Cursor AI / Copilot

Prompt your AI assistant like this to set up Redis caching for Mongoose queries:
- Make sure to adjust your Mongoose version here
```
Add Redis caching to Mongoose queries (e.g., .find(), .aggregate()), compatible with **Mongoose v8.14.2**. Here's what I believe the setup involves:

#### 1. Install Redis Client

"""
npm install redis
"""

#### 2. `redisClient.js`

"""
const redis = require('redis');
const client = redis.createClient();
client.connect();
module.exports = client;
"""

#### 3. `cacheUtils.js`

"""
const redisClient = require('./redisClient');

async function cacheQuery({ key, ttl = 86400, queryFn }) {
  const cached = await redisClient.get(key);
  if (cached) {
    console.log(`Cache hit: ${key}`);
    return JSON.parse(cached);
  }

  const result = await queryFn();
  await redisClient.setEx(key, ttl, JSON.stringify(result));
  console.log(`Cache set: ${key} (TTL: ${ttl}s)`);
  return result;
}

module.exports = { cacheQuery };
"""

#### 4. Example Usage in Mongoose Controller

"""
const { cacheQuery } = require('./cacheUtils');

const users = await cacheQuery({
  key: 'users:all',
  ttl: 86400,
  queryFn: () => User.find().lean()
});
"""

#### 5. Optional: Invalidate Cache on Mutation

"""
await redisClient.del('users:all');
console.log('Cache reset: users:all');
"""

You can apply this pattern to `.find()`, `.findOne()`, `.aggregate()`, etc.
```


---

### ⚙️ Configurable TTL via JSON File

Prompt Cursor AI or Copilot:

```bash
Awesome. Let’s add a config file so the web admin can set TTL from a JSON file.

At the endpoint, should we load the TTL setting from the JSON manually? Or can the app automatically pull from the file on every query?
```

---

### 🔐 Authenticated Cache Purge Endpoint

Prompt Cursor AI:

```bash
Awesome. Let’s create an endpoint to purge all cache.

Only allow access if the POST request includes `req.body.password` that matches the `CACHE_PURGE_PASSWORD` in the `.env` file.
```

---

### 🚀 Deploying to Production

Make sure your **production server also has Redis** installed—not just your local machine.

#### If you're on Heroku:

Use **Redis Cloud** (free tier available as of May 2025):

**Step 1 of 2**  
![[Pasted image 20250523070251.png]]

**Step 2 of 2**  
![[Pasted image 20250523070159.png]]

> ✅ Heroku will immediately accept you after you click **"Submit Order Form"**.

---

### 🧪 Test & Logs

Use `console.log()` to track your cache status:

```
Cache hit: deals:all  
Cache reset: Completed All  
Cache set: deals:all (TTL: 86400s)  
Cache hit: deals:all
```

Use **Postman** or any API tool to POST to the purge endpoint with the correct password in the body. You should see:

```
Cache reset: Completed All
```

Then, run a fresh query to re-populate the cache—subsequent calls will hit the cache.