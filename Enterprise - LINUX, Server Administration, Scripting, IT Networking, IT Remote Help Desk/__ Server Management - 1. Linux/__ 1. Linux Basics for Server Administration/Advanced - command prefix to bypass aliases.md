If a command name is aliased, extra flags you type after it are appended to the alias. That can break when the alias already includes flags that cannot be combined with the ones you want.

`command` skips the alias and runs the real executable:

```
command codex --sandbox read-only
```

Without `command`, if `codex` is aliased to `codex --approve-for-me`, the shell tries to combine those flags and fails.

Check what the shell will actually run:

```
type codex
type cxr
```

`type` shows whether the name is an alias, a function, a builtin, or a binary. See [[Which, whereis, type - For Commands]].
