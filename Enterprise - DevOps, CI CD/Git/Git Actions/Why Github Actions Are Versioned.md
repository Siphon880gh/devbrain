
When you see something like `uses: actions/checkout@v3` or `uses: actions/setup-node@v4`, the `@v3` or `@v4` refers to the **version of the GitHub Action** you are using.

### 🔢 Why Version Numbers Matter

GitHub Actions are open-source packages published by the community or GitHub itself. Just like any dependency, they get updates over time. Specifying a version ensures:

- ✅ **Consistency** – Your workflow behaves the same every time it runs.
- 🛡️ **Stability** – You avoid unexpected breaking changes when a newer version is released.
- 🧩 **Control** – You can decide when to upgrade.

If you have actions that are not compatible with each other, you can look up the Tags at their respective Github repo to figure out which version is which dates, and you'll use the versions with nearby dates.

---

### ✅ Example

```yaml
uses: actions/checkout@v3
```

This means:

> Use version 3 of the `actions/checkout` action.

---

### 🔄 How to Know Which Version to Use

You can check the **latest stable version** of an action on its GitHub page or the [GitHub Actions Marketplace](https://github.com/marketplace?type=actions).

Example:

- [`actions/checkout`](https://github.com/actions/checkout)
- [`actions/setup-node`](https://github.com/actions/setup-node)

Documentations for Specific Actions:
- Eg. Checkout action: https://github.com/actions/checkout - The documentation is in the Github Repo Readme
- **Change the URL at the final subpath depending on which action you want to read documentation for (At the Github Repo Readme)**

---

### 🛠 Versioning Tips

- Use `@v3` or `@v4` for latest major version and stability.
- Avoid `@main` or `@master` in production—it pulls the latest code, which may change anytime.
- You can pin to exact commits for maximum control:

```yaml
uses: actions/checkout@v3
# OR
uses: actions/checkout@v3.5.0
# OR
uses: actions/checkout@<commit-sha>
```
