Two different notification systems.

Built-in TUI notifications:

```toml
[tui]
notifications = true
notification_condition = "unfocused"
notification_method = "auto"
```

`notifications` can also be an event-type allow list, such as `agent-turn-complete` and `approval-requested`.

`auto` prefers OSC 9 desktop notifications and falls back to BEL.

External program on turn complete. Put this in user-level config only; project config ignores `notify`:

```toml
notify = ["python3", "/path/to/notify.py"]
```

The script receives one JSON argument. Current event type is `agent-turn-complete`. Common fields: `thread-id`, `turn-id`, `cwd`, `input-messages`, `last-assistant-message`.
