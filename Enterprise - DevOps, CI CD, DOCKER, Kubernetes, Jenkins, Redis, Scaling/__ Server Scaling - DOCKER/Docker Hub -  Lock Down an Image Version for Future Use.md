
So you've pulled a Docker image and successfully ran it as a container. Now you want to **save the exact version** so you can pull **that same image later** — maybe on a new computer or server — and ensure everything still works.

---

### 🔍 Step 1: Find the Image Version

Run this command to check the version of the image you’re using (in this example, `zadam/trilium`):

```bash
docker images | grep zadam/trilium
```

You might see something like this:

```
zadam/trilium    latest    3aeb08e9a0f8   11 months ago   449MB
```

If the image has a version tag (like `0.62.4`), great — note it down.

But if it just says `latest`, you'll want to use the **digest** instead, because `latest` can change over time.

---

### 🧬 Step 2: Get the Image Digest

Run this to inspect the image and find the **digest**:

```bash
docker inspect zadam/trilium:latest
```

Scroll until you find the `"RepoDigests"` section. It will look something like this:

```json
"RepoDigests": [
  "zadam/trilium@sha256:a0b5a6a5fd7a64391ae6039bbcd5493151a77a1d5470ef5911923c64d0c232c0"
]
```

Copy that entire `sha256:...` digest and save it somewhere (e.g., a README or setup script).

---

### 📥 Step 3: Pull the Same Image in the Future

To pull the **exact** same version later:

- If you know the version tag:
    
    ```bash
    docker pull zadam/trilium:0.62.4
    ```
    
- If you're using the digest:
    
    ```bash
    docker pull zadam/trilium@sha256:a0b5a6a5fd7a64391ae6039bbcd5493151a77a1d5470ef5911923c64d0c232c0
    ```
    