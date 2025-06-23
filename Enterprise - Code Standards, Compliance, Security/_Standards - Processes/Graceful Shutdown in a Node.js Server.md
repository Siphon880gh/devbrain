### Why Graceful Shutdown Matters

A graceful shutdown lets your application finish in-flight work, release resources, and exit predictably when it receives a termination signal (`SIGINT`, `SIGTERM`, container stop, etc.). Skipping this step risks data loss, hanging sockets, or corrupted state.

### Core Steps

|Step|What to Do|Code Snippet|
|---|---|---|
|**1. Capture OS Signals**|Listen for `SIGINT` & `SIGTERM` as the entry point of shutdown logic.|`js process.on('SIGINT', () => gracefulShutdown('SIGINT')); process.on('SIGTERM', () => gracefulShutdown('SIGTERM'));`|
|**2. Close Network Listeners**|Stop accepting new connections; let existing ones finish.|`js const server = app.listen(PORT); /* … */ server.close(() => console.log('[Shutdown] Express closed'));`|
|**3. Flush External Resources**|Finish async work and disconnect from databases, caches, queues, etc.|`js if (mongoose.connection.readyState === 1) await mongoose.connection.close(); if (redisClient.isOpen) await redisClient.quit();`|
|**4. Exit with a Status**|Call `process.exit(0)` once everything is confirmed closed (use a timeout fallback).|`js setTimeout(() => process.exit(0), 5000);`|

### Sample Wrapper

```js
app.listen(PORT, () => {
  console.log(`Server running on port ${PORT}`);
 
	const gracefulShutdown = async (signal) => {
	  console.log(`\n[${signal}] Starting graceful shutdown…`);
	
	  // 1. Stop HTTP server
	  await new Promise((res) => server.close(res));
	
	  // 2. Close DB / cache
	  if (mongoose.connection.readyState === 1) await mongoose.connection.close();
	  if (redisClient?.isOpen) await redisClient.quit();
	
	  console.log('[Shutdown] Complete, exiting');
	  process.exit(0);
	}; // gracefulShutdown
	
  // Handle shutdown signals
  process.on('SIGINT', () => gracefulShutdown('SIGINT'));
  process.on('SIGTERM', () => gracefulShutdown('SIGTERM'));
	
});
```

### Good Practices

- **Always await**: Use `await` or callbacks to be sure each close actually completes.
- **Add a global timeout**: Force‐exit in e.g. 15 seconds to avoid container death loops.
- **Log each step** for observability; it speeds up debugging in prod.
