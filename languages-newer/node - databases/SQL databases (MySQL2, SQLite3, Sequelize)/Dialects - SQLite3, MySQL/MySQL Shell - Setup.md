MySQL has a shell that you can invoke in the terminal so you can test MySQL flavored SQL statements and also MySQL commands that facilitate database management.

## On Mac, MySQL shell might come installed. But you'll still want to get the newest version.
Mac instructions:
1. Download and install the .dmg from: https://dev.mysql.com/downloads/mysql/
1a. For the installation options:
  Configure MySQL Server -> Use Legacy Password Encryption
1b. It'll ask for a password. Do not forget this password because it asks for your password when you run mySQL on command.
2. Make sure MySQL server is started: System Preferences -> MySQL

Note: Some MacOS users might get "command not found". In this case, go to ~/.bash_profile and append `export PATH="${PATH}:/usr/local/mysql/bin/"`. Then restart the terminal.

## On Windows, you have to install MySQL
1. Download and install from https://dev.mysql.com/downloads/windows/installer/8.0.html
1a. When installing, choose "Server only" for Setup Type.
1b. For the installation options:
 High Availability -> Standalone MySQL Server
 Authentication Method -> Use Legacy Authentication Method
1c. It'll ask for a password. Do not forget this password because it asks for your password when you run mySQL on command.
1d. At "Apply Configuration", do not tick any extra options.
2. Find C/Program Files/MySQL/MySQL Server 8.0/bin.
Add the MySQL Program Files path to the PATH environment variable so when you type the mysql command in terminal, it'll look in that path along other paths.
    2a. Do a system-wide search "Edit the system environmental variables" -> Click "Environment Variables" button.
    2b. Under "User variables" panel (NOT "System variables"), edit the "Path" variable
    2c. Add a new path to the Path variable: C:/Program Files/sqlite
3. Confirm that MySQL CLI is installed by running in Git Bash: `mysql -V`