## `prisma db push`

```bash
npx prisma db push
```

### Technical

This command:

- reads your `schema.prisma`
    
- directly updates the database to match it
    
- **does NOT create migration files**
    
- **does NOT use `prisma/migrations/` at all**
    

---

### Simple explanation

> “Just make my database match my schema right now.”

No history. No versioning. No SQL files saved.

---

### When to use it

Good for:

- quick prototyping
    
- local experiments
    
- early development before you care about migrations
    

---

### When NOT to use it

Avoid in:

- production
    
- team environments
    
- anything where you need history or rollback
    

Why?

Because:

> You lose the record of what changed and how to reproduce it.

---

### Key difference vs migrations

- **`db push`** = direct update (no history)
    
- **`migrate dev`** = creates SQL files + history
    

---

### Mental model

- `db push` = “just fix the DB to match this schema”
- `migrate dev` = “create a recorded, repeatable step to change the DB”