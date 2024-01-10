
Manifests as: Could show up with a blank white page or a white page with some error messages.

## Plug-in Incompatibility

My Wordpress suddenly shows a white screen. It could be a plug-in incompatibility. I have ftp access. Can I disable all plugins easily by renaming the plugins folder?  

  

Yes, you can disable all WordPress plugins by renaming the plugins folder via FTP. This is a common troubleshooting technique to determine if a plugin is causing a problem like the white screen issue. Here's how you can do it:

1. Connect to your website using an FTP client.
2. Navigate to the 'wp-content' directory.
3. Find the 'plugins' folder within 'wp-content'.
4. Rename the 'plugins' folder to something else, like 'plugins_old' or 'plugins_deactivated'.

By doing this, WordPress will not be able to find the plugins and will automatically disable them. If your site comes back up after this, it's a strong indicator that a plugin was causing the issue. You can then rename the folder back to 'plugins' and activate each plugin one by one to identify the culprit.

Remember to back up your site before making any changes, just in case something goes wrong.

  

---

  

## Custom Theme Incompatibility?

You mentioned that's a common troubleshooting method. What's another common troubleshooting method? Let's say the white page is not due to plugins, but due to php version not compatible with theme or wordpress  

  

If the white screen issue is not due to plugin incompatibility and you suspect it might be related to the PHP version not being compatible with your WordPress theme or core, another common troubleshooting method is to switch to a default WordPress theme. This helps determine if the problem is with your current theme. Here's how to do it:

  

1. **Access Your Website via FTP:** Connect to your website using an FTP client.

  

2. **Navigate to the Themes Directory:** Go to the 'wp-content' directory and find the 'themes' folder.

  

3. **Rename Your Current Theme Folder:** Find the folder for your current theme and rename it. This will force WordPress to revert to one of its default themes, like Twenty Twenty-One or Twenty Twenty-Two.

  

If your website works with the default theme, then the issue likely lies with your original theme. This could be due to incompatibilities with the current PHP version. In this case, you can:

  

- Check for theme updates, as the latest version might be compatible with your PHP version.

- Contact the theme developer for support or guidance.

- Temporarily use a default theme while resolving the issue.

  

Always ensure to backup your site before making these changes. If you're not comfortable performing these actions, consider seeking help from a professional.

  

---

  

## Versions

How find out version of Wordpress, my theme, and my php? Give simple methods  

  

To find out the versions of your WordPress installation, your theme, and PHP, you can follow these simple methods:

  

1. **WordPress Version**:

- **Admin Dashboard**: Log in to your WordPress admin dashboard. At the bottom right of the dashboard, you should see a "Thank you for creating with WordPress" message. The version number is usually displayed alongside this message.

- **Version.php File**: Use an FTP client to access your website's files. Navigate to the 'wp-includes' directory and open the 'version.php' file. Look for the `$wp_version` variable, which will show the current WordPress version.

  

2. **Theme Version**:

- **Theme Details in Dashboard**: From the WordPress dashboard, go to "Appearance" > "Themes". Hover over the active theme and click on 'Theme Details'. The version number is displayed in the theme's information popup.

- **Style.css File**: Connect to your website via FTP, navigate to the 'wp-content/themes/your-theme' directory, and open the 'style.css' file. The theme version is usually mentioned in the header comments of this file.

  

3. **PHP Version**:

- **WordPress Dashboard**: In newer WordPress versions, you can find the PHP version in the admin dashboard. Go to "Tools" > "Site Health" > "Info" tab, and under the "Server" section, you should see the PHP version.

- **Hosting Control Panel**: Log in to your web hosting control panel (like cPanel or Plesk). There is often a section for PHP where you can see the current PHP version. Some hosts also display it directly on the main dashboard.

  

These methods should give you the version information you need without requiring advanced technical skills. Remember, if you're not comfortable accessing these areas, it's always a good idea to ask for help from a professional or your hosting provider.

  

---

  

## Versions with no access to dashboard

How find out version of Wordpress, my theme, and my php? I can't access Wordpress dashboard because of the white screen. Even going to website.com/wp-admin shows a white screen  

  

If you're unable to access the WordPress dashboard due to a white screen, you can still find out the versions of your WordPress, theme, and PHP using other methods:

5. **WordPress Version**:
    

- **Version.php File**: Use an FTP client to access your website's files. Navigate to the 'wp-includes' directory and open the 'version.php' file. Look for the `$wp_version` variable, which will show the current WordPress version.

7. **Theme Version**:
    

- **Style.css File**: Connect to your website via FTP, navigate to the 'wp-content/themes/your-theme' directory (replace 'your-theme' with the name of your theme's folder). Open the 'style.css' file. The theme version is usually mentioned in the header comments of this file.

9. **PHP Version**:
    

- **Hosting Control Panel**: Log in to your web hosting control panel (like cPanel or Plesk). There is often a section for PHP where you can see the current PHP version. Some hosts also display it directly on the main dashboard.
- **PHP Info File**: You can create a PHP file to check the version. Here's how:

1. Create a new file and name it 'phpinfo.php' (or something similar).
2. Insert the following code: `<?php phpinfo(); ?>`.
3. Upload this file to the root directory of your website using FTP.
4. Access the file in a web browser by going to 'yourwebsite.com/phpinfo.php'. This will display a page with all the PHP configuration information, including the version.

  

After checking these versions, make sure to delete the 'phpinfo.php' file from your server as it can provide sensitive information about your server setup.

  

[https://chat.openai.com/c/e2b48519-67b7-4bce-a1f3-e8e91189c125](https://chat.openai.com/c/e2b48519-67b7-4bce-a1f3-e8e91189c125)