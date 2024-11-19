
Migration Guides

### Migration - Designed wordpress into fresh wordpress copy

All-In-One Migration Plugin
https://wordpress.org/plugins/all-in-one-wp-migration/

^ Click download
Unzip and move into /wp-content/plugins

If this error:
![](https://i.imgur.com/Gk36O6t.png)

cd into the wp-content/plugins/

make folders ./all-in-one-wp-migration/storage and ./all-in-one-wp-migration/migration/storage

run commands to recursively change permissions:
```
chmod 0777 -R ./wp-content
chown root:root -R ./wp-content
```

---

Increase Wordpress upload limits php before importing... making sure first 3 settings are greater than your wpress file:

```
@ini_set( 'upload_max_filesize' , '128M' );
@ini_set( 'post_max_size', '128M');
@ini_set( 'memory_limit', '256M' );
@ini_set( 'max_execution_time', '300' );
@ini_set( 'max_input_time', '300' );
```


If it complains still, then the settings are not taking. Here are other ways.

Try going into CPanel or WHM. Like ...cpsess0787040780/scripts2/multiphp_ini_editor/basic?login=1&post_login=29735274873117

![](https://i.imgur.com/VO1nkh4.png)





```
1. **Using a Plugin**
    
    There are plugins available that can increase your upload size limit. However, if your server has hard limits, a plugin might not work. The All-in-One WP Migration plugin itself has an extension to increase the upload size, but it's paid.
    
2. **Contact Your Hosting Provider**
    
    Sometimes shared hosting providers impose server-side limits that you cannot override from within WordPress. In such cases, the most straightforward solution might be to contact your hosting provider and request an increase in file upload size.
    
3. **Check the "Media" in the Dashboard**
    
    Sometimes WordPress might show the allowed max upload size in the `Media` -> `Add New` section in the dashboard. If it's not reflecting the changes, then it's very likely server-side settings or restrictions preventing the change.
    
4. **MultiPHP INI Editor (cPanel)**
    
    If your hosting uses cPanel, you may have the option to use the MultiPHP INI Editor, which provides a graphical interface to change PHP settings:
    
    - Login to cPanel.
    - Under the "Software" section, click on "MultiPHP INI Editor".
    - Select the domain you're working on.
    - Adjust the values for: `upload_max_filesize`, `post_max_size`, `memory_limit`, `max_execution_time`, and `max_input_time`.

Remember, after making these changes, always clear your browser cache and restart your web server (if you have that capability) to ensure the changes take effect. If all else fails, consider breaking up your backup into smaller parts or using another migration method.
```


https://claude.ai/chat/8a0a6411-bc60-4758-ab9a-2515f644e556
https://chat.openai.com/c/38475d71-70ad-4f18-956b-8fc5260620fc


---

You may see folders/files named "ai1wm" which stands for all-in-1 wordpress migration

---

Where to use the plugin

Shows on the left side:
![](https://i.imgur.com/PEANKGc.png)



----

### Migration - localhost to remote server

Have the same wordpress database name for that website as the target server

Upload the same files to the target server. Suggestion: It would be slow through a FTP client. A possible workflow is upload only once to a folder that you won’t change.  Then every time you migrate another Wordpress, go into ssh terminal and run the cp command from that folder to the new folder.

Adjust the database, username, and password at wp-config.php

Migration problems? Change wp-config.php:
define( 'WP_DEBUG', true );
And you might get a message like:

