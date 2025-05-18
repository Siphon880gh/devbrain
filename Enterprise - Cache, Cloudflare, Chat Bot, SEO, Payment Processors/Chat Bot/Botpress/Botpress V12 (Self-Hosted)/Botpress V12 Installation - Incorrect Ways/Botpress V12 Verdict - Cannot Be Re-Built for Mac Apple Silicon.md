
## ❌ Why Botpress v12 Cannot Be Converted to an ARM64 Docker Container (as of May 2025)

After hours of experimentation, Weng confirms: **Botpress v12 cannot be reliably containerized for ARM64**, due to deep dependency issues — especially around **`node-sass`**, native modules, and Python version mismatches.

---

### 🔥 Main Blocker: `node-sass` Fails on ARM64

- `node-sass` requires native compilation via `node-gyp`
- Fails inconsistently on ARM64 — even when using pinned versions (`4.14.1`, `6.0.1`)
- Heavily hardcoded into Botpress v12’s build scripts and dependencies
- Substituting with Dart Sass is nontrivial (see below)
    

---

### 🧪 What Was Tried — and Why It Failed

| Node Version                     | Outcome                                                                                                                           |
| -------------------------------- | --------------------------------------------------------------------------------------------------------------------------------- |
| **12**                           | `node-sass@4.14.1` installs, but **breaks ARM64 dependencies** (e.g., native modules fail to build); had to ignore `engines.node` |
| **14**                           | `node-sass` fails to compile on ARM64                                                                                             |
| **16 (multi-stage)**             | Build fails                                                                                                                       |
| **16 (simplified single-stage)** | Still fails                                                                                                                       |
| **18**                           | Required by other packages, but `node-sass` fails                                                                                 |
| **20**                           | Slight improvement, but still breaks due to inconsistent `node-sass` behavior                                                     |

---

### ⚙️ Python: Build-Time Dependency Chaos

- `node-gyp` depends on **Python 2 syntax**
- System Python defaults to **Python 3** (especially with newer Node versions)
- To resolve older build failures (on Node 12–14), Python 3 is often needed by other tools
- A dual setup (Python 2 for native builds, Python 3 for other tools) was tried — but:
    - It’s **fragile**: switching between Python versions caused silent build or runtime issues
    - Errors are inconsistent across containers and local builds

---

### 💡 Dart Sass: Works on ARM64, But Hard to Integrate

While **Dart Sass (`sass` package)** is modern, portable, and works on ARM64:
- Botpress v12 directly **requires `node-sass`** in:
    - SCSS loader configs
    - Gulp tasks
    - Build pipeline scripts
- Projects use a **mix of `node-sass@4.x` and `6.x`** — further complicating substitution
    

> 🛠 Replacing `node-sass` with Dart Sass would require:
> - Updating all dependent packages
> - Modifying SCSS loader scripts and build tools
> - Auditing all styling-related imports

✅ **Technically possible**,  
❌ **Practically too invasive** for non-maintainers

---

### 🧱 SQLite3: Broken Binaries at Older Versions

- Original `sqlite3` version in `package.json` used to work
- But hosted binaries on Amazon S3 started returning **403 Forbidden**
- This caused `node-pre-gyp` to fail during install

🔗 References:
- [GitHub Issue #1389](https://github.com/TryGhost/node-sqlite3/issues/1389)
- [StackOverflow](https://stackoverflow.com/questions/79181767/botpress-v12-dependencies-incompatible-with-node-version)

✅ Fix: Use `sqlite3@5.0.0` — works on ARM64 with valid binaries  
❌ Risk: Updating further or downgrading breaks Botpress database layer

---

### 📌 Summary

Every path — changing Node versions, substituting Sass compilers, patching native modules — leads to failure or major refactoring. Even the most promising approach (Dart Sass) requires deep structural changes across multiple packages.

---

### ✅ Final Verdict

> As of May 2025, **Botpress v12 cannot be containerized for ARM64 without a full rebuild** of the frontend toolchain and deep patching of its dependencies.

**Recommended:**
- Use **x86_64 containers only**
- Instead of locally testing Botpress V12 on your Mac, test it on a Windows computer, OR host it on production server at a secret URL and test remotely.


---

Last Dockerfile work done on this was:

```
FROM --platform=linux/arm64 node:18-buster

WORKDIR /app

# Setup proper sources for ARM64
RUN echo "deb http://deb.debian.org/debian buster main" > /etc/apt/sources.list && \
echo "deb http://deb.debian.org/debian-security buster/updates main" >> /etc/apt/sources.list && \
echo "deb http://deb.debian.org/debian buster-updates main" >> /etc/apt/sources.list

# Install system dependencies
RUN apt-get update && DEBIAN_FRONTEND=noninteractive apt-get install -y \
python2 \
python2-dev \
python3 \
python3-dev \
python3-pip \
build-essential \
git \
sqlite3 \
libsqlite3-dev \
chromium \
chromium-driver \
libnss3 \
libfreetype6 \
libfreetype6-dev \
libharfbuzz-dev \
ca-certificates \
&& rm -rf /var/lib/apt/lists/*

# Set environment variables
ENV PYTHON=/usr/bin/python2
ENV npm_config_python=/usr/bin/python2
ENV npm_config_build_from_source=true
ENV NODE_ENV=development

# Copy package files
COPY package.json yarn.lock ./
COPY packages/ui-shared/package.json ./packages/ui-shared/
COPY packages/ui-admin/package.json ./packages/ui-admin/
COPY packages/ui-lite/package.json ./packages/ui-lite/
COPY packages/bp/package.json ./packages/bp/
COPY packages/ui-shared-lite/package.json ./packages/ui-shared-lite/

# Create package directories
RUN mkdir -p packages/ui-shared packages/ui-admin packages/ui-lite packages/bp packages/ui-shared-lite

# Install dependencies
RUN yarn install --network-timeout 300000 --ignore-platform --no-cache --ignore-optional --force --legacy-peer-deps && \
yarn add -D sass

# Install sqlite3 with specific version for Botpress compatibility
RUN cd node_modules && \
npm install sqlite3@5.0.0 --build-from-source --python=/usr/bin/python2 --engine-strict=false --legacy-peer-deps && \
cd ..

# Copy the rest of the application
COPY . .

# Build the application
RUN yarn build

# Expose port
EXPOSE 3000

# Start the application
CMD ["yarn", "start"]

