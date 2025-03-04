If you’ve installed with `pipenv install`  from Pipfile or created Pipfiles, pipenv has created virtual environments. Even after you delete a project folder, the path to the virtual files may remain. To help with cleaning:

Pipenv cleanup
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

So look through .project’s and see which folders can be deleted. A decent sized folder with just several packages installed could be 300MB. You could open the entire `virtualenvs`  folder in VS Code to browse all the .project’s contents, and right click the folder to delete on the left file navigator sidebarTree.