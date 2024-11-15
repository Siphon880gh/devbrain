
**Access denied for user 'wff2'@'localhost' to database wp_expert_teams'**
Check your username and password match
Check if that user has permission to the database.

WHM or Control Panel not giving you the UI to check?

If you can ssh, run mysql shell with mysql -u wff2 -p then query for show databases; . What doesn't show up means your database user does not have permission to it.

You can grant permission. Since you are already root by going into SSH, then run without the user and pass flags by running in terminal: mysql
Then show databases; to confirm all databases
Then grant to the specific db user: GRANT ALL PRIVILEGES ON wp_expert_teams.* TO 'wff'@'localhost'
Or you can probably run GRANT ALL  at PHPMyAdmin. And vice versa, you could reveal the user to database permissions there with SQL query: SHOW GRANTS FOR 'wff'@'localhost';
Reworded (theoretical):
PHPMyAdmin way
You could reveal the database user's database permissions  with SQL query: SHOW GRANTS FOR 'wff'@'localhost';
Then you can grant all databases to that user: GRANT ALL PRIVILEGES ON wp_expert_teams.* TO 'wff'@'localhost'