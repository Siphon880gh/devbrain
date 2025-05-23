Requirements:
- For express with react server
- Make sure Redis is installed on your computer/server: [[_Redis Install]]

Prompt Cursor AI or Copilot:
- Adjust the Mongoose version. You can look into package.json for the version/
```
Add Redis caching to Mongoose queries (e.g., .find() or .findAll()), compatible with **Mongoose v8.14.2**. I believe it involves:

1. Install Redis:
"""
npm install redis
"""

2. Create redisClient.js:

"""
const redis = require('redis');
const client = redis.createClient();
client.connect();
module.exports = client;
"""

3. Create cacheUtils.js:

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
  console.log(`Cache set: ${key}`);
  return result;
}

module.exports = { cacheQuery };
"""

4. Example usage in Mongoose controller/service:

"""
const { cacheQuery } = require('./cacheUtils');

const users = await cacheQuery({
  key: 'users:all',
  ttl: 86400,
  queryFn: () => User.find().lean()
});
"""

5. Optional: invalidate cache on data mutation:

"""
await redisClient.del('users:all');
"""

Use this pattern for .find(), .findOne(), or .aggregate() queries where caching is helpful.
```

Configuration layer for the caching - Prompt the AI with:
```
Awesome. Lets add a config file so the web admin can set the ttl from a json file. at the endpoint, should probably load the cache ttl setting from the json file? or is it going to automatic load the json file without having to load it from the endpoint?
```

Add purging by authenticated endpoint - Prompt the AI with:
```
Awesome. Need an endpoint to purge all cache manually. Let's make sure the endpoint to purge will only work if POSTED with a req.body.password that matches CACHE_PURGE_PASSWORD from .env file
```

----

When ready to deploy, make sure the live server also has Redis (Not just your local development computer).

If Heroku, add Redis Cloud which has a free account as of 5/2025:
1 of 2
![[Pasted image 20250523070251.png]]

2 of 2
![[Pasted image 20250523070159.png]]
^ Note Heroku says to "Submit Order Form". You will be accepted immediately.

---

Challenge:

Console log the cache set, hit (retrieval), and purges:
```
Cache hit: deals:all  
Cache reset: Completed All  
Cache set: deals:all (TTL: 86400s)  
Cache hit: deals:all
```

Postman lets you POST with the password to the authenticated purge endpoint. Following that you should see `Cache reset: Completed All`

Opening a fresh database query will set the cache. All subsequent queries will hit/retrieve