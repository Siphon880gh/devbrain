
GitHub Actions lets you **automate workflows** directly in your GitHub repository. It’s commonly used for:

- Running tests when you push code
- Deploying code automatically
- Formatting or linting code
- Scheduling tasks (e.g. nightly builds)

---

## 🧠 What is a GitHub Action?

A **GitHub Action** is a set of instructions that GitHub runs when a specific event happens in your repo (e.g., push, pull request).

It lives inside a **workflow file**—a special `.yml` file in your project’s `.github/workflows/` folder.

You may want to read all the documentations on the different Github Actions, in order to properly create your Github Action/Workflows: [[Github Action Documentations]]

You'll find there's a version number after many versions. The reasoning why: [[Why Github Actions Are Versioned]]

---

## ✅ Simple Example: Run Tests on Push

Let's say you want to run tests every time code is pushed to `main`.

Create this file:  
`.github/workflows/test.yml`

```yaml
name: Run Tests

on:
  push:
    branches: [main]

jobs:
  test:
    runs-on: ubuntu-latest

    steps:
    - name: Checkout code
      uses: actions/checkout@v3

    - name: Set up Node.js
      uses: actions/setup-node@v4
      with:
        node-version: '18'

    - name: Install dependencies
      run: npm install

    - name: Run tests
      run: npm test
```

### What this does:

1. **Triggers on push** to the `main` branch.
    
2. **Checks out your repo**.
    
3. **Sets up Node.js**.
    
4. **Installs dependencies**.
    
5. **Runs your test script** (`npm test`).
    

---

## 🔁 Trigger Events You Can Use

You can trigger workflows on many events:

```yaml
on:
  push:           # When code is pushed
  pull_request:   # When a PR is opened
  schedule:       # On a timer (cron)
  workflow_dispatch:  # Manual run button
```

---

## 🧱 Jobs and Steps

- A **workflow** contains one or more **jobs**.
    
- A **job** runs on a virtual machine.
    
- A **step** is a command or action within a job.
    

You can even run jobs in **parallel** or set **dependencies**.

---

## 🛠 Common Built-in Actions

|Action|What it does|
|---|---|
|`actions/checkout`|Clones your repo|
|`actions/setup-node`|Sets up Node.js environment|
|`actions/cache`|Speeds up workflow by caching files|
|`actions/upload-artifact`|Saves files from a workflow|

---

## 💡 Tips

- Logs appear in the **"Actions" tab** of your repo.
    
- Workflows must be in `.github/workflows/`.
    
- You can **reuse** actions from the GitHub Marketplace.
    

---

## ⚙️ Custom Workflows

You can combine your own shell scripts or Docker commands. Example:

```yaml
- name: Build project
  run: |
    echo "Building..."
    npm run build
```

---

## 🧪 Try it Yourself

1. Create a new GitHub repo.
    
2. Create a `.github/workflows/hello.yml` file.
    
3. Paste this:
    

```yaml
name: Hello World

on: [push]

jobs:
  say-hello:
    runs-on: ubuntu-latest
    steps:
    - run: echo "👋 Hello from GitHub Actions!"
```

4. Commit and push — check the **Actions tab**!
    

---

Want help setting up a GitHub Action for your own project (Node, Python, Docker, etc)? Just ask!