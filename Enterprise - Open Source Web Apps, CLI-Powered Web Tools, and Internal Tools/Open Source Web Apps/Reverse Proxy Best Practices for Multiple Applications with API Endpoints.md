
This guide covers best practices for setting up reverse proxies when hosting multiple Python Flask, Node.js Express, or other web applications that each have their own `/api` endpoints.

## The Problem

When hosting multiple web applications behind a single reverse proxy, conflicts arise when each application uses the same `/api` path:

```
Application A: http://localhost:3000/api/users
Application B: http://localhost:3001/api/users  
Application C: http://localhost:3002/api/users
```

Without proper routing, the reverse proxy cannot distinguish which application should handle which API request.

## Solution Approaches

### 1. Path-Based API Routing (Recommended)

Add unique identifiers to API paths for each application:

```
Application A (User Service):     /api/users/endpoint
Application B (Order Service):    /api/orders/endpoint  
Application C (Inventory Service): /api/inventory/endpoint
Application D (abc123):           /api/abc123/endpoint
```

### 2. Subdomain-Based Routing

Use subdomains to separate applications:

```
User Service:      users-api.yourdomain.com/api/endpoint
Order Service:     orders-api.yourdomain.com/api/endpoint
Inventory Service: inventory-api.yourdomain.com/api/endpoint
abc123:            abc123-api.yourdomain.com/api/endpoint
```

### 3. Port-Based Routing (Not Recommended for Production)

Expose different ports publicly (security concerns):

```
User Service:      yourdomain.com:3000/api/endpoint
Order Service:     yourdomain.com:3001/api/endpoint
Inventory Service: yourdomain.com:3002/api/endpoint
```

## Path-Based Routing Implementation

### Nginx Configuration

```nginx
server {
    listen 80;
    server_name yourdomain.com;
    
    # User Management Service
    location ~ ^/api/users[/]* {
        rewrite ^/api/users[/]*(.*)$ /api/$1 break;
        proxy_pass http://127.0.0.1:3000;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
    
    # Order Management Service
    location ~ ^/api/orders[/]* {
        rewrite ^/api/orders[/]*(.*)$ /api/$1 break;
        proxy_pass http://127.0.0.1:3001;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
    
    # Inventory Management Service
    location ~ ^/api/inventory[/]* {
        rewrite ^/api/inventory[/]*(.*)$ /api/$1 break;
        proxy_pass http://127.0.0.1:3002;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
    
    # abc123 Workflow Service
    location ~ ^/api/abc123[/]* {
        rewrite ^/api/abc123[/]*(.*)$ /api/$1 break;
        proxy_pass http://127.0.0.1:8001;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
    
    # Analytics Service (Different pattern - versioned API)
    location ~ ^/api/v1/analytics[/]* {
        rewrite ^/api/v1/analytics[/]*(.*)$ /api/$1 break;
        proxy_pass http://127.0.0.1:3003;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
    
    # Static web applications
    location /app/users {
        rewrite ^/app/users[/]*(.*)$ /$1 break;
        proxy_pass http://127.0.0.1:3000;
    }
    
    location /app/orders {
        rewrite ^/app/orders[/]*(.*)$ /$1 break;
        proxy_pass http://127.0.0.1:3001;
    }
    
    location /app/n8n-templates/abc123-community {
        rewrite ^/app/n8n-templates/abc123-community[/]*(.*)$ /$1 break;
        proxy_pass http://127.0.0.1:8001;
    }
}
```

### Apache Configuration

```apache
<VirtualHost *:80>
    ServerName yourdomain.com
    
    # Enable required modules
    LoadModule proxy_module modules/mod_proxy.so
    LoadModule proxy_http_module modules/mod_proxy_http.so
    LoadModule rewrite_module modules/mod_rewrite.so
    
    # User Management Service
    <LocationMatch "^/api/users">
        RewriteEngine On
        RewriteRule ^/api/users/(.*)$ /api/$1 [P]
        ProxyPass http://127.0.0.1:3000/api/
        ProxyPassReverse http://127.0.0.1:3000/api/
        ProxyPreserveHost On
    </LocationMatch>
    
    # Order Management Service
    <LocationMatch "^/api/orders">
        RewriteEngine On
        RewriteRule ^/api/orders/(.*)$ /api/$1 [P]
        ProxyPass http://127.0.0.1:3001/api/
        ProxyPassReverse http://127.0.0.1:3001/api/
        ProxyPreserveHost On
    </LocationMatch>
    
    # Inventory Management Service
    <LocationMatch "^/api/inventory">
        RewriteEngine On
        RewriteRule ^/api/inventory/(.*)$ /api/$1 [P]
        ProxyPass http://127.0.0.1:3002/api/
        ProxyPassReverse http://127.0.0.1:3002/api/
        ProxyPreserveHost On
    </LocationMatch>
    
    # abc123 Workflow Service
    <LocationMatch "^/api/abc123">
        RewriteEngine On
        RewriteRule ^/api/abc123/(.*)$ /api/$1 [P]
        ProxyPass http://127.0.0.1:8001/api/
        ProxyPassReverse http://127.0.0.1:8001/api/
        ProxyPreserveHost On
    </LocationMatch>
    
    # Analytics Service
    <LocationMatch "^/api/v1/analytics">
        RewriteEngine On
        RewriteRule ^/api/v1/analytics/(.*)$ /api/$1 [P]
        ProxyPass http://127.0.0.1:3003/api/
        ProxyPassReverse http://127.0.0.1:3003/api/
        ProxyPreserveHost On
    </LocationMatch>
</VirtualHost>
```

## Subdomain-Based Routing Implementation

### Nginx Configuration

```nginx
# User Management Service
server {
    listen 80;
    server_name users-api.yourdomain.com;
    
    location /api/ {
        proxy_pass http://127.0.0.1:3000/api/;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
}

# Order Management Service
server {
    listen 80;
    server_name orders-api.yourdomain.com;
    
    location /api/ {
        proxy_pass http://127.0.0.1:3001/api/;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
}

# abc123 Workflow Service
server {
    listen 80;
    server_name abc123-api.yourdomain.com;
    
    location /api/ {
        proxy_pass http://127.0.0.1:8001/api/;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
}
```

### Apache Configuration

```apache
# User Management Service
<VirtualHost *:80>
    ServerName users-api.yourdomain.com
    
    ProxyPass /api/ http://127.0.0.1:3000/api/
    ProxyPassReverse /api/ http://127.0.0.1:3000/api/
    ProxyPreserveHost On
</VirtualHost>

# Order Management Service
<VirtualHost *:80>
    ServerName orders-api.yourdomain.com
    
    ProxyPass /api/ http://127.0.0.1:3001/api/
    ProxyPassReverse /api/ http://127.0.0.1:3001/api/
    ProxyPreserveHost On
</VirtualHost>

# abc123 Workflow Service
<VirtualHost *:80>
    ServerName abc123-api.yourdomain.com
    
    ProxyPass /api/ http://127.0.0.1:8001/api/
    ProxyPassReverse /api/ http://127.0.0.1:8001/api/
    ProxyPreserveHost On
</VirtualHost>
```

## Application Code Adjustments

### Frontend JavaScript Adjustments

#### Path-Based Routing
```javascript
// User service calls
const userResponse = await fetch('/api/users/profile', {
    method: 'GET',
    headers: { 'Content-Type': 'application/json' }
});

// Order service calls  
const orderResponse = await fetch('/api/orders/list', {
    method: 'GET',
    headers: { 'Content-Type': 'application/json' }
});

// abc123 service calls
const workflowResponse = await fetch('/api/abc123/workflows', {
    method: 'GET',
    headers: { 'Content-Type': 'application/json' }
});
```

#### Subdomain-Based Routing
```javascript
// User service calls
const userResponse = await fetch('https://users-api.yourdomain.com/api/profile', {
    method: 'GET',
    headers: { 'Content-Type': 'application/json' }
});

// Order service calls
const orderResponse = await fetch('https://orders-api.yourdomain.com/api/list', {
    method: 'GET',
    headers: { 'Content-Type': 'application/json' }
});

// abc123 service calls
const workflowResponse = await fetch('https://abc123-api.yourdomain.com/api/workflows', {
    method: 'GET',
    headers: { 'Content-Type': 'application/json' }
});
```

### Backend Application Adjustments

#### Flask (Python) - No Changes Needed
```python
# Your Flask apps can keep their original /api routes
from flask import Flask

app = Flask(__name__)

@app.route('/api/users', methods=['GET'])
def get_users():
    return {'users': []}

@app.route('/api/workflows', methods=['GET'])  
def get_workflows():
    return {'workflows': []}

if __name__ == '__main__':
    app.run(host='127.0.0.1', port=3000)
```

#### Express.js (Node.js) - No Changes Needed
```javascript
const express = require('express');
const app = express();

// Your Express apps can keep their original /api routes
app.get('/api/users', (req, res) => {
    res.json({ users: [] });
});

app.get('/api/orders', (req, res) => {
    res.json({ orders: [] });
});

app.listen(3000, '127.0.0.1', () => {
    console.log('Server running on port 3000');
});
```

## Port Management Strategy

### Development Environment
```bash
# User Management Service
python user_service.py --port 3000

# Order Management Service  
node order_service.js --port 3001

# Inventory Management Service
python inventory_service.py --port 3002

# Analytics Service
node analytics_service.js --port 3003

# abc123 Workflow Service
python run.py --port 8001
```

### Production Environment with Process Managers

#### Using PM2 (Node.js)
```json
{
  "apps": [
    {
      "name": "user-service",
      "script": "user_service.js",
      "env": { "PORT": 3000 }
    },
    {
      "name": "order-service", 
      "script": "order_service.js",
      "env": { "PORT": 3001 }
    },
    {
      "name": "inventory-service",
      "script": "inventory_service.js", 
      "env": { "PORT": 3002 }
    }
  ]
}
```

#### Using systemd (Linux)
```ini
# /etc/systemd/system/user-service.service
[Unit]
Description=User Management Service
After=network.target

[Service]
Type=simple
User=www-data
WorkingDirectory=/var/www/user-service
Environment=PORT=3000
ExecStart=/usr/bin/python app.py
Restart=always

[Install]
WantedBy=multi-user.target
```

#### Using Supervisor
```ini
# /etc/supervisor/conf.d/services.conf
[program:user-service]
command=python app.py --port 3000
directory=/var/www/user-service
user=www-data
autostart=true
autorestart=true

[program:order-service]
command=node app.js --port 3001
directory=/var/www/order-service
user=www-data
autostart=true
autorestart=true

[program:abc123-service]
command=python run.py --port 8001
directory=/var/www/abc123-community/n8n-workflows
user=www-data
autostart=true
autorestart=true
```

## Security Best Practices

### 1. Internal Network Access Only
Ensure backend services only listen on localhost:
```python
# Good
app.run(host='127.0.0.1', port=3000)

# Bad - Exposes service directly
app.run(host='0.0.0.0', port=3000)
```

### 2. Firewall Configuration
Block direct access to backend ports:
```bash
# Allow nginx/Apache
sudo ufw allow 80
sudo ufw allow 443

# Block direct access to backend services
sudo ufw deny 3000
sudo ufw deny 3001
sudo ufw deny 3002
sudo ufw deny 8001
```

### 3. Rate Limiting per Service
```nginx
# Define rate limiting zones per service
http {
    limit_req_zone $binary_remote_addr zone=users_api:10m rate=10r/s;
    limit_req_zone $binary_remote_addr zone=orders_api:10m rate=5r/s;
    limit_req_zone $binary_remote_addr zone=abc123_api:10m rate=20r/s;
    
    server {
        location ~ ^/api/users[/]* {
            limit_req zone=users_api burst=20 nodelay;
            # ... proxy configuration
        }
        
        location ~ ^/api/orders[/]* {
            limit_req zone=orders_api burst=10 nodelay;
            # ... proxy configuration  
        }
        
        location ~ ^/api/abc123[/]* {
            limit_req zone=abc123_api burst=50 nodelay;
            # ... proxy configuration
        }
    }
}
```

### 4. Authentication Headers
Forward authentication between services:
```nginx
location ~ ^/api/users[/]* {
    # Forward authentication headers
    proxy_set_header Authorization $http_authorization;
    proxy_set_header X-User-ID $http_x_user_id;
    proxy_set_header X-User-Role $http_x_user_role;
    
    proxy_pass http://127.0.0.1:3000;
}
```

## Monitoring and Logging

### 1. Service Health Checks
```nginx
# Health check endpoints
location /health/users {
    proxy_pass http://127.0.0.1:3000/health;
}

location /health/orders {
    proxy_pass http://127.0.0.1:3001/health;
}

location /health/abc123 {
    proxy_pass http://127.0.0.1:8001/health;
}
```

### 2. Logging Configuration
```nginx
# Separate log files per service
location ~ ^/api/users[/]* {
    access_log /var/log/nginx/users_api_access.log;
    error_log /var/log/nginx/users_api_error.log;
    proxy_pass http://127.0.0.1:3000;
}

location ~ ^/api/orders[/]* {
    access_log /var/log/nginx/orders_api_access.log;
    error_log /var/log/nginx/orders_api_error.log;
    proxy_pass http://127.0.0.1:3001;
}
```

## Testing the Setup

### 1. Test Each Service Individually
```bash
# Test each service directly
curl http://127.0.0.1:3000/api/users
curl http://127.0.0.1:3001/api/orders  
curl http://127.0.0.1:3002/api/inventory
curl http://127.0.0.1:8001/api/workflows
```

### 2. Test Through Reverse Proxy
```bash
# Test through reverse proxy with path-based routing
curl https://yourdomain.com/api/users/profile
curl https://yourdomain.com/api/orders/list
curl https://yourdomain.com/api/inventory/items
curl https://yourdomain.com/api/abc123/workflows

# Test through reverse proxy with subdomain routing
curl https://users-api.yourdomain.com/api/profile
curl https://orders-api.yourdomain.com/api/list
curl https://abc123-api.yourdomain.com/api/workflows
```

### 3. Load Testing
```bash
# Test individual services under load
ab -n 1000 -c 10 https://yourdomain.com/api/users/
ab -n 1000 -c 10 https://yourdomain.com/api/orders/
ab -n 1000 -c 10 https://yourdomain.com/api/abc123/workflows

# Or using wrk
wrk -t4 -c40 -d30s https://yourdomain.com/api/users/
```

## API Documentation Strategy

### 1. Centralized API Documentation
```yaml
# api-docs.yaml
openapi: 3.0.0
info:
  title: Multi-Service API
  version: 1.0.0
servers:
  - url: https://yourdomain.com/api/users
    description: User Management Service
  - url: https://yourdomain.com/api/orders  
    description: Order Management Service
  - url: https://yourdomain.com/api/abc123
    description: abc123 Workflow Service
```

### 2. Service Discovery Endpoint
```nginx
# API discovery endpoint
location /api/services {
    return 200 '{
        "services": [
            {"name": "users", "path": "/api/users", "version": "1.0"},
            {"name": "orders", "path": "/api/orders", "version": "1.0"},
            {"name": "abc123", "path": "/api/abc123", "version": "1.0"}
        ]
    }';
    add_header Content-Type application/json;
}
```

## Conclusion

### Recommended Approach: Path-Based Routing

For most scenarios, **path-based routing** is recommended because:

1. **Single domain management** - Easier SSL certificate management
2. **Simplified CORS** - All APIs share the same origin
3. **Cost effective** - No need for multiple subdomains
4. **Easier development** - Consistent base URL

### When to Use Subdomain Routing

Consider subdomain routing when:

1. **Independent teams** - Different teams manage different services
2. **Different SSL requirements** - Services need different certificates
3. **Geographical distribution** - Services deployed in different regions
4. **Marketing reasons** - Business wants branded API endpoints

### Key Takeaways

1. **Always use unique API path identifiers** (e.g., `/api/service-name/`)
2. **Keep backend applications unchanged** - Let the reverse proxy handle routing
3. **Implement proper security** - Rate limiting, authentication, internal-only binding
4. **Monitor each service separately** - Individual logs and health checks
5. **Document your API routing strategy** - Clear documentation for developers
6. **Plan your port allocation** - Consistent port numbering strategy

This approach ensures scalability, maintainability, and security when hosting multiple web applications with API endpoints behind a single reverse proxy. 