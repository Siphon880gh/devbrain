**Vocab**: npm ci stands for clean install. It does not mean continuous integration, even though it is commonly used in CI/CD pipelines because it gives fast, repeatable installs from package-lock.json.

Both `npm ci` and `npm install` install Node.js dependencies, but they are meant for different situations.

## `npm install`

`npm install` is the general-purpose command.

It reads `package.json`, installs dependencies, and can also update **`package-lock.json`** if needed. That makes it useful during development, especially when you are adding new packages or updating dependency versions.

Because it can modify the lockfile, it is more flexible, but also less strict.

## `npm ci`

`npm ci` means **clean install**.

It installs dependencies strictly from **`package-lock.json`**. It does not try to resolve versions in a new way. It also removes `node_modules` first if that folder already exists. If `package.json` and `package-lock.json` do not match, it fails instead of trying to fix the mismatch.

That makes `npm ci` better for situations where you want the install to be exact and repeatable.

## When to use each

Use `npm install` when:
- you are actively developing
- you are adding or updating packages
- you want npm to refresh the lockfile if needed

Use `npm ci` when:
- you want a clean install
- you want to install exactly what is in the lockfile
- you are running CI pipelines
- you are building Docker images
- you want more predictable results
## Can you use `npm ci` outside Docker?

Yes.

If a repo already has a valid `package-lock.json`, you can often run `npm ci` on your local machine or on the server where the app is hosted. It is not limited to Docker. It is simply stricter than `npm install`.

So while `npm ci` is especially common in Docker and CI systems, it can also be a good option any time you want **consistency** and do not want npm making changes to the dependency tree.