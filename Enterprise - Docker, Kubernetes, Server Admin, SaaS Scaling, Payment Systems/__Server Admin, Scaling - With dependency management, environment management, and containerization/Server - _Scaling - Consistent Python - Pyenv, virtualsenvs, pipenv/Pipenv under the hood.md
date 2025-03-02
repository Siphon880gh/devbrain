When you run `pipenv install` against a Pipfile, if this is your first time, then pipenv will create a folder representing the pipenv virtual environment for that project. 

Virtualenv directories:
- **Linux/macOS**: `~/.local/share/virtualenvs/`
- **Windows**: `%USERPROFILE%\.virtualenvs\`

The folder structure looks like:
```
tree -La 2  
.  
├── app-7u_qFkpo  
│   ├── .gitignore  
│   ├── .project  
│   ├── bin  
│   ├── include  
│   ├── lib  
│   ├── pyvenv.cfg  
│   ├── share  
│   └── src  
├── app-FDc139fg  
│   ├── .gitignore  
│   ├── .project  
│   ├── bin  
│   ├── include  
│   ├── lib  
│   ├── pyvenv.cfg  
│   ├── share  
│   └── src  
├── app-ZEGza2AW  
│   ├── .gitignore  
│   ├── .project  
│   ├── bin  
│   ├── include  
│   ├── lib  
│   ├── pyvenv.cfg  
│   ├── share  
│   └── src  
├── app-gbP3IIdU  
│   ├── .gitignore  
│   ├── .project  
│   ├── bin  
│   ├── include  
│   ├── lib  
│   ├── pyvenv.cfg  
│   ├── share  
│   └── src
```

The pyenv.cfg file is the python interpreter path. The bin/ are the packages. At .project inside is the path to your folder that gets matched when you run `pyenv shell` 