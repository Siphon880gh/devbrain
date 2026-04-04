There are a couple of practical caveats.

**Purging with asterisk:**
When you need to purge cache, it is often best to purge by path with a wildcard so you clear an entire folder at once. For example, if your updated files are inside `/assets/`, a practical purge pattern would be `/assets/*`. Or you can purge the entire website `https://yourzone.b-cdn.net/website1/*` 

**Upload Interface:**
Also, as of April 2026, Bunny still does not let you rename files or folders directly in the upload interface. If you want a different filename or folder name, you usually have to upload it again under the new name and delete the old one.