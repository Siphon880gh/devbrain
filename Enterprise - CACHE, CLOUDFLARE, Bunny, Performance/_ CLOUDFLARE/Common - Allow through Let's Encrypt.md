## Scenario: Cloudflare Is Blocking Let’s Encrypt Renewal on Your Server

Your website is behind Cloudflare, but you still want your server, such as CloudPanel, to renew a **Let’s Encrypt certificate** directly.

This is usually only necessary when your origin server needs a normal browser-trusted certificate, especially if:

- you have multiple domains pointing to the same web root or subfolders, and at least one of those domains may not always stay behind Cloudflare.
- you prefer Full (Strict) so your origin server must have valid SSL as well

CloudPanel’s Let’s Encrypt renewal may fail with an error like this:
```
www.domain.com: Domain could not be validated, error message: error type: urn:ietf:params:acme:error:unauthorized, error detail: During secondary validation: 2606:4700:3030::ac43:8de0: Invalid response from http://www.domain.com/.well-known/acme-challenge/xxx: 403
```

This means Let’s Encrypt tried to verify your domain by visiting:

```
http://www.domain.com/.well-known/acme-challenge/xxx
```

But Cloudflare returned a **403 Forbidden** response instead of allowing the request through.

---

You have to temporarily skip Cloudflare protection while going through Let's Encrypt:

![[Pasted image 20260519055912.png]]


1. Add a WAF rule for URL containing wildcard: `/api/*`
2. Choose Skip for action.
3. Select all components to skip
4. Move this rule **above** any stricter WAF rules, especially rules that block or challenge traffic by **country**.
   
   For example, if you have a rule that only allows US traffic, the Let’s Encrypt validation may fail because Let’s Encrypt can check your domain from multiple network locations.

5. Run the Let’s Encrypt renewal again in CloudPanel.
6. After the certificate is issued successfully, disable or remove the temporary skip rule.

---

## Why You Should Disable the Rule Afterward

You should not leave this bypass rule enabled longer than necessary.

Bots and scanners sometimes check paths like:

```
/.well-known/acme-challenge/
```

They are usually not trying to steal the ACME token itself. Instead, they are looking for paths that might bypass normal authentication, WAF rules, bot protection, or security filters.

Unfortunately, you also cannot simply allow only your VPS IP address, because Let’s Encrypt validation requests can come from multiple external network locations.

So the safest approach is:

```
Temporarily allow the ACME challenge pathRenew the certificateThen disable the bypass rule
```