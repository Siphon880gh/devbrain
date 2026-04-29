## `prisma migrate deploy`

```bash
npx prisma migrate deploy
```

### Technical

This command:

- reads the existing migration files inside `prisma/migrations/`
    
- checks which migrations have already been applied to the database
    
- applies any pending migrations that have not been run yet
    
- updates Prisma’s migration history table in the database
    
- **does NOT create new migration files**
    
- **does NOT compare your schema and database to generate changes**
    

---

### Simple explanation

> “Run the saved migration files that already exist.”

It does not invent new database changes.

It only applies migrations that were already created, usually by:

```bash
npx prisma migrate dev
```

---

### When to use it

Good for:

- production deployments
    
- staging deployments
    
- setting up a pulled project that already has migration files
    
- CI/CD deployment scripts
    
- applying committed migrations from your team
    

---

### When NOT to use it

Avoid using it when:

- you are trying to create a new migration file
    
- you changed `schema.prisma` but have not created a migration yet
    
- you are prototyping and do not care about migration history
    

Why?

Because:

> `migrate deploy` only runs existing migration files. It does not create new ones from your schema.

For creating migrations during development, use:

```bash
npx prisma migrate dev
```

---

### Key difference vs `migrate dev`

- **`migrate dev`** = creates new migration files and applies them locally
    
- **`migrate deploy`** = applies existing migration files only
    

---

### Key difference vs `db push`

- **`db push`** = directly updates the database to match the schema without migration files
    
- **`migrate deploy`** = updates the database by running saved migration files
    

---

### Mental model

- `db push` = “just make the database match the schema”
    
- `migrate dev` = “turn my schema change into a saved migration, then apply it locally”
    
- `migrate deploy` = “run the saved migration files that already exist”