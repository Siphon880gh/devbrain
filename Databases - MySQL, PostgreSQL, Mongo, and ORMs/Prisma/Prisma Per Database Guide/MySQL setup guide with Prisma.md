This guide shows how to set up Prisma with a **MySQL** database in a migration-based workflow. Prisma supports MySQL through the `mysql` provider, and the normal development flow is to define models in `schema.prisma`, create migrations with `prisma migrate dev`, and apply committed migrations in higher environments with `prisma migrate deploy`. ([Prisma](https://www.prisma.io/docs/orm/core-concepts/supported-databases/mysql?utm_source=chatgpt.com "MySQL database connector | Prisma Documentation"))

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

This is a standard Prisma layout for relational databases: schema file, migration history, and seed scripts. Prisma Migrate stores schema changes as SQL migration files in the `migrations/` directory. ([Prisma](https://www.prisma.io/docs/orm/prisma-migrate?utm_source=chatgpt.com "Database, Schema, SQL Migration Tool | Prisma Documentation"))

## Environment setup

Your `.env` file should contain a MySQL connection string. Prisma documents the MySQL connection URL format as `mysql://user:pass@host:3306/database`. ([Prisma](https://www.prisma.io/docs/orm/reference/connection-urls?utm_source=chatgpt.com "Connection URLs (Reference) | Prisma Documentation"))

```env
DATABASE_URL="mysql://root:password@localhost:3306/appdb"
```

## Prisma datasource example

In `prisma/schema.prisma`, set the datasource provider to MySQL. Prisma’s MySQL connector uses `provider = "mysql"`. ([Prisma](https://www.prisma.io/docs/orm/core-concepts/supported-databases/mysql?utm_source=chatgpt.com "MySQL database connector | Prisma Documentation"))

```prisma
datasource db {
  provider = "mysql"
  url      = env("DATABASE_URL")
}

generator client {
  provider = "prisma-client-js"
}
```

## Initial install

Install Prisma and generate the client:

```bash
npm install
npx prisma generate
```

Prisma Client is generated from `schema.prisma` and used by the application to access the database. Prisma’s quickstarts and schema docs follow this flow. ([Prisma](https://www.prisma.io/docs/prisma-orm/quickstart/mysql?utm_source=chatgpt.com "Quickstart: Prisma ORM with MySQL (10 min)"))

## Creating the first migration

After defining models in `schema.prisma`, create and apply the first migration locally:

```bash
npx prisma migrate dev --name initial_setup
```

`prisma migrate dev` is Prisma’s development command for relational databases. It creates a migration, applies it to the development database, and helps detect schema drift. ([Prisma](https://www.prisma.io/docs/orm/prisma-migrate?utm_source=chatgpt.com "Database, Schema, SQL Migration Tool | Prisma Documentation"))

## Example model

```prisma
model User {
  id    Int    @id @default(autoincrement())
  email String @unique
  name  String?
}
```

Prisma models map application models to database tables, and the MySQL connector supports standard relational model definitions like this. ([Prisma](https://www.prisma.io/docs/orm/prisma-schema/data-model/models?utm_source=chatgpt.com "Models | Prisma Documentation"))

## Seeding

After migrations are applied, seed baseline data:

```bash
npx prisma db seed
```

Seeding is a separate step from migration. Prisma’s workflow keeps schema changes and data bootstrapping as distinct operations. ([Prisma](https://www.prisma.io/docs/orm/prisma-migrate?utm_source=chatgpt.com "Database, Schema, SQL Migration Tool | Prisma Documentation"))

## Local setup flow

```bash
npm install
npx prisma generate
npx prisma migrate dev
npx prisma db seed
npm run dev
```

This is the normal local workflow for a MySQL-backed Prisma project: generate client, apply migrations in development, seed data, then run the app. ([Prisma](https://www.prisma.io/docs/orm/core-concepts/supported-databases/mysql?utm_source=chatgpt.com "MySQL database connector | Prisma Documentation"))

## Production deployment

In staging or production, do not create migrations on the server. Apply only committed migrations:

```bash
npx prisma migrate deploy
```

Prisma documents `migrate deploy` as the production-side command for applying existing migrations. ([Prisma](https://www.prisma.io/docs/orm/prisma-migrate?utm_source=chatgpt.com "Database, Schema, SQL Migration Tool | Prisma Documentation"))

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

This pattern matches Prisma’s documented split between development migrations and deployment-time migration application. ([Prisma](https://www.prisma.io/docs/orm/prisma-migrate?utm_source=chatgpt.com "Database, Schema, SQL Migration Tool | Prisma Documentation"))
