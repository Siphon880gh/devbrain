Redis is a versatile in-memory data store. Redis supports a wide range of other use cases thanks to its speed, data structures, and pub/sub capabilities.

### 🔧 Redis Use Cases

|**Category**|**Use Case**|
|---|---|
|**1. Caching**|Speed up access to frequently used data, API responses, or DB query results.|
|**2. Session Store**|Store user session data (e.g. in Express or Flask apps) for authentication.|
|**3. Pub/Sub**|Real-time messaging systems, live notifications, or chat apps.|
|**4. Rate Limiting**|Track user actions (e.g. logins, API calls) to prevent abuse.|
|**5. Queueing**|Task queues or background job processing (e.g. with Bull, Sidekiq, RQ).|
|**6. Leaderboards**|Use sorted sets to maintain real-time game or competition rankings.|
|**7. Real-time Analytics**|Aggregate counters, page views, or stats with high throughput.|
|**8. Geospatial Indexing**|Store and query locations, distances, and proximity searches.|
|**9. Stream Processing**|Use Redis Streams to build log-style data pipelines.|
|**10. Lightweight DB**|Store temporary or ephemeral key-value data structures (non-persistent).|

Redis supports various data types—strings, hashes, lists, sets, sorted sets, bitmaps, hyperloglogs, and streams—which enable these use cases.