**Where we are**: Docker containers spin up to the next available port number and spin down automatically -> So I added Kubernetes -> But now I need Ingress to have domain and subdomains

### 🌐 Ingress for Domain Routing (Using a Custom Domain)

If you want your service to be accessible via a domain like `myapp.example.com`, you’ll need to configure **Ingress** along with **TLS** (typically handled by `cert-manager`).

Ingress is a Kubernetes API object that manages **external HTTP/HTTPS traffic** to services inside your cluster. It uses rules based on **hostnames** and **paths** to route requests appropriately.

---

### 🔧 How Ingress Works

#### 1. **Defining Ingress Rules**

- **Hostnames**: Route based on domain (e.g., `www.example.com` → one service, `api.example.com` → another).
    
- **Paths**: Route based on URL paths (e.g., `/api` vs `/web`).
    
- **Services**: Each rule links to a specific Kubernetes service.
    
- **Protocols**: Supports both HTTP and HTTPS (you can redirect HTTP to HTTPS).
    

#### 2. **Ingress Controllers**

An Ingress rule won’t work without an **Ingress Controller**, which interprets and enforces the rules.

- Popular controllers: **NGINX**, **Traefik**, **HAProxy**, etc.
    
- Each controller may support different annotations and configurations.
    

#### 3. **Customization Options**

- **Annotations**: Add fine-grained control (e.g., rate limits, timeouts) directly on the Ingress resource.
    
- **ConfigMaps**: Set global configuration (e.g., NGINX tuning parameters).
    
- **Templates**: Advanced users can customize templates that generate the controller’s config.
    

---

### 📄 Example: Basic Ingress Config

```yaml
apiVersion: networking.k8s.io/v1
kind: Ingress
metadata:
  name: example-ingress
spec:
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

✅ In this example:

- Requests to `www.example.com` route to `my-service` on port 8080.
    
- Requests to `api.example.com` route to `api-service` on port 80.
    

---

Let me know if you want to add TLS with cert-manager or redirect HTTP to HTTPS next.