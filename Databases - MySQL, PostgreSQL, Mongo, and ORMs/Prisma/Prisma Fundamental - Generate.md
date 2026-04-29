
## `prisma generate`

```bash
npx prisma generate
```

### Technical

This command:

- reads your Prisma schema file, usually:
    

```bash
prisma/schema.prisma
```

- looks at your Prisma models, fields, relations, enums, and datasource/client settings
    
- generates or updates Prisma Client code
    
- places the generated client into your project’s dependencies, usually under:
    

```bash
node_modules/.prisma/client
```

- makes Prisma Client match the current schema
    
- does **NOT** change the database
    
- does **NOT** create migration files
    
- does **NOT** apply migration files
    
- does **NOT** seed the database
    

---

### Simple explanation

> “Read the schema and generate the Prisma Client code my app uses.”

`prisma generate` does not touch the database structure.

It prepares the code your app uses when you write things like:

```ts
await prisma.user.findMany()
```

So if your schema has a model like this:

```prisma
model User {
  id    Int    @id @default(autoincrement())
  email String @unique
}
```

`prisma generate` makes sure Prisma Client knows that `User` exists and that it has fields like `id` and `email`.

---

### Why many setup flows run it first

In many new-team-member setup flows, you will see:

```bash
npx prisma generate
npx prisma migrate deploy
npm run seed
```

or:

```bash
npx prisma generate
npx prisma migrate deploy
npx prisma db seed
```

That is common because:

- `generate` is fast
    
- it is low-risk
    
- it only reads schema files that are already there
    
- it does **not** change the database
    
- it prepares Prisma Client before the app or scripts try to use it
    
- many tools, build steps, seed scripts, and TypeScript checks expect the generated Prisma Client to already exist
    
- it is usually safe to run again
    

Another benefit is that `generate` gives you an early setup check.

It quickly confirms that Prisma can read the schema and create the Prisma Client. If something is wrong with the setup, you may catch it before running database commands.

For example, `generate` may expose problems like:

- missing packages
    
- a bad or invalid Prisma schema
    
- Prisma Client generation issues
    
- Node.js and Prisma compatibility problems
    
- install issues inside `node_modules`
    

This is safe because migration commands can generate again later anyway. So running `generate` first is often a clean way to verify the Prisma setup before touching the database.

---

### When to use it

Good for:

- setting up a project you just pulled from GitHub
    
- after running:
    

```bash
npm install
```

or:

```bash
pnpm install
```

- after changing `schema.prisma`
    
- before running app code that imports Prisma Client
    
- before running a seed script that uses Prisma Client
    
- before building the project in CI/CD
    
- when TypeScript or your editor complains Prisma Client types are missing or outdated
    

---

### When NOT to confuse it with migrations

Avoid thinking `generate` updates the actual database.

It does not.

For example, if you add this to `schema.prisma`:

```prisma
model Post {
  id    Int    @id @default(autoincrement())
  title String
}
```

Then run:

```bash
npx prisma generate
```

Prisma Client may now know about `Post`, but your database may still not have a `Post` table.

To update the database, you still need a database command such as:

```bash
npx prisma migrate dev
```

or:

```bash
npx prisma migrate deploy
```

or, in some prototype workflows:

```bash
npx prisma db push
```

---

### Key difference vs `migrate deploy`

- **`generate`** = reads schema and generates Prisma Client code
    
- **`migrate deploy`** = reads migration files and applies them to the database
    

So:

```text
generate = prepare app code
migrate deploy = update database from saved migrations
```

---

### Key difference vs `migrate dev`

- **`generate`** = updates generated Prisma Client code
    
- **`migrate dev`** = creates migration files from schema changes and applies them locally
    

In development, `migrate dev` often triggers generation automatically, but it is still useful to understand `generate` as its own command.

Mental model:

```text
generate = make Prisma Client match the schema
migrate dev = make migration files and local database match the schema
```

---

### Key difference vs `db push`

- **`generate`** = updates generated Prisma Client code
    
- **`db push`** = directly updates the database to match the schema without migration files
    

So:

```text
generate = schema → Prisma Client code
db push = schema → database
```

---

### Common new project setup order

For a project that already has:

- `schema.prisma`
    
- existing migration files
    
- maybe a seed script
    

A common setup order is:

```bash
npm install
npx prisma generate
npx prisma migrate deploy
npm run seed
```

or, if the project uses Prisma’s seed command:

```bash
npm install
npx prisma generate
npx prisma migrate deploy
npx prisma db seed
```

The reason is simple:

> First install dependencies, then generate the Prisma Client from the schema, then apply the existing migrations, then seed the database if needed.

`generate` comes before `migrate deploy` in many setup guides because it is fast, safe, and useful as an early check. It reads the schema files that already exist, creates the Prisma Client, and catches certain setup problems before you run commands that affect the database.

Even if a later migration command generates the client again, that is okay. Running `generate` first usually does not hurt anything.

---

### Mental model

- `prisma generate` = “read my schema and generate the Prisma Client code”
    
- `prisma migrate deploy` = “run the saved migration files that already exist”
    
- `prisma migrate dev` = “create migration files from schema changes and apply them locally”
    
- `prisma db push` = “make the database match the schema without migration files”
    

Simple version:

```text
generate = schema → Prisma Client
migrate deploy = migration files → database
migrate dev = schema → migration files → local database
db push = schema → database
```

Best one-line memory:

> `prisma generate` does not build the database. It builds the Prisma Client your app uses to talk to the database.