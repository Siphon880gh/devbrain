**Debian 12 guide (adapt or google as needed, eg. Mac is entirely different)**

---

**Check Node**

```bash
node -v
```

---

**Install Node (NodeSource, recommended)**

```bash
sudo apt update
sudo apt install -y curl
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt install -y nodejs
```

Verify:

```bash
node -v
```

---

**Check npm**

```bash
npm -v
```

---

**Fix npm (if missing)**

```bash
sudo apt install -y npm
```

Verify:

```bash
npm -v
```

---

**Install NVM (Node Version Manager)**

```bash
curl -fsSL https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.7/install.sh | bash
```

**Load NVM (adds to bash profile automatically, but ensure it’s loaded)**

Check is in bash profile but doesn't matter if it's not because it's even better in bash rc
```bash
export NVM_DIR="$HOME/.nvm"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"
```

You should also add it to bash rc so it persists beyond login SSH terminals (in case have to run scripts that change folder and then runs node scripts so we can leverage .nvmrc)

```bash
echo 'export NVM_DIR="$HOME/.nvm"' >> ~/.bashrc
echo '[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"' >> ~/.bashrc
source ~/.bashrc
```

---

**Use NVM to install/manage Node**

```bash
nvm install 20
nvm use 20
nvm alias default 20
```

Verify:

```bash
node -v
npm -v
```

---

**Quick test**

```bash
node -e "console.log('Node works')"
npm init -y
```

---

If `node -v` and `npm -v` return versions → you’re set.