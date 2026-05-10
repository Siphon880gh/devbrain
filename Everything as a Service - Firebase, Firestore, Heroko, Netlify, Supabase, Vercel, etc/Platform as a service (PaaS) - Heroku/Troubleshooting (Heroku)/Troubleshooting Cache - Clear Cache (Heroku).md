Heroku maintains a build cache between deploys to speed up recurring dependency installs (npm modules, gems, etc.). Occasionally you’ll need to purge that cache—e.g. if you’ve bumped a dependency major-version, are seeing weird build failures, or want to reclaim disk usage. Here’s how you do it with the Heroku CLI:

---

## 1. Using the official “builds” command (Heroku CLI v7+)

Heroku’s newer CLI versions include a built-in cache-purge command:

```bash
# Purge the build cache for your app
heroku builds:cache:purge -a your-app-name
```

- **Install**: If you don’t have it, update the Heroku CLI:
    
    ```bash
    heroku update
    ```
    
- **What it does**: Deletes the cache folder under the hood so that the next build starts “from scratch.”
    

---

## 2. Using the `heroku-repo` plugin

If your CLI doesn’t support `builds:cache:purge`, you can install the community plugin:

```bash
# 1. Install the plugin
heroku plugins:install heroku-repo

# 2. Purge the cache via the plugin
heroku repo:purge_cache -a your-app-name
```

- **Why a plugin?** Older CLI versions didn’t include a cache-purge command, so this adds that functionality.
    

---

## 3. When to clear the cache

1. **Dependency version bumps**  
    If you upgrade a major version of a package (e.g. dropping Node 12 → 14, or Rails 5 → 6) and the old cached modules conflict, purging forces a fresh install.
    
2. **Stale or corrupted cache**  
    Random build errors—missing files, inconsistent lockfile behavior, or modules not found—often trace back to a bad cache state.
    
3. **Disk usage concerns**  
    If you add or remove large dependencies (e.g. moving from heavy image-processing libs to lighter ones), the cache can grow. Purging reclaims space.
    
4. **Buildpack changes**  
    When you change or reorder buildpacks (e.g. add the apt buildpack for Puppeteer libs), old caches may skip installing the new pack’s assets.
    

---

## 4. After purging

1. **Trigger a new deploy** (e.g. push to Git, trigger CI, or run `heroku builds:create`).
    
2. **Monitor output**—you’ll see a full reinstall of all dependencies.
    
3. **Verify** that the build succeeds with your updated dependencies or buildpacks.
    

---

**Tip:** You rarely need to purge on every deploy—only when you suspect the cache is causing trouble. Otherwise you’ll lose the speedup that caching provides.