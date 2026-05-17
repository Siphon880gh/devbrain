
Keep these limits in mind to prevent webhook errors (at n8n receiving webhook) or payload too large errors (at HTTP Request node or tool with method set to "POST" and enabled "Send Body" option)
- Heroku inbound 30 secs / 10mb
- Nodejs default is very low 100kb but you can adjust it
- If Cloudflare beware: Free is 120seconds / 100mb
- If nginx you can adjust but configuration may be at multiple places

For a more comprehensive list of connection limits, refer to [[Reference - Payload limits on n8n, heroku, nodejs, etc]]

---

Payload's Send Body option, and the fields that followed it refers to values:
![[Pasted image 20260517063258.png]]

Scrolling up shows the method is "POST":
![[Pasted image 20260517063900.png]]