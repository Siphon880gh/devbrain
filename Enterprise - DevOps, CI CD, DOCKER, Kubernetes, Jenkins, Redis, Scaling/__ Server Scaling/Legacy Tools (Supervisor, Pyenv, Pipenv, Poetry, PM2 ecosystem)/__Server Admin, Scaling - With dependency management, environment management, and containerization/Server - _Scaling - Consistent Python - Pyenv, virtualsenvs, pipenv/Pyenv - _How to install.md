
### **Mac**

Often if you are testing locally. When ready to deploy your app that uses pyenv, you'll likely to deploy to a Linux OS, which has different setup instructions (next section).

Use homebrew's `brew`:
```bash
brew install pyenv
```

### Linux
#### **Debian-based** (e.g., Debian, Ubuntu)

Use the automated installer to ensure all dependencies and environment variables are set up correctly:

```bash
# Install basic dependencies
sudo apt update
sudo apt install -y make build-essential libssl-dev zlib1g-dev \
  libbz2-dev libreadline-dev libsqlite3-dev curl git \
  libncursesw5-dev xz-utils tk-dev libxml2-dev \
  libxmlsec1-dev libffi-dev liblzma-dev

# Download and run the installer
curl https://pyenv.run | bash
```

After installation, add the following to the end of your shell configuration file (`~/.bashrc`, `~/.zshrc`, etc.):

```bash
export PATH="$HOME/.pyenv/bin:$PATH"
eval "$(pyenv init -)"
eval "$(pyenv virtualenv-init -)"
```

Then apply the changes:

```bash
source ~/.bashrc   # or source ~/.zshrc
```

You can confirm it's working with:

```bash
pyenv --version
```

#### **2. Red Hat-based** (e.g., RHEL, CentOS, AlmaLinux, Rocky Linux)

- Package manager: `yum` or `dnf` (modern)
    
- ✅ You can install pyenv with the same curl method, but dependencies differ:
    

```bash
# For CentOS/RHEL/AlmaLinux/Rocky
sudo yum install -y gcc zlib-devel bzip2 bzip2-devel readline-devel \
  sqlite sqlite-devel openssl-devel xz xz-devel libffi-devel \
  wget curl git make

curl https://pyenv.run | bash
```

#### **3. Fedora**

- Package manager: `dnf`
- ✅ Similar to RHEL but uses more modern package names:

```bash
sudo dnf install -y gcc zlib-devel bzip2 bzip2-devel readline-devel \
  sqlite sqlite-devel openssl-devel xz xz-devel libffi-devel \
  wget curl git make

curl https://pyenv.run | bash
```

#### **Arch-based** (e.g., Arch Linux, Manjaro)

- Package manager: `pacman`
    
- ✅ You can install pyenv directly via `pacman` or `yay`:
    

```bash
# If you use pacman and want to build manually
sudo pacman -S --needed base-devel openssl zlib xz tk git

# Manual install via pyenv.run:
curl https://pyenv.run | bash

# Or install using AUR helper like yay:
yay -S pyenv
```
