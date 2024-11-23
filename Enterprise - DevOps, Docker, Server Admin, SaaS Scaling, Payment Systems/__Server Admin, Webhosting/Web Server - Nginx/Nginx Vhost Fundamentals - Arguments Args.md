
WARNING - A location block that is an exact match like this doesnt have access to $args:
```
    location = / {
        return 301 /me;
    }
```

---

Example 1:
wengindustries.com/test?q=2 redirects to wengindustries.com/me/?q=2
```
    location /test {
        return 301 /me?$args;
    }
```

Example 2:
wengindustries.com/test?qq redirects to wengindustries.com/me/qq
```
    location /test {
        return 301 /me/$args;
    }
```

---

# Nginx Location Blocks & URL Query Parameters Reference

## Basic Query String Variables

- `$args`: Contains the entire query string
  - Example URL: `/search?q=nginx&category=web`
  - Value of `$args`: `q=nginx&category=web`

- `$arg_PARAMETER`: Contains the value of a specific query parameter
  - Example URL: `/search?q=nginx&category=web`
  - Value of `$arg_q`: `nginx`
  - Value of `$arg_category`: `web`

- `$is_args`: Set to "?" if a query string exists, or empty string otherwise
  - With query: `/search?q=nginx` → `$is_args` = "?"
  - Without query: `/search` → `$is_args` = ""

## Location Block Syntax

### Basic Location Matches

```nginx
# Exact Match
location = /path {
    # Matches: /path
    # Does NOT match: /path/, /path/image, /path1
}

# Preferential Prefix Match
location ^~ /images/ {
    # Matches: /images/photo.jpg, /images/subfolder/icon.png
    # Does NOT match: /imagesextra/photo.jpg
}

# Regular Expression Match (Case Sensitive)
location ~ \.php$ {
    # Matches: /script.php, /folder/page.php
    # Does NOT match: /script.PHP, /script.php/
}

# Regular Expression Match (Case Insensitive)
location ~* \.(jpg|jpeg|png)$ {
    # Matches: /image.jpg, /image.JPG, /folder/photo.PNG
    # Does NOT match: /image.jpg/extra
}

# Generic Prefix Match
location /api/ {
    # Matches: /api/users, /api/v1/posts
    # Does NOT match: /apiextra
}
```

## Working with Query Parameters

### 1. Accessing All Query Parameters

```nginx
location /debug {
    # Example URLs and their outputs:
    # /debug?name=john&age=25
    # → Query String: name=john&age=25
    
    # /debug?search=nginx+config&sort=desc
    # → Query String: search=nginx+config&sort=desc
    
    add_header X-Debug-Query $args;
    
    if ($is_args) {
        add_header X-Has-Query "yes";
    }
    
    return 200 "Query String: $args\n";
}
```

### 2. Accessing Specific Query Parameters

```nginx
location /user {
    # Example URLs:
    # /user?id=123&name=john&role=admin
    # → User ID: 123
    # → Name: john
    # → Role: admin
    
    # /user?id=456&name=jane
    # → User ID: 456
    # → Name: jane
    # → Role: [empty]
    
    set $user_id $arg_id;
    set $user_name $arg_name;
    set $user_role $arg_role;
    
    return 200 "User ID: $arg_id\nName: $arg_name\nRole: $arg_role\n";
}
```

### 3. Conditional Processing Based on Query Parameters

```nginx
location /filter {
    # Example URLs and their behavior:
    # /filter?type=article&category=tech
    # → Redirects to /filtered-content
    
    # /filter?status=active
    # → No redirect (neither type nor category present)
    
    set $param_exists "0";
    
    if ($arg_type) {
        set $param_exists "1";
    }
    
    if ($arg_category) {
        set $param_exists "1";
    }
    
    if ($param_exists = "1") {
        rewrite ^ /filtered-content last;
    }
}
```

### 4. URL Rewriting with Query Parameters

```nginx
location /old-path {
    # Example URLs and their redirects:
    # /old-path/article?id=123&view=full
    # → /new-path/article?id=123&view=full
    
    # /old-path/user/profile
    # → /new-path/user/profile
    
    rewrite ^/old-path/(.*) /new-path/$1$is_args$args permanent;
}

location /add-tracking {
    # Example URLs and their transformations:
    # /add-tracking?page=home
    # → /add-tracking?page=home&tracking=true
    
    # /add-tracking
    # → /add-tracking?tracking=true
    
    set $args "${args}&tracking=true";
    rewrite ^ $uri redirect;
}
```

### 5. Proxy Pass with Query Parameters

```nginx
location /api {
    # Example URLs and their proxy destinations:
    # /api/users?role=admin&status=active
    # → http://backend/api/users?role=admin&status=active
    
    # Original query string
    proxy_pass http://backend$request_uri;
    
    # Modified query string example:
    # /api/users?role=admin
    # → http://backend/api/users?role=admin&version=2
    
    set $new_args "version=2";
    if ($args) {
        set $new_args "${args}&${new_args}";
    }
    proxy_pass http://backend$uri?$new_args;
}
```

## Common Use Cases

### 1. API Version Control

```nginx
location /api/ {
    # Example URLs and their proxy destinations:
    # /api/users?version=v2
    # → http://backend/v2/api/users
    
    # /api/posts (no version specified)
    # → http://backend/v1/api/posts
    
    set $api_version "v1";  # Default version
    
    if ($arg_version) {
        set $api_version $arg_version;
    }
    
    proxy_pass http://backend/$api_version$uri$is_args$args;
}
```

### 2. Caching Based on Query Parameters

```nginx
location /cached {
    # Example URLs and resulting cache keys:
    # /cached?id=123&type=article&random=xyz
    # Cache key: "/cached:123:article"
    # (random parameter ignored)
    
    # /cached?id=456&type=page
    # Cache key: "/cached:456:page"
    
    set $cache_key "$uri:$arg_id:$arg_type";
    proxy_cache_key $cache_key;
    proxy_cache my_cache;
}
```

### 3. Parameter Validation

```nginx
location /secure {
    # Example URLs and responses:
    # /secure
    # → 403 Token required
    
    # /secure?token=abc
    # → 400 Invalid token format
    
    # /secure?token=1a2b3c4d5e6f7g8h9i0j1k2l3m4n5o6p
    # → Proxied to backend
    
    if ($arg_token = "") {
        return 403 "Token required\n";
    }
    
    if ($arg_token !~ "^[a-zA-Z0-9]{32}$") {
        return 400 "Invalid token format\n";
    }
    
    proxy_pass http://backend;
}
```

## Best Practices

1. Always encode query parameters properly:
   - Good: `/search?q=nginx+configuration`
   - Bad: `/search?q=nginx configuration`

2. Use `$is_args$args` to preserve query strings:
   - Input: `/page?lang=en&view=full`
   - Rewrite: `rewrite ^ /new-page$is_args$args last;`

3. Remember that `$arg_` variables are normalized:
   - URL: `/page?user-name=john`
   - Access as: `$arg_user_name`

## Security Considerations

1. Validate query parameters:
   - Unsafe: `/api?callback=<script>alert(1)</script>`
   - Safe: Only allow alphanumeric callbacks

2. Set length limits:
   - Good: `large_client_header_buffers 4 16k;`
   - Prevents: Extremely long query strings

3. Careful with logging:
   - Unsafe: Logging `$args` containing passwords
   - Safe: Logging specific safe parameters only

4. Parameter escaping:
   - Unsafe: `return 200 "$arg_input";`
   - Safe: Use appropriate escaping methods