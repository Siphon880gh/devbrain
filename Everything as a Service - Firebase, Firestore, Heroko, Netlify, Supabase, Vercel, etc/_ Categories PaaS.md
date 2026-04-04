**PaaS = you deploy code, the platform handles infrastructure**

You don’t manage:

- servers
- OS
- scaling
- networking

That means you usually do not manage the servers, operating system, scaling, or networking yourself. You push your code, and the platform runs it. In many cases, that also means the platform can host a basic full-stack app, including backend code such as a `server.js` process or PHP application. It may support only specific types of backend (NodeJS or PHP).

Some PaaS platforms give you more **control over how the infrastructure runs**, such as Heroku with dynos. Others give you much less control or **no infrastructure control** at all over the underlying runtime and infrastructure, even though they still support backend code execution, such as running a `server.js` process, PHP code, or solely as a place for serverless functions.