## Missing config — run openclaw setup or set gateway.mode to local

Exact error when starting the gateway:

```text
Missing config. Run `openclaw setup` or set gateway.mode=local (or pass --allow-unconfigured).
```

---

### First-time setup

If OpenClaw was never configured, run the setup wizard:

```bash
openclaw setup
```

![[Pasted image 20260525195349.png]]

---

### Already set up

If OpenClaw was configured before, you may only need to start the gateway service:

```bash
openclaw gateway start
```

Terminal might look like:
- Second command in the screenshot
![[Pasted image 20260509084317.png]]

---

### Alternative

Or set local mode in a command. Remember the gateway mode is the one setting that triggers the missing config message. Set with this command:

```bash
openclaw config set gateway.mode "local"
```

Or pass `--allow-unconfigured` when starting the gateway.

See also: [[Reference - Starting OpenClaw (Daemon, Gateway, TUI, Web UI)]]
