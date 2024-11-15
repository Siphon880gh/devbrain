
Let's say you have a .wpress file because you had exported (can be many hundred megabytes huge)

Firstly, setup a fresh installation of wordpress at your desired folder. For information on how to install a new wordpress, refer to [[_ Wordpress PRIMER]] and there are instructions on setting up the database user credentials if necessary

Your installation wizard could look like this:
![](https://i.imgur.com/reZNk1g.png)
^ Yes you can do "localhost:3306". 
^ Yes, notice the wp_ is repeated twice. That can cause confusion. It isn't erroneous though. But maybe you should keep it blank. For more information, refer to [[_ Wordpress - Multiple wordpress websites sharing the same database]]
^ Need troubleshooting? May want to spell out the host if localhost doesnt work (localhost usually works even on remote servers though). You may want to test your database credentials using `mysql -u USERNAME -p` then interactively typing the password, while in the SSH terminal.

You may need to have created the database at PHPMyAdmin or MySQL shell
![](https://i.imgur.com/B8ebVP2.png)


You may need to create users. 

If on CloudPanel, you may create the database and/or user in the CloudPanel. Regardless PHPMyAdmin/MYSQLShell/CloudPanel, result is pretty similar. 

Here's the Cloudpanel where you can create databases and/or users:

![](https://i.imgur.com/nYGriDW.png)

You may need to grant all tables to a database user. Refer to [[_ Wordpress PRIMER]] which includes the SQL command to do so (CloudPanel isn't matured enough to handle specific privileges of database users)

---

Now that your Wordpress is finished setting up, go **install All-in-One WP Migration** on this new fresh copy of wordpress. We will import in your .wpress file (from exporting) to replace the current new wordpress.

---

Now go to Import:
![](https://i.imgur.com/B6nMSEC.png)

Clicking file, if you notice:
![](https://i.imgur.com/797Beww.png)

Then you have network limits to fix. Refer to in that case: [[All-In-One WP Migration Plugin not working, poss network limits]]

---

Then, it will start importing from 0% to 100%. If PHP 7 vs 8, you may get this warning message but it's ok
![](https://i.imgur.com/9peYG2r.png)
