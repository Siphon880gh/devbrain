
You can add url query at the end of script src and link href like this:
```
<script src="asset/index.js?random=7823"/>
```

That busts the cache on the user, assuming the html document wasn't loaded from cache! If that's the case, you have to send no-cache and expired headers from the PHP or Nginx/Apache side.