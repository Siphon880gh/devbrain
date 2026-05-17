This document tracks which URLs need to be reconfigured after a URL change. These URLs are usually found in .env files, DevOps configuration files, deployment settings, reverse proxy vhost configs, API settings, or similar places. A URL change may involve updating only the path after the domain, or it may require changing the full domain as well, depending on how the configuration is written.

- Only if changed the url wengindustries.com/app/*brain/curriculum/server-update.php:
	- On local machine's Obsidian -> At Content-Published -> In each brain/notebooks -> package.json has URL that open to remote php file that will git pull and rebuild cached render

- Only if changed folder structure, url, or webhost. In regards to: https://reports.mixotype.com
	- vhost sets the root: /home/wengindustries/htdocs/wengindustries.com/partner/mixo;
	- If you changed webhost, we need to re-assigning A record at Numair's DNS Registrar ONOS to point to our domain

- Only if changed webhost. In regards to github.com and gitlab.com where you push/pull repos from remote servers as CI/CD processes, then you got to regenerate the SSH key pairs and reupload the contents of the public key to github.com / gitlab.com


