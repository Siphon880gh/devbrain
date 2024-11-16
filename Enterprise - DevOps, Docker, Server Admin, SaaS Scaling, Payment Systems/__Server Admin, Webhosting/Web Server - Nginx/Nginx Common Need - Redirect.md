
[https://wengindustries.com/tools/devbrain/](https://wengindustries.com/app/devbrain/) => [https://wengindustries.com/app/devbrain/](https://wengindustries.com/app/devbrain/)  

```
# Redirect tools/ to app/  
location ~ ^/tools/(.*) {  
	return 301 /app/$1;  
}
```