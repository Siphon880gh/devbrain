All-in-One WP Migration remains **free as of May 2026**.

However, you need to have a lot of ducks lined up in a row to make it work. Long import times or large files can cause the import to time out or freeze because one of the required settings is not high enough.

A single-page developer portfolio can be over **250 MB**. On basic consumer internet, it can take more than 120 seconds to upload. That means you need to account for both the **time limit** and the **file size limit**.

Most default server settings are insufficient for the 250mb / 120 seconds example.

---

Then at a minimum, you need to configure the limits at the **PHP level** and the **WordPress level**. Then it's a matter of apache or nginx (your web server) that needs configuration.

It is more challenging if you use **Nginx** or **Cloudflare** because they are difficult to configure:
- **Free Cloudflare accounts enforce a 120-second limit** (This used to be a 100-second limit). Free accounts also have a **100 MB upload limit**. 
	- One workaround is to disable Cloudflare’s proxy by changing your DNS records back to **DNS only** instead of **Proxied**.
	- But if you are protecting your VPS / dedicated server's IP from being exposed to botnets, then it gets even trickier (You still have to turn off Cloudflare though)
- **Nginx requires configuration in multiple places** to fully increase the upload and timeout limits.

You will know there is a problem when you restore from a file and, during the import, it either shows an error or freezes on the progress bar. **Refer to the files in this folder for specific errors, then troubleshoot from there.**

---

The **paid version** of All-in-One WP Migration is easier because you can upload the backup file and then simply select it to restore. If you try to do that with the free version, it will ask you to upgrade to the paid version.

A lot of problems from the free version that requires you to have the right configuration can simply be bypassed using the paid features: manually uploading your `.wpress` backup file directly to your hosting server’s `wp-content/ai1wm-backups` directory, then selecting the file to restore at Wordpress Migrations All-in-one