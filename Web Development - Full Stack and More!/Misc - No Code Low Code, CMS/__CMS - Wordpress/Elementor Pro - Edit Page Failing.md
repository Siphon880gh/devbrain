## ERROR

When editing a page with Elementor, it is stuck on loading Elementor logo
![](https://i.imgur.com/JZ2wEBl.png)


OR it says Preview could not be loaded
![](https://i.imgur.com/EQkzlQM.png)

Console errors show:
```
web-cli.min.js?ver=3.12.1:3 SyntaxError: Unexpected token '<', "<!-- <meta"... is not valid JSON  
error	@	web-cli.min.js?ver=3.12.1:3  
  
post.php:1 Uncaught (in promise) SyntaxError: Unexpected token '<', "<!-- <meta"... is not valid JSON
```

---

## SOLUTION

SOLUTION 1 (Do All Solution Sets)


1. Check min requirements of php (7.4 as of 11/2024), wordpress, mysql etc. Nginx and apache are both supported
	- Ready 1/1 - Elementor requirements here [https://elementor.com/help/requirements/](https://elementor.com/help/requirements/)
	- Ready 2/2 - Get php version, wp version: To get php version, one way is Site Health (Sidebar “Tools” → Site Health → Top tab “Info”):
	- Get wp version → Under Site Health top tab “Info” → Expand “Wordpress” drawer → Look for row “Version”
	- Get mysql version → Under Site Health top tab “Info” → Expand “Databases” drawer 
	- Get php version → Under Site Health top tab “Info” → Expand “Server” drawer  → Look for row “PHP version”


2. SOLUTION 2 (Do All Solution Sets)  
- Set memory limit in wp-config
- Set the fetch requests from client to php:
	- Nginx: set body client max
	- Apache: LimitRequestBody
- Set max line length that can be processed during text substitution
	- Nginx: proxy_buffer_size (substitution happens within buffer constraints in Nginx)  
	- Apache: SubstituteMaxLineLength  
- Nginx/Apache?
	- Both supported
	- Yes wordpress still generates htaccess file even though you are in Nginx - ignore that

3. SOLUTION 3 (Do All Solution Sets)
	- Wordpress address and site address both must match at settings → general
		- For example if your website is domain.tld/wordpress1, then that’s the url for both. SKIP the trailing slash `/` 
	1. Plain permalinks
		1. Settings -> Permalinks → Have permalink structure set to “Plain”




---

## Further Troubleshooting 

- Incognito checks if it’s a chrome extension (they rewrite your html so that can cause conflict)


- Safe mode checks if it’s a theme conflict.  Elementor > Tools → Select Enable for Safe Mode  
  ^ More info: [https://elementor.com/help/what-is-safe-mode/](https://elementor.com/help/what-is-safe-mode/)
  
- Editor Loader Method:   
  Elementor -> Settings -> top tab "Advanced " -> Switch Editor Loader Method: Disabled/Enabled
  ^ More info: [https://elementor.com/help/server-configuration-conflicts/](https://elementor.com/help/server-configuration-conflicts/)  
  ^ More info: quoted from page “Enabling Switch Editor Loader Method helps users running sites on servers with low resources which have difficulty reading long JSON code.  When enabled, the tool splits the lines of code so that these servers can read the JSON code without issues.”
  
- Force Wordpress to regenerate htaccess (only maters if using apache server):  
	- Settings > Permalinks  → Without changing anything, scroll to the bottom and click Save Changes 
	- WordPress will try to generate a new .htaccess file 
	- If it's successful, you'll find the new file in the WordPress root folder 

  - Look into your apache or nginx error logs (which includes php errors)

- Look into wp errors. If not configured to log wp errors, go into wp config (file found at wordpress site's root folder):
	```
	define( 'WP_DEBUG', true );  
	define( 'WP_DEBUG_LOG', true );
	```
	- There will be a `debug.log` file generated in your `wp-content` folder.

---

## Official Help Docs

- Elementor Requirements: https://elementor.com/help/requirements/
- Elementor on 404 errors: https://elementor.com/help/how-to-fix-404-page-or-page-not-found-error-messages/
- Elementor on 502 errors: https://elementor.com/help/502-error-when-i-try-to-edit-with-elementor/