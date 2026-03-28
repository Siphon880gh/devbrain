
**Does not apply to ports: 80, 443**

Do not add the ports to vhost. That's a beginner mistake. vhost is suppose to be for port 80 and 443 where webpages and assets are delivered to a web browser.

Adding to vhost will cause some conflict that makes your port unable to open for the intended purposes (eg. running gunicorn on port 5001 will say it's in use)

---

**Reworded:**

Do not modify vhosts for the port to work, otherwise it will look for a webpage at document root rather than listen to a Python server; in fact running gunicorn or flask will say port or address in use (for delivering webpages)