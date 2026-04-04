
**Vocab:** `npm ci` stands for **clean install**. It does **not** mean continuous integration, even though it is often used in CI/CD pipelines because it provides fast, repeatable installs from `package-lock.json`.

When building Node.js apps in Docker, you may see either `npm ci` or `npm install` in the Dockerfile. `npm ci` is usually a better choice than `npm install`.

The main reason for `npm ci` is reproducibility. Docker builds are meant to be predictable, so the same build process should produce the same result every time.

`npm ci` is designed for that kind of consistency. It installs dependencies strictly from `package-lock.json`, rather than recalculating versions. It also removes `node_modules` first if it already exists, and it fails if `package.json` and `package-lock.json` do not match.

That behavior makes it a strong fit for Docker. A Docker image is supposed to be a controlled environment. The Dockerfile usually starts from a known base image, such as a specific Node.js version on a specific Linux distribution. From there, each step should behave the same way every time. Running `npm ci` inside that environment helps keep dependency installation stable across builds, machines, and deployments.

By contrast, `npm install` is more flexible, but that flexibility can make Docker builds less predictable. It may update the lockfile or resolve dependencies differently depending on what has changed. In a container build, that is usually not what you want.

That is why `npm ci` is so common in Dockerfiles: it supports Docker’s main goal of creating clean, reproducible build environments.