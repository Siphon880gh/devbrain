## Mnemonics for Prisma Subcommands

Here’s an easy way to remember these three Prisma commands:

```bash
npx prisma db push
npx prisma migrate deploy
npx prisma migrate dev
```

Think of them by how involved they are with the `prisma/migrations/` folder.

---

## `db push`

```bash
npx prisma db push
```

Mnemonic:

> **Push the schema straight into the database.**

`db push` bypasses the `prisma/migrations/` folder. It reads `schema.prisma` and updates the database directly.

You can think of it almost like:

```bash
git push --force
```

Not because it is the same thing, but because the feeling is similar:

> “Force this current state into the destination.”

With `db push`, the direction is:

```text
schema.prisma → database
```

So the mental shortcut is:

> `db push` = push the schema straight to the DB.

---

## `migrate deploy`

```bash
npx prisma migrate deploy
```

Mnemonic:

> **Deploy the migration files to the database server.**

`migrate deploy` reads from the existing files inside:

```text
prisma/migrations/
```

Then it applies those migrations to the database.

The word **deploy** should make you think:

> “I already have the migration files. Now deploy them to the database server.”

The direction is:

```text
prisma/migrations/ → database
```

So the mental shortcut is:

> `migrate deploy` = deploy existing migration files.

---

## `migrate dev`

```bash
npx prisma migrate dev
```

Mnemonic:

> **Dev means you are developing the migrations.**

This is the one where the word **dev** starts to click.

`migrate dev` is for local development, usually on localhost. In development, you are changing your schema and creating new database changes.

So `migrate dev` can:

- read your `schema.prisma`
    
- detect schema changes
    
- create new migration files
    
- write them into `prisma/migrations/`
    
- apply them to your local database
    

The direction is:

```text
schema.prisma → prisma/migrations/ → database
```

So the mental shortcut is:

> `migrate dev` = develop new migration files, then run them locally.

---

## Simple Memory Stack

From least migration-folder involvement to most:

```text
db push        = skip migrations and push schema to DB
migrate deploy = use existing migrations and deploy them to DB
migrate dev    = create migration files during dev, then apply them
```

Another way to remember it:

```text
Push = schema straight to DB
Deploy = migration files to DB server
Dev = develop new migration files
```