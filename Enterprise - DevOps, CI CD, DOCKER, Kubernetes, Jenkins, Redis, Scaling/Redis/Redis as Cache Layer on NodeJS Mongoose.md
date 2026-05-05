## 🧠 Redis Caching for Mongoose Queries


### 🎙️ Introduction

The Redis implementation serves as a **high-performance caching layer** between your Express.js API and MongoDB database, specifically optimized for exercise data retrieval. It uses a mature Redis client (v5.1.0) with robust connection management and provides significant performance improvements for frequently accessed exercise data while maintaining data consistency through strategic cache invalidation.


### ✅ Requirements
- Your stack includes **Express with React server**
- **Redis must be installed on machine** (local machine for localhost or on your server for remote app). Refer to [[_Redis Install on Machine]]

### 🫱🏻 How to use this tutorial
Turn on persistent table of contents

---

## METHOD A: AI Generate the code

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


## METHOD B: Create the code

### Redis Version and Dependencies

**Version**: A project could use Redis client version **5.1.0** (from `package.json`):
```json
"redis": "^5.1.0"
```


### 1. **Core Redis Client** (`src/utils/redisClient.js`)
```javascript
import { createClient } from 'redis';
```

**Key Exports**:
- `client` - The main Redis client instance
- `initRedis()` - Initializes the Redis connection
- `isConnected()` - Checks connection status
- `closeConnection()` - Gracefully closes the connection

### 2. **Cache Utilities** (`src/utils/cacheUtils.js`)
```javascript
import { client as redisClient } from './redisClient.js';
```

**Key Functions**:
- `cacheQuery({ key, ttl, queryFn })` - Caches Mongoose query results
- `invalidateCache(key)` - Invalidates specific cache keys
- `purgeAllCache()` - Flushes all cache entries

### 3. **Cache Configuration** (`src/utils/cacheConfig.js`)
```javascript
import { loadConfig, updateConfig } from './src/utils/cacheConfig.js';
```

### Main Redis Activities

#### 1. **Connection Management**
- **Connection URL**: Uses `REDISCLOUD_URL` environment variable or falls back to `redis://localhost:6379`
- **Reconnection Strategy**: Exponential backoff (2^retries * 100ms, max 3000ms)
- **Event Handling**: Comprehensive logging for connect, error, reconnecting, and end events

#### 2. **Caching Strategy**
The Redis implementation follows a **cache-aside pattern** with the following TTL configuration:
```json
{
  "ttl": {
    "exercises": {
      "all": 86400,      // 24 hours
      "featured": 1800,   // 30 minutes
      "category": 7200    // 2 hours
    },
    "default": 86400
  }
}
```

#### 3. **Primary Use Cases**

**a) Exercise Caching** (`server.js`):
- Caches all exercises: `exercises:all`
- Paginated exercises: `exercises:page:${page}:limit:${limit}`
- Limited/offset queries: `exercises:limit:${limit}:offset:${offset}`

**b) Cache Invalidation**:
- Automatic cache purging after:
  - Creating new exercises
  - Updating existing exercises
  - Manual purge via API endpoints

**c) Authentication**:
- Cache purge operations protected by `REDIS_CACHE_PURGE_PASSWORD`

#### 4. **Integration Points**
- **Server Initialization**: Redis is initialized alongside MongoDB on server startup
- **API Endpoints**: Multiple endpoints use cache-first strategy for exercise retrieval
- **Data Seeding**: Cache is purged during database seeding operations
- **Graceful Shutdown**: Proper connection cleanup on server termination

#### 5. **Error Handling**
- **Fallback Strategy**: If Redis fails, queries fall back to direct MongoDB access
- **Connection Resilience**: Automatic reconnection with exponential backoff
- **Comprehensive Logging**: All cache operations are logged for debugging

---

## 🧪 Test & Logs

Use `console.log()` to track your cache status:

```
Cache hit: exercises:all  
Cache reset: Completed All  
Cache set: exercises:all (TTL: 86400s)  
Cache hit: exercises:all
```

Use **Postman** or any API tool to POST to the purge endpoint with the correct password in the body. You should see:

```
Cache reset: Completed All
```

Then, run a fresh query to re-populate the cache—subsequent calls will hit the cache.