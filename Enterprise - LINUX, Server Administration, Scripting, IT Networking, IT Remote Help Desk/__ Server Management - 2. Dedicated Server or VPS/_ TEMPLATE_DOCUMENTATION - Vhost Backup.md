This is your crucial vhost and included vhosts, whether Nginx or Apache. Keeping a backup in case you mess up the crucial vhost in the future or when you migrate your website to another server.

Hint: Note if vhost from Cloudpanel, it has variables that need expanded. Use comments to comment off the `{{variable}}`'s and enter manually the actual path or value (see `/etc/nginx/sites-enabled/...conf`)

---

## Backup Date: `<Date>`
Have: Eg. Metabase and VLAI Microservices with SSE connections

```
Vhost file contents here
```

Additional included vhost files here. Then use headings and subheadings so that a table of contents is possible in Obsidian or Markdown rendered, to navigate to different Vhosts

Included .conf file: ...
```
...
```


Included .conf file: ...
```
...
```

---

## OR - Path to backups on server and local machine

Alternately, you could just backup as vhost files near where your pm2 is inside a centralized eco/ folder (make sure to block public web access). In that case, write it so under the document so you can remember to refer to the files