Some **Python CLI tools** don’t recommend installing with plain `pip`.  
Instead, they may tell you to use a **specific package manager other than `pip`**, such as `pipx`.

`pipx` is designed specifically for installing and running Python CLI tools in a clean, isolated way.

---

## What `pipx` is

`pipx` is a tool for installing Python applications (CLI tools) globally while keeping their dependencies isolated.

It:

- installs each tool in its own virtual environment
    
- avoids conflicts between tools
    
- keeps your system Python clean
    

---

## Why Python CLI tools recommend `pipx`

Many CLI tools recommend `pipx` because it solves a common problem:

Installing tools globally with `pip` can break things over time.

`pipx` avoids that by isolating each tool.

For example, tools like httpie often recommend installing with `pipx`:

```bash
pipx install httpie
```

---

## `pipx` vs `pip` (simple view)

- **`pip`** → installs packages into the current environment
    
- **`pipx`** → installs CLI tools into their own isolated environments
    

Think of it like:

- `pip` = general-purpose installer
    
- `pipx` = safe installer for CLI tools
    

---

## When to use `pipx`

Use `pipx` when:

- a CLI tool’s docs tell you to use it
    
- you want to install a tool globally without conflicts
    
- you don’t want to manage virtual environments manually
    

---

## Install `pipx`

### Mac (Homebrew)

```bash
brew install pipx
pipx ensurepath
```

^ pipx ensurepath is something you usually run once after installing pipx to make sure its binary directory is added to your system’s PATH. This lets you run installed CLI tools directly from your terminal without needing full paths or extra setup.
### Linux (Debian/Ubuntu)

```bash
sudo apt install pipx
pipx ensurepath
```

Verify:

```bash
pipx --version
```

---

## Common usage

### Install a CLI tool

```bash
pipx install black
```

### Run a tool without installing

```bash
pipx run black --help
```

### Upgrade a tool

```bash
pipx upgrade black
```

---

## Why this matters

If a Python CLI tool recommends `pipx`, it’s usually because:

- it prevents dependency conflicts
    
- it keeps your system clean
    
- it makes uninstalling tools easy
    

**Bottom line:**  
`pipx` is one of the package managers Python CLI tools may tell you to use instead of `pip` when installing standalone tools safely.

---