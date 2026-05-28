## Why shell scripts with AppleScript start like this: `osascript <<'APPLESCRIPT'`

When a shell script needs to run AppleScript, you often see this pattern:

```bash
/usr/bin/osascript <<'APPLESCRIPT'

tell application "Terminal"
    activate
    do script "echo 'Tab 1'"
end tell

APPLESCRIPT
```

`osascript <<'APPLESCRIPT'` is really two old worlds glued together.

---

### `osascript` — the macOS side

`osascript` is the macOS command-line tool that executes AppleScript or another OSA scripting language.

**OSA** means **Open Scripting Architecture**. It is Apple’s older automation architecture that lets scripting languages control Mac apps through Apple Events.

The scripting languages are:

- **AppleScript**
- **JavaScript** (also called **JXA** / **JavaScript for Automation**)

When you run `osascript`, macOS reads the script and sends Apple Events to apps like Terminal, Finder, or System Events.

---

### `<<'APPLESCRIPT'` — the shell side

The `<< ...` part is **not** AppleScript. It is shell syntax called a **here document**, or **heredoc**.

Heredocs come from Unix shell scripting and were already present in the Bourne shell era. They let you embed a multi-line block of text directly inside a shell script and pass it into a command as input.

In this pattern:

```bash
osascript <<'APPLESCRIPT'
... AppleScript goes here ...
APPLESCRIPT
```

- `<<'APPLESCRIPT'` tells the shell: read everything until a line that is exactly `APPLESCRIPT`, then pass that block to `osascript` as standard input.
- The quotes around `'APPLESCRIPT'` prevent the shell from expanding variables or interpreting special characters inside the block.

So the shell hands a plain text AppleScript program to `osascript`, and `osascript` executes it.

---

### Why combine them?

Shell scripts are good at:

- file paths
- environment variables
- logging
- delays (`sleep`)
- LaunchAgent startup wrappers

AppleScript is good at:

- controlling GUI apps
- opening Terminal tabs
- simulating keyboard shortcuts through `System Events`

The heredoc pattern keeps both languages in one file without escaping every quote in the AppleScript block.

---

### Related

See also: [[Automating Terminal Tabs on macOS with LaunchAgents, AppleScript, and Startup Scripts]]

Fleet deployment: [[PPPC - Pre-Approving macOS Automation Permissions with MDM]]
