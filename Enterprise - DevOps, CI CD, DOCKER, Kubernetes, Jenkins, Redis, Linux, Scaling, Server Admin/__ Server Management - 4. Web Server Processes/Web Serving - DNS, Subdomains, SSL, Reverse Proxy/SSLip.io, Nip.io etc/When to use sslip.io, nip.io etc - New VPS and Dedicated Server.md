You usually use **sslip.io**, **nip.io**, or similar services when you are **first setting up a new web server** on a VPS or dedicated server, especially when installing a tool like **CloudPanel** that expects a proper hostname.

Sometimes a VPS plan does **not** come with a ready-made **default hostname** such as `shared1234.hostingerservers.com`. Instead, the provider may give you only a **public IP address**, which you can visit directly in a browser. In that situation, you would normally need to set up a hostname. That often means buying a domain from a registrar such as Namecheap and pointing that domain to your server. But maybe you do not have budget approval yet, or you simply do not want to wait, because the full process takes time: purchasing the domain, setting up the DNS zone, and waiting for DNS record propagation.

If your provider does give you a default hostname, then you can usually access your website on the internet without typing the raw IP address directly. Even so, that **default hostname** usually looks generic and is unlikely to match your brand, so you will probably still want to move to a proper domain later so the site looks more normal to users and can be indexed more appropriately by Google. In that case, using a service like sslip.io or nip.io would not really solve the branding problem either, because those hostnames also still look generic.

When setting up a hostname, there are several layers involved:
- **System configured**
- **Vhost configured and DNS resolved**
- **SSL for HTTPS**

Whether you need all of those layers depends on the tool you are installing and how far its hostname requirements go.

**System configured:**  
On the server side, you configure the server or hosting panel to list your chosen hostname as the official system hostname.

**Vhost configured and DNS resolved:**  
You also need public DNS so the internet knows that the hostname should resolve to your server’s IP address. Without that DNS step, people cannot reach the server by that hostname. Separately from that, you would configure the web server vhost or server block so incoming requests for that hostname are matched and handled correctly. A single webhost can have multiple hostnames or domains pointing to it and serve different websites depending on which hostname was requested. In a control panel such as CloudPanel, cPanel, or something similar, you may manage that Vhost through the UI.

**SSL for HTTPS:**  
Some tools may call back to your webhost during installation and expect HTTPS for secure transmission. In that case, you would need SSL set up so the connection can be made properly. That usually means having a certificate issued after proving that your server can respond correctly for that hostname. However, SSL itself is **not** required for tools like **Let’s Encrypt validation**, because Let’s Encrypt expects that you may not have HTTPS yet. That is why it usually checks over plain HTTP for the challenge file created during the approval process to prove control of the domain.

---
Example:
**To install CloudPanel, you are expected to have a hostname already set on the server before installation.** For CloudPanel specifically, configuring the system hostname is the important part. Vhost configuration or DNS resolution is not the main requirement for the installer itself.

You can set the system hostname on the server side with a command such as:

`hostnamectl set-hostname HOST_NAME`

That is technically enough for Cloudpanel to install successfully. But... you are likely installing cloudpanel, then later testing if the website can actually be reached on the web browser, and whether it can be reached at the https protocol. Let's make the host name also reachable for further tests on the Cloudpanel interface

A quick free workaround to making your website reachable on web browser is to use **sslip.io** or **nip.io**. You do **not need to sign up**, and you do not need to buy a domain first. These services automatically resolve a hostname to the IP address embedded in it, for example:

`123.123.123.123.sslip.io`

This is especially helpful during setup when you just purchased the VPS and do not have time to buy a domain and wait for DNS to propagate. If your real domain is not ready yet, sslip.io or nip.io can act as a temporary hostname so you can keep moving.

Some tools that call back to your webhost do require proper SSL so they can connect over HTTPS. You can also set up Let’s Encrypt with an sslip.io hostname with no problem, such as:

`123.123.123.123.sslip.io`
