## Loading and unloading LaunchAgents with launchctl

After you create a LaunchAgent `.plist` file, you register it with `launchd` using `launchctl`.

Typical location for user LaunchAgents:

```text
~/Library/LaunchAgents/
```

Example plist label:

```text
com.user.test-terminal-tabs
```

---

### Load a LaunchAgent

```bash
launchctl load ~/Library/LaunchAgents/com.user.test-terminal-tabs.plist
```

Loading tells `launchd` to read the plist and start managing that job. If the plist has `RunAtLoad` set to `true`, the job runs immediately.

---

### Unload a LaunchAgent

```bash
launchctl unload ~/Library/LaunchAgents/com.user.test-terminal-tabs.plist
```

Unloading stops the job and removes it from active management by `launchd`.

---

### Error: load again without unloading first

If you try to load it again when it has not been unloaded, you get this error:

```text
Load failed: 5: Input/output error
Try running `launchctl bootstrap` as root for richer errors.
```

This usually means the LaunchAgent is already loaded. Unload it first, then load again:

```bash
launchctl unload ~/Library/LaunchAgents/com.user.test-terminal-tabs.plist
launchctl load ~/Library/LaunchAgents/com.user.test-terminal-tabs.plist
```

If you changed the plist, unload and reload so `launchd` picks up the new settings.

---

### Related

See also:

- [[Automating Terminal Tabs on macOS with LaunchAgents, AppleScript, and Startup Scripts]]
- [[Jamf Pro - Policies, Profiles, and Smart Groups]] (deploy LaunchAgents fleet-wide)
- [[Jamf Troubleshooting - Common Issues]] (when a deployed agent fails to load)
