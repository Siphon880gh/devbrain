## `prisma migrate dev`

```bash
npx prisma migrate dev
```

### Technical

This command:

- reads your `schema.prisma`
    
- compares it against your database
    
- creates a new migration file inside `prisma/migrations/` if there are schema changes
    
- applies that migration to your local database
    
- updates Prisma’s migration history table in the database
    
- usually runs `prisma generate` after the migration succeeds
    

---

### Simple explanation

> “Create a saved database change step from my schema, then apply it to my dev database.”

It gives you both:

- the actual database update
    
- a recorded migration file you can reuse later
    

---

### When to use it

Good for:

- local development
    
- creating new migration files
    
- working on schema changes before committing them
    
- team projects where database changes need to be tracked
    

---

### When NOT to use it

Avoid using it directly in:

- production
    
- staging environments that should only apply already-created migrations
    
- deployment scripts
    

Why?

Because:

> `migrate dev` is for creating and testing migrations, not safely deploying existing migrations.

For production or deployment, use:

```bash
npx prisma migrate deploy
```

---

### Key difference vs `db push`

- **`db push`** = directly changes the database without creating migration files
    
- **`migrate dev`** = creates migration files and applies them locally
    

---

### Key difference vs `migrate deploy`

- **`migrate dev`** = creates new migrations from your schema changes
    
- **`migrate deploy`** = applies existing migrations from `prisma/migrations/`
    

---

### Mental model

- `db push` = “just make the database match the schema”
    
- `migrate dev` = “turn my schema change into a saved migration, then apply it locally”
    
- `migrate deploy` = “run the saved migrations that already exist”