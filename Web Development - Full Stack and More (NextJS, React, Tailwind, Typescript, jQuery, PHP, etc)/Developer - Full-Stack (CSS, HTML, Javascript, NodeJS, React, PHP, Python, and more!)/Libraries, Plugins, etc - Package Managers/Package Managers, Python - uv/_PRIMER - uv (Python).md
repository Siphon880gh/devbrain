Some **Python CLI tools** don’t recommend installing with plain `pip`.  
Instead, they may tell you to use a **specific package manager other than `pip`**, such as `uv`. For example, LiteLLM in April 2026 recommends using uv to install their python package.

`uv` is a fast Python package and environment manager designed to make installing and running tools easier and more reliable.

Namesake:
It's Rust-based Python package manager and toolchain developed by Astral that mainly stands for ==**Ultraviolet**==.

---

## What `uv` is

`uv` is a modern tool for managing Python packages and environments.

It can:

- create virtual environments
    
- install packages
    
- run Python CLI tools
    
- manage dependencies for projects
    

It replaces several steps you’d normally do manually with `pip`.

---

## Why Python CLI tools recommend `uv`

Many newer Python CLI tools prefer `uv` because:

- it installs faster than `pip`
    
- it avoids common environment issues
    
- it keeps tool installs isolated (no global mess)
    
- it provides more consistent setups across machines
    

So instead of telling you:

```bash
pip install some-tool
```

they may say:

```bash
uv tool install some-tool
```

---

## `uv` vs `pip` (simple view)

- **`pip`** → installs packages
    
- **`uv`** → installs packages _and_ manages environments and tools cleanly
    

Think of `uv` as a more complete workflow tool.

---

## When to use `uv`

Use `uv` when:

- a Python CLI tool tells you to use it
    
- you want to install tools globally without breaking your system Python
    
- you want a cleaner setup than `pip install` everywhere
    

---

## Install `uv`

### Mac (Homebrew)

```bash
brew install uv
```

### Linux (Debian/Ubuntu and others)

```bash
curl -LsSf https://astral.sh/uv/install.sh | sh
```

Verify:

```bash
uv --version
```

---

## Common usage

### Install a CLI tool

```bash
uv tool install some-tool
```

### Run a tool without installing globally

```bash
uvx some-tool
```

### Create a virtual environment

```bash
uv venv
```

### Install packages in a project

```bash
uv pip install requests
```

---

## Why this matters

If a Python CLI tool recommends `uv`, it’s usually because:

- it avoids dependency conflicts
    
- it installs faster
    
- it keeps your system clean
    

**Bottom line:**  
`uv` is one of the package managers Python CLI tools may tell you to use instead of `pip` for a smoother setup and fewer issues.