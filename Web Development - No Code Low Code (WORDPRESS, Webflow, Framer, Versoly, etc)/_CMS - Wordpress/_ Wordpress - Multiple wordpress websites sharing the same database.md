### When to Use a Shared Database

Using one database for multiple WordPress installations can make sense when your hosting plan has limited database availability, such as shared hosting plans that only allow one MySQL database.

### Pros of Using One Database

- Simpler database management.
    
- Easier backups because all site data is stored in one database.
    
- Useful when your hosting provider limits the number of databases you can create.
    

### Cons of Using One Database

- The database grows larger faster, which may affect performance over time.
    
- If the database becomes corrupted or misconfigured, multiple sites could be affected.
    
- It can become harder to visually separate which tables belong to which WordPress site.
    
- A mistake during cleanup, migration, or repair could affect the wrong site if table prefixes are confusing.
    

---

See initial setup of a Wordpress website:

![](om4VcrU.png)

In the screenshot, notice that `wp_` appears twice: once in the database name and again as the table prefix.

That can look confusing, but it is not automatically wrong.

For example, the database name might be:

```text
wp_wordpress_test
```

And the WordPress table prefix might be:

```text
wp_
```

That would create tables like:

```text
wp_posts
wp_users
wp_options
```

The repeated `wp_` is only confusing visually. It is not an error if the database is actually being used for a WordPress website.

---

### Using One Database for Multiple WordPress Sites

When setting up multiple WordPress installations in the same database, you can use the **same database name**, but each WordPress installation must use a **unique table prefix**.

For example, suppose you have two WordPress sites:

```text
https://domain.tld/site1
https://domain.tld/site2
```

Both sites could share the same database:

```text
wp_wordpress_test
```

But each site should use a different table prefix.

For example:

```text
site1 prefix: wp_
site2 prefix: ai_
```

Inside MySQL or phpMyAdmin, you would see one database, but the tables would be separated by prefix (for each wordpress site):

```text
ai_posts
ai_users
ai_options
ai_postmeta
ai_usermeta
...
wp_posts
wp_users
wp_options
wp_postmeta
wp_usermeta
```

![[Pasted image 20260527034045.png]]

In this example:

- Tables starting with `wp_` belong to the first WordPress installation.
- Tables starting with `ai_` belong to the second WordPress installation.
    

So if you were installing another WordPress site, such as an AI lessons website, you could set its table prefix to something like:

```text
ai_
```

That way, WordPress knows which tables belong to which site, even though both installations are stored inside the same database.