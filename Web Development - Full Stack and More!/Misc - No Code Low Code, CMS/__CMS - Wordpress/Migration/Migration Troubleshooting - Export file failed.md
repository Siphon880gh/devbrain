
![](https://i.imgur.com/Bu6BMJn.png)


![](https://i.imgur.com/vRHpMHk.png)


Issue when exporting file: wp all in one migration file wasn't available on site

Is usually downloaded a .wpress file to `<document_root>/<wp_site>/wp-content/ai1wm-backups`

Had you renamed the wordpress folder, it’s possible it’s downloading into a different folder but the web browser is downloading from the “correct location” relative to the wp site. Look for other folders that are like `<some_path>/wp-content/ai1wm-backups`. This is likely the case because the plugin didn't complain it failed, but the web browser complained the download is not found.

---


The issue may stem from restrictions enforced by your hosting provider or a security plugin on your WordPress site. Here are some steps to troubleshoot:

1. **Hosting Restrictions**: Reach out to your hosting provider to check for any limitations that might block file downloads, particularly larger files or specific file types like the `.wpress` extension.  
2. **Security Plugins**: If you have active security plugins, they may be causing the issue. Temporarily deactivate these plugins and attempt the download again.  
3. **Server Configuration**: Verify that your server is configured to handle large file downloads. Check PHP settings such as `max_execution_time`, `memory_limit`, and `post_max_size`.  In this. case, refer to: [[All-In-One WP Migration Plugin not working, poss network limits]]
4. **Alternative Download Methods**: If the problem continues, try accessing the backup file directly from the server using FTP or a file manager.  
5. **Browser Issues**: Some browsers might have compatibility issues. Test the download using a different browser or clear your current browser's cache.  
6. **Plugin Updates**: Ensure that All in One WP Migration and other installed plugins are updated to their latest versions.  
7. **Error Logs**: Review your WordPress and server error logs for specific error messages that can provide more details about the problem.  

By following these steps, you can identify and address the root cause effectively.