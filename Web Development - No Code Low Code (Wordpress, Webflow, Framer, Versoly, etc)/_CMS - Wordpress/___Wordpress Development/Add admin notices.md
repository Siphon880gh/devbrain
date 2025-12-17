![[Pasted image 20251217002332.png]]

Add this to your child theme file `functions.php` or your plugin file `*.php`:
```
add_action('admin_notices', function () {
    $screen = function_exists('get_current_screen') ? get_current_screen() : null;
    if ($screen && $screen->base === 'edit') {
        echo '<div class="notice notice-success"><p><b>SUCCESS!</b></p></div>';
    }
});
```

Go to **Pages → All Pages**. If you should see the green notice.
