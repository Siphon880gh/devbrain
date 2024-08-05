By: Weng

Learning objectives:

- Host column can be thought of as subdomain except when @
- @ is the root directory like test.com
- www should be CNAME though it can be A record. Some people still type www into their address bar so it should be covered
- Advantage of CNames is that you reduce the number of rows you have to change the IP address if the web host changes IP address or you change the webhost
- For the subdomain, if it’s another website on the same webhost, you can use CNAME. Remember it’s the vhost on the public ip that determines based on the server name (subdomain + domain + tld) which website and therefore which root document directory to deliver (furthermore the one nginx config file includes all other vhost configs)


For a basic pullup web app that has api calls and a frontend:

|   |   |   |   |
|---|---|---|---|
|Type|Host|Value|TTL|
|A|@|[IP address]|Automatic|
|CNAME|www|pullups.app|Automatic|
|CNAME|api|pullups.app|Automatic|

- For the subdomains, if it’s another website on a different webhost and therefore different public IP address, you’re forced to use A record

|   |   |   |   |
|---|---|---|---|
|Type|Host|Value|TTL|
|A|@|[IP address]|Automatic|
|CNAME|www|pullups.app|Automatic|
|A|api|[Other IP address]|Automatic|

- You should add a catch all * which runs after all subdomains have been ran. (FYI: The wildcard `CNAME` record for `*` ensures that any subdomain not specifically defined (e.g., `anything.pullups.app`) will point to `pullups.app`. It knows because the nameserver of the DNS hosting provider (in this case, Namecheap) handles the logic for wildcard entries. Your whatsmydns can show the NS for the domain so it’s out there).

|   |   |   |   |
|---|---|---|---|
|Type|Host|Value|TTL|
|A|@|[IP address]|Automatic|
|CNAME|www|pullups.app|Automatic|
|A|api|[Other IP address]|Automatic|
|CNAME|*|pullups.app|Automatic|
