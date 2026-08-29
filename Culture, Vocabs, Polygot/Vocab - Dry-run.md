A **dry run** means:

> Simulate an operation and show what would happen, without actually changing anything.

For example:

```bash
brew cleanup --dry-run
```

* Examines what could be cleaned.
* Lists the files it **would remove**.
* Does not delete anything.

Then:

```bash
brew cleanup
```

performs the actual deletion.

Dry runs are common in IT for previewing potentially risky operations such as deleting files, deploying software, synchronizing folders, or changing infrastructure. Think of it as a **rehearsal or preview mode**.