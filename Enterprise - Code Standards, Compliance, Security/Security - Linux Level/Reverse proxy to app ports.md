If you have ports like 300X and 500X for NodeJS Express servers or Python Flask servers, you don't want users to even know the underlying technology or port. So instead of accessing your app at: `domain.tld:3000`

They access the app at `domain.tld/app/app1`

In addition to hiding away your tech and its possible vulnerabilities, you are hiding a port from being accessed.

You can close the port to internet access (firewall: ufw over iptables, or iptables), and your vhost can reverse proxy internally into that port. When vhost receives the internet requests, it already hits its private network, so it has access to the port even if it's not been allowed to the internet by the firewall. In addition, because your nodejs or python app was likely developed from a local environment first, where it loads automatically to localhost:300X or localhost:500X, for example, then your API endpoints may not match for domain.tld/app/app1, so your vhost needs to internally rewrite the url to strip away the base url back to /, then your api endpoints at your backend server can match again.

Other benefits of reverse proxying a friendly url to app port is:
- Easier for user to memorize the url
- Google will rank your webpage
- It can go through https so the webpage gets SSL signed along with the rest of your domain. Your app won't get the scary "not a secured website" warning in the web browser.

Again the security benefits are:
- Hide underlying technology and possible exploits hackers can try
- Close off another port hackers can try to access