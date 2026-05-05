Here’s a handy **GitHub Actions Cheat Sheet** with the most common official actions and their latest stable versions (as of mid-2025):

## 🧰 Essential GitHub Actions Cheat Sheet

|Action|Use Case|Latest Stable Version|
|---|---|---|
|`actions/checkout`|Clone your repo into the runner|`@v4`|
|`actions/setup-node`|Install Node.js and configure caching|`@v4`|
|`actions/setup-python`|Install and configure Python|`@v5`|
|`actions/setup-java`|Install Java (JDKs, Maven, etc.)|`@v4`|
|`actions/cache`|Cache dependencies (npm, pip, etc.)|`@v4`|
|`actions/upload-artifact`|Upload build/test files to GitHub|`@v4`|
|`actions/download-artifact`|Download previously uploaded artifacts|`@v4`|
|`actions/github-script`|Run JavaScript with GitHub context|`@v7`|
|`actions/create-release`|Create a GitHub Release from workflow|`@v1` (no update yet)|
|`actions/upload-release-asset`|Attach files to a GitHub Release|`@v1`|

---

## 🧪 Useful for Testing and CI

|Action|Use Case|Version|
|---|---|---|
|`codecov/codecov-action`|Upload coverage reports to Codecov|`@v4`|
|`coverallsapp/github-action`|Upload coverage to Coveralls|`@v2`|
|`peter-evans/create-pull-request`|Auto-create PRs from workflow|`@v6`|
|`actions/setup-go`|Set up Go environment|`@v4`|
|`docker/login-action`|Login to Docker Hub/GCR|`@v3`|
|`docker/build-push-action`|Build and push Docker images|`@v5`|

---

## 🔐 Security and Linting

|Action|Use Case|Version|
|---|---|---|
|`github/codeql-action/init`|Start CodeQL analysis|`@v3`|
|`github/codeql-action/analyze`|Analyze your code for vulnerabilities|`@v3`|
|`super-linter/super-linter`|Run many linters at once (JavaScript, Python, etc.)|`@v6`|

---

## 📌 Tip: Always Check the Marketplace

You can always search or confirm versions here:  
👉 [https://github.com/marketplace/actions](https://github.com/marketplace/actions)