
This guide assumes Debian 12 with PHP 8.2. Please adapt according to your needs

## ⚠️ First: Match CLI and Web PHP Versions

Before installing anything, make sure your **CLI PHP version matches your web server PHP version** (FPM/Apache).

### Check CLI version

```bash
php -v
```

### Check web (browser) version

Create a file in your web root:

```php
<?php
echo PHP_VERSION;
```

Visit it in your browser:

```
http://yourdomain.com/test.php
```

👉 Both should show the same version (e.g., **8.2**)  
If they don’t match, your extension may install to the wrong PHP version and won’t load.

---

## 🧭 Overview

|Method|When to Use|Pros|Cons|
|---|---|---|---|
|`apt install php8.2-mongodb`|Preferred|Fast, stable, auto-configured|Version may be older|
|`pecl install mongodb`|When apt fails / newer version needed|Latest version|Manual setup required|

---

# ✅ Method 1 — Using `apt` (Recommended)

## 🔍 Step 0: Find Available MongoDB Packages

Before installing, check what’s available:

```bash
apt search php | grep -i mongodb
```

Example output:

```
php8.2-mongodb/oldstable,oldstable,now 1.15.0+... amd64
```

👉 Key pattern:

```
php<version>-mongodb
```

---

## Step 1: Install package

```bash
sudo apt update
sudo apt install php8.2-mongodb
```

---

## 🧠 What `apt` does automatically

When using `apt`, it will:

- ✅ Install the compiled extension (`mongodb.so`)
    
- ✅ Create the config file (`mongodb.ini`)
    
- ✅ Enable the extension for PHP
    
- ✅ Place files in correct directories
    

👉 **No manual setup needed**

---

## Step 2: Verify installation

```bash
php -m | grep mongodb
```

Expected:

```
mongodb
```

---

## Step 3: Confirm `.ini` file exists

```bash
ls /etc/php/8.2/mods-available/mongodb.ini
```

---

# ⚙️ Method 2 — Using `pecl` (Manual Install)

Use this if:

- `php8.2-mongodb` is unavailable
    
- You need a newer version
    
- You’re using custom PHP (e.g., PHP 8.5 on CloudPanel)
    

---

## Step 1: Install dependencies

```bash
sudo apt update
sudo apt install php8.2-dev php-pear build-essential pkg-config
```

---

## Step 2: Install MongoDB via PECL

```bash
sudo pecl install mongodb
```

Press **Enter** for defaults.

---

## Step 3: Enable the extension (IMPORTANT)

PECL does **not auto-enable**, so:

```bash
echo "extension=mongodb.so" | sudo tee /etc/php/8.2/mods-available/mongodb.ini
sudo phpenmod mongodb
```

---

## Step 4: Restart PHP

```bash
sudo systemctl restart php8.2-fpm   # or apache2
```

---

## Step 5: Verify

```bash
php -m | grep mongodb
```

---

# 🔍 Troubleshooting

## ❌ No `.ini` file after PECL

```bash
echo "extension=mongodb.so" | sudo tee /etc/php/8.2/mods-available/mongodb.ini
```

---

## ❌ Extension not showing

```bash
find / -name mongodb.so 2>/dev/null
php -i | grep extension_dir
```

---

## ❌ Wrong PHP version (VERY common)

```bash
php -v
```

Switch if needed:

```bash
sudo update-alternatives --config php
```

---

# 🧠 Key Takeaways

- Always confirm **CLI = Web PHP version first**
    
- Use **apt first** → fully automated (`.so` + `.ini`)
    
- Use **pecl if needed** → manual but flexible
    

---

# ⚡ Quick Comparison

|Task|apt|pecl|
|---|---|---|
|Install|`apt install php8.2-mongodb`|`pecl install mongodb`|
|`.so` file|Auto|Auto|
|`.ini` file|Auto|Manual|
|Enable extension|Auto|Manual|
|Effort|Low|Medium|
