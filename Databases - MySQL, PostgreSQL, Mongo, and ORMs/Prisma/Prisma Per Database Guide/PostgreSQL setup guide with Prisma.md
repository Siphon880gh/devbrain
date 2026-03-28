This guide shows how to set up Prisma with **PostgreSQL** using Prisma Migrate. The Prisma PostgreSQL connector uses `provider = "postgresql"`, and PostgreSQL follows the same migration-based development and deployment workflow as other supported relational databases. ([Prisma](https://www.prisma.io/docs/v6/orm/overview/databases/postgresql?utm_source=chatgpt.com "PostgreSQL database connector | Prisma Documentation"))

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

For PostgreSQL, Prisma Migrate stores SQL migrations in `prisma/migrations`, just as it does for MySQL. ([Prisma](https://www.prisma.io/docs/orm/prisma-migrate?utm_source=chatgpt.com "Database, Schema, SQL Migration Tool | Prisma Documentation"))

## Environment setup

Your `.env` file should use a PostgreSQL connection string. Prisma’s connection URL reference documents the PostgreSQL format, and Prisma’s PostgreSQL connector expects `provider = "postgresql"`. ([Prisma](https://www.prisma.io/docs/orm/reference/connection-urls?utm_source=chatgpt.com "Connection URLs (Reference) | Prisma Documentation"))

```env
DATABASE_URL="postgresql://postgres:password@localhost:5432/appdb?schema=public"
```

The `?schema=public` portion is commonly used in Prisma PostgreSQL examples. Prisma’s schema reference also documents PostgreSQL schema support. ([Prisma](https://www.prisma.io/docs/v6/orm/overview/databases/postgresql?utm_source=chatgpt.com "PostgreSQL database connector | Prisma Documentation"))

## Prisma datasource example

```prisma
datasource db {
  provider = "postgresql"
  url      = env("DATABASE_URL")
}

generator client {
  provider = "prisma-client-js"
}
```

That is the standard PostgreSQL datasource configuration for Prisma ORM. ([Prisma](https://www.prisma.io/docs/v6/orm/overview/databases/postgresql?utm_source=chatgpt.com "PostgreSQL database connector | Prisma Documentation"))

## Initial install

```bash
npm install
npx prisma generate
```

Prisma’s PostgreSQL quickstart uses the same general flow: install dependencies, connect via `DATABASE_URL`, then generate Prisma Client. ([Prisma](https://www.prisma.io/docs/prisma-orm/quickstart/postgresql?utm_source=chatgpt.com "Quickstart: Prisma ORM with PostgreSQL (10 min)"))

## Creating the first migration

```bash
npx prisma migrate dev --name initial_setup
```

For PostgreSQL, `prisma migrate dev` creates a migration, applies it locally, and checks for drift or migration-history issues. Prisma also notes that `migrate dev` uses a shadow database to help detect problems. ([Prisma](https://www.prisma.io/docs/orm/prisma-migrate?utm_source=chatgpt.com "Database, Schema, SQL Migration Tool | Prisma Documentation"))

## Example model

```prisma
model User {
  id    Int    @id @default(autoincrement())
  email String @unique
  name  String?
}
```

Prisma models work the same way across supported relational databases, including PostgreSQL. ([Prisma](https://www.prisma.io/docs/orm/prisma-schema/data-model/models?utm_source=chatgpt.com "Models | Prisma Documentation"))

## Seeding

```bash
npx prisma db seed
```

Use seeding after the schema is in place so local developers get predictable baseline records. Prisma treats seeding as a separate workflow from migrations. ([Prisma](https://www.prisma.io/docs/orm/prisma-migrate?utm_source=chatgpt.com "Database, Schema, SQL Migration Tool | Prisma Documentation"))

## Local setup flow

```bash
npm install
npx prisma generate
npx prisma migrate dev
npx prisma db seed
npm run dev
```

This is the standard local development path for PostgreSQL with Prisma. ([Prisma](https://www.prisma.io/docs/prisma-orm/quickstart/postgresql?utm_source=chatgpt.com "Quickstart: Prisma ORM with PostgreSQL (10 min)"))

## Production deployment

```bash
npx prisma migrate deploy
```

In higher environments, Prisma recommends applying existing migrations rather than generating new ones there. ([Prisma](https://www.prisma.io/docs/orm/prisma-migrate?utm_source=chatgpt.com "Database, Schema, SQL Migration Tool | Prisma Documentation"))

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

This keeps build-time Prisma Client generation separate from runtime migration application. ([Prisma](https://www.prisma.io/docs/orm/prisma-migrate?utm_source=chatgpt.com "Database, Schema, SQL Migration Tool | Prisma Documentation"))