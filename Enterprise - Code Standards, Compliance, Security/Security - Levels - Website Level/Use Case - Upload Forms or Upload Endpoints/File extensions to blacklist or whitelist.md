It's better to whitelist only the acceptable file extensions (e.g., images, text files) rather than maintaining a long blacklist. Blacklisting requires accounting for many variations in extension names—like `php` vs `php5` vs `php6` — which adds complexity and risk.

In addition, make sure the whitelist or blacklist is case-insensitive, usually done through lowercasing.

- Whitelist  
```
    $allowedMimeTypes = [  
        'image/jpeg',  
        'image/png',  
        'image/gif',  
        'application/pdf',  
        'application/zip',  
        'text/plain'  
    ];
```

- Blacklist

	- Web server executables:
	```
	.php, .php5, .php7, .phtml
	.asp, .aspx, .jsp, .jspx, .cfm, .pl, .cgi
	```
	
	- Shell or command files:
	```
	.sh, .bash, .zsh, .csh, .ksh
	.bat, .cmd, .ps1
	```
	
	- Binary executables:
	```
	.exe, .dll, .so, .msi, .deb, .rpm, .bin, .out, .com
	```
	
	- Scripts & interpreted files:
	```
	.py, .pyc, .pyw, .rb, .rhtml
	.vbs, .wsf, .js, .ts, .jar, .class, .swift, .scala
	```
	
	- Configuration & server control files:
	```
	.env, .htaccess, .htpasswd, .yaml, .yml, .ini, .json
	```
	
	- Misc dangerous or uncommon types:
	```
	.scr, .reg, .chm, .vb, .cpl, .phar, .pif
	```
