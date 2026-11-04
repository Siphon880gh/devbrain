`shell_environment_policy` controls which environment variables spawned commands inherit.

```toml
[shell_environment_policy]
inherit = "core"
set = { MY_FLAG = "1" }
ignore_default_excludes = false

[shell_environment_policy.filters]
"AWS_*" = "exclude"
"AZURE_*" = "exclude"
```

`inherit` is `all`, `core`, or `none`.

`ignore_default_excludes` defaults to `true`, so names containing `KEY`, `SECRET`, or `TOKEN` are kept. Set it to `false` to strip those automatically before your filters run.

Filter patterns are case-insensitive and support `*` and `?`. If any filter is `"include"`, Codex keeps only matching variables. Includes cannot restore a value that was already excluded.

Order: automatic exclusions, then custom exclusions, then `set`, then the include allowlist. `set` can put an excluded variable back. An include allowlist can still drop it.

Do not combine `[shell_environment_policy.filters]` with the older `exclude` or `include_only` arrays in the same layer. Codex rejects that.
