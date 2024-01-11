
```
RewriteEngine On  
  
# Check if the request is for the root directory  
RewriteCond %{REQUEST_URI} ^/$  
  
# Internally redirect with masking  
RewriteRule ^$ me2/index.php [L]  
  
# Have devbrain internally redirect masking to tools/gamified-knowledge  
# Have app/, apps/, tool/ externally redirect to tools/  
RewriteRule ^devbrain(/.*)?$ tools/gamified-knowledge$1 [NC,L]  
RewriteRule ^tool/([^/]+)$ /tools/$1 [R=301,L]  
RewriteRule ^app/([^/]+)$ /tools/$1 [R=301,L]  
RewriteRule ^apps/([^/]+)$ /tools/$1 [R=301,L]
```


/devbrain will open up /tools/gamified-knowledge without changing url

tool/, app/, and apps/ do change url