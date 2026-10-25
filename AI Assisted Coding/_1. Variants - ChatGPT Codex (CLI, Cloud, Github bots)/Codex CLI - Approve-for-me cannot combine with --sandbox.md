`codex` may already be aliased to:

```
codex --approve-for-me
```

That flag already selects the workspace-write sandbox. It cannot be combined with `--sandbox`.

So these fail if `codex` is that alias:

```
codex --sandbox read-only
codex --sandbox workspace-write
```

Call the Codex binary directly when you need a sandbox flag:

```
command codex --sandbox read-only
command codex --sandbox workspace-write
```

`command` skips the alias and runs the real executable.

Related: [[Advanced - command prefix to bypass aliases]]
