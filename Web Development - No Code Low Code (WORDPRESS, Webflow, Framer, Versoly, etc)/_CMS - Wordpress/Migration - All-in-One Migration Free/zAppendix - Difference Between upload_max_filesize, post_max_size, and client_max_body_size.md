
`upload_max_filesize` controls the max size of **one uploaded file**.

For example:
```
upload_max_filesize = 512M
```

---

`post_max_size` controls the max size of the **entire HTTP POST request**, including:
```
uploaded file
form fields
metadata
other request body data
```

For example:
```
post_max_size = 512M
```

---

Nginx `client_max_body_size` controls the max request size Nginx accepts before passing it to PHP.

For example:
```
client_max_body_size 512M;
```

---

To make configurations easier, match them to each other like this:
```
upload_max_filesize = 512M
post_max_size = 512M
client_max_body_size 512M;
```
