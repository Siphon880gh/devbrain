This security checklist is for wordpress with web app under the same domain.

Security Optimizer by SiteGround
![[Pasted image 20250509025006.png]]

There’s a limit of 12 days of logs. It’ll just cut off and won’t say end of logs:
![[Pasted image 20250509025021.png]]

More examples of bots hacking most common files:
![[Pasted image 20250509025032.png]]

(That’s why you should have a separate VM or server for wordpress and web app - Keep the two on separate VM!)

Reversed looked up the IP address shows it’s malicious.
[https://securefeed.com/Content/WebLookup?host=88.214.48.88](https://securefeed.com/Content/WebLookup?host=88.214.48.88)  


AWS and cloudflare has a list of known IP addresses that are attacker services so you can sign up with them and feed through at the proxy level by using the ip address into the DNS zone editing.

![[Pasted image 20250509025118.png]]
^ https://securefeed.com/Content/WebLookup?host=88.214.48.88

Wordpress ASE (Admin and Site Enhancements)
By Bowo/wpase.com

Change the wp-login url to a custom url with numbers in it (dont use common words like entrance or login... and dont use common number combinations like 1234)

You can block IP address by going:
![[Pasted image 20250509025155.png]]

You can view blocked IP addresses here at another tab under Security Optimizer for Site Ground
![[Pasted image 20250509025210.png]]

Don't worry about accidentally blocking your own ip address as long as you’ve been logged in because you would look at Unknown tab
![[Pasted image 20250509025659.png]]

But under Registered, do check for IP addresses logging in as one of the Wordpress users:
![[Pasted image 20250509030119.png]]

^ that’s my ipaddress I login with when going into wordpress.  
^ it also shows the ip address that is for unknown user is my webhost colocationamerica as reversed looked up ip by [https://securefeed.com/Content/WebLookup?host=208.76.249.75.](https://securefeed.com/Content/WebLookup?host=208.76.249.75.) how/why would it access wordpress to Deleted Customize_changeset and Deleted Post - Auto Draft?

That’s okay.
  
WordPress often **automatically**:
- Delete `Customize_changeset` records (drafts of theme customizer changes).
- Delete `Auto Draft` posts (like blank drafts made when you create a new page or post and don't save it).

**Why is it showing as "Unknown User"?**  
Because:
- **System processes** (like wp-cron) or **server-level tasks** don't log in as a _named user_.

Also another way to see logins but also see attempts and lockouts is Admin and Site Enhancements:
![[Pasted image 20250509030518.png]]

---

xmlrpc.php  

**Hacking bots scan `xmlrpc.php` because it’s a common WordPress target for attacks.**  
That file (`xmlrpc.php`) enables **XML** **remote procedure calls** (RPC), meaning external applications can interact with your WordPress site — like posting articles from an app, pingbacks, trackbacks, etc.

You'll find this file at the root of your wordpress codebase: `xmlrpc.php`
![[Pasted image 20250509030605.png]]

It can be abused for DDoS attacks and brute forcing admin passwords (sending 100 logins at once rather than one at a time with wp-login:
![[Pasted image 20250509030620.png]]

**Common Mitigations:**
- Disable or block access to `xmlrpc.php` if you don't need it.
- Use `.htaccess` or firewall rules to deny it:
```
<Files xmlrpc.php>  
  Order Deny,Allow  
  Deny from all  
</Files>
```

- Or Wordfence. Or ASE (Admin and Site Enhancements):
  ![[Pasted image 20250509030702.png]]
Example other attempts:
![[Pasted image 20250509030722.png]]

But notice it’s 404 failed. So we're good. That's a common url that hacking bots challenge and we don't have such backup locations.

Wordpress get author names from posts which likely will be usernames that you can bruteforce login attempts at either wp-login or xmlrpc:

[https://domain.ai/wp-json/wp/v2/users/](https://videolistings.ai/wp-json/wp/v2/users/)  

Lists all users and authors (You can test visiting in incognito - you dont need to be logged in!!)

Old ASE Security panel:
![[Pasted image 20250509030809.png]]


Should be:
![[Pasted image 20250509030821.png]]

Otherwise it shows all the usernames that can be bruteforced:
https://domain.com/wp-json/wp/v2/users/

![[Pasted image 20250509030956.png]]

Do double check that AES disabled wp-json/wp/v2/users/ after those settings. 

Approach 1

Add to theme’s functions.php:
```
// Disable REST API user endpoint
add_filter('rest_endpoints', function( $endpoints ){
    if ( isset( $endpoints['/wp/v2/users'] ) ) {
        unset( $endpoints['/wp/v2/users'] );
    }
    if ( isset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] ) ) {
        unset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
    }
    return $endpoints;
});
```

Approach 2 - Apache

Add .htaccess:
```
<IfModule mod_rewrite.c>  
RewriteEngine On  
RewriteCond %{REQUEST_URI} ^/wp-json/wp/v2/users  
RewriteRule ^(.*)$ - [F,L]  
</IfModule>
```

Approach 2 - Nginx:

Edit vhost and add this to the server block:
```
location ~* ^/wp-json/wp/v2/users {  
    return 403;  
}
```

Why you may not want to disable all of the API rest endpoints: so that plugins like Elementor, WooCommerce, etc. may still work.