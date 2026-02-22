**Requirements**: 
You know how to renew your SSL through Let's Encrypt at Cloud Panel already which requires commenting away certain vhost to allow the challenge file at the http url to be reached - [[CloudPanel - SSL Renew Annually]]

Here you'll learn a semi automated way to renew your certificate.

---

**Problem**:
You're renewing the SSL/TLS certificate for HTTPS in CloudPanel. You may see an old certificate that's expired or no longer relevant—especially if you're adding new domains or subdomains to the web host for public access, which requires HTTPS. Or that 3 months is up/coming up.

![[Pasted image 20250524042303.png]]

But when you create a new SSL... unfortunately it wont remember your old domains. You have to manually type them in:
![[Pasted image 20250524042321.png]]

You wish you have a list of domains and subdomains that can just enter automatically into these fields for you (And click "Add Domain" as needed). You're in lucky. That's what this doc is for.

---

**Firstly**

WAIT - before you click "Create and Install". You still have to double check the gotchas at [[CloudPanel - SSL Renew Annually]]. Or in other words:

Make sure to comment off or toggle comment per your comments at vhost and included vhosts. This makes sure challenge file is accessible. You should do something like comment `# SSL RENEWAL` with instructions to comment off/on or toggle between two lines as comment vs active. Then you can search for that comment and follow instructions when turning off for SSL challenge or turning back on when done with SSL challenge and the SSL is setup successfully.

Example:
```
  # SSL RENEWAL? (Temporarily switch in default root using "#" because ACME challenge file is created at default root and verification tries to GET file)
  root /home/wengindustries/htdocs/wengindustries.com/;
  # root /home/wengindustries/htdocs/wengindustries.com/app/run-app;

  # SSL RENEWAL? (Temporarily disable lines with "#" because ACME validation can only reach http)
  # if ($scheme != "https") {
  #  rewrite ^ https://$host$uri permanent;
  # }
```

----

**DevTools script:**

Have a list of the domains/subdomains in the wildcard code. Paste the entire code snippet into Google Chrome DevTools console. It'll automatically create the the needed number of textfields (by programmatically clicking the "Add Domain" button) and it'll fill them in with your domain/subdomains

```
var wildcards = [  
    "wengindustry.com",   
    "www.wengindustry.com",  
    "wengindustries.com",   
    "www.wengindustries.com",   
    "n8n.wengindustries.com",   
    "n8n.wengindustry.com",   
    "automation.wengindustries.com",  
    "automation.wengindustry.com",   
    "3dnotes.wengindustry.com",   
    "3dnotes.wengindustries.com",   
    "biznotes.wengindustry.com",   
    "biznotes.wengindustries.com",   
    "codernotes.wengindustry.com",   
    "codernotes.wengindustries.com",   
    "healthnotes.wengindustry.com",   
    "healthnotes.wengindustries.com",   
    "ctrl-tw-pm.wengindustry.com",   
    "ctrl-tw-pm.wengindustries.com",
    "therunner.app",   
    "www.therunner.app",  
    "nursing.icu",   
    "www.nursing.icu",  
    "nae.wengindustry.com",   
    "nae.wengindustries.com",  
    "nae.xny.agency",
    "reports.mixotype.com"
]  
  
// Create text fields  
var prefilledAlready = document.querySelectorAll(".domain-input").length;  
for(var i=0; i<wildcards.length-prefilledAlready+1; i++) {  
    document.querySelector("#add-domain-name").click();  
}  
  
// Fill text fields  
document.querySelectorAll(".domain-input input").forEach((el,i)=>{  
 if(i<wildcards.length) {  
   el.value = wildcards[i];  
 }  
});
```

Run it here:
![[Pasted image 20260208222604.png]]

The textfields will be created and filled in with your desired subdomains and domains. Save this snippet somewhere save for you to renew whenever the Let's Encrypt expires.

