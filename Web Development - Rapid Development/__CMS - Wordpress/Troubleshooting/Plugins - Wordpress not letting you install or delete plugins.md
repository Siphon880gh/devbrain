
Plugin installation/upgrade issues

In my wordpress I try to install a plugin from wp admin. It errored:Installation failed: Could not create directory. /some-path/wp-content/upgrade


Make sure your wp-config.php for your wordpress site has this:
```
// ** Enable FTP dependencies at wp-admin dashboard ** //

define('FS_METHOD', 'direct');
define('FS_CHMOD_DIR',0755);
define('FS_CHMOD_FILE',0644);
```

Everytime you create new folders/files via Filezilla, including for a new wordpress, it will break wordpress's dashboard from being able to download and install new plugins (because it relies on ftp user user@website.com belonging to group wheel, and the folder will default to group root)

So after using FIlezilla, your folders/files belong to root:root. Wordpress at GoDaddy VPS doesnt let you associate with root for ftp/plugins management. So you have to ssh and manually change group ownership to wheel:

```
chown -R :wheel expert-teams-ai
```

If that doesnt work, you need to enable writing and execution for group owner (which will be wheel at this point):
```
chmod -R 775 expert-teams-ai
```

For example:
In case you want to waste time fixing this: No you can't seem to login to user or user@website.com at Filezilla. No you can't login to root for the plugins/ftp management associated with wordpress. No, FIlezilla doesnt have an option to change the default group. No, creating default group for ftp uploads as a setting in ssh did not work. No, adding group wheel to root with `sudo usermod -aG wheel root` expecting Filezilla to upload folders/files into the permission root:wheel did not work.