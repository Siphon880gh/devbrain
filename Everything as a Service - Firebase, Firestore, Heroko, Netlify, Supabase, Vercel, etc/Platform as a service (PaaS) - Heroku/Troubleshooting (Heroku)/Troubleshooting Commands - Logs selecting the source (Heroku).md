## Log Sources Overview

|**Source**|**Flag(s)**|**What you’ll see**|
|---|---|---|
|**app**|`--source app`|Your dyno processes’ stdout/stderr|
|**platform**|`--source heroku`|Heroku system events (router, dyno restarts, SSL)|
|**api**|`--source app --dyno api`|Admin actions (deploys, config-var changes)|
|**add-ons**|`--source <add-on-slug>`|Third-party add-on streams (Postgres, Redis, etc.)|
|**build logs**|**Dashboard only**|Slug compile & release logs (Activity → Builds)|

---

## Common Filters & Examples

- **System events only**
    
    ```bash
    heroku logs --source heroku
    ```
    
- **API actions (deploys, config changes)**
    
    ```bash
    heroku logs --source app --dyno api
    ```
    
- **Specific add-on (e.g. Postgres)**
    
    ```bash
    heroku logs --source heroku-postgresql
    ```
    
- **Live stream instead of a one-time dump**
    
    ```bash
    heroku logs --tail
    ```
    
- **Combine filter + live stream**
    
    ```bash
    heroku logs --source app --tail
    ```
    

---

## Dyno & Process-Type Filters

- **By specific dyno**
    
    ```bash
    # e.g. router events
    heroku logs --source heroku --dyno router
    ```
    
- **By process type** (Fir stack)
    
    ```bash
    heroku logs --process-type web
    heroku logs --process-type worker
    ```
    

Feel free to mix `--tail`, `-n <lines>`, and these filters to get exactly the slice of logs you need.