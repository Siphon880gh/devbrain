
If your PHP or python script is creating a new file (for example log.txt) and you run into permission errors when reading the logs:

This is because the php or python file is not the same user or group ownership as the folder where it's writing to. That's the likely case. A less likely case is just not having write permission


### Problem Statement
When visit a php page in the web browser, can it append or write to a file using fwrite? Eg. tracking user behaviors at a user-log.txt. If it's unable, see user and group ownership of the folder it writes to and the php page that does the writing. You can see with `ls -la` and you see they do not match so no wonder the file does not have permission to write to the folder.

### Quick Fix

Your quick fix may be to SSH to where you need to be to make the user and group ownerships the same. Your command will vary depending on situatation, but for example:

```
sudo chown -R b..:b.. devbrain; 
sudo chmod -R u+w devbrain;
```


### Long Term Solution

Keep in mind that when your web hosting panel (like cpanel or cloudpanel) created files for your website, they belong to your "site user" account usually. If you upload your files and scripts from the web hosting panel's in-browser File Manager, the file ownership will be the "site user" usually

You'll likely use your own FTP Client for convenience. So make sure your Filezilla or whatever FTP client logs in using the same site user credentials.

This is to make sure the same user / group ownership belongs to the folder being written to AND of the file that does the writing.


### Debugging

At SSH root access terminal, you can always `ls -la` to see ownership stats. 

Your php and python script can also print the user and group ownership of itself (the file) and the target folder it's being written to. 


----

Files created inside File Manager at CloudPanel as site user wengindustries vs Those from Filezilla as weng

![](https://i.imgur.com/bW4x7jv.png)


Now you’re gonna have a problem if you have index.php write a log.txt of user activities because the folder is not owned by the same user. So make sure you have the site user setup. The site user can also log into SFTP: