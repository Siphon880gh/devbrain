
If you change the folder name of a WordPress installation, you need to update two fields in the `wp_options` table to ensure your site functions correctly. These fields are:

1. **`siteurl`**
    
    - This field defines the URL of your WordPress installation.
    - Update it to the new folder path, e.g., `http://example.com/new-folder`.
2. **`home`**
    
    - This field defines the URL of the site homepage (where visitors access your site).
    - Update it to the new folder path, e.g., `http://example.com/new-folder`.

---


If you have multiple databases that all have Wordpress, then before changing the subfolder name (otherwise you can't go into WP dashboard), go into WP dashboard, then go into Tools -> Appearances -> Info. Open "Databases" and look for the database name.