Let's say your Mongoose/Mongo queries get cached.

Console logs:
```
Cache hit: deals:all  
Cache reset: Completed All  
Cache set: deals:all (TTL: 86400s)  
Cache hit: deals:all
```

Let's say Postman lets you POST with the password to the authenticated purge endpoint. Following that you should see `Cache reset: Completed All`

Opening a fresh database query will set the cache. All subsequent queries will hit/retrieve