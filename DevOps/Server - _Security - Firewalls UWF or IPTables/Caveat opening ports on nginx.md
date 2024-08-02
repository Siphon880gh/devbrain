
Do not add the ports to vhost. That's a beginner mistake. vhost is suppose to be for port 80 and 443 where webpages and assets are delivered to a web browser.

Adding to vhost will cause some conflict that makes your port unable to open for the intended purposes (eg. running gunicorn on port 5001 will say it's in use)