
For a visual indicator of progress while decompressing files, you can use the `pv` command, which provides a progress bar. This is better than what appeared to be a hanging command.

Here’s how you can do it:

1. **Install `pv` (if not already installed):**
   ```bash
   sudo apt-get install pv
   ```

2. **Use `pv` with `gzip` to show progress:**
   ```bash
   pv ubuntu-22.04-live-server-riscv64.img.gz | gunzip > ubuntu-22.04-live-server-riscv64.img
   ```

This command pipes the compressed file through `pv`, which displays a progress bar, and then uncompresses it using `gunzip`.

Alternatively, you can use `zcat` combined with `pv`:

```bash
pv ubuntu-22.04-live-server-riscv64.img.gz | zcat > ubuntu-22.04-live-server-riscv64.img
```

This achieves the same result and also shows progress.

These methods should give you a visual indication of the progress while decompressing the file.

Looks like this:
```
.30GiB 0:00:22 [1.13MiB/s] [==============================================================================================================================================================================>        ] 96% ETA 0:00:00                      ] 62% ETA 0:00:05
```
