 In PM2, `exec_mode` is an option that controls how your application will be run in a way that scales to cpu bounded apps:

1. **Fork Mode (default)**: This is the standard mode where PM2 runs your application in a single process. It's useful for development and simple setups, but it doesn't take advantage of multi-core systems.

2. **Cluster Mode**: This mode allows PM2 to run your application in multiple instances (workers) by creating child processes. These processes share the same port and help distribute incoming requests across the worker processes, making it ideal for production environments. Cluster mode ensures that all CPU cores are utilized.

   - **instances**: You can specify the number of instances (workers) to be created. For example:
     - Setting `instances` to a number like 4 will create 4 worker processes.
     - Setting `instances` to `max` will spawn as many workers as the number of available CPU cores.

   **Example configuration:**
   ```bash
   pm2 start app.js --name "my-app" --exec_mode cluster --instances 4
   ```

   If you're unsure how many cores are available, setting `instances` to `max` will automatically use all available CPU cores.

In summary, for production environments, **cluster mode** is recommended for better performance and scalability, while **fork mode** is often used for local development or simpler applications.


For concurrency and i/o bounded apps, unfortunately pm2 does not support multithreading, however newer versions of NodeJS does support multithreading and this would be done at the app coding level instead of the process supervisor level.