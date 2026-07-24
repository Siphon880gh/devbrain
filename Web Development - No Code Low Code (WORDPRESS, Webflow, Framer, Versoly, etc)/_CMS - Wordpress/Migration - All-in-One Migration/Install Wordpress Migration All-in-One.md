
Download from
https://wordpress.org/plugins/all-in-one-wp-migration/

Drop it into your `wp-content/plugins` folder:
![[Pasted image 20260515032316.png]]

Activate the plugin:
![[Pasted image 20260515033121.png]]

---

If this error:
![](Gk36O6t.png)

cd into the wp-content/plugins/

make folders ./all-in-one-wp-migration/storage and ./all-in-one-wp-migration/migration/storage

Run commands to recursively change ownership to the site user so that wordpress has read/write permissino:
```
chown SITE_USER:SITE_USER -R ./wp-content
```

You might want to do that for your entire website Wordpress folder though

If still doesn't work, last resort quick fix (but patch this up later):
```
chmod 0777 -R ./wp-content
```

You'll want to deactivate then re-activate.

---

Shows on the left side:
![](PEANKGc.png)

