Deploy a built frontend (`dist/`) to the server with rsync. Dry-run first.

Basic rsync syntax: [[Rsync]].

## Dry run first (`-n`)

```bash
rsync -avzn --delete ./dist/ user@host:/var/www/app/
```

`-n` is `--dry-run`. It prints what would be copied, updated, or deleted. No files change.

`--delete` removes files on the destination that are not in `./dist/`. That is what you want for a clean static deploy, and also how you wipe a leftover asset from last build. Confirm the destination path before you drop `-n`.

## Then the real deploy

```bash
rsync -avz --delete ./dist/ user@host:/var/www/app/
```

Flags:
- `-a` archive (perms, times, recurse)
- `-v` verbose
- `-z` compress in transit
- `--delete` mirror: extra files on the host go away

## Trailing slashes matter

`./dist/` (slash) copies the **contents** of `dist` into `/var/www/app/`.

`./dist` (no slash) can nest a `dist` folder inside `/var/www/app/`. For this deploy you want the slash on the source.
