Use this guide when you already have n8n running on Heroku via our container image and want to upgrade to a different n8n version.

## Prerequisites

- [Heroku CLI](https://devcenter.heroku.com/articles/heroku-cli) installed and logged in
- [Docker](https://docs.docker.com/get-docker/) installed
- Your Heroku app name (e.g. `n8n-tc`)

---

## Step 1: Set the n8n version in the Dockerfile

Edit `n8n-heroku/Dockerfile` and change the base image line:

```dockerfile
FROM n8nio/n8n:latest
```

Or pin a specific version:

```dockerfile
FROM n8nio/n8n:1.118.2
```

**Version reference** (see [versioning.md](versioning.md)):

| Tag | Notes |
|-----|-------|
| `latest` | Current release; may be 2.x with breaking changes |
| `1.123.24` | Newer 1.x; may exceed 512MB on Heroku Basic |
| `1.118.2` | Middle ground; fits Heroku Basic 512MB |
| `1.115.3` | Older, lighter |

Release list: https://docs.n8n.io/release-notes/1-x

---

## Step 2: Build, push, and release

From the repo root:

```bash
cd n8n-heroku
heroku container:login
docker build --platform linux/amd64 --no-cache -t registry.heroku.com/YOUR-APP-NAME/web .
docker push registry.heroku.com/YOUR-APP-NAME/web
heroku container:release web -a YOUR-APP-NAME
```

Replace `YOUR-APP-NAME` with your Heroku app name.

- `--platform linux/amd64` – Required on Apple Silicon; Heroku runs amd64
- `--no-cache` – Ensures a fresh pull of the chosen n8n version

---

## Step 3: Verify

```bash
heroku open -a YOUR-APP-NAME
heroku logs --tail -a YOUR-APP-NAME
```

---

## Troubleshooting

| Issue | Fix |
|-------|-----|
| R14 (memory exceeded) | Use an older version (e.g. 1.118.2 or 1.115.3) |
| "Authentication failed" | Do not change `N8N_ENCRYPTION_KEY`; it must stay fixed |
| Build fails on M1/M2 | Ensure `--platform linux/amd64` is in the build command |
