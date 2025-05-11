
1. Tell Git to stop tracking the submodule as a submodule of the repository (Effectively removes the submodule's configuration entry from .git/config).

```
git submodule deinit `pwd`/FOLDER_NAME
```

2. Edit `.gitmodules` and remove that entry. It's found in the root and not inside `.git` folder

For example removing:
```
[submodule "FOLDER_NAME"]

path = FOLDER_NAME

url = /Users/wengffung/dev/web/app/FOLDER_NAME
```