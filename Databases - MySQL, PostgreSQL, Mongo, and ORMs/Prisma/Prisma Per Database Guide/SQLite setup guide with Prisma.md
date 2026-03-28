This guide shows how to set up Prisma with **SQLite** using a migration-based workflow. SQLite is a file-based relational database, which makes it especially useful for local development, prototypes, small apps, and simple internal tools. Prisma’s SQLite connector supports local `.db` files and works with `prisma migrate dev` for schema changes. ([Prisma](https://www.prisma.io/docs/orm/core-concepts/supported-databases/sqlite?utm_source=chatgpt.com "SQLite database connector | Prisma Documentation"))

## Folder structure

```text
prisma/
├── migrations
│   ├── 20250321000000_initial_setup
│   │   └── migration.sql
│   ├── 20250321120000_add_external_reference
│   │   └── migration.sql
│   ├── 20250322100000_add_record_metadata
│   │   └── migration.sql
│   └── migration_lock.toml
├── schema.prisma
├── seed-data.ts
└── seed.ts
```

This is a standard Prisma layout for a relational database project: a schema file, migration history, and seed files. Prisma Migrate stores schema changes as SQL files inside `prisma/migrations/`. ([Prisma](https://www.prisma.io/docs/orm/prisma-migrate?utm_source=chatgpt.com "Database, Schema, SQL Migration Tool | Prisma Documentation"))

## Environment setup

Your `.env` file should point to a SQLite database file. Prisma’s SQLite connection URL format uses `file:` paths, such as `file:./dev.db`. ([Prisma](https://www.prisma.io/docs/orm/core-concepts/supported-databases/sqlite?utm_source=chatgpt.com "SQLite database connector | Prisma Documentation"))

```env
DATABASE_URL="file:./dev.db"
```

That creates or connects to a local SQLite database file in your project. Prisma’s SQLite connector docs describe local SQLite as standard `.db` files stored anywhere in your filesystem. ([Prisma](https://www.prisma.io/docs/orm/core-concepts/supported-databases/sqlite?utm_source=chatgpt.com "SQLite database connector | Prisma Documentation"))

## Prisma datasource example

In `prisma/schema.prisma`, set the datasource provider to SQLite:

```prisma
datasource db {
  provider = "sqlite"
  url      = env("DATABASE_URL")
}

generator client {
  provider = "prisma-client-js"
}
```

Prisma documents `sqlite` as the datasource provider for SQLite databases. ([Prisma](https://www.prisma.io/docs/orm/core-concepts/supported-databases/sqlite?utm_source=chatgpt.com "SQLite database connector | Prisma Documentation"))

## Initial install

Install dependencies and generate Prisma Client:

```bash
npm install
npx prisma generate
```

Prisma Client is generated from `schema.prisma` and is the type-safe client your app uses to query the database. Prisma’s SQLite quickstart uses the same overall flow: initialize Prisma, define models, then generate and use the client. ([Prisma](https://www.prisma.io/docs/prisma-orm/quickstart/sqlite?utm_source=chatgpt.com "Quickstart: Prisma ORM with SQLite (5 min)"))

## Creating the first migration

After defining models in `schema.prisma`, create and apply the first migration locally:

```bash
npx prisma migrate dev --name initial_setup
```

For SQLite, `prisma migrate dev` is the normal development command for schema changes. Prisma documents that it creates migrations, applies them in development, and helps detect issues such as migration conflicts or schema drift. ([Prisma](https://www.prisma.io/docs/orm/core-concepts/supported-databases/sqlite?utm_source=chatgpt.com "SQLite database connector | Prisma Documentation"))

## Example model

```prisma
model User {
  id    Int    @id @default(autoincrement())
  email String @unique
  name  String?
}
```

This is a normal Prisma relational model definition and works with SQLite. Prisma’s SQLite quickstart examples use this same style of `Int @id @default(autoincrement())` model structure. ([Prisma](https://www.prisma.io/docs/prisma-orm/quickstart/sqlite?utm_source=chatgpt.com "Quickstart: Prisma ORM with SQLite (5 min)"))

## Seeding

After the schema is in place, seed baseline data:

```bash
npx prisma db seed
```

Prisma v7 requires seeding to be run explicitly; `migrate dev` no longer auto-runs the seed script the way earlier versions did. ([Prisma](https://www.prisma.io/docs/guides/upgrade-prisma-orm/v7?utm_source=chatgpt.com "Upgrade to Prisma ORM 7"))

## Local setup flow

```bash
npm install
npx prisma generate
npx prisma migrate dev
npx prisma db seed
npm run dev
```

This is the practical local workflow for a SQLite-backed Prisma project: generate the client, apply migrations in development, seed data, and start the app. Prisma’s SQLite docs recommend `prisma migrate dev` for local SQLite schema changes. ([Prisma](https://www.prisma.io/docs/orm/core-concepts/supported-databases/sqlite?utm_source=chatgpt.com "SQLite database connector | Prisma Documentation"))

## Production note

SQLite can work well for simple deployments, but it is still a file-based database. Prisma documents SQLite primarily as a local SQLite connector using `.db` files, and its own connector page frames it as best for development and small applications. ([Prisma](https://www.prisma.io/docs/orm/core-concepts/supported-databases/sqlite?utm_source=chatgpt.com "SQLite database connector | Prisma Documentation"))

If you deploy with a migration-based workflow, apply only committed migrations:

```bash
npx prisma migrate deploy
```

Prisma documents `migrate deploy` as the production-side command for applying already-created migrations. ([Prisma](https://www.prisma.io/docs/orm/prisma-migrate?utm_source=chatgpt.com "Database, Schema, SQL Migration Tool | Prisma Documentation"))

## Docker example

```dockerfile
FROM node:22-alpine
WORKDIR /app

RUN apk add --no-cache libc6-compat openssl

COPY package.json package-lock.json* ./
RUN npm ci

COPY . .
RUN npx prisma generate && npm run build

ENV NODE_ENV=production
EXPOSE 3000

CMD ["sh", "-c", "npx prisma migrate deploy && npm run start"]
```

This follows Prisma’s general migration model: generate the client during build, then apply committed migrations when the container starts. ([Prisma](https://www.prisma.io/docs/orm/prisma-migrate?utm_source=chatgpt.com "Database, Schema, SQL Migration Tool | Prisma Documentation"))

## Existing SQLite database workflow

If the project already has a SQLite database and you want Prisma to adopt it, Prisma documents this flow:

```bash
npx prisma db pull
npx prisma generate
```

And if you want to baseline that existing database for Prisma Migrate, Prisma’s SQLite “add to existing project” guide shows creating an initial migration from the schema using `prisma migrate diff`. ([Prisma](https://www.prisma.io/docs/prisma-orm/add-to-existing-project/sqlite?utm_source=chatgpt.com "How to add Prisma ORM to an existing project using SQLite ..."))

Example baseline flow:

```bash
mkdir -p prisma/migrations/0_init
npx prisma migrate diff --from-empty --to-schema prisma/schema.prisma --script > prisma/migrations/0_init/migration.sql
```

That is specifically for adopting an existing database into a migration-managed workflow. ([Prisma](https://www.prisma.io/docs/prisma-orm/add-to-existing-project/sqlite?utm_source=chatgpt.com "How to add Prisma ORM to an existing project using SQLite ..."))