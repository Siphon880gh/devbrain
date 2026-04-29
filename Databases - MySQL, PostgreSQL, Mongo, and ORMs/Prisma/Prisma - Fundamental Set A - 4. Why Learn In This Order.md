We arranged these tutorials in this order:

1. `prisma db push`
    
2. `prisma migrate deploy`
    
3. `prisma migrate dev`
    

That order moves from **least involvement with the `prisma/migrations/` folder** to **most involvement with the migration files**.

`db push` has the least involvement. It bypasses the migrations folder completely and simply updates the database directly from `schema.prisma`.

`migrate deploy` is the next step up. It does use the migrations folder, but only to **read existing migration files** and apply them to your database server. It does not create new migration files.

`migrate dev` is for your local development workflow. Since “dev” usually means you are working locally, changing the schema, and creating new database changes, this command can write new migration files into the `prisma/migrations/` folder when needed, then apply the changes to your database.

So the mental model is:
- `db push` = bypass migrations
- `migrate deploy` = run existing migrations
- `migrate dev` = create and run migrations during development