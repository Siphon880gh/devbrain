# Missing gateway auth token

Exact error when running `openclaw tui`:

```text
Error: Missing gateway auth token.
Fix: set OPENCLAW_GATEWAY_TOKEN/OPENCLAW_GATEWAY_PASSWORD, pass --token/--password,
or resolve the configured secret provider for this credential.
```

---

## Local development (no auth)

If you are only developing locally and do not need gateway auth, set local mode and disable auth:

```bash
openclaw config get gateway.mode
openclaw config get gateway.auth.mode

openclaw config set gateway.mode "local"
openclaw config set gateway.auth.mode "none"
```

Then run `openclaw tui` again.

---

## Production / shared environments

### Easiest: get the token from `openclaw dashboard`

When gateway auth is enabled, the quickest way to get a token for the TUI is to open the web dashboard. The CLI prints the dashboard URL in the terminal; when the token is a plain configured value (not a SecretRef), that URL includes the token in the fragment so the browser can connect.

1. Start the gateway (if it is not already running):

   ```bash
   openclaw gateway
   ```

2. Open the dashboard:

   ```bash
   openclaw dashboard
   ```

   To print the URL without opening a browser:

   ```bash
   openclaw dashboard --no-open
   ```

3. Copy the token from the URL printed in the terminal. It appears in the fragment, for example:

   ```text
   http://127.0.0.1:18789/#token=YOUR_TOKEN_HERE
   ```

4. Pass it to the TUI:

   ```bash
   openclaw tui --token YOUR_TOKEN_HERE
   ```

   For a remote gateway:

   ```bash
   openclaw tui --url ws://<host>:<port> --token YOUR_TOKEN_HERE
   ```

> [!note] SecretRef-managed tokens
> If `gateway.auth.token` is managed by a secret provider, `openclaw dashboard` intentionally prints a URL **without** the token. In that case, resolve the secret from your provider or set `OPENCLAW_GATEWAY_TOKEN` in the shell, then use one of the other options below.

See also: [[_ENTRY - OpenClaw GUI Web]], [[Reference - Starting OpenClaw (Daemon, Gateway, TUI, Web UI)]]

### Other options

Use one of the fixes suggested in the error message:

- Set `OPENCLAW_GATEWAY_TOKEN` or `OPENCLAW_GATEWAY_PASSWORD` in the environment
- Pass `--token` or `--password` to the TUI command
- Configure the secret provider referenced in your OpenClaw config

See also: [[_PRIMER - Open Claw - Required Configuration]]
