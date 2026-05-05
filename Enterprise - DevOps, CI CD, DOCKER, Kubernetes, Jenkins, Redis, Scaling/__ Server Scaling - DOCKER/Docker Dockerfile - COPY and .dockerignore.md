
In a Dockerfile:

```dockerfile
COPY . .
```

### What it does:
* Recursively copies everything from the build context directory into the image’s working directory.
* Includes hidden files (like `.env`, `.git`, etc.).
* Respects `.dockerignore`.
* Even includes all `node_modules` folders, including ones inside subdirectories, unless excluded via `.dockerignore`.

---
### To exclude `node_modules`:

Use a `.dockerignore` file like:

```
node_modules
**/node_modules
.dockerignore
.git
```

This keeps your image clean and speeds up the build by preventing unnecessary files from being copied.