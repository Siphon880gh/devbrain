👉 **FastAPI does _not_ come with a built-in status/health check endpoint out of the box.**

This is a tutorial on how to implement a health check. It returns a JSON string representing the API's health. It's not a full status page.

---

Here’s a production-ready /status endpoint for FastAPI that checks:
✅ App uptime
✅ CPU & disk usage
✅ PostgreSQL DB connection
✅ Redis connection

You can trim or customize it based on your stack.

```
from fastapi import FastAPI
from fastapi.responses import JSONResponse
import time, psutil, asyncio
import asyncpg
import aioredis

app = FastAPI()

start_time = time.time()

# Configure your DB and Redis settings here
POSTGRES_DSN = "postgresql://user:password@localhost:5432/mydb"
REDIS_URL = "redis://localhost"

@app.get("/status", summary="Health Check")
async def health_check():
    uptime = int(time.time() - start_time)
    status = {
        "status": "ok",
        "uptime_seconds": uptime,
        "resources": {},
        "dependencies": {},
    }

    # Check CPU & Disk
    try:
        status["resources"]["cpu_percent"] = psutil.cpu_percent(interval=0.1)
        disk = psutil.disk_usage('/')
        status["resources"]["disk_percent"] = disk.percent
    except Exception as e:
        status["resources"]["error"] = str(e)

    # Check PostgreSQL connection
    try:
        conn = await asyncpg.connect(dsn=POSTGRES_DSN)
        await conn.execute("SELECT 1")
        await conn.close()
        status["dependencies"]["postgres"] = "connected"
    except Exception as e:
        status["dependencies"]["postgres"] = f"error: {e}"
        return JSONResponse(content=status, status_code=503)

    # Check Redis connection
    try:
        redis = aioredis.from_url(REDIS_URL)
        pong = await redis.ping()
        status["dependencies"]["redis"] = "connected" if pong else "no ping"
        await redis.close()
    except Exception as e:
        status["dependencies"]["redis"] = f"error: {e}"
        return JSONResponse(content=status, status_code=503)

    return JSONResponse(content=status, status_code=200)

```

Note that you may have to install those utils:
```
 pip install psutil asyncpg aioredis
```


---

If first time using FastAPI, you may need to install the core packages:
```
pip install fastapi uvicorn
```

And you run the server with (assuming `./main.py`):
```
fastapi % uvicorn main:app --reload 
```