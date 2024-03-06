1. Declaring Host Permissions:
	- In your manifest.json, you can specify host permissions using the host_permissions field.
	- The host_permissions field is an array of match patterns (e.g., "https://.example.com/") that specify which hosts the extension wants access to.
	- This is different from Manifest V2, where host permissions were declared in the permissions field along with API permissions.
Example:
```
json
Copy code
"host_permissions": [
  "https://*.example.com/*",
  "https://api.some-other-site.com/"
],

```
2. Limited Access by Default:
	- Extensions no longer get automatic access to all sites. Instead, they must declare which hosts they need access to.
	- This reduces the potential for privacy violations because extensions can't access data from sites the user visits unless those sites are included in the host_permissions