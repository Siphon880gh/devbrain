**Where we are**: Docker containers spin up to the next available port number and spin down automatically -> So I added Kubernetes -> But now I need Ingress to have domain and subdomains -> But those domains must be over https, so I need cert-manager

Here’s how to **add TLS with cert-manager** and optionally **redirect HTTP to HTTPS** in your Ingress configuration.

---

### 🔐 Add TLS with cert-manager

To use HTTPS, you'll need:

- A valid domain (e.g., `myapp.example.com`)
    
- DNS pointing to your cluster (via LoadBalancer or Ingress IP)
    
- cert-manager installed in your cluster
    
- A CertificateIssuer (e.g., Let's Encrypt)
    

---

### 🧾 Step 1: Define a CertificateIssuer (Let's Encrypt example)

```yaml
apiVersion: cert-manager.io/v1
kind: ClusterIssuer
metadata:
  name: letsencrypt-prod
spec:
  acme:
    server: https://acme-v02.api.letsencrypt.org/directory
    email: your-email@example.com
    privateKeySecretRef:
      name: letsencrypt-prod
    solvers:
      - http01:
          ingress:
            class: nginx
```

---

### 📄 Step 2: Update the Ingress with TLS

```yaml
apiVersion: networking.k8s.io/v1
kind: Ingress
metadata:
  name: example-ingress
  annotations:
    cert-manager.io/cluster-issuer: "letsencrypt-prod"
    nginx.ingress.kubernetes.io/ssl-redirect: "true"
spec:
  tls:
    - hosts:
        - www.example.com
        - api.example.com
      secretName: example-tls
  rules:
    - host: www.example.com
      http:
        paths:
          - path: /
            pathType: Prefix
            backend:
              service:
                name: my-service
                port:
                  number: 8080
    - host: api.example.com
      http:
        paths:
          - path: /
            pathType: Prefix
            backend:
              service:
                name: api-service
                port:
                  number: 80
```

- `cert-manager.io/cluster-issuer`: Tells cert-manager which issuer to use.
    
- `example-tls`: The name of the TLS secret cert-manager will generate.
    
- `ssl-redirect: true`: Forces HTTP → HTTPS redirection via the NGINX controller.
    

---

✅ Once applied:

- cert-manager will handle issuing and renewing TLS certificates.
    
- NGINX (or your controller) will enforce HTTPS access.
    

Let me know if you also want examples for staging certs (Let’s Encrypt staging), wildcard domains, or handling multiple Ingresses.