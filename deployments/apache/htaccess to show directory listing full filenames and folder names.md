.htaccess:
```
Options +Indexes
<IfModule mod_autoindex.c>
  IndexOptions NameWidth=*
</ifModule>
```

Notice the NameWidth is set to wildcard `*` which will show full length of file and folder names