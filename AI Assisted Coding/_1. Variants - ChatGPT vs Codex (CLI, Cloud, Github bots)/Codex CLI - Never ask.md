If you want Codex CLI to run without asking for permission on new commands, new folder paths, etc:

To always deny permissions that hadn't been saved before:
```
codex -a never
```

To always accept permissions that hadn't been saved before:
```
codex --yolo
```
^ Warning: Could wipe out your hard drive.

Note:
- The `-a` is approval
- There is no such thing as `codex -a always` - its equivalent is `codex --yolo`