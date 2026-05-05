
**What is Composer**
Composer is PHP’s standard dependency manager. It lets you list the libraries your project needs, then installs and updates them for you. Same concept to Node Modules for NodeJS.

**Assumptions**
This assumes you are installing it through packages at Debian 12. For other installation types, refer to: https://getcomposer.org/doc/00-intro.md

---

**Big Picture:**
- Composer is **installed globally** (the CLI tool)
- Dependencies are **installed per project**. You need the composer CLI tool installed globally so you can run commands at the project level to init or manage.

**Check if you have composer installed globally already**

Cloudpanel? Composer is pre-installed by default on CloudPanel

Find out if you already have composer by running this command:
```
composer --version
```

---

## Install Composer globally on Debian 12

### 1) Install PHP + required tools

```bash
sudo apt update
sudo apt install php-cli php-mbstring curl unzip -y
```

---

### 2) Download Composer installer

```bash
cd ~
curl -sS https://getcomposer.org/installer -o composer-setup.php
```

---

### 3) (Optional but best practice) Verify installer

```bash
HASH=$(curl -sS https://composer.github.io/installer.sig)
php -r "if (hash_file('sha384', 'composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
```

---

### 4) Install globally

```bash
sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
```

---

### 5) Test

```bash
composer --version
```

You should now be able to run `composer` anywhere.

---

## Where it gets installed

Global binary:

```
/usr/local/bin/composer
```

That’s why it works system-wide.

---

## What is Guzzle (and why you’d use it)

Guzzle

**Guzzle = HTTP client for PHP**

It lets your PHP app make requests to other services/APIs.

---

## Example use cases

### 1) Call an external API

```php
use GuzzleHttp\Client;

$client = new Client();

$response = $client->get('https://api.github.com');

echo $response->getBody();
```

---

### 2) POST data (like form/API submission)

```php
$response = $client->post('https://example.com/api', [
    'json' => ['name' => 'Weng']
]);
```

---

### 3) Add headers (auth tokens, etc.)

```php
$response = $client->get('https://api.example.com', [
    'headers' => [
        'Authorization' => 'Bearer TOKEN'
    ]
]);
```

---

## When you’d actually use Guzzle

- Calling APIs (Stripe, OpenAI, internal microservices)
    
- Web scraping (basic)
    
- Backend-to-backend communication
    
- Replacing `curl` with cleaner PHP code
    

---

## Why not just use curl?

You _can_, but Guzzle gives you:

- cleaner syntax
    
- built-in JSON handling
    
- middleware (retries, logging)
    
- async support
    

---

## Install Guzzle in a project

```bash
composer require guzzlehttp/guzzle
```

---

## Quick mental model

- Composer → installs libraries
    
- Guzzle → one of those libraries (for HTTP requests)
    

---

If you want, I can show a **real-world pattern** (Flask ↔ PHP ↔ API using Guzzle) since you’re running mixed stacks.