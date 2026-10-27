Dump and restore Postgres with the custom format. Do not use plain SQL dumps for big databases.

Installation and basic `psql` access: [[PostgreSQL - _PRIMER - Installation]].

## Why `-Fc`

`pg_dump` default is a plain `.sql` file. Fine for small DBs. For anything large it is slower, uncompressed, and you cannot restore one table or run the restore in parallel.

`-Fc` is custom format: compressed, and `pg_restore` can be selective and parallel.

## Dump

```bash
pg_dump -Fc -d mydb -f mydb.dump
```

Or with an explicit host/user:

```bash
pg_dump -Fc -h 127.0.0.1 -U myapp_user -d mydb -f mydb.dump
```

You get one binary `.dump` file, not a folder of SQL.

## Restore

Create the empty target database first if it does not exist, then:

```bash
pg_restore -d mydb mydb.dump
```

Common extras:

```bash
pg_restore -d mydb --clean --if-exists -j 4 mydb.dump
```

- `--clean` drop objects before recreate
- `--if-exists` so `--clean` does not error on missing objects
- `-j 4` parallel jobs (custom format only — this is why you did not dump as plain SQL)

To restore a single table:

```bash
pg_restore -d mydb -t users mydb.dump
```

## Do not do this for big DBs

```bash
pg_dump mydb > mydb.sql
psql -d mydb -f mydb.sql
```

That is the plain-SQL path. Use it for tiny DBs or when you specifically want a readable script. For backups you will actually restore, use `-Fc` / `pg_restore`.
