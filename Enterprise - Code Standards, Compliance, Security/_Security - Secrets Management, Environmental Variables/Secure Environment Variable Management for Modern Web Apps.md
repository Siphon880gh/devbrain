Most developers rely on `.env` files during **development and staging**, despite the risk of exposing them — such as through **Local File Inclusion (LFI)** vulnerabilities. Why? Because managing Linux-level environment variables across multiple web apps is often:
- Cumbersome to configure per app
- Difficult to scale across teams, systems, or CI/CD pipelines  

When the codebase is shared via GitHub (even in private repos), `.env` files are usually excluded via `.gitignore`. The actual environment variable values are shared separately — sometimes informally (e.g., private messages or email), or more securely through encrypted files. Each developer then configures their local environment accordingly.  

In deployment stacks using platforms like **Heroku** or **Docker**, environment variables are managed more securely:
- **Heroku** stores env variables outside the file system and prevents direct access to them from the app.
- **Docker** can isolate secrets at the container level using `.env` files or Docker secrets.  

If you're self-hosting, you must ensure all security measures are in place — an attacker should never be able to exploit vulnerabilities (like LFI) to access your `.env` file. As a safer alternative, you can define environment variables at the **service level**, such as:
- In `php-fpm` via the `env[]` directive in `www.conf`
- In `systemd` with `Environment=` overrides per service
- At the **web server level**, using `SetEnv` in Apache or `fastcgi_param` in Nginx

These methods keep secrets out of the file system entirely. However, managing these configurations becomes more complex when multiple web apps run on the same server, making isolation, deployment, and scaling harder without containerization or platform-as-a-service solutions.

Below is a comprehensive list of service-level, web server-level, and more manageable solutions such as containerization and platform-as-a-service options.

### ✅ Secure Alternatives for Multiple Web Apps (No `.env` files)

| Strategy                                | Use When…                                         | Details                                                                              |
| --------------------------------------- | ------------------------------------------------- | ------------------------------------------------------------------------------------ |
| 🔧 **Systemd environment override**     | Few apps on a Linux VPS                           | Use `systemctl edit` to inject `Environment=...` per service (e.g., php-fpm)         |
| ⚙️ **PHP-FPM env config (`env[]`)**     | You use PHP-FPM (with Nginx or Apache)            | Define vars in `www.conf` using `env[KEY]=value`; secure and app-specific            |
| 🧩 **Nginx-level fastcgi_param**        | PHP served via Nginx + PHP-FPM                    | Use `fastcgi_param VAR $VAR;` to pass values explicitly to PHP                       |
| 🛠️ **Apache-level `SetEnv`**           | mod_php or CGI-based PHP                          | Use `SetEnv VAR value` in Apache config or `.htaccess`; passed to PHP via `getenv()` |
| 🧱 **CI/CD secrets injection**          | GitHub Actions, GitLab, Bitbucket, etc            | Store in platform secrets UI; inject during deploy                                   |
| 🐳 **Docker secrets / `.env` files**    | Docker and Docker Compose deployments             | Use `docker secrets` or `.env` for container-scoped config                           |
| 🗝️ **Infra-as-Code secret management** | Terraform / Pulumi                                | Encrypt and provision secrets during infrastructure builds                           |
| 📦 **Kubernetes Secrets / ConfigMaps**  | You're using Kubernetes                           | Inject secrets as envs or volumes using manifests                                    |
| ☁️ **Cloud environment configs**        | AWS, GCP, Azure, Heroku, Vercel, etc.             | Use managed secrets or environment dashboards                                        |
| 📂 **Volume-mounted secrets**           | Docker/Kubernetes hardened environments           | Mount secrets into container or VM securely at runtime                               |
| 🧭 **HashiCorp Vault**                  | Enterprise or compliance-sensitive infrastructure | Centralized secret storage with audit and access control                             |
| 🔁 **Consul / Etcd / Config servers**   | Distributed systems needing dynamic config        | Stores and syncs env config across services                                          |

### 🔐 **Local and Small Projects**

| Strategy                     | Use When…                                          | Details                                                |
| ---------------------------- | -------------------------------------------------- | ------------------------------------------------------ |
| 📜 **.env + dotenv parsing** | Local dev or minimal apps (e.g., Laravel, Symfony) | Convenient, but must be protected from public exposure |

### 🧯 Why Shell Config Files Aren’t Enough

You might wonder — why not just set environment variables in `.bashrc`, `.bash_profile`, or use tools like `z` or `direnv`?

These methods only apply to **interactive shell sessions** — meaning they affect what’s available when you open a terminal and run commands manually. Web servers, background services, and deployment tools **don’t source your shell configs**, so any variables set there won’t be available to your app in production.

For example:
- A Node.js or PHP app launched by `systemd` or a process manager like `pm2` won’t see variables set in `.bashrc`.
- CI/CD pipelines (e.g., GitHub Actions) don’t load your local shell configs.
- Web servers like Apache and Nginx spawn child processes that inherit variables **only** if explicitly configured at the service or server level.

In short: **CLI-based env config is isolated to your terminal.** For secure, reliable access to environment variables across different contexts, you need to define them at the service, container, or platform level.

---

### 👇 Bottom Line

Yes, `.env` files are a practical compromise for **local dev and small projects**, but for:

- Serious production apps
- Multi-app deployments
- Multi-user systems

→ you need **infrastructure-level** solutions: `systemd`, Docker secrets, or CI/CD-managed environments.

### NextJS

NextJS server accessing env variables that are not in .env file tricky, but not impossible. Refer to [[NextJS - Runtime environmental variables not in .env file]]