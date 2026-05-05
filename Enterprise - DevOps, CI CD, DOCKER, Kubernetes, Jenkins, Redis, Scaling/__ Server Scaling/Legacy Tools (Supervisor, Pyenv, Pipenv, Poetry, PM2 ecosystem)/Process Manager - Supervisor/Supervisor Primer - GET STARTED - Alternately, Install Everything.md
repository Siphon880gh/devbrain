This goes ahead and installs everything you need for persistent Python apps. Persistent Python requires consistent and portable python and dependencies.

Skips the theory and just make your system ready to try out the persistent system.

---

- Perform these steps in a temporary throwaway folder.

-  update system
    
    ```bash
    apt update && apt upgrade -y
    ```
    
-  install base deps (needed for pyenv + builds)
    
    ```bash
    apt install -y make build-essential libssl-dev zlib1g-dev \
    libbz2-dev libreadline-dev libsqlite3-dev curl git \
    libncursesw5-dev xz-utils tk-dev libxml2-dev libxmlsec1-dev \
    libffi-dev liblzma-dev ca-certificates
    ```

---

-  install pyenv
    
    ```bash
    curl https://pyenv.run | bash
    ```
    
-  add pyenv to shell (important)
    
    ```bash
    echo 'export PYENV_ROOT="$HOME/.pyenv"' >> ~/.bashrc
    echo 'export PATH="$PYENV_ROOT/bin:$PATH"' >> ~/.bashrc
    echo 'eval "$(pyenv init -)"' >> ~/.bashrc
    echo 'eval "$(pyenv virtualenv-init -)"' >> ~/.bashrc
    source ~/.bashrc
    ```
    
-  install a python version via pyenv (You may choose another version)

    ```bash
    pyenv install 3.11.9
    ```
^ Pyenv's "patching file setup.py" step takes a long time because it compiles Python from source, which can take **5–15+ minutes** depending on your machine, or freeze if dependencies are missing. Interrupt it (Ctrl+C), update your build dependencies (especially zlib, openssl), and retry, as patching can hang due to environment issues.

- set it as the global python version

	```
	pyenv global 3.11.9
	```

-  verify python
    
    ```bash
    python --version
    ```

---

-  install pyenv-virtualenv
    
    ```bash
    git clone https://github.com/pyenv/pyenv-virtualenv.git $(pyenv root)/plugins/pyenv-virtualenv
    exec "$SHELL"
    ```
    
-  create virtualenv
    
    ```bash
    pyenv virtualenv 3.11.9 myenv
    pyenv activate myenv
    ```
Your command line should now be preceded with (myenv)

---

-  install pipenv
    
    ```bash
    pip install pipenv
    ```
    
-  verify pipenv
    
    ```bash
    pipenv --version
    ```

---

-  install flask + gunicorn
    
    ```bash
    pip install flask gunicorn
    ```
    
-  verify flask
    
    ```bash
    python -c "import importlib.metadata as m; print(m.version('flask'))"
    ```
    
-  verify gunicorn
    
    ```bash
    gunicorn --version
    ```

---

-  install supervisor
    
    ```bash
    apt install -y supervisor
    ```
    
-  start + enable supervisor
    
    ```bash
    systemctl enable supervisor
    systemctl start supervisor
    ```
    
-  verify supervisor
    
    ```bash
    systemctl status supervisor
    ```
    
-  quick flask test app

Create this shell script `app.sh`:
```bash
cat <<EOF > app.py
from flask import Flask
app = Flask(__name__)

@app.route("/")
def hello():
	return "Hello World"

if __name__ == "__main__":
	app.run()
EOF
```

- Run shell script to create `app.py`:
```
chmod u+x app.sh
./app.sh
ls app.py
```

-  run with gunicorn

```bash
gunicorn -w 2 -b 0.0.0.0:8000 app:app
```

-  verify works

May need to open another SSH terminal concurrently:
```bash
curl http://127.0.0.1:8000
```