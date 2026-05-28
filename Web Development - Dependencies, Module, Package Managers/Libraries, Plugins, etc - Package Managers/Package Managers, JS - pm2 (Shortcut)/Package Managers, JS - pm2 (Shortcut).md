pm2 is often grouped with npm, yarn, and pnpm because it is installed via npm and lives in the Node.js tooling world. That association is misleading — **pm2 is not a package manager**.

pm2 is a **process manager**. It keeps your Node.js apps running persistently: if a process crashes or the server restarts, pm2 can bring those apps back online without you manually starting them again. It also helps you **manage multiple Node.js apps at once**, each bound to its own port, from a single place (`pm2 list`, logs, restart, and so on).

Refer here: [[PM2 - _Beginner PRIMER]]
