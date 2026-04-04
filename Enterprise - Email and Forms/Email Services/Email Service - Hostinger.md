## Hostinger Email


Estimated money to put in is $4.68 for a whole year of basic email on Hostinger as of 5/2025.

You can sign up at https://www.hostinger.com/business-email

## Setup Hostinger Email

You can come back to the Email for further setup at

![[Pasted image 20250723073741.png]]

Or at 
![[Pasted image 20250723073801.png]]

Continuing setup...
![[Pasted image 20250723073853.png]]

Let's say you own a domain that you're managing at Hostinger (either you've delegated access to Hostinger or you purchased the domain at Hostinger):
![[Pasted image 20250723073925.png]]

Then follow the next screens on setting up verification that you own that domain, before Hostinger can create an email inbox for that domain:
![[Pasted image 20250723073956.png]]

![[Pasted image 20250723074003.png]]

If you're managing the domain address somewhere else (eg. Namecheap), you can choose from the dropdown and it'll generate the values you need:
![[Pasted image 20250723074051.png]]

Setup MX (mail server) and verify per instructions

Then setup SPD and DKIM and verify per instructions

Setup also Dmarc which does not need instructions from Hostinger. Create TXT record following this universal DMARC format :  

Name:` _dmarc`
TTL: `300`
TXT Value:
```
v=DMARC1; p=quarantine; rua=mailto:you@yourdomain.com; ruf=mailto:you@yourdomain.com; aspf=r; adkim=r;  
```

Eg. Filled in as weng@wengindustries.com
```
v=DMARC1; p=quarantine; rua=mailto:weng@wengindustries.com; ruf=mailto:weng@wengindustries.com; aspf=r; adkim=r;
```


^ RUF (reporting uri for failures) tag is optional. If specified, it sends failure reports to your email address in real-time.

^ RUA (reporting uri for aggregations)  tag is optional. If specified, it sends aggregate reports daily.


CAVEAT: If you type the wrong email address (like not the same domain), Hostinger will quietly reset the record to "v=DMARC1; p=none" which will fail your verification later at MX Toolbox when it concerns having set a DMARC policy.

CAVEAT:
Subdomains? If you’re checking a subdomain, it may not inherit the policy unless explicitly set or you use `sp=quarantine`

Or you can keep a lean DMARC with:
```
v=DMARC1; p=quarantine; aspf=r; adkim=r;
```

You must have setup all these domain settings including DMARC (which is just policies/instructions on what to do if an incoming email or sender is not trusted). When sending out emails, the recipient's Gmail, Microsoft, Yahoo etc email servers look for these as trust signals that your email can be trustworthy just from following established rules and you diligently setting up DMARC policies. This is in contrast to spammers who quickly setup email addresses that get marked as flag.

Final setup page:
![[Pasted image 20250723074551.png]]

---

## Future reconfigurations

In the future you can go back to edit at:
![[Pasted image 20250723074627.png]]

These tabs correspond to MX, SPF, DKIM, DMARC
![[Pasted image 20250723074649.png]]

---

## Troubleshooting

Setup failing at the MX, SPF, DKIM, DMARC stages?

Hostinger lets you verify at their Connect Domain under Emails:

- See Current records vs Expected records. Make sure they match. And check at all the tabs (not just "Receive Emails" tab):
  ![[Pasted image 20250723074818.png]]
- In addition, you can verify at [https://mxtoolbox.com/SuperTool.aspx](https://mxtoolbox.com/SuperTool.aspx) but be warned it's not as obvious as typing the domain then pressing "DKIM Lookup", however the MX, SPF, and Dmarc is that simple.

---

## Access Web mail

![[Pasted image 20250723074906.png]]

That opens this page (Feel to bookmark):

[https://mail.hostinger.com/](https://mail.hostinger.com/)  

  

Test emailing one of your personal emails. Reply back on the personal email. Confirm the email service actually works (If fails, check your MX settings / reach out to customer support).