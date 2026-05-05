It's best you dont have nginx already installed. Installing Cloudpanel will install nginx with it
One of the requirements of Cloudpanel is you need to have a hostname already configured at the system level (for example a default hostname like `shared1234.hostingerservers.com` or a traditional domain like domain.com). So when you install a control panel like Cloudpanel, it can see that hostname setting and orientate responding/matching to that hostname and also configure nginx' vhost to that match to that hostname for incoming internet connections.

Cloudpanel absolutely requires that you have a hostname configured at the system level for it to install successfully.

## Do we have a hostname?

Sometimes a VPS plan does **not** come with a ready-made hostname such as `shared1234.hostingerservers.com`. Instead, the provider only gives you a **public IP address** that you can visit directly in the browser. (eg. Hetzner Cloud VPS). 

If you don't have a hostname, there are extra steps you must take to acquire a hostname so that Cloudpanel installation can work.

Ask yourself if there's a hostname (does the control panel immediately after logging in shows only IP or does it show a hostname too):

- No we don't have a hostname
	- In that situation, you normally need to set up a hostname. It's enough to configure at the system level what your hostname should be. It's usually the domain name you have planned for the website.
	- Technically the hostname isn't required to work on the web browser for cloudpanel to install. You just have to make sure an alphanumeric hostname is configured at the system level. But... you are likely installing cloudpanel, then later testing if the website can actually be reached on the web browser, and whether it can be reached at the https protocol.
	- That often means buying a domain from a DNS registrar such as Namecheap and then pointing that domain to your server. OR it can be a free non-branded domain through sslip.io. Either way, you can re-adjust the nginx' vhost that the cloudpanel generates for intercepting and responding to incoming connections based on hostname matching, so doesn't matter which approach.
	- Go to the next section "If dont have a hostname" for a more detailed step by step guide

- Yes we have a hostname
	- No extra steps necessary. Skip the next section "If dont have a hostname"


---

## If dont have a hostname

We will prepare to install cloudpanel and nginx.

Cloudpanel will bundle in nginx web server

Setup system to self-identify as a specific hostname
```
hostnamectl set-hostname 5.55.555.555.sslip.io
```

That is technically enough for Cloudpanel to install successfully. But... you are likely installing cloudpanel, then later testing if the website can actually be reached on the web browser, and whether it can be reached at the https protocol.

If you do not want to buy a domain right away or wait for DNS records to propagate, you can use **sslip.io** or **nip.io** as a temporary workaround. You do not need to sign up or purchase a domain. These services automatically resolve a wildcard hostname to the IP address embedded in it. For example, `123.123.123.123.sslip.io` can be used like a normal hostname in a web browser, and the service will automatically point it to `123.123.123.123` without requiring you to create DNS records through a domain registrar. It also will make the internet connection to your webhost and your webhost will be expecting that hostname `123.123.123.123.sslip.io` after you've configured the hostname at the server-side using a simple command, and then Cloudpanel setup will take it from there.

---


## If have a hostname or finish setting up not having a hostname

If already have a default hostname, you don't need the previous section's steps on setting up with sslip.io (unless you patiently go with DNS registrar like namecheap) and hostnamectl. The VPS already had configured hostnamectl for you since you log in through your webhost and their control panel shows you a default hostname. When you install Cloudpanel, it will already configure vhost to match for that hostname as the domain when receiving incoming connections. 

If it's a default hostname that your webhost provider gave you, you don't need to setup with namecheap or sslip.io for it to be reachable on a web browser because the webhost's default hostname is usually visitiable. But for a branded custom hostname aka domain, you would need namecheap.

Regardless which path you took, this should be the converging point - we now install CloudPanel knowing that hostname must exist at this point at the system level.

Install CloudPanel:
```
curl -sSL https://installer.cloudpanel.io/ce/v2/install.sh | bash
```


Then check nginx bundled with cloudpanel is installed:
```
nginx -version
```

CloudPanel would have installed nginx for you and also configured your nginx's vhost (which you can access ats the cloudpanel GUI - more later). It'd have. configured the nginx vhost to accept incoming connections and match if those incoming connections are asking for a specific hostname to respond (in this case 5.55.555.555.sslip.io)

Access CloudPanel GUI:
https://panel.5.55.555.555.sslip.io:8443

^ Cloudpanel already setup that hostname matching for you because it referred to the settings at `hostnamectl`

OR:
https://5.55.555.555:8443

If fail, check if ufw enabled and scopes limited:
```
ufw status
ufw disable
```

If fail, did you get this message?
![[Pasted image 20260411010948.png]]

Then solution is: CloudPanel’s admin interface on port 8443 is meant to be opened as at https://..., not http://.. YES it's dumb because you don't have SSL setup at this point

If Chrome blocking you because of the lack of SSL certificate, hit Advanced -> Proceed. If they're even stricter than that, free type without spaces "thisisunsafe" to bypass and proceed the lack of SSL certificate

Now visiting https version:
![[Pasted image 20260411011448.png]]


![[Pasted image 20260411012009.png]]

Add a new website. Then best bang for the buck is PHP site (because it does PHP already, and it can handle Wordpress, and you can SSH install NodeJS and Python later, and reverse proxy is easily done through vhost anyways):
![[Pasted image 20260411012715.png]]

On the php questions, you can choose Generic for Application instead of one of the CMS. This will allow maximum flexibility. Make sure to enter your domain name, preferred site user, and preferred site user password

---

## Further setup

Vhost adjustments to sslip.io and other vhost enhancements, and testing instructions (to see that a webpage is actually delivered over the internet) are listed in other guides like [[_ GET STARTED - Setup VPS Checklist - Eg. Hetzner]].

We diverge from this tutorial because this focuses on getting you that far from the SSH terminal. The rest of the configuration is done through the web browser.