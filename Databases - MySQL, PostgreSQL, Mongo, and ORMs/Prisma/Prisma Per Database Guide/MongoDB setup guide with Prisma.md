This guide shows how to set up Prisma with **MongoDB**. Unlike MySQL and PostgreSQL, **MongoDB does not use Prisma Migrate**, so you should **not** create SQL migration folders for it. Instead, Prisma says to use `prisma db push` to sync schema changes. Prisma’s docs also currently note that MongoDB support is **not yet available in Prisma ORM v7**, so MongoDB projects should remain on Prisma ORM v6 for now. ([Prisma](https://www.prisma.io/docs/v6/orm/overview/databases/mongodb?utm_source=chatgpt.com "MongoDB database connector | Prisma Documentation"))

## Folder structure

For MongoDB, a better neutral project structure looks like this:

```text
prisma/
├── schema.prisma
├── seed-data.ts
└── seed.ts
```

There is no migration SQL history here because Prisma Migrate does not support the MongoDB connector. ([Prisma](https://www.prisma.io/docs/orm/prisma-migrate/understanding-prisma-migrate/limitations-and-known-issues?utm_source=chatgpt.com "Limitations and known issues | Prisma Documentation"))

## Important MongoDB requirement

Prisma’s MongoDB connector requires a MongoDB deployment configured as a **replica set**, including in many local-development setups. Prisma documents this explicitly in its MongoDB connector guide. ([Prisma](https://www.prisma.io/docs/v6/orm/overview/databases/mongodb?utm_source=chatgpt.com "MongoDB database connector | Prisma Documentation"))

## Environment setup

Use a MongoDB connection string in `.env`:

```env
DATABASE_URL="mongodb://localhost:27017/appdb?replicaSet=rs0"
```

Exact connection strings vary by local or hosted deployment, but Prisma’s MongoDB connector uses a MongoDB URI and expects the datasource provider to be `mongodb`. ([Prisma](https://www.prisma.io/docs/v6/orm/overview/databases/mongodb?utm_source=chatgpt.com "MongoDB database connector | Prisma Documentation"))

If you use MongoDB Atlas, you would instead use the Atlas connection URI for your cluster. Prisma’s MongoDB setup materials include Atlas-based guidance as well. ([Prisma](https://www.prisma.io/dataguide/mongodb/mongodb-atlas-setup?utm_source=chatgpt.com "MongoDB Atlas Setup | Prisma's Data Guide"))

## Prisma datasource example

```prisma
datasource db {
  provider = "mongodb"
  url      = env("DATABASE_URL")
}

generator client {
  provider = "prisma-client-js"
}
```

That is the standard Prisma datasource configuration for MongoDB. ([Prisma](https://www.prisma.io/docs/v6/orm/overview/databases/mongodb?utm_source=chatgpt.com "MongoDB database connector | Prisma Documentation"))

## Example model

MongoDB models in Prisma usually map MongoDB’s `_id` field with `@map("_id")` and `@db.ObjectId`:

```prisma
model User {
  id    String @id @default(auto()) @map("_id") @db.ObjectId
  email String @unique
  name  String?
}
```

This pattern is used in Prisma’s MongoDB examples because MongoDB documents use ObjectIds rather than relational integer primary keys. ([Prisma](https://www.prisma.io/docs/v6/orm/overview/databases/mongodb?utm_source=chatgpt.com "MongoDB database connector | Prisma Documentation"))

## Initial install

```bash
npm install
npx prisma generate
```

Prisma Client is still generated normally for MongoDB-backed projects. ([Prisma](https://www.prisma.io/docs/prisma-orm/quickstart/mongodb?utm_source=chatgpt.com "Quickstart: Prisma ORM with MongoDB (10 min)"))

## Syncing schema changes

Instead of `prisma migrate dev`, use:

```bash
npx prisma db push
```

Prisma explicitly says to use `db push` for MongoDB because Prisma Migrate is not supported there. `db push` syncs the Prisma schema to the database and regenerates Prisma Client. ([Prisma](https://www.prisma.io/docs/prisma-orm/add-to-existing-project/mongodb?utm_source=chatgpt.com "MongoDB - Prisma orm"))

## Seeding

After the schema is pushed, seed the database:

```bash
npx prisma db seed
```

Even without migrations, seeding remains a separate step for baseline data. ([Prisma](https://www.prisma.io/docs/prisma-orm/quickstart/mongodb?utm_source=chatgpt.com "Quickstart: Prisma ORM with MongoDB (10 min)"))

## Local setup flow

```bash
npm install
npx prisma generate
npx prisma db push
npx prisma db seed
npm run dev
```

That is the Prisma-friendly MongoDB flow: generate client, push schema, seed data, start the app. ([Prisma](https://www.prisma.io/docs/prisma-orm/quickstart/mongodb?utm_source=chatgpt.com "Quickstart: Prisma ORM with MongoDB (10 min)"))

## Production note

MongoDB deployments do not use `prisma migrate deploy`. Schema synchronization is done with `prisma db push`, and MongoDB projects should be careful about schema changes because they do not have the same migration-file workflow Prisma uses for SQL databases. ([Prisma](https://www.prisma.io/docs/orm/prisma-migrate/understanding-prisma-migrate/limitations-and-known-issues?utm_source=chatgpt.com "Limitations and known issues | Prisma Documentation"))

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

CMD ["sh", "-c", "npx prisma db push && npm run start"]
```

That startup pattern matches Prisma’s documented MongoDB workflow better than `migrate deploy`, because MongoDB uses `db push` rather than Prisma Migrate. ([Prisma](https://www.prisma.io/docs/prisma-orm/add-to-existing-project/mongodb?utm_source=chatgpt.com "MongoDB - Prisma orm"))
