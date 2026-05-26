# OpenClaw TUI Primer

TUI means **Terminal User Interface**.

The TUI connects to the gateway at:

`ws://127.0.0.1:18789`

## Basic Flow

1. Start the gateway:

   ```bash
   openclaw gateway
   ```

   ![[Pasted image 20260525194744.png]]

   > [!note] Error: Missing config
   > Missing config. Run openclaw setup or set gateway.mode=local (or pass --allow-unconfigured).
   >
   > Run openclaw setup for first-time setup. See [[Missing config. Run openclaw setup or set gateway.mode to local]].
   >

   ![[Pasted image 20260525194837.png]]

2. Open the TUI:

   ```bash
   openclaw tui
   ```

   > [!note] Error: Missing gateway auth token
   > Error: Missing gateway auth token. Set OPENCLAW_GATEWAY_TOKEN or OPENCLAW_GATEWAY_PASSWORD, pass --token or --password, or configure your secret provider.
   >
   > For local development only: openclaw config set gateway.mode "local" and openclaw config set gateway.auth.mode "none".
   >
   > For production / shared environments: run openclaw dashboard (or openclaw dashboard --no-open), copy the token from the URL printed in the terminal, then run openclaw tui --token YOUR_TOKEN_HERE. See [[Missing gateway auth token]].
   >

3. Type a message and press Enter.

TUI in terminal:

![[Pasted image 20260525203148.png]]

Docs:
[https://docs.openclaw.ai/web/tui](https://docs.openclaw.ai/web/tui)

If you open the same endpoint in a browser, it looks like:

![[019d7787-3124-72ac-8689-4883612266c8.png]]
