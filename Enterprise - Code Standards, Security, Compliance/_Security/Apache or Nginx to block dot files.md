Here’s a cleaner and easier-to-read version of your write-up. I’ve reorganized and simplified some of the explanations while preserving all technical details:

---

## Blocking `.env` File Access

The `.env` file should never be accessible via a web browser. Most web servers already block hidden files (dotfiles) by default — but it’s still a good idea to be explicit.

---

### Apache

#### Option 1: Block `.env` directly in `.htaccess`:

```apache
# Disable directory listing
Options -Indexes

# Block access to .env file
<Files .env>
    Order allow,deny
    Deny from all
</Files>
```

> ✅ The key directive here is `<Files .env>`.

#### Option 2: Block all dotfiles explicitly:

```apache
# Disable directory listing
Options -Indexes

# Block all hidden files (starting with a dot)
<FilesMatch "^\.">
    Order allow,deny
    Deny from all
</FilesMatch>
```

> ✅ This is the better option

---

### Nginx

In your server block (vhost) or a config it includes, add this to block dotfiles:

```nginx
location ~ /\. {
    deny all;
    access_log off;
    error_log /var/log/nginx/blocked_dotfile.log;
}
```

---

## Directory Indexing Behavior

### Apache

- **Default behavior:** Directory indexing is **enabled**.
- Apache **does hide** dotfiles (like `.env`) when listing directories.

> 📌 You should disable indexing to avoid listing files:

```apache
Options -Indexes
```

---

### Nginx

- **Default behavior:** Directory indexing is **disabled**.
- But if directory indexing is **enabled manually**, dotfiles **are shown** in the listing (which is dangerous).

> ❗ Even if `.env` is blocked from direct access, showing it in a directory listing may tip off attackers to its location. Then the hacker can try to access the .env file in ways that the vhost denying the file won't be able to block (eg. LFI with Directory Traversal vulnerability if your app gets supplied a filename to show its content through a url search param)

---

## Safer Custom Directory Listing (PHP Example)

To list files in a folder _without_ exposing hidden files or `.env`, you can use a custom script like this:
```
<?php
// dir-list.php

$dir = __DIR__;
$files = array_filter(scandir($dir), function ($file) {
    return $file[0] !== '.' && $file !== '.env';
});

usort($files, function ($a, $b) use ($dir) {
    return strcasecmp($a, $b); // Sort alphabetically, case-insensitive
});

function formatBytes($bytes) {
    if ($bytes == 0) return '0 B';
    $sizes = ['B', 'KB', 'MB', 'GB', 'TB'];
    $i = floor(log($bytes, 1024));
    return round($bytes / pow(1024, $i), 2) . ' ' . $sizes[$i];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Index of <?= htmlspecialchars(basename($dir)) ?>/</title>
    <style>
        body { font-family: monospace; padding: 20px; background: #fff; color: #000; }
        h1 { margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { text-align: left; padding: 5px 10px; }
        th { border-bottom: 1px solid #000; }
        tr:hover td { background: #f0f0f0; }
    </style>
</head>
<body>
    <h1>Index of <?= htmlspecialchars($_SERVER['REQUEST_URI']) ?></h1>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Last Modified</th>
                <th>Size</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($files as $file): ?>
                <?php
                    $filePath = $dir . DIRECTORY_SEPARATOR . $file;
                    $isDir = is_dir($filePath);
                    $modTime = date("Y-m-d H:i:s", filemtime($filePath));
                    $size = $isDir ? '-' : formatBytes(filesize($filePath));
                    $href = rawurlencode($file) . ($isDir ? '/' : '');
                ?>
                <tr>
                    <td><a href="<?= htmlspecialchars($href) ?>"><?= htmlspecialchars($file) ?><?= $isDir ? '/' : '' ?></a></td>
                    <td><?= $modTime ?></td>
                    <td><?= $size ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
```
  