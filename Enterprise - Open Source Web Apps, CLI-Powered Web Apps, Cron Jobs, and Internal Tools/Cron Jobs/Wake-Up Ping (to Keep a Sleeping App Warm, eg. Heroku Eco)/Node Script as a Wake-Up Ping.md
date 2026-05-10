For a quick express server.js that wakes up apps:
```
var reqTimer = setTimeout(function wakeUp() {
   request("https://YOUR-APP.herokuapp.com", function() {
      console.log("Dyno woken up by ping");
   });
   return reqTimer = setTimeout(wakeUp, 1200000);
}, 1200000); // Every 20 minutes
```

---

But below is an extensible **Express.js** server you can setup different types of wake-up pings (which URL, what time intervals)

## `.nvmrc`

```
22.8.0
```

## `package.json`

```
{
  "name": "url-pinger",
  "version": "1.0.0",
  "description": "Express app that pings multiple URLs at configurable intervals.",
  "main": "server.js",
  "type": "module",
  "scripts": {
    "start": "node server.js"
  },
  "engines": {
    "node": "22.8.0"
  },
  "dependencies": {
    "express": "^4.18.3"
  }
}
```

## `server.js`
- I'm using port 3101 instead of the usual ports 3000, 3001, etc to reduce the chance of colliding with other NodeJS apps running at those ports. Feel free to change it to whatever port makes sense to you.
```
import express from "express";

const app = express();

const PORT = process.env.PORT || 3101;

/**
 * Add URLs here.
 *
 * Each entry should have:
 * - url: The URL to ping
 * - intervalMinutes: How often to ping the URL, in minutes
 *
 * Example:
 * {
 *   url: "https://example.com",
 *   intervalMinutes: 10
 * }
 */
const pingTargets = [
  {
    url: "https://example.com",
    intervalMinutes: 10
  },
  {
    url: "https://example.org",
    intervalMinutes: 15
  },
  {
    url: "https://example.net",
    intervalMinutes: 30
  }
];

async function pingUrl(target) {
  const startedAt = new Date();

  try {
    const response = await fetch(target.url, {
      method: "GET",
      headers: {
        "User-Agent": "url-pinger/1.0"
      }
    });

    console.log(
      `[${startedAt.toISOString()}] Pinged ${target.url} - Status: ${response.status}`
    );
  } catch (error) {
    console.error(
      `[${startedAt.toISOString()}] Failed to ping ${target.url}: ${error.message}`
    );
  }
}

function startPingJobs() {
  for (const target of pingTargets) {
    const intervalMs = target.intervalMinutes * 60 * 1000;

    console.log(
      `Starting ping job for ${target.url} every ${target.intervalMinutes} minutes`
    );

    // Ping once immediately on startup.
    pingUrl(target);

    // Then ping repeatedly based on this target's interval.
    setInterval(() => {
      pingUrl(target);
    }, intervalMs);
  }
}

app.get("/", (req, res) => {
  res.json({
    status: "ok",
    message: "URL pinger is running",
    port: PORT,
    targets: pingTargets
  });
});

app.get("/health", (req, res) => {
  res.json({
    status: "healthy"
  });
});

app.listen(PORT, () => {
  console.log(`Express server running on port ${PORT}`);
  startPingJobs();
});
```

Install and run:

```
nvm usenpm install
npm start
```

Test:

```
curl http://localhost:3101
curl http://localhost:3101/health
```

---

You'll want to make sure the server.js will restart when crashed. Setup pm2 and its ecosystem.config.js ([[PM2 - _Beginner PRIMER]], [[PM2 ecosystem.config.js - _PRIMER]])

An ecosystem.config.js:
```
module.exports = {
  apps: [
    {
      name: "app-3100",
      cwd: "/home/user/htdocs/domain.com/app/url-pinger",
      script: "server.js",
      interpreter: "/home/user/.nvm/versions/node/v22.8.0/bin/node",

      autorestart: true,
      restart_delay: 5000,
      exp_backoff_restart_delay: 100,
      min_uptime: "10s",
      max_restarts: 10,
      max_memory_restart: "512M",

      watch: false,

      // Use fork for a single process.
      // Use cluster only if the app is safe to run in multiple processes.
      exec_mode: "fork",
      instances: 1,

      // Optional: renames PM2's default instance variable
      instance_var: "INSTANCE_ID",

      kill_timeout: 5000,
      log_date_format: "YYYY-MM-DD HH:mm Z",

      env_production: {
        NODE_VERSION: "22.8.0",
        NODE_ENV: "production",
        PORT: 3100
      }
    }
  ]
};
```