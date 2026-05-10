
PM2 by default uses the environmental variable "NODE_APP_INSTANCE" to identify 0, 1, 2, 3 depending on which instance it is that's running in your cluster

The problem is that's actually a pretty common wording convention. A lot of technologies come up with the same variable name without meaning to conflict with each other.

PM2 allows you to change that variable name from `process.env.NODE_APP_INSTANCE` to something else like `process.env.INSTANCE_ID`

---

## Why `instance_var` Helps When Using PM2 with `node-config`

The `node-config` library is a popular configuration management tool for Node.js applications. It lets you organize settings into separate config files, such as:

```text
config/default.json
config/development.json
config/production.json
```

The usual idea is:

- `default.json` contains the base settings.
    
- `development.json`, `staging.json`, or `production.json` override settings based on the current environment.
    
- The active environment is usually controlled by `NODE_ENV`.
    

For example:

```bash
NODE_ENV=production node server.js
```

That tells `node-config` to load production-specific configuration.

### The Conflict with PM2

The tricky part is that `node-config` also uses another environment variable:

```bash
NODE_APP_INSTANCE
```

`node-config` uses `NODE_APP_INSTANCE` to load instance-specific config files. For example, if this is set:

```bash
NODE_APP_INSTANCE=3
```

then `node-config` may try to load a file like:

```text
default-3.json
```

This is useful when you intentionally want different config files for different app instances. ([GitHub](https://github.com/node-config/node-config/wiki/Multiple-Node-Instances?utm_source=chatgpt.com "Multiple Node Instances"))

But PM2 also uses `NODE_APP_INSTANCE`.

In PM2 cluster mode, PM2 sets `NODE_APP_INSTANCE` so each running process can identify itself. For example, with 4 instances, PM2 may assign:

```text
0
1
2
3
```

That lets your app do things like:

```js
if (process.env.NODE_APP_INSTANCE === "0") {
  startCronJobs();
}
```

PM2’s docs describe this as a way to tell cluster processes apart, and PM2 also allows this variable to be renamed with `instance_var`. ([PM2](https://pm2.keymetrics.io/docs/usage/environment/?utm_source=chatgpt.com "Environment Variables"))

### Why This Causes Problems

The problem is that PM2 and `node-config` both use the same variable name for different purposes.

PM2 uses:

```bash
NODE_APP_INSTANCE=0
```

to mean:

> This is PM2 cluster process number 0.

But `node-config` may interpret that as:

> Load the config file for app instance 0.

That can cause confusing errors if `node-config` expects files like:

```text
default-0.json
production-0.json
```

but those files do not exist or were never intended to exist. This PM2 + `node-config` conflict has been reported historically because both tools read `NODE_APP_INSTANCE` differently. ([GitHub](https://github.com/Unitech/pm2/issues/2045?utm_source=chatgpt.com "Error using PM2 with node-config when ..."))

### The Fix: Rename PM2’s Variable

To avoid the conflict, you can tell PM2 to use a different environment variable name.

Example:

```js
module.exports = {
  apps: [
    {
      name: "my-app",
      script: "server.js",
      instances: 4,
      exec_mode: "cluster",

      // Rename PM2's default NODE_APP_INSTANCE variable
      instance_var: "INSTANCE_ID"
    }
  ]
};
```

Now PM2 will expose the cluster ID as:

```js
process.env.INSTANCE_ID
```

instead of:

```js
process.env.NODE_APP_INSTANCE
```

The value is still the same style of value:

```text
0
1
2
3
```

But the variable name no longer collides with `node-config`.

### Why This Helps with TypeScript

TypeScript does not directly conflict with `NODE_APP_INSTANCE`.

The benefit is more about **cleaner, safer application code**.

In a TypeScript app, you may define your expected runtime environment variables in one place. For example:

```ts
type RuntimeEnv = {
  NODE_ENV: "development" | "staging" | "production";
  INSTANCE_ID?: string;
  PORT: string;
};
```

Using a custom name like `INSTANCE_ID` makes the purpose clearer:

```ts
const instanceId = process.env.INSTANCE_ID;
```

That is easier to understand than:

```ts
const instanceId = process.env.NODE_APP_INSTANCE;
```

because `NODE_APP_INSTANCE` sounds like a Node.js or `node-config` concept, while `INSTANCE_ID` sounds like your app’s own runtime instance ID.

This becomes helpful when your project has a typed environment layer, for example:

```ts
export const env = {
  nodeEnv: process.env.NODE_ENV,
  port: Number(process.env.PORT || 3000),
  instanceId: process.env.INSTANCE_ID || "0"
};
```

Now the rest of your app can use:

```ts
env.instanceId
```

instead of directly depending on PM2’s default variable name.

### Why This Helps with Runtime Variables

Runtime variables are environment variables that exist when the app starts. They may come from:

- PM2
    
- Docker
    
- Kubernetes
    
- `.env` files
    
- CI/CD deployment settings
    
- hosting platforms
    
- shell exports
    

When many tools inject environment variables, naming collisions become easier to create.

For example:

```bash
NODE_ENV=production
NODE_APP_INSTANCE=0
PORT=3000
DATABASE_URL=...
```

If multiple tools care about the same variable name, your app can behave in unexpected ways.

Renaming PM2’s variable makes the runtime environment cleaner:

```bash
NODE_ENV=production
INSTANCE_ID=0
PORT=3000
DATABASE_URL=...
```

Now the meaning is clearer:

- `NODE_ENV` controls the environment.
    
- `INSTANCE_ID` identifies the PM2 cluster instance.
    
- `PORT` controls the server port.
    
- `DATABASE_URL` controls the database connection.
    

### Key Takeaway

`instance_var` does not change how PM2 assigns instance IDs.

It only changes the environment variable name PM2 uses.

The main advantage is avoiding naming conflicts, especially with tools like `node-config`, while also making your TypeScript and runtime environment variables easier to understand.

Instead of this:

```js
process.env.NODE_APP_INSTANCE
```

you can use this:

```js
process.env.INSTANCE_ID
```

That small rename can make your app configuration cleaner, safer, and less confusing.