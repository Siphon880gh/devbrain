
```
% litellm --config config.yaml /Users/wengffung/anaconda3/lib/python3.10/site-packages/pydantic/_internal/_config.py:345: UserWarning: Valid config keys have changed in V2: * 'fields' has been removed warnings.warn(message, UserWarning) Traceback (most recent call last): File "/Users/wengffung/anaconda3/lib/python3.10/site-packages/litellm/proxy/proxy_server.py", line 59, in <module> from apscheduler.schedulers.asyncio import AsyncIOScheduler ModuleNotFoundError: No module named 'apscheduler' During handling of the above exception, another exception occurred: Traceback (most recent call last): File "/Users/wengffung/anaconda3/bin/litellm", line 8, in <module> sys.exit(run_server()) File "/Users/wengffung/anaconda3/lib/python3.10/site-packages/click/core.py", line 1485, in __call__ return self.main(*args, **kwargs) File "/Users/wengffung/anaconda3/lib/python3.10/site-packages/click/core.py", line 1406, in main rv = self.invoke(ctx) File "/Users/wengffung/anaconda3/lib/python3.10/site-packages/click/core.py", line 1269, in invoke return ctx.invoke(self.callback, **ctx.params) File "/Users/wengffung/anaconda3/lib/python3.10/site-packages/click/core.py", line 824, in invoke return callback(*args, **kwargs) File "/Users/wengffung/anaconda3/lib/python3.10/site-packages/litellm/proxy/proxy_cli.py", line 275, in run_server raise e File "/Users/wengffung/anaconda3/lib/python3.10/site-packages/litellm/proxy/proxy_cli.py", line 266, in run_server from .proxy_server import ( File "/Users/wengffung/anaconda3/lib/python3.10/site-packages/litellm/proxy/proxy_server.py", line 61, in <module> raise ImportError(f"Missing dependency {e}. Run `pip install 'litellm[proxy]'`") ImportError: Missing dependency No module named 'apscheduler'. Run `pip install 'litellm[proxy]'`

```


That error means **the shell command `litellm` is not using the `uv tool` install you just did**.

Your traceback shows this clearly:

- it is running from: `/Users/wengffung/anaconda3/bin/litellm`
    
- and importing packages from: `/Users/wengffung/anaconda3/lib/python3.10/...`
    

So even though LiteLLM’s docs say the proxy server can be installed with `uv tool install 'litellm[proxy]'`, your terminal is still picking up the **Anaconda copy** of `litellm`, which does not have the proxy extras installed. ([liteLLM](https://docs.litellm.ai/docs/?utm_source=chatgpt.com "Getting Started | liteLLM"))

Use this:

```bash
which litellm
which litellm-proxy
uv tool list
uv tool dir --bin
```

If `which litellm` points to Anaconda, that is the problem. `uv` installs tool executables into its own bin directory, and that directory must be on your `PATH` for the shell to pick them up. `uv tool update-shell` is the official way to add that tools directory to your shell config. ([Astral Docs](https://docs.astral.sh/uv/concepts/tools/?utm_source=chatgpt.com "Tools | uv"))

Most likely fix:

```bash
uv tool install 'litellm[proxy]'
uv tool update-shell
exec $SHELL
which litellm
which litellm-proxy
```

Then try:

```bash
litellm --config config.yaml
```

or, if installed, use the dedicated CLI LiteLLM documents for proxy tooling:

```bash
litellm-proxy
```

LiteLLM’s docs specifically show that installing `litellm[proxy]` via `uv tool install` should provide executables like `litellm` and `litellm-proxy`. ([liteLLM](https://docs.litellm.ai/docs/proxy/management_cli?utm_source=chatgpt.com "LiteLLM Proxy CLI"))

If you want to avoid all PATH confusion right now, use the uv-managed executable directly from its bin dir:

```bash
"$(uv tool dir --bin)/litellm" --config config.yaml
```

or:

```bash
"$(uv tool dir --bin)/litellm-proxy"
```

That bypasses Anaconda entirely. `uv` documents `uv tool dir --bin` for locating the executable directory. ([Astral Docs](https://docs.astral.sh/uv/reference/storage/?utm_source=chatgpt.com "Storage | uv"))

If you do not want the Anaconda copy at all, you can also remove it from that environment:

```bash
pip uninstall litellm
```

or in conda:

```bash
conda remove litellm
```

Then your shell is less likely to grab the wrong one.

The important part is this:

- `uv tool install 'litellm[proxy]'` installs a **tool**
    
- it does **not** repair whatever old `litellm` executable Anaconda already put earlier on your `PATH` ([Astral Docs](https://docs.astral.sh/uv/guides/tools/?utm_source=chatgpt.com "Using tools | uv"))
    

So the fix is not really “install proxy again.”  
The fix is “make sure you are launching the **uv-installed** LiteLLM, not the Anaconda one.”

Run these 4 commands and look at the output:
```bash
which litellm
which litellm-proxy
uv tool list
uv tool dir --bin
```

For example:
```
/Users/wengffung/anaconda3/bin/litellm
/Users/wengffung/.local/bin/litellm-proxy
litellm v1.83.12
- litellm
- litellm-prox
```


You currently have **two different LiteLLM executables**:

- `litellm` → `/Users/wengffung/anaconda3/bin/litellm` ← **wrong one**
- `litellm-proxy` → `/Users/wengffung/.local/bin/litellm-proxy` ← **uv one**


Use the uv-installed executable directly right now:
```
~/.local/bin/litellm --config config.yaml
```

If you want the plain `litellm` command to work normally, put uv’s tools bin **ahead of Anaconda** in your shell `PATH`. `uv tool update-shell` is the official way to add the tools directory to your shell config.

Try:
```
uv tool update-shell  
exec $SHELL  
which litellm  
which litellm-proxy
```

After that, `which litellm` should point to something under:

```
/Users/wengffung/.local/bin/litellm
```

not Anaconda.