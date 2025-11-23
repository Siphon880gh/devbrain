Goal: Deploy PHP 8.2 website to Heroku

Lets say you have php files and the main entry is `index.php`

1) Add the minimal PHP files Heroku expects
   
   In your repo root:
   **composer.json** — tells Heroku which PHP line to use (don’t pin an exact patch):
```
{  
  "require": {  
    "php": "^8.2"  
  }  
}

```

Heroku reads this to select a PHP 8 runtime. Use `^8.2` (or `^8.3`) so you get security updates without jumping to PHP 9. ([devcenter.heroku.com](https://devcenter.heroku.com/articles/specifying-a-php-runtime?utm_source=chatgpt.com "Specifying a PHP Runtime"))

2. Heroku also expects a composer.lock file:

	- a. Generate a composer lock file (no packages will be installed yet):
	```
	composer config platform.php 8.2.0
	```
	
	- b. Create composer.lock without installing vendors  
	```
	composer update --no-install
	```
	
	- c. gitignore:
		- Make sure you do not gitignore the composer lock file
		- Keep vendors out of Git:
		```
		printf "vendor/\n" >> .gitignore
		```

3.   **Procfile** — explicit:
```
web: heroku-php-apache2
```

This starts Apache + PHP-FPM serving your repo root. 


Note: If your `index.php` lives in a subfolder (e.g., `public/`), use:
```
web: heroku-php-apache2 public/
```

(You can swap Apache for Nginx with `heroku-php-nginx` if you prefer.) ([devcenter.heroku.com](https://devcenter.heroku.com/articles/managing-php-web-servers?utm_source=chatgpt.com "Managing PHP Web Servers")

4. Push to Heroku. Should work as expected opening `index.php` and it can include/require other php files as coded.

  

## Troublehooting

  

### A) Heroku didn’t detect PHP

- Make sure `composer.json` is **in the repo root** (not a subfolder).
    
- If you had multiple buildpacks before (e.g., Node), reset to PHP:
    
    heroku buildpacks:clear  
    heroku buildpacks:set heroku/php  
    git push heroku HEAD:main
    
    (Heroku’s PHP buildpack handles PHP runtimes and Apache/Nginx.) [Heroku Ele](https://elements.heroku.com/buildpacks/heroku/heroku-buildpack-php?utm_source=chatgpt.com)
    

  

### B) Other errors

##### Verify logs (handy for 404/500s)

heroku logs --tail

##   

  

## (Optional) Useful tweaks

- **PHP settings:** put a `.user.ini` next to your document root to override things like memory limit:
    
    memory_limit = 128M
    
    ([devcenter.heroku.com](https://devcenter.heroku.com/articles/custom-php-settings?utm_source=chatgpt.com "Customizing Web Server and Runtime Settings for PHP"))
    
- **Extensions:** declare optional PHP extensions in `composer.json` if you need them (e.g., `ext-gd`, `ext-intl`). ([devcenter.heroku.com](https://devcenter.heroku.com/articles/managing-php-extensions?utm_source=chatgpt.com "Managing PHP Extensions"))
    
- **Nginx instead of Apache:**  
    `Procfile` → `web: heroku-php-nginx` (and optionally pass a subfolder). ([devcenter.heroku.com](https://devcenter.heroku.com/articles/managing-php-web-servers?utm_source=chatgpt.com "Managing PHP Web Servers"))
    

###