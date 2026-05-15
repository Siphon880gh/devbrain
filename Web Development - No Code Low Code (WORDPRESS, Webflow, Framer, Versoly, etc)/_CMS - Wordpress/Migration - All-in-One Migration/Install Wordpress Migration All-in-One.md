
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

run commands to recursively change permissions:
```
chmod 0777 -R ./wp-content
chown root:root -R ./wp-content
```

---

Shows on the left side:
![](PEANKGc.png)

