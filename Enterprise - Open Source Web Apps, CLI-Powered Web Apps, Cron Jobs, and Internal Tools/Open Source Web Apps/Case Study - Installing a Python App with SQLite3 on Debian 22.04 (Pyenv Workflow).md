Titled: Installing a Python App with SQLite3 on Debian 22.04 (Pyenv Workflow)

#### **Problem**

Running `python run.py` failed due to Python not starting, and later due to a missing `sqlite3` module.

#### **Diagnosis**

- `python --version` returned:
  
	```
	pyenv: python: command not found
	
	The python command exists in these Python versions:
	  3.12.4
	  3.12.4/envs/app1
	  app1
	```    
    
- Pyenv showed Python versions available but not currently active.
    
- After activating Python 3.8.18 with `pyenv local 3.8.18`, the app still failed due to missing `sqlite3`, even though `requirements.txt` installed cleanly.

#### **Root Cause**

- `sqlite3` is part of Python's standard library, **but only included if Python is built with SQLite dev libraries**.
- Since `libsqlite3-dev` wasn’t installed system-wide, `pyenv` built Python **without `sqlite3` support**.

#### **Fix Steps**

1. **Check your OS**:
    
    ```bash
    cat /etc/os-release
    # Confirms you're on Debian/Ubuntu (in this case, Ubuntu 22.04)
    ```
    
2. **Install SQLite dev headers**:
    
    ```bash
    sudo apt update
    sudo apt install libsqlite3-dev
    ```
    
    > If you skip `apt update`, you may get `404` errors due to outdated package references.
    
3. **Reinstall Python via Pyenv**:
    
    ```bash
    pyenv uninstall 3.8.18
    pyenv install 3.8.18
    pyenv local 3.8.18
    ```
    
4. **Install project dependencies**:
    
    ```bash
    pip install -r requirements.txt
    ```
    
5. **Run your app**:
    
    ```bash
    python run.py
    # Now works — sqlite3 is correctly built into Python
    ```