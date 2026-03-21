Need boilerplate to change http to https or 80 to 443? Refer to Nginx - Redirect http to https or 80 to 443

If had been changing your vhost to have http to https but the changes don’t seem to be going through, browser-level caching may be to be blamed. Make sure:
If testing on incognito: Close out all previous incognito then open incognito again
If testing on regular Chrome: Clear cache
