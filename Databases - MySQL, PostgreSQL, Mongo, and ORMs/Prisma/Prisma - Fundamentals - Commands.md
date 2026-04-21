## Prisma commands made simple

Prisma can feel confusing because several commands affect different parts of your setup.

The easiest way to think about it is this:
- **`migrate dev`** = create and apply database changes during development
- **`migrate deploy`** = apply already-created database changes in production
- **`generate`** = build Prisma Client so your app can talk to the database
- **`seed`** = run **your own seed file** to insert starter data using Prisma Client

---

## The 4 Prisma pieces

### 1. `prisma migrate dev`

```bash
npx prisma migrate dev --name add_users
```

#### Technical

This command compares your `schema.prisma` to your current database, creates a new migration file if needed, applies it, updates migration history, and usually runs `generate`.

It also creates a **new migration folder** inside:

```bash
prisma/migrations/
```

Each migration folder is **timestamped (versioned by date)** and contains SQL files that Prisma will run.

The idea is that you define your schema in Prisma, and Prisma turns those changes into a series of SQL migration files that get run against your database. The first migration often contains the CREATE TABLE statements that build the initial structure, and later migrations contain SQL that changes that structure over time, such as adding columns, modifying tables, or undoing earlier decisions through new changes. By running those migration files in order, Prisma can recreate the database structure faithfully from the beginning to the current version. Prisma determines which SQL files to run to deploy to your database and determines if it needs to create additional SQL files to make sure the database matches your schema.

---

#### Simple explanation

This is your **development command**.

It means:

> “I changed my schema. Please turn that into real database changes and apply them now.”

So if you add a new field or table, `migrate dev` creates the actual SQL needed and runs it.

---

### 2. `prisma migrate deploy`

```bash
npx prisma migrate deploy
```

### Technical

This command does **not** create new migrations.

It reads all migration folders inside:

```bash
prisma/migrations/
```

Each folder contains SQL (like `migration.sql`), and Prisma **runs those SQL queries** against your database — but only the ones that haven’t been applied yet.

---

#### Simple explanation

This is your **production command**.

It means:

> “Only run the database changes that were already created earlier.”

It does **not** invent new changes.  
It simply executes the saved SQL steps.

---

### 3. `prisma generate`

```bash
npx prisma generate
```

#### Technical

This builds Prisma Client from your `schema.prisma`.

It generates code inside:

```bash
node_modules/.prisma/
```

(and related Prisma client files used by your app)

This step **creates or recreates the Prisma Client code**, which is what your app imports to query the database.

---

#### Simple explanation

Prisma Client is the code your app uses to talk to the database.

So `generate` means:

> “Build (or rebuild) the database helper code my app needs.”

Important:

- It does **not** change the database
    
- It **does** update the code your app uses to interact with the database
    

---

### 4. `prisma db seed`

```bash
npx prisma db seed
```

#### Technical

This runs **your own seed file**, usually something like:

```bash
prisma/seed.ts
```

Inside that file, you typically use Prisma Client to insert data.

---

#### Simple explanation

This means:

> “Run my custom script that fills the database with starter data.”

Examples:

- create an admin user
    
- add sample products
    
- insert default settings
    
- create test data
    

Important:

**Prisma does not magically know what to seed.**  
You write the seed logic yourself.

---

## The difference between database changes and data insertion

This is one of the most important distinctions:

### `migrate`

Changes the **structure** of the database

Examples:

- create table
    
- add column
    
- remove column
    

Behind the scenes, this means:

> Prisma generates and runs SQL like `CREATE TABLE` and `ALTER TABLE`

---

### `seed`

Adds **rows of data** into the database

Examples:

- insert admin user
    
- insert categories
    
- insert default config
    

---

## Understanding migration folders (very important)

Prisma stores migrations here:

```bash
prisma/migrations/
```

Each migration:

- is stored in its own folder
    
- is **versioned by timestamp (date-based)**
    
- contains SQL files (usually `migration.sql`)
    

#### What they usually look like

- **First migration**
    
    - often contains `CREATE TABLE` statements
        
- **Later migrations**
    
    - usually contain `ALTER TABLE`, `ADD COLUMN`, etc.
        

---

#### What actually happens during migration

When you run:

```bash
npx prisma migrate dev
```

or

```bash
npx prisma migrate deploy
```

Prisma is basically doing:

> “Take the SQL files inside the migration folders and run them against the database.”

---

## The easiest mental model

Think of it like building a restaurant:

- **`migrate dev`** = change the building layout during planning
    
- **`migrate deploy`** = apply the approved building changes at the real location
    
- **`generate`** = give staff the updated map of the restaurant
    
- **`seed`** = stock the kitchen with initial food and supplies
    

---

## The key difference: `migrate dev` vs `migrate deploy`

### `migrate dev`

Use on your local machine while building

It can:

- detect schema changes
    
- create migration files
    
- apply them
    

#### Simple version

> “Make new database changes for me.”

---

### `migrate deploy`

Use on a server or production system

It can:

- apply existing migration files
    

It cannot:

- create new ones
    
- compare schema and invent changes
    

#### Simple version

> “Only apply the changes we already approved.”

---

## What “run existing migration files” means

This phrase sounds harder than it is.

Each migration folder contains SQL instructions like:

- create `User` table
    
- add `email` column
    
- add index
    

When you run:

```bash
npx prisma migrate deploy
```

Prisma checks:

- which migration folders exist
    
- which ones the database already ran
    

Then it executes the missing ones by running their SQL.

---

#### Simple version

> “Database, here are the saved steps you haven’t done yet. Run them now.”

---

## Do you need `generate` before migrations on a new system?

Usually, **no**.

A common order is:

```bash
npx prisma migrate deploy
npx prisma generate
```

Why:

- `migrate deploy` → prepares the database
- `generate` → prepares your app to talk to it

---

#### Simple version

First make sure the database is ready.  
Then make sure your app has the updated client code.

---

## Can you name migrations?

Yes:

```bash
npx prisma migrate dev --name add_user_email
```

That name becomes part of the migration folder name.

---

#### Simple version

You are labeling your database change:

- `init`
- `add_orders`
- `remove_legacy_field`

---

## Can you revert to an older migration?

Not like Git.

Prisma does **not** have a simple rollback command like:

```bash
prisma migrate rollback
```

That’s not really the purpose of the migration system. The idea is that you define your schema in Prisma, and Prisma turns those changes into a series of SQL migration files that get run against your database. The first migration often contains the CREATE TABLE statements that build the initial structure, and later migrations contain SQL that changes that structure over time, such as adding columns, modifying tables, or undoing earlier decisions through new changes. By running those migration files in order, Prisma can recreate the database structure faithfully from the beginning to the current version. Prisma determines which SQL files to run to deploy to your database and determines if it needs to create additional SQL files to make sure the database matches your schema.

---

### In development

```bash
npx prisma migrate reset
```

This:

- wipes the database
    
- re-runs all migrations from scratch
    
- optionally re-runs seed
    

---

### In normal workflow

You:

- undo the schema change
    
- create a **new migration** that reverses the old one
    

---

#### Simple version

You don’t “go back in time.”

You create a **new step that fixes the old step**.

---

## Typical development workflow

```bash
# 1. change schema.prisma

# 2. create/apply migration
npx prisma migrate dev --name add_products

# 3. generate client (often automatic, but safe to run)
npx prisma generate

# 4. seed starter data if needed
npx prisma db seed
```

---

## Typical production workflow

```bash
# apply approved database changes
npx prisma migrate deploy

# build prisma client
npx prisma generate
```

Optional:

```bash
npx prisma db seed
```

(only if your production setup expects seeded data)

---

## Very short summary

- **`migrate dev`** = create + apply schema changes (and generate SQL)
- **`migrate deploy`** = run existing migration SQL files
- **`generate`** = build/rebuild Prisma Client in `node_modules/.prisma/`
- **`seed`** = run your custom script to insert data using Prisma Client