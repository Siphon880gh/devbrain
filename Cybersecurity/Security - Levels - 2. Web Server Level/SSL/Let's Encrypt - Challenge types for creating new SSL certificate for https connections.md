
## Let’s Encrypt ACME Challenge Types

When you request a certificate from Let’s Encrypt, their servers need to confirm that you control the domain name on the certificate. This is done through an **ACME challenge**.

Most of the time, your ACME client handles this automatically. If you are using a normal web server setup, the default challenge type is usually fine. When in doubt, **HTTP-01** is usually the simplest option. ([letsencrypt.org](https://letsencrypt.org/docs/challenge-types/ "Challenge Types -  Let's Encrypt"))

## HTTP-01 Challenge

The **HTTP-01 challenge** is the most common challenge type.

Let’s Encrypt gives your ACME client a token. Your ACME client then places a file on your web server at:

```txt
http://YOUR_DOMAIN/.well-known/acme-challenge/TOKEN
```

Let’s Encrypt tries to retrieve that file over HTTP. If the response matches what Let’s Encrypt expects, the domain is validated and the certificate can be issued.

HTTP-01 only works on **port 80**. It can follow redirects, but only to HTTP or HTTPS on ports **80** or **443**. ([letsencrypt.org](https://letsencrypt.org/docs/challenge-types/ "Challenge Types -  Let's Encrypt"))

### Pros

- Easy to automate.
    
- Works with normal web servers.
    
- Good default choice for most websites.
    
- Allows hosting providers to issue certificates for domains pointed to them.
    
- Can be used to validate IP addresses.
    

### Cons

- Requires port **80** to be reachable.
    
- Cannot issue wildcard certificates.
    
- If you have multiple web servers, the challenge file must be available on all of them.
    

## DNS-01 Challenge

The **DNS-01 challenge** proves domain control through DNS.

Instead of placing a file on your web server, your ACME client creates a TXT record at:

```txt
_acme-challenge.YOUR_DOMAIN
```

Let’s Encrypt checks DNS for that TXT record. If the value matches, the domain is validated.

DNS-01 is more complex than HTTP-01, but it works in situations where HTTP-01 does not. It is also the challenge type used for **wildcard certificates**. ([letsencrypt.org](https://letsencrypt.org/docs/challenge-types/ "Challenge Types -  Let's Encrypt"))

### Pros

- Supports wildcard certificates, such as `*.example.com`.
    
- Works well with multiple web servers.
    
- Can validate domains even when the web server is not publicly exposed.
    

### Cons

- Requires DNS updates.
    
- Best automation requires a DNS provider with API support.
    
- Storing full DNS API credentials on a web server can be risky.
    
- DNS propagation delays can cause validation delays.
    
- Cannot be used to validate IP addresses.
    

### Security Note

If you automate DNS-01, avoid putting full DNS API credentials directly on your web server when possible. A safer setup is to use narrowly scoped API credentials, or run DNS validation from a separate system and copy the certificates to the web server afterward. ([letsencrypt.org](https://letsencrypt.org/docs/challenge-types/ "Challenge Types -  Let's Encrypt"))

## TLS-ALPN-01 Challenge

The **TLS-ALPN-01 challenge** validates domain control over TLS on **port 443**.

It uses a special ALPN protocol during the TLS handshake. This lets Let’s Encrypt confirm that the server answering for the domain is intentionally configured to handle this challenge.

This challenge is not the best choice for most regular website owners. It is mainly useful for TLS-terminating reverse proxies, infrastructure providers, and systems that want validation to happen entirely at the TLS layer. ([letsencrypt.org](https://letsencrypt.org/docs/challenge-types/ "Challenge Types -  Let's Encrypt"))

### Pros

- Works when port **80** is unavailable.
    
- Runs entirely at the TLS layer.
    
- Can be used to validate IP addresses.
    

### Cons

- ACME client support is more limited.
    
- If you have multiple servers, they must all be configured to answer correctly.
    
- Cannot issue wildcard certificates.
    

## Removed: TLS-SNI-01

Do **not** use TLS-SNI-01.

It was an older ACME challenge method that used TLS and SNI on port 443. Let’s Encrypt removed it in March 2019 because it was not secure enough. It should only be mentioned as historical context, not as a current option. ([letsencrypt.org](https://letsencrypt.org/docs/challenge-types/ "Challenge Types -  Let's Encrypt"))

---

Read reworded here including ACME challenge methods that are no longer used:
https://letsencrypt.org/docs/challenge-types