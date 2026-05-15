The file that you exported/downloaded off the older server, you can just upload to `wp-content/ai1wm-backups` via FTP/SFTP:
![[Pasted image 20260515023622.png]]

At the Wordpress admin dashboard, go to left sidebar's All-in-One WP Migration -> Backups -> Select the backup that represents what you uploaded to FTP/SFTP -> Restore:
![[Pasted image 20260515023929.png]]

That's it!

However, if you're on the free plugin, you'll get this warning:
![[Pasted image 20260515024001.png]]

Then you'd have to import the manual way (uploading the wpress file through the plugin web interface) which requires you to have all the ducks lined up configuration-wise because most websites can't handle large hundreds of megabytes upload. Refer to [[Caveat about Free Version (All-in-One Migration)]]