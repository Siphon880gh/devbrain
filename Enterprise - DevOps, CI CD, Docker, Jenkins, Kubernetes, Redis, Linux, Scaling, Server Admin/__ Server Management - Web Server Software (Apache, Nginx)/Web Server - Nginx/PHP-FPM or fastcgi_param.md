
Leraning Objectives:
- Know what is php-fpm found in vhost
- Know what is fastcgi_param found in vhost

Nginx itself **cannot directly override PHP** like in php.ini but it **can indirectly override**

Like for settings `post_max_size`, `memory_limit`, `max_execution_time`, or `upload_max_filesize` for PHP applications (like WP All-In-One Migration or your own custom code app that relies on php). 

Nginx interacts with PHP through a FastCGI process (e.g., PHP-FPM), and it can **pass directives to PHP-FPM** using `fastcgi_param`.