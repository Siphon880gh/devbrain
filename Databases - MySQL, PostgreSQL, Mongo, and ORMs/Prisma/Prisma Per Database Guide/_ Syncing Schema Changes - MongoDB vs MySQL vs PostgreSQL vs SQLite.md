## MySQL

Use:

```bash
npx prisma migrate dev
npx prisma migrate deploy
```

MySQL is supported through Prisma’s `mysql` provider and has full Prisma Migrate support. ([Prisma](https://www.prisma.io/docs/orm/core-concepts/supported-databases/mysql?utm_source=chatgpt.com "MySQL database connector | Prisma Documentation"))

## PostgreSQL

Use:

```bash
npx prisma migrate dev
npx prisma migrate deploy
```

PostgreSQL uses the `postgresql` provider and follows the same migration-based workflow. ([Prisma](https://www.prisma.io/docs/v6/orm/overview/databases/postgresql?utm_source=chatgpt.com "PostgreSQL database connector | Prisma Documentation"))

## SQLite

Use:

```bash
npx prisma migrate dev
npx prisma migrate deploy
```

SQLite uses the `sqlite` provider and follows the same migration-based workflow. ([Prisma](https://www.prisma.io/docs/v6/orm/overview/databases/sqlite))

## MongoDB

Use:

```bash
npx prisma db push
```

MongoDB does not use Prisma Migrate, requires the `mongodb` provider, and currently remains on Prisma ORM v6. ([Prisma](https://www.prisma.io/docs/v6/orm/overview/databases/mongodb?utm_source=chatgpt.com "MongoDB database connector | Prisma Documentation"))

If you want, I can turn these into a single polished internal doc with one shared intro and three clean subsections.