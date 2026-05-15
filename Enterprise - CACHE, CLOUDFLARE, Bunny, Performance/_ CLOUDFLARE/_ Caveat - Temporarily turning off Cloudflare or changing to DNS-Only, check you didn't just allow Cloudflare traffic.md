
After temporarily turning off Cloudflare proxying or switching a DNS record to **DNS Only**, make sure your server is not configured to **only allow Cloudflare traffic**.

If that setting is still enabled, your website may stop working once the Cloudflare proxy is disabled.

For example, in **CloudPanel**, there is a setting under the **Security** tab that can restrict traffic to Cloudflare IPs only. This works when Cloudflare is proxying your site, because visitors reach your server through Cloudflare.

However, when you switch the record to **DNS Only**, Cloudflare is no longer acting as the proxy. Your browser connects directly to the server from your own public IP address. Since your IP is not a Cloudflare IP, the server blocks the request.

This commonly results in a:

```
403 Forbidden
```


![[Pasted image 20260514235856.png]]


---

For Nginx:
You can check the Cloudpanel settings or you can run the command to check if there are settings that only allow through Cloudflare settings:

```
sudo nginx -T | grep -Ei "allow|deny|return 403|geo|cloudflare"
```

If you have Cloudpanel, just edit the Cloudpanel settings and it'll adjust the nginx.conf file accordingly for you.

An example output that shows there is configuration that only allows Cloudflare traffic:
```
nginx: the configuration file /etc/nginx/nginx.conf syntax is ok
nginx: configuration file /etc/nginx/nginx.conf test is successful
19:    geoip_country /etc/nginx/geoip/GeoIP.dat; # the country IP database
20:    geoip_city    /etc/nginx/geoip/GeoLiteCity.dat; # the city IP database
38:    log_format cloudflare '$http_cf_connecting_ip - $remote_user [$time_local] '
137:# configuration file /etc/nginx/modules-enabled/50-mod-http-geoip.conf:
138:load_module modules/ngx_http_geoip_module.so;
300:            allow all;
301:            auth_basic off;
348:            include /etc/nginx/cloudflare/ips;
351:            access_log /home/wengindustries/logs/nginx/access.log cloudflare;
510:# configuration file /etc/nginx/cloudflare/ips:
511:allow 173.245.48.0/20;
512:allow 103.21.244.0/22;
513:allow 103.22.200.0/22;
514:allow 103.31.4.0/22;
515:allow 141.101.64.0/18;
516:allow 108.162.192.0/18;
517:allow 190.93.240.0/20;
518:allow 188.114.96.0/20;
519:allow 197.234.240.0/22;
520:allow 198.41.128.0/17;
521:allow 162.158.0.0/15;
522:allow 104.16.0.0/13;
523:allow 104.24.0.0/14;
524:allow 172.64.0.0/13;
525:allow 131.0.72.0/22;
526:allow 2400:cb00::/32;
527:allow 2606:4700::/32;
528:allow 2803:f800::/32;
529:allow 2405:b500::/32;
530:allow 2405:8100::/32;
531:allow 2a06:98c0::/29;
532:allow 2c0f:f248::/32;
533:deny all;
575:### SET GEOIP Variables ###
576:fastcgi_param GEOIP_COUNTRY_CODE $geoip_country_code;
```