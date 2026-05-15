SQLite3 Shell is usually installed to test SQLite SQL statements in the terminal. There are SQLite commands that run in the SQLite Shell and those commands are preceded with a period "."

On Mac, SQLite3 shell is already installed. You don't have to do anything.

On Windows, you have to install SQLite Shell:
1. Create C:/Program Files/sqlite.
2. Download bundle of command line tools for managing SQLite database at https://www.sqlite.org/download.html#win32
3. Unzip CLI executables to the sqlite Program Files path. 
4. Add the sqlite Program Files path to the PATH environment variable so when you type the sqlite3 command in terminal, it'll look in that path along other paths.
    4a. Search "Edit the system environmental variables" -> Click "Environment Variables" button.
    4b. Under "User variables" panel (NOT "System variables"), edit the "Path" variable
    4c. Add a new path to the Path variable: C:/Program Files/sqlite
5. Confirm that sqlite3 command is now installed by running in the terminal `sqlite3 --version`